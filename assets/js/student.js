import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    const csrfTokenEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');

    // Cache elemen form
    const usernameEl = document.getElementById('studentUsername');
    const passwordEl = document.getElementById('studentPassword');
    const usernameGroup = document.getElementById('usernameGroup');
    const passwordGroup = document.getElementById('passwordGroup');

    // Helper Update Stats (Menghitung baris tabel untuk update kartu "Total Siswa")
    const updateStats = () => {
        setTimeout(() => {
            const rows = document.querySelectorAll('#studentTable tbody tr');
            // Cek jika baris berisi "No data found"
            const count = (rows.length === 1 && rows[0].cells.length === 1) ? 0 : rows.length;
            
            const statEl = document.getElementById('statTotalStudents');
            if(statEl) statEl.innerText = count;
        }, 500);
    };

    const studentConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Siswa',

        modalId: 'studentModal',
        formId: 'studentForm',
        modalLabelId: 'studentModalLabel',
        hiddenIdField: 'studentId', 
        tableId: 'studentTable',
        btnAddId: 'btnAddStudent',
        tableParentSelector: '.studentContainer',

        csrf: {
            tokenName: window.CSRF_TOKEN_NAME,
            tokenHash: csrfTokenEl ? csrfTokenEl.value : ''
        },

        urls: {
            load: 'admin/dashboard/getStudentList', 
            save: 'admin/dashboard/student_save',
            delete: 'admin/dashboard/student_delete'
        },
        deleteMethod: 'POST',

        modalTitles: {
            add: 'Tambah Siswa Baru',
            edit: 'Edit Data Siswa'
        },
        deleteNameField: 'name',

        // MAPPER DATA (Updated Layout & Remix Icons)
        dataMapper: (user, index) => {
            const emailText = user.email ? `<span class="text-muted small"><i class="ri-mail-line me-1"></i>${user.email}</span>` : '<span class="text-muted small">-</span>';
            
            return [
                `<div class="text-center fw-bold text-secondary">${index + 1}</div>`,
                `<div class="d-flex align-items-center">
                    <div class="avatar-sm bg-light rounded-circle text-success d-flex align-items-center justify-content-center me-2" style="width:35px;height:35px">
                        <i class="ri-user-smile-line fs-5"></i>
                    </div>
                    <span class="fw-bold text-dark">${user.name}</span>
                 </div>`,
                `<div>
                    <div class="fw-bold text-primary small">@${user.username}</div>
                    ${emailText}
                 </div>`,
                `
                <div class="text-center">
                    <button class="btn btn-sm btn-outline-warning btn-edit me-1" 
                        data-id="${user.id}" 
                        data-name="${user.name}"
                        data-username="${user.username}"
                        data-email="${user.email || ''}"
                        title="Edit Data">
                        Ubah
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-delete border-0" 
                        data-id="${user.id}" 
                        data-name="${user.name}"
                        title="Hapus Data">
                        Hapus
                    </button>
                </div>
                `
            ];
        },

        formPopulator: (form, data) => {
            form.querySelector('#studentId').value = data.id;
            form.querySelector('#studentName').value = data.name;
            form.querySelector('#studentEmail').value = data.email;

            // Logika mode EDIT: Disable Username & Password
            usernameEl.value = data.username; // Tampilkan tapi disable
            usernameEl.disabled = true; 
            usernameEl.required = false; 
            usernameGroup.style.opacity = '0.5'; // Visual feedback disabled

            passwordEl.value = '';
            passwordEl.disabled = true;
            passwordEl.required = false;
            passwordGroup.style.display = 'none'; // Sembunyikan field password saat edit
        },

        onAdd: (form) => {
            // Logika mode TAMBAH: Enable
            usernameEl.disabled = false;
            usernameEl.required = true; 
            usernameEl.value = '';
            usernameGroup.style.opacity = '1';
            
            passwordEl.disabled = false;
            passwordEl.required = false; // controller punya default
            passwordGroup.style.display = 'block'; 
        },

        // Update stats setiap kali data diload/disimpan
        onDataLoaded: updateStats
    };

    const studentHandler = new CrudHandler(studentConfig);
    studentHandler.init();
});