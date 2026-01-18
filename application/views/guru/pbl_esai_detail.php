<style>
	/* 1. Hero Card (Header Judul) */
	.hero-card {
		background: linear-gradient(135deg, #4154f1 0%, #2132bd 100%) !important;
		color: white !important;
		border: none !important;
		border-radius: 10px !important;
		position: relative !important;
		overflow: hidden !important;
		box-shadow: 0 5px 15px rgba(65, 84, 241, 0.3) !important;
		margin-bottom: 25px;
	}

	.hero-content {
		position: relative;
		z-index: 2;
	}

	.hero-icon-bg {
		position: absolute !important;
		right: -20px !important;
		bottom: -30px !important;
		font-size: 8rem !important;
		color: rgba(255, 255, 255, 0.1) !important;
		transform: rotate(-15deg) !important;
		pointer-events: none !important;
	}

	/* 2. Stat Cards */
	.stat-card {
		border: none;
		border-radius: 8px;
		box-shadow: 0 0 15px rgba(0,0,0,0.05);
		transition: transform 0.3s;
	}
	.stat-card:hover {
		transform: translateY(-5px);
	}
	.stat-icon {
		width: 48px;
		height: 48px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}

	/* 3. Table Styling */
	.table-responsive {
		border-radius: 8px;
		overflow: hidden;
	}
	#questionTable thead th, #gradingTable thead th {
		background-color: #f6f9ff !important;
		color: #012970 !important;
		border-bottom: 2px solid #dee2e6 !important;
		font-family: "Poppins", sans-serif;
	}
	#questionTable tbody td, #gradingTable tbody td {
		vertical-align: middle !important;
		padding: 12px 15px !important;
	}

	/* 4. Modal Styling */
	.modal-header-custom {
		background-color: #f6f9ff;
		border-bottom: 1px solid #dee2e6;
	}
</style>

