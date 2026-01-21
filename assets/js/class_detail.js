// Impor class CrudHandler
import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {
    
    // Ambil status hak akses dari PHP
    const IS_ADMIN_OR_GURU = window.IS_ADMIN_OR_GURU || false;
    const CURRENT_CLASS_ID = window.CURRENT_CLASS_ID || null;
    
    // Ambil CSRF token (hanya jika admin/guru, karena modalnya ada)
    const csrfTokenEl = IS_ADMIN_OR_GURU 
        ? document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]') 
        : null;

    if (!CURRENT_CLASS_ID) {
        console.error('CLASS ID tidak ditemukan. Skrip dibatalkan.');
        return;
    }

    // Fungsi update jumlah siswa secara real-time di UI
    const updateStudentCount = () => {
        setTimeout(() => {
            const rowCount = document.querySelectorAll('#siswaTable tbody tr').length;
            // Jika tabel kosong atau berisi "No data", set 0 (perlu logic tambahan di handler sebenarnya, tapi ini basic)
            const noData = document.querySelector('.dataTables-empty'); // Class bawaan simple-datatables jika kosong
            const finalCount = noData ? 0 : rowCount;
            
            const countDisplay = document.getElementById('displayCount');
            const countHeader = document.getElementById('jumlah-siswa'); // Backward compatibility
            
            if(countDisplay) countDisplay.innerText = finalCount;
            if(countHeader) countHeader.innerText = finalCount;
        }, 500); // Delay sedikit menunggu tabel render
    };

    // Konfigurasi CrudHandler untuk TABEL SISWA
    const studentConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Siswa',

        // Mode readOnly jika BUKAN admin/guru
        readOnly: !IS_ADMIN_OR_GURU,

        // --- 1. Selektor DOM ---
        modalId: 'siswaModal',
        formId: 'studentForm',
        modalLabelId: 'siswaModalLabel',
        hiddenIdField: null, 
        tableId: 'siswaTable',
        btnAddId: 'btnAddStudent',
        tableParentSelector: '#siswaTableContainer',

        // --- 2. Konfigurasi CSRF ---
        csrf: {
            tokenName: window.CSRF_TOKEN_NAME,
            tokenHash: (IS_ADMIN_OR_GURU && csrfTokenEl) ? csrfTokenEl.value : ''
        },

        // --- 3. Endpoint URL ---
        urls: {
            load: window.IS_ADMIN_OR_GURU 
                ? `guru/dashboard/getStudentListForClass/${CURRENT_CLASS_ID}` 
                : `siswa/dashboard/getStudentListForClass/${CURRENT_CLASS_ID}`,
            save: 'guru/dashboard/add_student_to_class',
            delete: 'guru/dashboard/remove_student_from_class' 
        },
        deleteMethod: 'POST',

        // --- 4. Teks Spesifik ---
        modalTitles: {
            add: 'Tambah Siswa ke Kelas',
            edit: ''
        },
        deleteNameField: 'name',

        // Data Ekstra untuk delete
        extraDeleteData: {
            class_id: CURRENT_CLASS_ID
        },

        // --- 5. Logika Spesifik (Callback) ---
        dataMapper: (student, index) => {
            
            // Kolom dasar (untuk semua role)
            const rowData = [
                `<div class="text-center fw-bold text-secondary">${index + 1}</div>`,
                `<div class="fw-bold text-dark"><i class="ri-user-smile-line me-2 text-primary"></i>${student.name}</div>`,
                `<span class="badge bg-light text-dark border">@${student.username}</span>`,
                student.email ? `<span class="text-muted small">${student.email}</span>` : '<span class="text-muted small">-</span>'
            ];

            // (KONDISIONAL) Hanya tambahkan kolom Aksi jika admin/guru
            if (IS_ADMIN_OR_GURU) {
                rowData.push(`
                    <div class="text-center">
                        <button class="btn btn-outline-danger btn-sm btn-delete border-0" 
                        data-id="${student.id}" 
                        data-name="${student.name}"
                        title="Keluarkan dari kelas">
                        <i class="ri-user-unfollow-line me-1"></i> Keluarkan
                        </button>
                    </div>
                `);
            }
            
            return rowData;
        },

        formPopulator: (form, data) => {
            // Tidak ada implementasi edit untuk tabel ini (hanya add/remove)
        },

        onAdd: (form) => {
            form.reset(); 
            form.querySelector('#classIdHidden').value = CURRENT_CLASS_ID;
        },

        // Optional: Update counter setelah load/save/delete
        onDataLoaded: updateStudentCount
    };

    // Inisialisasi handler
    const studentHandler = new CrudHandler(studentConfig);
    studentHandler.init();
});