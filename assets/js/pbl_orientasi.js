// assets/js/pbl_orientasi.js
import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfTokenEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const classIdEl = document.getElementById('classIdHidden');
  const CURRENT_CLASS_ID = classIdEl ? classIdEl.value : null;

  if (!CURRENT_CLASS_ID) {
    console.error('CLASS ID tidak ditemukan. CRUD PBL dibatalkan.');
    return;
  }

  // Konfigurasi untuk Tahap 1 – Orientasi Masalah
  const pblConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Skenario Masalah',
    readOnly: !IS_ADMIN_OR_GURU,

    // DOM SELECTORS 
    modalId: 'pblModal',
    formId: 'pblForm',
    modalLabelId: 'pblModalLabel',
    hiddenIdField: 'pblId',
    tableId: 'pblTable',
    btnAddId: 'btnAddPbl',
    tableParentSelector: '.card-body',

    // CSRF CONFIG 
    csrf: {
      tokenName: window.CSRF_TOKEN_NAME,
      tokenHash: csrfTokenEl ? csrfTokenEl.value : ''
    },

    // API ENDPOINTS 
    urls: {
      load: window.IS_ADMIN_OR_GURU 
        ? `guru/pbl/get_data/${CURRENT_CLASS_ID}` 
        : `siswa/pbl/get_data/${CURRENT_CLASS_ID}`,
      save: `guru/pbl/save`,
      delete: (id) => `guru/pbl/delete/${id}`
    },
    deleteMethod: 'POST',

    // UI TEXTS 
    modalTitles: {
      add: 'Tambah Skenario Baru',
      edit: 'Edit Skenario Masalah'
    },
    deleteNameField: 'title',

    // RENDER TABLE ROW 
    dataMapper: (item, index) => {

  let fileHtml = '-';

  if (item.file_path) {
    const ext = item.file_path.split('.').pop().toLowerCase();

    let badge = '';
    let icon = '';

    if (ext === 'pdf') {
      badge = 'danger'; icon = 'bi-file-earmark-pdf';
    } else if (['mp4'].includes(ext)) {
      badge = 'primary'; icon = 'bi-camera-video';
    } else if (['mp3','wav'].includes(ext)) {
      badge = 'warning'; icon = 'bi-music-note';
    } else if (['jpg','jpeg','png'].includes(ext)) {
      badge = 'info text-dark'; icon = 'bi-image';
    } else {
      badge = 'secondary'; icon = 'bi-file-earmark-word';
    }

    fileHtml = `
      <div class="d-flex gap-2 align-items-center justify-content-center">
        <span class="badge bg-${badge}">
          <i class="bi ${icon} me-1"></i> ${ext.toUpperCase()}
        </span>
        <button class="btn btn-outline-info btn-sm text-dark btn-preview"
          data-id="${item.id}" data-ext="${ext}">
          Lihat
        </button>
      </div>`;
  }

  const rowData = [
    index + 1,
    item.title,
    item.reflection,
    fileHtml
  ];

  if (IS_ADMIN_OR_GURU) {
    rowData.push(`
      <div class="d-flex gap-1 justify-content-center">
        <button class="btn btn-sm btn-warning btn-edit"
          data-id="${item.id}"
          data-title="${item.title}"
          data-reflection="${item.reflection}">
          Ubah
        </button>
        <button class="btn btn-sm btn-danger btn-delete"
          data-id="${item.id}"
          data-title="${item.title}">
          Hapus
        </button>
      </div>
    `);
  }

  return rowData;
},



    // POPULATE EDIT FORM 
    formPopulator: (form, data) => {
      form.querySelector('#pblId').value = data.id;
      form.querySelector('#pblTitle').value = data.title;
      form.querySelector('#pblReflection').value = data.reflection;
    },

    // RESET FORM ON ADD 
    onAdd: (form) => {
      form.reset();
      form.querySelector('input[name="class_id"]').value = CURRENT_CLASS_ID;
    }
  };

  // INIT CRUD HANDLER 
  const pblHandler = new CrudHandler(pblConfig);
  pblHandler.init();
});

document.addEventListener('click', (e) => {
  const btn = e.target.closest('.btn-preview');
  if (!btn) return;

  const id = btn.dataset.id;
  const fileUrl = `${window.BASE_URL}file/pbl/${id}`;

  // Ambil ekstensi dari data attribute (fallback aman)
  const ext = (btn.dataset.ext || '').toLowerCase();

  const container = document.getElementById('filePreviewContent');
  let html = '';

  if (['jpg', 'jpeg', 'png'].includes(ext)) {
    html = `
      <img src="${fileUrl}" class="img-fluid rounded mx-auto d-block">
    `;
  } 
  else if (['mp4'].includes(ext)) {
    html = `
      <video controls class="w-100 rounded">
        <source src="${fileUrl}">
        Browser tidak mendukung video.
      </video>
    `;
  } 
  else if (['mp3', 'wav'].includes(ext)) {
    html = `
      <audio controls class="w-100">
        <source src="${fileUrl}">
        Browser tidak mendukung audio.
      </audio>
    `;
  } 
  else if (ext === 'pdf') {
    html = `
      <iframe src="${fileUrl}" width="100%" height="600" style="border:none"></iframe>
    `;
  } 
  else {
    html = `
      <div class="text-center py-5">
        <i class="bi bi-file-earmark-text fs-1 text-secondary mb-3"></i>
        <p class="mb-3">File tidak dapat dipratinjau.</p>
        <a href="${fileUrl}" class="btn btn-primary">
          <i class="bi bi-download me-1"></i> Download File
        </a>
      </div>
    `;
  }

  container.innerHTML = html;

  new bootstrap.Modal(
    document.getElementById('filePreviewModal')
  ).show();
});
