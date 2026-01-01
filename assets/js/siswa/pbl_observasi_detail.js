import CrudHandler from '../crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
    const SLOT_ID = window.SLOT_ID;
    const btnAddId = 'btnAddUpload'; // Simpan ID tombol dalam variabel

    if (!SLOT_ID) return;

    const csrfConfig = {
        tokenName: window.CSRF_TOKEN_NAME,
        tokenHash: csrfEl ? csrfEl.value : ''
    };

    // Konfigurasi CRUD
    const config = {
        baseUrl: window.BASE_URL,
        entityName: 'File',
        modalId: 'uploadModal',
        formId: 'uploadForm',
        modalLabelId: 'uploadModalLabel',
        tableId: 'myUploadsTable',
        btnAddId: btnAddId, // Gunakan variabel ID
        
        hiddenIdField: 'dummyId', 
        tableParentSelector: '.uploadContainer',
        
        csrf: csrfConfig,
        urls: {
            load: `siswa/pbl_observasi/get_my_uploads/${SLOT_ID}`,
            save: `siswa/pbl_observasi/upload_file`,
            delete: (id) => `siswa/pbl_observasi/delete_upload/${id}`
        },
        deleteMethod: 'POST',
        deleteNameField: 'original_name', // Ubah ke original_name agar konfirmasi hapus lebih jelas
        
        modalTitles: { add: 'Upload Hasil Observasi', edit: '' },

        // Data Mapper
        dataMapper: (item, i) => {
            const uploadDate = new Date(item.created_at).toLocaleString('id-ID', {
                dateStyle: 'medium',
                timeStyle: 'short'
            });

            // const fileUrl = `${window.BASE_URL}uploads/observasi/${item.file_name}`;
            const fileUrl = `${window.BASE_URL}file/observasi/${item.file_name}`;
            
            // Tombol Download
            const downloadBtn = `
                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-info text-dark me-1" title="Unduh">
                    Unduh
                </a>
            `;

            const deleteBtn = `
                <button class="btn btn-sm btn-danger btn-delete" 
                    data-id="${item.id}" 
                    data-original_name="${item.original_name}"> 
                    Hapus
                </button>
            `;

            return [
                i + 1,
                item.original_name,
                item.description || '-',
                uploadDate,
                downloadBtn + deleteBtn
            ];
        },

        // Form Populator (Kosong)
        formPopulator: (form, data) => {},

        // Reset form saat tombol tambah diklik
        onAdd: (form) => {
            form.reset();
        },

        // [BARU] Logika Toggle Tombol Upload
        // Dijalankan otomatis oleh CrudHandler setiap kali data selesai dimuat (Load/Save/Delete)
        onDataLoaded: (data) => {
            const btnAdd = document.getElementById(btnAddId);
            if (btnAdd) {
                // Jika ada data (length > 0), sembunyikan tombol. Jika kosong, tampilkan.
                if (data && data.length > 0) {
                    btnAdd.classList.add('d-none');
                } else {
                    btnAdd.classList.remove('d-none');
                }
            }
        }
    };

    const handler = new CrudHandler(config);
    handler.init();
});