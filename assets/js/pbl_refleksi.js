import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
    
    // Konfigurasi CSRF
    const csrfConfig = {
        tokenName: window.CSRF_TOKEN_NAME,
        tokenHash: csrfEl ? csrfEl.value : ''
    };

    // Konfigurasi CrudHandler untuk Refleksi
    const refleksiConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Refleksi Siswa',
        tableId: 'table-refleksi',
        modalId: 'modalRefleksi',
        formId: 'formRefleksi',
        modalLabelId: 'modalTitle',
        
        // Tidak ada tombol Tambah Global (karena trigger dari baris tabel)
        btnAddId: null, 

        csrf: csrfConfig,

        urls: {
            load: 'guru/pbl/get_data_wrapper', // Sesuaikan dengan controller Anda
            save: 'guru/pbl/save',
            // delete: null // Tidak ada fitur delete
        },

        modalTitles: {
            add: 'Input Refleksi', 
            edit: 'Edit Refleksi'
        },

        // --- Data Mapper: Mengubah JSON menjadi Baris Tabel ---
        dataMapper: (row) => {
            const hasReflection = row.reflection_id ? true : false;
            
            // Badge Status
            const statusBadge = hasReflection 
                ? '<span class="badge bg-success">Sudah Dinilai</span>' 
                : '<span class="badge bg-warning text-dark">Belum Dinilai</span>';
            
            // Tombol Aksi
            // Kita selipkan data ke dataset agar bisa diambil oleh formPopulator
            const btnAction = `
                <button class="btn btn-sm btn-${hasReflection ? 'primary' : 'outline-primary'} btn-edit"
                    data-id="${row.reflection_id || ''}" 
                    data-user-id="${row.user_id}"
                    data-name="${row.full_name}"
                    data-teacher-reflection="${row.teacher_reflection || ''}"
                    data-student-feedback="${row.student_feedback || ''}"
                >
                    <i class="bi bi-pencil-square"></i> ${hasReflection ? 'Edit Refleksi' : 'Input Refleksi'}
                </button>
            `;

            return [
                row.name,
                row.quiz_score,
                row.tts_score,
                row.obs_score,
                row.essay_grade,
                statusBadge,
                btnAction
            ];
        },

        // --- Form Populator: Mengisi Modal saat tombol diklik ---
        formPopulator: (form, data) => {
            // Isi field hidden
            form.querySelector('#reflection_id').value = data.id || ''; // Kosong jika baru
            form.querySelector('#student_user_id').value = data.userId;
            
            // Isi tampilan nama (input readonly)
            const displayName = document.getElementById('display_name');
            if(displayName) displayName.value = data.name;

            // Isi Textarea
            form.querySelector('#teacher_reflection').value = data.teacherReflection || '';
            form.querySelector('#student_feedback').value = data.studentFeedback || '';
        }
    };

    // Inisialisasi
    new CrudHandler(refleksiConfig).init();
});