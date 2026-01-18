import CrudHandler from '../crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

	const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
	const SLOT_ID = window.SLOT_ID;
	const btnAddId = 'btnAddUpload';

	if (!SLOT_ID) return;

	const csrfConfig = {
		tokenName: window.CSRF_TOKEN_NAME,
		tokenHash: csrfEl ? csrfEl.value : ''
	};

	const config = {
		baseUrl: window.BASE_URL,
		entityName: 'File',
		modalId: 'uploadModal',
		formId: 'uploadForm',
		modalLabelId: 'uploadModalLabel',
		tableId: 'myUploadsTable',
		btnAddId: btnAddId,
		hiddenIdField: 'dummyId', 
		tableParentSelector: '.uploadContainer',
		csrf: csrfConfig,
		urls: {
			load: `siswa/pbl_observasi/get_my_uploads/${SLOT_ID}`,
			save: `siswa/pbl_observasi/upload_file`,
			delete: (id) => `siswa/pbl_observasi/delete_upload/${id}`
		},
		deleteMethod: 'POST',
		deleteNameField: 'original_name',
		modalTitles: { add: 'Upload Hasil Observasi', edit: '' },

    // --- BAGIAN UTAMA PERUBAHAN ---
    dataMapper: (item, i) => {
    	const uploadDate = new Date(item.created_at).toLocaleString('id-ID', {
    		dateStyle: 'medium',
    		timeStyle: 'short'
    	});

    	const fileUrl = `${window.BASE_URL}file/observasi/${item.file_name}`;
    	
      // 1. LOGIKA IKON FILE (Agar lebih menarik)
      const ext = item.file_name.split('.').pop().toLowerCase();
      let iconClass = 'bi-file-earmark-text'; // default
      let iconColor = 'text-secondary';
      
      if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
      	iconClass = 'bi-file-earmark-image';
      	iconColor = 'text-warning';
      } else if (ext === 'pdf') {
      	iconClass = 'bi-file-earmark-pdf';
      	iconColor = 'text-danger';
      } else if (['doc', 'docx'].includes(ext)) {
      	iconClass = 'bi-file-earmark-word';
      	iconColor = 'text-primary';
      }

      const fileNameHtml = `
      <div class="d-flex align-items-center">
      <i class="bi ${iconClass} ${iconColor} fs-4 me-2"></i>
      <span class="fw-bold text-dark">${item.original_name}</span>
      </div>
      `;

      // 2. LOGIKA TOMBOL HAPUS (Cek apakah sudah dinilai)
      // item.score didapat dari join di Model tadi
      const isGraded = item.score !== null && item.score !== undefined;
      
      let actionButtons = `
      <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-light border text-primary me-1" title="Unduh">
      Unduh
      </a>
      `;

      if (isGraded) {
          // Jika sudah dinilai, ganti tombol hapus dengan ikon gembok/badge
          actionButtons += `
          <button class="btn btn-sm btn-secondary" disabled title="File terkunci karena sudah dinilai">
          <i class="ri-lock-2-line"></i>
          </button>
          `;
        } else {
          // Jika belum dinilai, tampilkan tombol hapus
          actionButtons += `
          <button class="btn btn-sm btn-outline-danger btn-delete my-2" 
          data-id="${item.id}" 
          data-original_name="${item.original_name}"
          title="Hapus File"> 
          Hapus
          </button>
          `;
        }

      // Tambahkan badge status di kolom keterangan jika perlu
      let descHtml = `<div>${item.description || '-'}</div>`;
      if(isGraded) {
      	descHtml += `<span class="badge bg-success bg-opacity-10 text-success mt-1"><i class="bi bi-check-circle me-1"></i>Sudah Dinilai</span>`;
      } else {
      	descHtml += `<span class="badge text-warning mt-1">Menunggu Penilaian</span>`;
      }

      return [
      `<div class="text-center">${i + 1}</div>`,
      fileNameHtml,
      descHtml,
      `<div class="text-muted small">${uploadDate}</div>`,
      `<div class="text-center">${actionButtons}</div>`
      ];
    },
  // -----------------------------

  formPopulator: (form, data) => {},
  onAdd: (form) => { form.reset(); },
  onDataLoaded: (data) => {
  	const btnAdd = document.getElementById(btnAddId);
  	if (btnAdd) {
      // Logic: Tombol tambah hilang jika ada file
      if (data && data.length > 0) {
      	btnAdd.classList.add('d-none');
          // Tampilkan pesan limit jika perlu
          document.getElementById('uploadLimitMsg')?.classList.remove('d-none');
        } else {
        	btnAdd.classList.remove('d-none');
        	document.getElementById('uploadLimitMsg')?.classList.add('d-none');
        }
      }
    }
  };

  const handler = new CrudHandler(config);
  handler.init();
});