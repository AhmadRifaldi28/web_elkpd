import CrudHandler from '../crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const CURRENT_CLASS_ID = window.CURRENT_CLASS_ID || null;
  const CURRENT_USER_ID = document.getElementById('currentUserId').value; // Ambil ID Siswa Login

  if (!CURRENT_CLASS_ID) return;

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: csrfEl ? csrfEl.value : ''
  };

  // URL Load: Menggunakan endpoint yang sama (Controller harus return JSON)
  // Logic Privasi: Kita filter di client-side (Javascript) agar hanya baris siswa ybs yang muncul.
  // ATAU lebih aman jika Anda membuat controller `siswa/pbl/get_my_recap` yang hanya me-return array 1 baris.
  // Script di bawah ini support keduanya (Array banyak atau Array satu).
  const LOAD_URL = `siswa/pbl/get_my_recap/${CURRENT_CLASS_ID}`; 

  // ============================================================
  // HANDLER 1: TABEL REKAP NILAI (View Only)
  // ============================================================
  const rekapConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Nilai Saya',
    tableId: 'rekapTable',      
    tableParentSelector: '.card-body',
    
    readOnly: true, // View Only

    urls: { load: LOAD_URL },

    dataMapper: (student, index) => {

      // Pastikan float
      const quiz = parseFloat(student.quiz_score) || 0;
      const tts = parseFloat(student.tts_score) || 0;
      const obs = parseFloat(student.obs_score) || 0;
      const essay = parseFloat(student.essay_score) || 0;

      // Hitung Rata-rata
      const finalScore = (quiz + tts + obs + essay) / 4;

      return [
        index + 1, // Nomor urut (akan jadi 1 karena cuma ada 1 data)
        `<span class="fw-bold text-success">${student.student_name} (Anda)</span>`,
        quiz.toFixed(0),
        tts.toFixed(0),
        obs.toFixed(0),
        essay.toFixed(0),
        `<span class="badge bg-primary fs-6">${finalScore.toFixed(2)}</span>`
      ];
    }
  };

  new CrudHandler(rekapConfig).init();


  // ============================================================
  // HANDLER 2: TABEL REFLEKSI (Lihat Refleksi)
  // ============================================================
  const refleksiConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Refleksi',
    
    modalId: 'refleksiModal',
    formId: 'refleksiForm',
    modalLabelId: 'refleksiModalLabel', // Penting untuk judul modal
    
    tableId: 'reflectionTable', 
    tableParentSelector: '.reflectionContainer',
    
    btnAddId: null, 
    csrf: csrfConfig,
    
    // PENTING: readOnly false agar tombol "Lihat" bisa diklik & membuka modal
    // Meskipun siswa tidak bisa simpan, kita butuh fitur "Show Modal" dari CrudHandler
    readOnly: false, 

    urls: {
      load: LOAD_URL,
      save: 'siswa/pbl/dummy_save', // Dummy URL (tidak akan dipanggil karena tidak ada tombol submit)
      delete: null
    },

    modalTitles: { edit: 'Detail Refleksi & Feedback' },

    dataMapper: (student, index) => {
      // --- FILTER PRIVASI ---
      if (student.user_id !== CURRENT_USER_ID) return null;

      const teacherRef = student.teacher_reflection || '';
      const feedback = student.student_feedback || '';
      
      // Status apakah guru sudah mengisi
      const isFilled = teacherRef !== '' || feedback !== '';
      
      // Display Teks Pendek di Tabel
      const displayRef = teacherRef ? teacherRef.substring(0, 40) + '...' : '<span class="text-muted">-</span>';
      const displayFeed = feedback ? feedback.substring(0, 40) + '...' : '<span class="text-muted">-</span>';

      // Tombol Aksi: "Lihat" (View)
      // Kita gunakan class "btn-edit" agar CrudHandler otomatis membuka modal dan mengisi data
      let actionBtn = '';
      if (isFilled) {
          actionBtn = `
            <button type="button" class="btn btn-sm btn-info text-dark btn-edit" 
              data-id="${student.user_id}" 
              data-name="${student.student_name}"
              data-reflection="${teacherRef}"
              data-feedback="${feedback}">
              Lihat Detail
            </button>
          `;
      } else {
          actionBtn = `<span class="badge bg-secondary">Belum ada feedback</span>`;
      }

      return [
        index + 1,
        `<span class="fw-bold text-success">${student.student_name} (Anda)</span>`,
        displayRef,
        displayFeed,
        actionBtn
      ];
    },

    // Fungsi Pengisi Modal
    formPopulator: (form, data) => {
      // Isi Nama
      form.querySelector('#modalStudentName').value = data.name;
      
      // Isi Textarea (Readonly)
      const refArea = form.querySelector('[name="teacher_reflection"]');
      const feedArea = form.querySelector('[name="student_feedback"]');
      
      if(refArea) refArea.value = data.reflection || '- Belum ada catatan -';
      if(feedArea) feedArea.value = data.feedback || '- Belum ada feedback -';
    }
  };

  new CrudHandler(refleksiConfig).init();

});