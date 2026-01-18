import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const CURRENT_QUIZ_ID = window.QUIZ_ID;
  if (!CURRENT_QUIZ_ID) return;

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: csrfEl ? csrfEl.value : ''
  };

  // Helper untuk update statistik halaman
  const updateStats = () => {
    // Timeout kecil untuk memastikan tabel terisi
    setTimeout(() => {
        const questionRows = document.querySelectorAll('#questionTable tbody tr');
        const submissionRows = document.querySelectorAll('#submissionsTable tbody tr');
        
        // Cek jika baris berisi "No data found"
        const qCount = (questionRows.length === 1 && questionRows[0].cells.length === 1) ? 0 : questionRows.length;
        const sCount = (submissionRows.length === 1 && submissionRows[0].cells.length === 1) ? 0 : submissionRows.length;

        const statQ = document.getElementById('statTotalQuestions');
        const statS = document.getElementById('statTotalSubmissions');
        
        if(statQ) statQ.innerText = qCount;
        if(statS) statS.innerText = sCount;
    }, 1000);
  };

  // ============================================================
  // 1. KONFIGURASI TABEL PERTANYAAN
  // ============================================================
  const questionConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Pertanyaan',
    modalId: 'questionModal',
    formId: 'questionForm',
    modalLabelId: 'questionModalLabel',
    tableId: 'questionTable',
    tableParentSelector: '#questionTableContainer',
    btnAddId: 'btnAddQuestion',
    hiddenIdField: 'questionId',
    csrf: csrfConfig,
    urls: {
      load: `guru/pbl_kuis/get_quiz_questions/${CURRENT_QUIZ_ID}`,
      save: `guru/pbl_kuis/save_quiz_question`,
      delete: `guru/pbl_kuis/delete_quiz_question`
    },
    deleteMethod: 'POST',
    modalTitles: {
      add: 'Tambah Pertanyaan Baru',
      edit: 'Edit Pertanyaan'
    },
    deleteNameField: 'question', 

    // Mapper Pertanyaan (Updated with Remix Icons & Better Styling)
    dataMapper: (q, i) => [
      `<div class="text-center font-weight-bold text-muted">${i + 1}</div>`,
      `<div style="font-size: 0.95rem;">${q.question_text}</div>`,
      `<div class="text-center"><span class="badge bg-success bg-opacity-10 text-success border border-success px-3">${q.correct_answer}</span></div>`,
      `
        <div class="text-center">
            <button class="btn btn-sm btn-soft-primary btn-edit me-1"
            title="Edit Soal"
            data-id="${q.id}"
            data-question_text="${q.question_text}"
            data-option_a="${q.option_a}"
            data-option_b="${q.option_b}"
            data-option_c="${q.option_c}"
            data-option_d="${q.option_d}"
            data-correct_answer="${q.correct_answer}">
              ubah
            </button>
            <button class="btn btn-sm btn-outline-danger btn-delete border-0"
            title="Hapus Soal"
            data-id="${q.id}"
            data-question="${q.question_text.substring(0, 20)}...">
              Hapus
            </button>
        </div>
      `
    ],

    formPopulator: (form, data) => {
      form.querySelector('#questionId').value = data.id;
      form.querySelector('#question_text').value = data.question_text;
      form.querySelector('#option_a').value = data.option_a;
      form.querySelector('#option_b').value = data.option_b;
      form.querySelector('#option_c').value = data.option_c;
      form.querySelector('#option_d').value = data.option_d;
      form.querySelector('#correct_answer').value = data.correct_answer;
    },

    onAdd: (form) => {
      form.reset();
      form.querySelector('#questionId').value = '';
    },
    
    // Update stats after load/save/delete
    onDataLoaded: updateStats
  };

  const questionHandler = new CrudHandler(questionConfig);
  questionHandler.init();


  // ============================================================
  // 2. KONFIGURASI TABEL NILAI SISWA
  // ============================================================
  const submissionConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Nilai Siswa',
    tableId: 'submissionsTable',
    tableParentSelector: '#submissionsTableContainer',
    csrf: csrfConfig,
    urls: {
      load: `guru/pbl_kuis/get_quiz_submissions/${CURRENT_QUIZ_ID}`,
      delete: `guru/pbl_kuis/delete_quiz_submission`
    },
    deleteMethod: 'POST',
    deleteNameField: 'student_name',

    // Mapper Nilai (Updated with Remix Icons & Badges)
    dataMapper: (res, i) => {
        const date = new Date(res.created_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        let badgeClass = 'bg-danger';
        if(res.score >= 80) badgeClass = 'bg-success';
        else if(res.score >= 60) badgeClass = 'bg-warning text-dark';

        return [
            `<div class="text-center text-muted">${i + 1}</div>`,
            `<div class="d-flex align-items-center">
                <strong>${res.student_name}</strong>
             </div>`,
            `<div class="text-center"><span class="badge ${badgeClass} rounded-pill px-3 shadow-sm" style="font-size:0.9em">${res.score}</span></div>`,
            `<div class="text-center small text-muted"><i class="ri-time-line me-1"></i>${date}</div>`,
            `
            <div class="text-center">
                <button class="btn btn-sm btn-outline-danger btn-delete border-0"
                title="Batalkan/Hapus Nilai"
                data-id="${res.id}"
                data-student_name="${res.student_name} (Nilai: ${res.score})">
                <i class="ri-close-circle-line me-1"></i>Batal
                </button>
            </div>
            `
        ];
    },
    
    formPopulator: () => {},
    onAdd: () => {},
    onDataLoaded: updateStats
  };

  const submissionHandler = new CrudHandler(submissionConfig);
  submissionHandler.init();

});