import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {
  
  const IS_ADMIN_OR_GURU = window.IS_ADMIN_OR_GURU || false;
  const CURRENT_CLASS_ID = window.CURRENT_CLASS_ID || null;

  // Ambil elemen label yang mau diubah
  const infoLabel = document.getElementById('info-label');
  // Ambil semua tombol tab
  const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
  // Loop untuk pasang listener di setiap tab
  tabEls.forEach(tabEl => {
    tabEl.addEventListener('shown.bs.tab', function (event) {
      // event.target adalah tab yang baru saja aktif
      if (event.target.id === 'tts-tab') {
          infoLabel.textContent = 'tts';
      } else {
          infoLabel.textContent = 'kuis';
      }
    });
  });

  //  Hapus tombol "Tambah" jika Murid
  if (!IS_ADMIN_OR_GURU) {
    ['btnAddQuiz', 'btnAddTts'].forEach(id => {
      const btn = document.getElementById(id);
      if (btn) btn.remove(); // Menghapus elemen dari DOM
    });
  }

  const csrfTokenEl = IS_ADMIN_OR_GURU 
    ? document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]') 
    : null;

  if (!CURRENT_CLASS_ID) return console.error('CLASS ID tidak ditemukan.');

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: (IS_ADMIN_OR_GURU && csrfTokenEl) ? csrfTokenEl.value : ''
  };

  // --- CRUD KUIS ---
  const quizConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Kuis',
    readOnly: !IS_ADMIN_OR_GURU,
    modalId: 'quizModal', formId: 'quizForm', modalLabelId: 'quizModalLabel', hiddenIdField: 'quizId',
    tableId: 'quizTable', btnAddId: 'btnAddQuiz', tableParentSelector: '#quiz',
    csrf: csrfConfig,
    urls: {
      load: IS_ADMIN_OR_GURU ? `guru/pbl/get_quizzes/${CURRENT_CLASS_ID}` : `siswa/pbl/get_quizzes/${CURRENT_CLASS_ID}`,
      save: IS_ADMIN_OR_GURU ? `guru/pbl/save_quiz` : null,
      delete: IS_ADMIN_OR_GURU ? (id) => `guru/pbl/delete_quiz/${id}` : null
    },
    deleteMethod: 'POST',
    modalTitles: { add: 'Tambah Kuis', edit: 'Edit Kuis' },
    deleteNameField: 'title',
    
    // [DIPERSINGKAT] Data Mapper Kuis
    dataMapper: (q, i) => {
      const detailBtn = `<a href="${window.BASE_URL}${window.URL_NAME}/pbl_kuis/kuis_detail/${q.id}" class="btn btn-sm btn-info"> Detail</a>`;
      
      const actionBtns = IS_ADMIN_OR_GURU ? `
        <button class="btn btn-sm btn-warning btn-edit" data-id="${q.id}" data-title="${q.title}" data-description="${q.description || ''}">Ubah</button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="${q.id}" data-title="${q.title}">Hapus</i></button>
      ` : '';

      return [i + 1, q.title, q.description || '-', detailBtn + actionBtns];
    },

    formPopulator: IS_ADMIN_OR_GURU ? (form, data) => {
      form.querySelector('#quizId').value = data.id;
      form.querySelector('#quizTitle').value = data.title;
      form.querySelector('#quizDescription').value = data.description || '';
    } : null,
    onAdd: IS_ADMIN_OR_GURU ? (form) => { form.reset(); form.querySelector('#quizClassId').value = CURRENT_CLASS_ID; } : null
  };

  // --- CRUD TTS ---
  const ttsConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'TTS',
    readOnly: !IS_ADMIN_OR_GURU,
    modalId: 'ttsModal', formId: 'ttsForm', modalLabelId: 'ttsModalLabel', hiddenIdField: 'ttsId',
    tableId: 'ttsTable', btnAddId: 'btnAddTts', tableParentSelector: '#tts',
    csrf: csrfConfig,
    urls: {
      load: IS_ADMIN_OR_GURU ? `guru/pbl/get_tts/${CURRENT_CLASS_ID}` : `siswa/pbl/get_tts/${CURRENT_CLASS_ID}`,
      save: IS_ADMIN_OR_GURU ? `guru/pbl/save_tts` : null,
      delete: IS_ADMIN_OR_GURU ? (id) => `guru/pbl/delete_tts/${id}` : null
    },
    deleteMethod: 'POST',
    modalTitles: { add: 'Tambah TTS', edit: 'Edit TTS' },
    deleteNameField: 'title',

    // Data Mapper TTS
    dataMapper: (t, i) => {
      const detailBtn = `<a href="${window.BASE_URL}${window.URL_NAME}/pbl_tts/detail/${t.id}" class="btn btn-info btn-sm me-1"> Detail</a>`;
      
      const actionBtns = IS_ADMIN_OR_GURU ? `
        <button class="btn btn-sm btn-warning btn-edit" data-id="${t.id}" data-title="${t.title}" data-grid_data="${t.grid_data || ''}">Ubah</button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="${t.id}" data-title="${t.title}">Hapus</i></button>
      ` : '';

      return [i + 1, t.title, (t.grid_data || '').substring(0, 50) + '...', detailBtn + actionBtns];
    },

    formPopulator: IS_ADMIN_OR_GURU ? (form, data) => {
      form.querySelector('#ttsId').value = data.id;
      form.querySelector('#ttsTitle').value = data.title;
      form.querySelector('#ttsGridData').value = data.grid_data || '';
    } : null,
    onAdd: IS_ADMIN_OR_GURU ? (form) => { form.reset(); form.querySelector('#ttsClassId').value = CURRENT_CLASS_ID; } : null
  };

  new CrudHandler(quizConfig).init();
  new CrudHandler(ttsConfig).init();
});