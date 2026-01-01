// Impor class CrudHandler
import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    // Ambil token CSRF
    const csrfTokenEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');

    // Cache elemen form yang akan di-disable/enable
    const usernameEl = document.getElementById('teacherUsername');
    const passwordEl = document.getElementById('teacherPassword');
    const passwordGroup = document.getElementById('passwordGroup');

    // Konfigurasi spesifik untuk modul "Guru"
    const teacherConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Guru',

        // --- 1. Selektor DOM ---
        modalId: 'teacherModal',
        formId: 'teacherForm',
        modalLabelId: 'teacherModalLabel',
        hiddenIdField: 'teacherId',
        tableId: 'teacherTable',
        btnAddId: 'btnAddTeacher',
        tableParentSelector: '.card-body',

        // --- 2. Konfigurasi CSRF ---
        csrf: {
            tokenName: window.CSRF_TOKEN_NAME,
            tokenHash: csrfTokenEl ? csrfTokenEl.value : ''
        },

        // --- 3. Endpoint URL ---
        urls: {
            // PENTING: Anda perlu membuat endpoint ini!
            load: 'admin/dashboard/getTeacherList', 
            save: 'admin/dashboard/teacher_save',
            // 'delete' adalah string karena ID dikirim via POST body
            delete: 'admin/dashboard/teacher_delete' 
        },
        deleteMethod: 'POST', // WAJIB

        // --- 4. Teks Spesifik ---
        modalTitles: {
            add: 'Tambah Guru Baru',
            edit: 'Edit Data Guru'
        },
        deleteNameField: 'name', // data-name="..."

        // --- 5. Logika Spesifik (Callback) ---

        /**
         * Mapper data JSON ke array untuk simple-datatable.
         * (Asumsi JSON Anda memiliki field 'name', 'username', 'email', 'school_name')
         */
        dataMapper: (teacher, index) => {
            return [
                index + 1,
                teacher.name,       // dari tabel user
                teacher.username,   // dari tabel user
                teacher.email || '-', // dari tabel user
                teacher.school_name || 'N/A', // dari join tabel school
                `
                <button class="btn btn-warning btn-sm btn-edit" 
                    data-id="${teacher.id}" 
                    data-name="${teacher.name}"
                    data-username="${teacher.username}"
                    data-email="${teacher.email || ''}"
                    data-school-id="${teacher.school_id}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm btn-delete" 
                    data-id="${teacher.id}" 
                    data-name="${teacher.name}">
                    <i class="fas fa-trash"></i> Hapus
                </button>
                `
            ];
        },

        /**
         * Pengisi form saat tombol "Edit" diklik.
         * Sesuai controller, kita disable username & password.
         */
        formPopulator: (form, data) => {
            // Isi data
            form.querySelector('#teacherId').value = data.id;
            form.querySelector('#teacherName').value = data.name;
            form.querySelector('#teacherSchool').value = data.schoolId;
            form.querySelector('#teacherEmail').value = data.email;

            // Logika mode EDIT:
            // Isi username tapi disable
            usernameEl.value = data.username;
            usernameEl.readonly = true; 
            usernameEl.required = false; // Tidak wajib
            
            // Sembunyikan/kosongkan & disable password
            passwordEl.value = '';
            passwordEl.disabled = true;
            passwordEl.required = false;
            passwordGroup.style.display = 'none'; // Sembunyikan grup password
        },

        /**
         * Hook opsional: Dipanggil saat modal "Tambah" dibuka.
         * Kita pastikan username & password bisa diisi.
         */
        onAdd: (form) => {
            // Logika mode TAMBAH:
            // Pastikan field bisa diisi
            usernameEl.disabled = false;
            usernameEl.required = true; // Wajib
            
            passwordEl.disabled = false;
            // Password tidak 'required' karena controller punya default
            passwordEl.required = false; 
            passwordGroup.style.display = 'block'; // Tampilkan grup password
        }
    };

    // Inisialisasi handler
    const teacherHandler = new CrudHandler(teacherConfig);
    teacherHandler.init();
});