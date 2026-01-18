import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

	const ESSAY_ID = document.getElementById('currentEssayId').value;
	const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');

	const csrfConfig = {
		tokenName: window.CSRF_TOKEN_NAME,
		tokenHash: csrfEl ? csrfEl.value : ''
	};

    // ==========================================
    // FUNGSI UPDATE STATISTIK (DIPERBAIKI)
    // ==========================================
    const updateStats = () => {
    	setTimeout(() => {
    		const questionRows = document.querySelectorAll('#questionTable tbody tr');
    		const studentRows = document.querySelectorAll('#gradingTable tbody tr');

            // 1. Hitung Soal (abaikan jika baris "No data found")
            const qCount = (questionRows.length === 1 && questionRows[0].cells.length === 1) ? 0 : questionRows.length;
            document.getElementById('statTotalQuestions').innerText = qCount;

            // 2. Hitung Siswa & Grading (Logic Baru)
            let sCount = 0;       // Jumlah siswa yang statusnya "Sudah Mengumpulkan"
            let needGrading = 0;  // Jumlah yang sudah kumpul tapi "Belum Dinilai"
            
            // Cek apakah tabel tidak kosong/loading
            if (!(studentRows.length === 1 && studentRows[0].cells.length === 1)) {
            	studentRows.forEach(row => {
                    // Ambil Kolom Status (Index 2)
                    const statusCell = row.cells[2];
                    const statusText = statusCell ? statusCell.innerText : '';

                    // Ambil Kolom Nilai (Index 4)
                    const gradeCell = row.cells[4];
                    const gradeText = gradeCell ? gradeCell.innerText : '';

                    // LOGIKA HITUNG:
                    // Jika teks status mengandung kata "Sudah", berarti siswa submit
                    if (statusText.includes('Sudah')) {
                    	sCount++;

                        // Cek apakah perlu dinilai (hanya jika sudah submit)
                        if (gradeText.includes('Belum Dinilai')) {
                        	needGrading++;
                        }
                      }
                    });
            }

            document.getElementById('statTotalStudents').innerText = sCount;
            document.getElementById('statNeedGrading').innerText = needGrading;
        }, 800); // Delay sedikit menunggu tabel render
    };

    // ==========================================
    // FUNGSI BANTUAN DOM (DYNAMIC INPUT)
    // ==========================================
    const container = document.getElementById('dynamicQuestionContainer');
    const btnAddRowWrapper = document.getElementById('btnAddRowWrapper');
    const btnAddRow = document.getElementById('btnAddRow');

    const createInputRow = (value = '', isRemovable = true) => {
    	const div = document.createElement('div');
    	div.className = 'input-group mb-3 question-row shadow-sm';

    	const label = document.createElement('span');
    	label.className = 'input-group-text bg-light text-primary fw-bold';
    	label.innerHTML = '<i class="ri-question-mark"></i>';

    	const textarea = document.createElement('textarea');
    	textarea.name = 'question_text[]';
    	textarea.className = 'form-control border-start-0';
    	textarea.rows = 2;
    	textarea.placeholder = 'Ketik pertanyaan esai disini...';
    	textarea.value = value;
    	textarea.required = true;

    	div.appendChild(label);
    	div.appendChild(textarea);

    	if (isRemovable) {
    		const btnDel = document.createElement('button');
    		btnDel.type = 'button';
    		btnDel.className = 'btn btn-outline-danger border-start-0';
    		btnDel.innerHTML = '<i class="ri-delete-bin-line"></i>';
    		btnDel.onclick = () => div.remove();
    		div.appendChild(btnDel);
    	}

    	return div;
    };

    if(btnAddRow) {
    	btnAddRow.addEventListener('click', () => {
    		container.appendChild(createInputRow('', true));
    	});
    }

    // ==========================================
    // 1. INSTANCE CRUD: DAFTAR PERTANYAAN
    // ==========================================
    const questionConfig = {
    	baseUrl: window.BASE_URL,
    	entityName: 'Soal',
    	modalId: 'questionModal',
    	formId: 'questionForm',
    	modalLabelId: 'questionModalLabel',
    	hiddenIdField: 'questionId',
    	tableId: 'questionTable',
    	btnAddId: 'btnAddQuestion',
    	tableParentSelector: '#questionTableContainer', 
    	csrf: csrfConfig,
    	urls: {
    		load: `guru/pbl_esai/get_questions_json/${ESSAY_ID}`,
    		save: `guru/pbl_esai/save_question`,
    		delete: (id) => `guru/pbl_esai/delete_question/${id}`
    	},
    	deleteMethod: 'POST',
    	modalTitles: { add: 'Tambah Soal Baru', edit: 'Edit Soal' },
    	deleteNameField: 'text',

    	dataMapper: (q, i) => {
    		const shortText = q.question_text.length > 80 ? q.question_text.substring(0, 80) + '...' : q.question_text;

    		const btns = `
    		<div class="text-center">
    		<button class="btn btn-sm btn-warning text-dark border-warning btn-edit m-2" 
    		title="Edit"
    		data-id="${q.id}" 
    		data-question_text="${q.question_text}">
    			Ubah
    		</button>
    		<button class="btn btn-sm btn-outline-danger border-danger btn-delete" 
    		title="Hapus"
    		data-id="${q.id}" 
    		data-text="No. ${q.question_number}">
    			Hapus
    		</button>
    		</div>
    		`;
    		return [`<div class="text-center text-muted fw-bold">${q.question_number}</div>`, shortText, btns];
    	},

    	onAdd: (form) => {
    		container.innerHTML = '';
    		container.appendChild(createInputRow('', false));
    		btnAddRowWrapper.style.display = 'block';

    		const infoEl = document.getElementById('infoMassUpload');
        if(infoEl) infoEl.classList.remove('d-none');
    	},

    	formPopulator: (form, data) => {
    		container.innerHTML = '';
    		container.appendChild(createInputRow(data.question_text, false));
    		form.querySelector('#questionId').value = data.id;
    		btnAddRowWrapper.style.display = 'none';

    		const infoEl = document.getElementById('infoMassUpload');
        if(infoEl) infoEl.classList.add('d-none');
    	},

    	onDataLoaded: updateStats
    };

    // ==========================================
    // 2. INSTANCE CRUD: PENILAIAN (GRADING)
    // ==========================================
    const gradingConfig = {
    	baseUrl: window.BASE_URL,
    	entityName: 'Nilai',
    	modalId: 'gradeModal',
    	formId: 'gradeForm',
    	modalLabelId: 'gradeModalLabel', 
    	tableId: 'gradingTable',
    	tableParentSelector: '#gradingTableContainer',

    	csrf: csrfConfig,
    	urls: {
    		load: `guru/pbl_esai/get_grading_json/${ESSAY_ID}`,
    		save: `guru/pbl_esai/save_grade`,
    		delete: null 
    	},
    	modalTitles: { edit: 'Evaluasi Siswa' },

    	dataMapper: (s, i) => {
    		let statusBadge = '<span class="badge bg-secondary bg-opacity-10 text-secondary"><i class="ri-time-line me-1"></i>Belum Mengumpulkan</span>';
    		let dateText = '-';
    		let gradeText = '-';
    		let btnClass = 'btn-secondary disabled';
    		let btnIcon = '';
    		let btnText = 'Belum Ada';
    		let isDisabled = 'disabled';

    		if (s.submission_id) {
    			statusBadge = '<span class="badge bg-success bg-opacity-10 text-success"><i class="ri-checkbox-circle-line me-1"></i>Sudah Mengumpulkan</span>';
    			dateText = new Date(s.submitted_at).toLocaleString('id-ID', {day: 'numeric', month: 'short', hour:'2-digit', minute:'2-digit'});

    			if (s.grade !== null) {
    				let gradeColor = s.grade >= 75 ? 'text-success' : 'text-warning';
    				gradeText = `<span class="fw-bold ${gradeColor} fs-6">${s.grade}</span>`;
    				btnClass = 'btn-outline-success btn-edit'; 
    				btnIcon = 'ri-edit-box-line';
    				btnText = 'Edit Nilai';
    			} else {
    				gradeText = '<span class="badge bg-danger bg-opacity-10 text-danger">Belum Dinilai</span>';
    				btnClass = 'btn-primary btn-edit shadow-sm'; 
    				btnIcon = 'ri-ball-pen-line';
    				btnText = 'Beri Nilai';
    			}
    			isDisabled = '';
    		}

    		const safeContent = s.submission_content ? encodeURIComponent(s.submission_content) : '';

    		const actionBtn = `
    		<div class="text-center">
    		<button class="btn btn-sm ${btnClass}" ${isDisabled}
    		data-id="${s.submission_id}" 
    		data-student_name="${s.student_name}"
    		data-content="${safeContent}"
    		data-grade="${s.grade || ''}"
    		data-feedback="${s.feedback || ''}">
    		<i class="${btnIcon} me-1"></i> ${btnText}
    		</button>
    		</div>
    		`;

    		return [
    		`<div class="text-center text-muted">${i + 1}</div>`, 
    		`<span class="fw-bold text-dark">${s.student_name}</span>`, 
    		`<div class="text-center">${statusBadge}</div>`, 
    		`<small class="text-muted">${dateText}</small>`, 
    		`<div class="text-center">${gradeText}</div>`, 
    		actionBtn
    		];
    	},

    	formPopulator: (form, data) => {
    		form.querySelector('#submissionId').value = data.id; 

    		const labelEl = document.getElementById('gradeModalLabel');
    		if(labelEl) labelEl.innerHTML = `<i class="ri-user-star-line me-2"></i>Evaluasi: ${data.student_name}`;

    		const content = data.content ? decodeURIComponent(data.content) : '-';
    		document.getElementById('studentAnswerContent').innerHTML = content.replace(/\n/g, '<br>');

    		form.querySelector('#gradeInput').value = data.grade;
    		form.querySelector('#feedbackInput').value = data.feedback;
    	},

    	onDataLoaded: updateStats
    };

    new CrudHandler(questionConfig).init();
    new CrudHandler(gradingConfig).init();
  });