<div class="container-fluid">

	<div class="pagetitle mb-3">
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">PBL</a>
				</li>
				<li class="breadcrumb-item active">Detail Esai</li>
			</ol>
		</nav>
	</div>

	<div class="card hero-card">
		<div class="card-body p-4 hero-content">
			<div class="d-flex justify-content-between align-items-start">
				<div>
					<a href="<?= base_url('guru/pbl/tahap4/' . $essay->class_id) ?>" class="btn btn-sm btn-light mb-3 rounded-pill px-3">
						<i class="ri-arrow-go-back-line"></i> Kembali
					</a>
					<h2 class="fw-bold mb-2 text-white"><?= htmlspecialchars($essay->title ?? 'Tugas Esai', ENT_QUOTES, 'UTF-8'); ?></h2>
					<p class="mb-0 opacity-75 text-white" style="max-width: 700px;">
						<?= htmlspecialchars($essay->description, ENT_QUOTES, 'UTF-8'); ?>
					</p>
				</div>
				<div class="d-flex flex-column gap-2 align-items-end">
					<button class="btn btn-light text-primary fw-bold shadow-sm" id="btnAddQuestion">
						<i class="ri-add-circle-line me-1"></i> Tambah Soal
					</button>
					<a href="<?= base_url($url_name . '/pbl_esai/panduan_detail_esai/' . $class_id); ?>" class="btn btn-outline-light btn-sm">
						<i class="ri-book-open-line me-1"></i> Panduan
					</a>
				</div>
			</div>
		</div>
		<i class="ri-file-text-line hero-icon-bg"></i>
	</div>

	<input type="hidden" id="currentEssayId" value="<?= $essay->id; ?>">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
	value="<?= $this->security->get_csrf_hash(); ?>">

	<div class="row mb-4">
		<div class="col-md-4">
			<div class="card stat-card h-100">
				<div class="card-body d-flex align-items-center">
					<div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
						<i class="ri-question-answer-line"></i>
					</div>
					<div>
						<h6 class="text-muted small mb-0 font-weight-bold">Total Soal</h6>
						<h3 class="mb-0 fw-bold" id="statTotalQuestions">0</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card stat-card h-100">
				<div class="card-body d-flex align-items-center">
					<div class="stat-icon bg-success bg-opacity-10 text-success me-3">
						<i class="ri-group-line"></i>
					</div>
					<div>
						<h6 class="text-muted small mb-0 font-weight-bold">Siswa Mengumpulkan</h6>
						<h3 class="mb-0 fw-bold" id="statTotalStudents">0</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card stat-card h-100">
				<div class="card-body d-flex align-items-center">
					<div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
						<i class="ri-edit-circle-line"></i>
					</div>
					<div>
						<h6 class="text-muted small mb-0 font-weight-bold">Perlu Dinilai</h6>
						<h3 class="mb-0 fw-bold" id="statNeedGrading">0</h3>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 mb-4">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
					<h5 class="card-title m-0 text-primary">
						<i class="ri-list-check me-2"></i> Daftar Pertanyaan
					</h5>
					<span class="badge bg-primary bg-opacity-10 text-primary">Bank Soal</span>
				</div>
				<div class="card-body pt-0" id="questionTableContainer">
					<div class="table-responsive">
						<table class="table table-hover align-middle" id="questionTable">
							<thead>
								<tr>
									<th width="8%" class="text-center">No</th>
									<th>Pertanyaan</th>
									<th class="text-center" width="24%">Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
					<h5 class="card-title m-0 text-success">
						<i class="ri-trophy-line me-2"></i> Jawaban Murid
					</h5>
					<span class="badge bg-success bg-opacity-10 text-success">Monitoring</span>
				</div>
				<div class="card-body pt-0" id="gradingTableContainer">
					<div class="table-responsive">
						<table class="table table-hover align-middle" id="gradingTable">
							<thead>
								<tr>
									<th width="5%" class="text-center">No</th>
									<th>Nama Murid</th>
									<th class="text-center">Status</th>
									<th>Waktu Kirim</th>
									<th class="text-center">Nilai</th>
									<th width="15%" class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content border-0 shadow-lg">
			<form id="questionForm">
				<div class="modal-header modal-header-custom">
					<h5 class="modal-title fw-bold text-primary" id="questionModalLabel">
						<i class="ri-edit-2-line me-2"></i>Form Soal Esai
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body p-4">
					<input type="hidden" name="id" id="questionId">
					<input type="hidden" name="essay_id" value="<?= $essay->id; ?>">

					<div id="infoMassUpload" class="alert alert-info d-flex align-items-center p-2 mb-3 small">
						<i class="ri-information-fill me-2 fs-5"></i>
						<div>Anda dapat menambahkan beberapa soal sekaligus.</div>
					</div>

					<div id="dynamicQuestionContainer"></div>

					<div class="mt-3" id="btnAddRowWrapper">
						<button type="button" class="btn btn-outline-primary btn-sm w-100 border-dashed" id="btnAddRow">
							<i class="ri-add-line me-1"></i> Tambah Baris Soal Lagi
						</button>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary px-4">Simpan Soal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content border-0 shadow-lg">
			<form id="gradeForm">
				<div class="modal-header bg-success text-white">
					<h5 class="modal-title" id="gradeModalLabel">
						<i class="ri-check-double-line me-2"></i>Penilaian Siswa
					</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body p-0">
					<input type="hidden" name="submission_id" id="submissionId">
					<div class="row g-0">
						<div class="col-md-7 border-end bg-light">
							<div class="p-3 border-bottom bg-white">
								<h6 class="fw-bold m-0 text-dark"><i class="ri-file-text-line me-1"></i> Jawaban Siswa</h6>
							</div>
							<div class="p-4" id="studentAnswerContent" style="min-height: 300px; max-height: 500px; overflow-y: auto; font-family: 'Courier New', monospace; font-size: 0.95rem; line-height: 1.6;">
							</div>
						</div>

						<div class="col-md-5 bg-white">
							<div class="p-4 h-100 d-flex flex-column">
								<h6 class="fw-bold mb-3 text-success">Form Evaluasi</h6>

								<div class="mb-3">
									<label class="form-label small text-muted fw-bold text-uppercase">Nilai (0-100)</label>
									<div class="input-group">
										<span class="input-group-text bg-light text-success fw-bold">Score</span>
										<input type="number" name="grade" id="gradeInput" class="form-control form-control-lg fw-bold text-center text-primary" min="0" max="100" placeholder="0" required>
									</div>
								</div>

								<div class="mb-3 flex-grow-1">
									<label class="form-label small text-muted fw-bold text-uppercase">Feedback Guru</label>
									<textarea name="feedback" id="feedbackInput" class="form-control h-100" style="min-height: 150px;" placeholder="Berikan catatan penguatan atau koreksi..."></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-light justify-content-between">
					<small class="text-muted"><i class="ri-lock-line me-1"></i>Penilaian bersifat rahasia bagi siswa lain.</small>
					<div>
						<button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-success px-4"><i class="ri-save-3-line me-1"></i> Simpan Nilai</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	window.BASE_URL = "<?= base_url(); ?>";
	window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
</script>
<script type="module" src="<?= base_url('assets/js/pbl_esai_detail.js'); ?>"></script>