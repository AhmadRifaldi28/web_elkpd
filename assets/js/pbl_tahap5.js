import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const CURRENT_CLASS_ID = window.CURRENT_CLASS_ID || null;

  if (!CURRENT_CLASS_ID) return;

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: csrfEl ? csrfEl.value : ''
  };

  /**
   * HELPER: Fungsi Generate Tombol Aksi
   */
  const generateActionButtons = (student) => {
    const teacherRef = student.teacher_reflection || '';
    const feedback = student.student_feedback || '';
    const isFilled = teacherRef !== '' || feedback !== '';
    const isLocked = parseInt(student.is_locked) === 1;

    // Logic Tombol Lock
    let lockBtn = '';
    if (isFilled) {
      if (isLocked) {
        lockBtn = `
          <button type="button" class="btn btn-sm btn-outline-danger btn-lock" 
            title="Batalkan Publikasi" data-id="${student.user_id}" data-status="0">
            <i class="bi bi-unlock-fill"></i> Buka
          </button>`;
      } else {
        lockBtn = `
          <button type="button" class="btn btn-sm btn-outline-success btn-lock" 
             title="Publikasikan Nilai" data-id="${student.user_id}" data-status="1">
             <i class="bi bi-lock-fill"></i> Kunci
          </button>`;
      }
    } else {
      lockBtn = `<button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-lock"></i></button>`;
    }

    // Logic Tombol Input/Ubah
    const btnClass = isFilled ? 'btn-warning' : 'btn-primary';
    const btnText = isFilled ? 'Ubah' : 'Input';
    const icon = isFilled ? 'bi-pencil-square' : 'bi-plus-circle';

    return `
      <div class="btn-group" role="group">
          <button type="button" class="btn btn-sm ${btnClass} btn-edit" 
            data-id="${student.user_id}" 
            data-name="${student.student_name}"
            data-reflection="${teacherRef}"
            data-feedback="${feedback}"
            data-is-locked="${isLocked ? 1 : 0}">
            <i class="bi ${icon}"></i> ${btnText}
          </button>
          ${lockBtn}
      </div>
    `;
  };

  /**
   * DEFINISI CONFIG HANDLER UTAMA (REFLEKSI)
   * Kita definisikan variabel ini di luar agar bisa diakses oleh commonFormPopulator
   */
  const refleksiConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Refleksi',
    
    // Ini Handler Utama yang menangani Form & Modal
    readOnly: false, 
    
    modalId: 'refleksiModal',
    formId: 'refleksiForm',
    modalLabelId: 'refleksiModalLabel',
    
    tableId: 'reflectionTable', 
    tableParentSelector: '.reflectionContainer', 
    
    btnAddId: null, 
    csrf: csrfConfig,
    
    urls: {
      load: `guru/pbl/get_student_recap/${CURRENT_CLASS_ID}`, 
      save: `guru/pbl/save_reflection`,
      delete: null
    },

    modalTitles: { add: 'Tambah Refleksi', edit: 'Ubah Refleksi' }, // Default

    dataMapper: (student, index) => {
      const teacherRef = student.teacher_reflection || '';
      const feedback = student.student_feedback || '';
      const isLocked = parseInt(student.is_locked) === 1;

      const displayRef = teacherRef ? teacherRef.substring(0, 30) + '...' : '-';
      const displayFeed = feedback ? feedback.substring(0, 30) + '...' : '-';
      
      const statusBadge = isLocked 
        ? '<span class="badge bg-success">Published</span>' 
        : '<span class="badge bg-secondary">Draft</span>';

      return [
        index + 1,
        `<div><span class="fw-bold">${student.student_name}</span> <br> ${statusBadge}</div>`,
        displayRef,
        displayFeed,
        generateActionButtons(student)
      ];
    },

    formPopulator: (form, data) => {
      // 1. Populate Field Standard
      form.querySelector('#modalUserId').value = data.id;
      form.querySelector('#modalStudentName').value = data.name;
      form.querySelector('[name="teacher_reflection"]').value = data.reflection || '';
      form.querySelector('[name="student_feedback"]').value = data.feedback || '';

      const checkboxLocked = form.querySelector('#is_locked');
      
      // Cek apakah ini Input Baru? (Refleksi & Feedback masih kosong)
      const isNewInput = (!data.reflection || data.reflection === '') && (!data.feedback || data.feedback === '');

      if (checkboxLocked) {
         if (isNewInput) {
             // KASUS 1: Input Baru -> Default Checkbox AKTIF (Dicentang)
             checkboxLocked.checked = true;
         } else {
             // KASUS 2: Edit Data -> Ikuti status yang tersimpan di Database
             checkboxLocked.checked = (data.isLocked == '1');
         }
      }

      // 2. LOGIC JUDUL MODAL DINAMIS
      // Cek apakah ini "Input" (Data kosong) atau "Ubah" (Data ada)
      const isAdd = (!data.reflection || data.reflection === '') && (!data.feedback || data.feedback === '');
      const dynamicTitle = isAdd ? 'Tambah Refleksi' : 'Ubah Refleksi';
      
      // Update Config Handler agar CrudHandler menampilkannya dengan benar
      refleksiConfig.modalTitles.edit = dynamicTitle;

      // Update DOM Langsung (Penting untuk panggilan manual dari Tabel Rekap)
      const label = document.getElementById('refleksiModalLabel');
      if(label) label.textContent = dynamicTitle;
    }
  };


  // ============================================================
  // INISIALISASI HANDLER
  // ============================================================

  // 1. Handler Refleksi (Handler UTAMA - Read/Write)
  const refleksiHandler = new CrudHandler(refleksiConfig);
  refleksiHandler.init();


  // 2. Handler Rekap Nilai (Handler KEDUA - Read Only)
  // Kita set readOnly: true agar tidak double submit form
  const rekapConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Rekap Nilai',
    
    // PENTING: Read Only agar tidak membuat instance Modal ganda yang konflik
    readOnly: true, 

    tableId: 'rekapTable',      
    tableParentSelector: '.rekapContainer', 

    urls: {
      load: `guru/pbl/get_student_recap/${CURRENT_CLASS_ID}`
    },

    dataMapper: (student, index) => {
      const quiz = parseFloat(student.quiz_score) || 0;
      const tts = parseFloat(student.tts_score) || 0;
      const obs = parseFloat(student.obs_score) || 0;
      const essay = parseFloat(student.essay_score) || 0;
      const finalScore = (quiz + tts + obs + essay) / 4;

      return [
        index + 1,
        `<span class="fw-bold">${student.student_name}</span>`,
        quiz.toFixed(0),
        tts.toFixed(0),
        obs.toFixed(0),
        essay.toFixed(0),
        `<span class="badge bg-primary fs-6">${finalScore.toFixed(2)}</span>`,
        generateActionButtons(student)
      ];
    }
  };

  const rekapHandler = new CrudHandler(rekapConfig);
  rekapHandler.init();


  // ============================================================
  // LISTENER MANUAL UNTUK TABEL REKAP (Karena ReadOnly)
  // ============================================================
  // Karena rekapHandler diset readOnly, tombol .btn-edit di tabel rekap 
  // tidak akan berfungsi otomatis. Kita buat listener manual untuk 
  // memanggil modal milik refleksiHandler.
  
  const rekapContainer = document.querySelector('.rekapContainer');
  if (rekapContainer) {
      rekapContainer.addEventListener('click', (e) => {
          // Cari tombol edit terdekat
          const btn = e.target.closest('.btn-edit');
          if (btn) {
              // 1. Reset Form
              const form = document.getElementById('refleksiForm');
              form.reset();

              // 2. Populate Form (Gunakan fungsi populator dari config utama)
              refleksiConfig.formPopulator(form, btn.dataset);

              // 3. Tampilkan Modal (Gunakan instance modal dari Handler Utama)
              if (refleksiHandler.modalInstance) {
                  refleksiHandler.modalInstance.show();
              }
          }
      });
  }


  // ============================================================
  // EVENT LISTENER GLOBAL UNTUK TOMBOL LOCK (GEMBOK)
  // ============================================================
  document.addEventListener('click', async (e) => {
      const btn = e.target.closest('.btn-lock');
      if (!btn) return; 

      const userId = btn.dataset.id;
      const status = btn.dataset.status; 
      const actionText = status === '1' ? 'Publikasikan Nilai' : 'Tarik Kembali Nilai';

      const confirm = await Swal.fire({
          title: 'Konfirmasi',
          text: `Apakah Anda yakin ingin ${actionText} untuk siswa ini?`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya, Lakukan',
          cancelButtonText: 'Batal'
      });

      if (confirm.isConfirmed) {
          try {
              const formData = new FormData();
              formData.append('class_id', CURRENT_CLASS_ID);
              formData.append('user_id', userId);
              formData.append('status', status);
              formData.append(window.CSRF_TOKEN_NAME, document.querySelector(`input[name="${window.CSRF_TOKEN_NAME}"]`).value);

              const response = await fetch(`${window.BASE_URL}guru/pbl/toggle_lock`, {
                  method: 'POST',
                  body: formData
              });

              const result = await response.json();

              if (result.csrf_hash) {
                  document.querySelectorAll(`input[name="${window.CSRF_TOKEN_NAME}"]`).forEach(el => el.value = result.csrf_hash);
                  csrfConfig.tokenHash = result.csrf_hash;
              }

              if (result.status === 'success') {
                  Swal.fire('Berhasil', result.message, 'success').then(() => {
                    location.reload(); 
                  });
              } else {
                  Swal.fire('Gagal', result.message, 'error');
              }

          } catch (error) {
              console.error(error);
              Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
          }
      }
  });

});