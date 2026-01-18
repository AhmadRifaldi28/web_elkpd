// assets/js/kelas_crud.js
import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

	const csrfTokenEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
	const schoolIdEl = document.getElementById('schoolId');
	const schoolId = schoolIdEl ? schoolIdEl.value : null;

	if (!schoolId) {
		console.error('School ID tidak ditemukan.');
		return;
	}

  // --- Helper Update Stats ---
  const updateClassStats = () => {
  	setTimeout(() => {
  		const rows = document.querySelectorAll('#kelasTable tbody tr');
      // Cek jika baris berisi "No data found" (biasanya 1 row, 1 cell)
      const count = (rows.length === 1 && rows[0].cells.length === 1) ? 0 : rows.length;
      
      const statEl = document.getElementById('statTotalClasses');
      if(statEl) statEl.innerText = count;
    }, 500);
  };

  const classConfig = {
  	baseUrl: window.BASE_URL,
  	entityName: 'Kelas',

  	modalId: 'classModal',
  	formId: 'classForm',
  	modalLabelId: 'classModalLabel',
  	hiddenIdField: 'classId',
  	tableId: 'kelasTable',
  	btnAddId: 'btnAddClass',
  	tableParentSelector: '.kelasContainer',

  	csrf: {
  		tokenName: window.CSRF_TOKEN_NAME,
  		tokenHash: csrfTokenEl ? csrfTokenEl.value : ''
  	},

  	urls: {
  		load: `guru/dashboard/getClassList/${schoolId}`,
  		save: 'guru/dashboard/class_save',
  		delete: 'guru/dashboard/class_delete'
  	},
  	deleteMethod: 'POST',

  	modalTitles: {
  		add: 'Tambah Kelas Baru',
  		edit: 'Edit Kelas'
  	},
  	deleteNameField: 'name',

    // --- MAPPER DATA (Updated with Remix Icons & New Styles) ---
    dataMapper: (cls, index) => {
      return [
        index + 1,
        cls.name,
        cls.code,
        `
        <a href="${window.BASE_URL}guru/dashboard/class_detail/${cls.id}" 
          class="btn btn-bd-primary btn-sm btn-detail" 
          title="Lihat Siswa">
          <i class="fas fa-users"></i> Detail
        </a>
        <button class="btn btn-warning btn-sm btn-edit" 
            data-id="${cls.id}" 
            data-name="${cls.name}"
            data-code="${cls.code || ''}">
            <i class="fas fa-edit"></i> Edit
        </button>
        <button class="btn btn-danger btn-sm btn-delete" 
            data-id="${cls.id}" 
            data-name="${cls.name}">
            <i class="fas fa-trash"></i> Hapus
        </button>
        `
      ];
  	},

    formPopulator: (form, data) => {
    	form.querySelector('#classId').value = data.id;
    	form.querySelector('#className').value = data.name;
    	form.querySelector('#classCode').value = data.code;
    },

    onAdd: (form) => {
    	const schoolIdValue = form.querySelector('#schoolId').value;
    	form.reset();
    	form.querySelector('#schoolId').value = schoolIdValue; 
    	form.querySelector('#classId').value = '';
    },

    // Update stats setiap kali data diload/disimpan
    onDataLoaded: updateClassStats
  };

  const classHandler = new CrudHandler(classConfig);
  classHandler.init();
});