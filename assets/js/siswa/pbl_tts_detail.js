document.addEventListener('DOMContentLoaded', () => {
	const TTS_ID = window.TTS_ID;
	const GRID_SIZE = window.GRID_SIZE;
	const IS_DONE = window.IS_DONE;
	const CELL_SIZE = 30;

	if (!TTS_ID) return;

  // Elements
  const gridContainer = document.getElementById('ttsGridContainer');
  const listAcross = document.getElementById('listAcross');
  const listDown = document.getElementById('listDown');
  const btnSubmit = document.getElementById('btnSubmitTTS');

  // 1. Render Grid Dasar (Hitam)
  renderEmptyGrid();

  // 2. Tentukan Mode: Mengerjakan atau Review
  if (IS_DONE) {
  	loadReviewData();
  } else {
  	loadGameData();
  }

  // --- FUNCTION RENDER GRID DASAR ---
  function renderEmptyGrid() {
  	gridContainer.style.gridTemplateColumns = `repeat(${GRID_SIZE}, ${CELL_SIZE}px)`;
    // Hitung lebar agar centered
    gridContainer.style.width = `${(GRID_SIZE * CELL_SIZE) + (GRID_SIZE * 2)}px`; 

    for (let y = 1; y <= GRID_SIZE; y++) {
    	for (let x = 1; x <= GRID_SIZE; x++) {
    		const cell = document.createElement('div');
    		cell.classList.add('tts-cell');
    		cell.dataset.x = x;
    		cell.dataset.y = y;
    		gridContainer.appendChild(cell);
    	}
    }
  }

  // --- MODE 1: MENGERJAKAN (GAME) ---
  function loadGameData() {
  	fetch(`${window.BASE_URL}siswa/pbl_tts/get_game_data/${TTS_ID}`)
  	.then(res => res.json())
  	.then(data => {
      mapQuestionsToGrid(data, false); // false = mode game
      renderClues(data, false);
      setupInputNavigation();
    });
  }

  // --- MODE 2: REVIEW (LIHAT HASIL) ---
  function loadReviewData() {
  	fetch(`${window.BASE_URL}siswa/pbl_tts/get_review_data/${TTS_ID}`)
  	.then(res => res.json())
  	.then(data => {
      mapQuestionsToGrid(data, true); // true = mode review
      renderClues(data, true);
    });
  }

  // --- LOGIKA MAPPING SOAL KE GRID ---
  function mapQuestionsToGrid(questions, isReviewMode) {
  	questions.forEach(q => {
  		const len = parseInt(q.ans_length);
  		const startX = parseInt(q.start_x);
  		const startY = parseInt(q.start_y);
  		const isAcross = q.direction === 'across';

      // Variabel untuk Review
      const userAnsArray = isReviewMode ? (q.user_answer || '').split('') : [];

      // Render Label Nomor
      const startCell = document.querySelector(`.tts-cell[data-x="${startX}"][data-y="${startY}"]`);
      if (startCell && !startCell.querySelector(`.num-label[data-dir="${q.direction}"]`)) {
      	const numSpan = document.createElement('span');
      	numSpan.className = 'num-label';
      	if (q.direction === 'down') numSpan.classList.add('down');
      	numSpan.innerText = q.number;
      	numSpan.dataset.dir = q.direction;
      	startCell.appendChild(numSpan);
      }

      // Loop per huruf
      for (let i = 0; i < len; i++) {
      	let cx = startX + (isAcross ? i : 0);
      	let cy = startY + (isAcross ? 0 : i);

      	const cell = document.querySelector(`.tts-cell[data-x="${cx}"][data-y="${cy}"]`);
      	if (cell) {
      		if (!cell.classList.contains('active-cell')) {
      			cell.classList.add('active-cell');

            // Buat Input
            const input = document.createElement('input');
            input.type = 'text';
            input.dataset.x = cx;
            input.dataset.y = cy;
            
            if (isReviewMode) {
                input.readOnly = true; // Review tidak bisa edit
              } else {
              	input.maxLength = 1;
              }

              cell.appendChild(input);
            }

        // --- LOGIKA WARNA & ISI NILAI (KHUSUS REVIEW) ---
        if (isReviewMode) {
        	const input = cell.querySelector('input');
            const userChar = userAnsArray[i] || ''; // Huruf jawaban siswa di index ini
            
            // Jika sel ini belum diisi (atau ditimpa soal lain), isi value
            // Prioritaskan visualisasi 'salah' jika terjadi persimpangan
            if (input.value === '' || !cell.classList.contains('cell-wrong')) {
            	input.value = userChar;
            }

            // Warna Cell
            // Logika sederhana: Jika jawaban user utk soal ini Benar, cell hijau.
            // Jika Salah, cell merah.
            // (Catatan: di persimpangan, warna 'salah' akan menimpa 'benar')
            if (q.is_correct == 1) {
            	if (!cell.classList.contains('cell-wrong')) {
            		cell.classList.add('cell-correct');
            	}
            } else {
            	cell.classList.remove('cell-correct');
            	cell.classList.add('cell-wrong');
            }
          } else {
            // Mode Game: Tampilkan hint huruf pertama
            if (q.first_char && i === 0) {
            	const input = cell.querySelector('input');
            	input.value = q.first_char;
            }
          }

        // Simpan ID soal di dataset cell (untuk highlight clue)
        const existingQIds = cell.dataset.questionIds ? cell.dataset.questionIds.split(',') : [];
        if (!existingQIds.includes(q.id)) {
        	existingQIds.push(q.id);
        	cell.dataset.questionIds = existingQIds.join(',');
        }
      }
    }
  });
}

// --- RENDER LIST PERTANYAAN (DENGAN EMOTE) ---
function renderClues(questions, isReviewMode) {
	questions.forEach(q => {
		const item = document.createElement('div');
		item.className = 'clue-item';
		item.dataset.id = q.id;

        // Konten Teks
        let html = `<span><strong>${q.number}.</strong> ${q.question}</span>`;

        // Tambah Emote jika Review Mode
        if (isReviewMode) {
        	if (q.is_correct == 1) {
        		html += `<i class="bi bi-emoji-smile-fill text-success emote-icon" title="Benar: ${q.key_answer}"></i>`;
        	} else {
        		html += `<div class="text-end ms-2">
        		<i class="bi bi-emoji-frown-fill text-danger emote-icon"></i><br>
        		<small class="text-success fw-bold" style="font-size:0.7em">Jwb: ${q.key_answer}</small>
        		</div>`;
        	}
        }

        item.innerHTML = html;

        // Klik Item -> Highlight di Grid
        item.addEventListener('click', () => {
        	const input = document.querySelector(`.tts-cell[data-x="${q.start_x}"][data-y="${q.start_y}"] input`);
        	if (input && !isReviewMode) input.focus();
        	highlightClue(q.id);
        });

        if (q.direction === 'across') listAcross.appendChild(item);
        else listDown.appendChild(item);
      });
}

function highlightClue(questionId) {
	document.querySelectorAll('.clue-item').forEach(el => el.classList.remove('active-clue'));
	if (questionId) {
		const clueEl = document.querySelector(`.clue-item[data-id="${questionId}"]`);
		if (clueEl) {
			clueEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
			clueEl.classList.add('active-clue');
		}
	}
}

// --- NAVIGASI KEYBOARD (Hanya Mode Game) ---
function setupInputNavigation() {
	const inputs = document.querySelectorAll('.tts-cell input');
	inputs.forEach(input => {
		input.addEventListener('focus', (e) => {
			const cell = e.target.closest('.tts-cell');
			const qIds = cell.dataset.questionIds.split(',');
			if (qIds.length > 0) highlightClue(qIds[0]);
		});

		input.addEventListener('input', (e) => {
			if (e.target.value.length === 1) {
                // Cari input berikutnya di DOM (secara urutan render)
                const next = Array.from(inputs).indexOf(e.target) + 1;
                if (next < inputs.length) inputs[next].focus();
              }
            });

		input.addEventListener('keydown', (e) => {
			if (e.key === 'Backspace' && e.target.value === '') {
				const prev = Array.from(inputs).indexOf(e.target) - 1;
				if (prev >= 0) inputs[prev].focus();
			}
		});
	});
}

// --- SUBMIT JAWABAN ---
if (btnSubmit) {
	btnSubmit.addEventListener('click', () => {
		Swal.fire({
			title: 'Kirim Jawaban?',
			text: "Pastikan semua kotak terisi.",
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: 'Ya, Kirim!'
		}).then((result) => {
			if (result.isConfirmed) processSubmission();
		});
	});
}

function processSubmission() {
    // Kumpulkan jawaban berdasarkan ID soal (bukan per grid)
    // Kita butuh data asli soal dari DOM atau fetch ulang. 
    // Agar efisien, kita ambil dari variabel global 'questions' jika disimpan, 
    // tapi di sini kita ambil dari DOM Grid dgn rekonstruksi sederhana
    // atau fetch data game dulu di awal dan simpan di variabel.
    
    // PENTING: Untuk simplifikasi, kita ambil semua input dan kirim
    // Tapi server butuh format: answers[question_id] = "KATA"
    // Maka kita harus reconstruct kata berdasarkan koordinat.
    
    // Fetch ulang struktur soal (cepat karena cache) atau gunakan data global
    fetch(`${window.BASE_URL}siswa/pbl_tts/get_game_data/${TTS_ID}`)
    .then(res => res.json())
    .then(questions => {
    	const answers = {};

    	questions.forEach(q => {
    		const len = parseInt(q.ans_length);
    		const startX = parseInt(q.start_x);
    		const startY = parseInt(q.start_y);
    		const isAcross = q.direction === 'across';

    		let word = '';
    		for (let i = 0; i < len; i++) {
    			let cx = startX + (isAcross ? i : 0);
    			let cy = startY + (isAcross ? 0 : i);

    			const input = document.querySelector(`.tts-cell[data-x="${cx}"][data-y="${cy}"] input`);
    			if (input) word += input.value;
    		}
    		answers[q.id] = word;
    	});

    	sendData(answers);
    });
  }

  function sendData(answers) {
  	const form = document.getElementById('ttsSubmissionForm');
  	const formData = new FormData(form);

  	for (const [qid, val] of Object.entries(answers)) {
  		formData.append(`answers[${qid}]`, val);
  	}

  	fetch(`${window.BASE_URL}siswa/pbl_tts/submit_tts`, {
  		method: 'POST',
  		body: formData
  	})
  	.then(res => res.json())
  	.then(data => {
  		if (data.csrf_hash) document.querySelector(`input[name="${window.CSRF_TOKEN_NAME}"]`).value = data.csrf_hash;

  		if (data.status === 'success') {
  			Swal.fire({
  				icon: 'success',
  				title: 'Selesai!',
  				text: `Nilai Anda: ${data.score}`,
  				allowOutsideClick: false
  			}).then(() => window.location.reload());
  		} else {
  			Swal.fire('Gagal', data.message, 'error');
  		}
  	})
  	.catch(err => Swal.fire('Error', 'Gagal mengirim data.', 'error'));
  }
});