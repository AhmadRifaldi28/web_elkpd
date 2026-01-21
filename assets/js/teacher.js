import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    const csrfTokenEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
    
    // Cache elemen form
    const usernameEl = document.getElementById('teacherUsername');
    const passwordEl = document.getElementById('teacherPassword');
    const passwordGroup = document.getElementById('passwordGroup');
    const usernameHint = document.getElementById('usernameHint');

    // Helper Update Stats
    const updateStats = () => {
        setTimeout(() => {
            const rows = document.querySelectorAll('#teacherTable tbody tr');
            const count = (rows.length === 1 && rows[0].cells.length === 1) ? 0 : rows.length;
            const statEl = document.getElementById('statTotalTeachers');
            if(statEl) statEl.innerText = count;
        }, 500);
    };

    const teacherConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Guru',

        modalId: 'teacherModal',
        formId: 'teacherForm',
        modalLabelId: 'teacherModalLabel',
        hiddenIdField: 'teacherId',
        tableId: 'teacherTable',
        btnAddId: 'btnAddTeacher',
        tableParentSelector: '.teacherContainer',

        csrf: {
            tokenName: window.CSRF_TOKEN_NAME,
            tokenHash: csrfTokenEl ? csrfTokenEl.value : ''
        },

        urls: {
            load: 'admin/dashboard/getTeacherList', 
            save: 'admin/dashboard/teacher_save',
            delete: 'admin/dashboard/teacher_delete' 
        },
        deleteMethod: 'POST',

        modalTitles: {
            add: 'Tambah Guru Baru',
            edit: 'Edit Data Guru'
        },
        deleteNameField: 'name',

        // MAPPER DATA (Updated Layout & Remix Icons)
        dataMapper: (teacher, index) => {
            const emailText = teacher.email ? `<div class="text-muted small"><i class="ri-mail-line me-1"></i>${teacher.email}</div>` : '<span class="text-muted small">-</span>';
            
            return [
                `<div class="text-center fw-bold text-secondary">${index + 1}</div>`,
                `<div class="d-flex align-items-center">
                    <div class="avatar-sm bg-light rounded-circle text-primary d-flex align-items-center justify-content-center me-2" style="width:35px;height:35px">
                        <i class="ri-user-2-fill fs-5"></i>
                    </div>
                    <span class="fw-bold text-dark">${teacher.name}</span>
                 </div>`,
                `<div>
                    <div class="fw-bold text-primary small">@${teacher.username}</div>
                    ${emailText}
                 </div>`,
                `<span class="badge text-info border border-info">
                    ${teacher.school_name || 'N/A'}
                 </span>`,
                `
                <div class="text-center p-1">
                    <button class="btn btn-sm btn-outline-warning btn-edit me-1" 
                        data-id="${teacher.id}" 
                        data-name="${teacher.name}"
                        data-username="${teacher.username}"
                        data-email="${teacher.email || ''}"
                        data-school-id="${teacher.school_id}"
                        title="Ubah Data">
                        Ubah
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-delete border-0" 
                        data-id="${teacher.id}" 
                        data-name="${teacher.name}"
                        title="Hapus Data">
                        Hapus
                    </button>
                </div>
                `
            ];
        },

        formPopulator: (form, data) => {
            form.querySelector('#teacherId').value = data.id;
            form.querySelector('#teacherName').value = data.name;
            form.querySelector('#teacherSchool').value = data.schoolId;
            form.querySelector('#teacherEmail').value = data.email;

            // Mode Edit: Disable Username & Password
            usernameEl.value = data.username;
            usernameEl.readonly = true;
            usernameEl.classList.add('bg-light');
            usernameHint.style.display = 'none'; // Sembunyikan hint
            
            passwordEl.value = '';
            passwordEl.disabled = true;
            passwordGroup.style.display = 'none';
        },

        onAdd: (form) => {
            // Mode Tambah: Enable Username & Password
            usernameEl.readonly = false;
            usernameEl.classList.remove('bg-light');
            usernameEl.value = '';
            usernameHint.style.display = 'block';

            passwordEl.disabled = false;
            passwordGroup.style.display = 'block';
        },

        onDataLoaded: updateStats
    };

    const teacherHandler = new CrudHandler(teacherConfig);
    teacherHandler.init();
});