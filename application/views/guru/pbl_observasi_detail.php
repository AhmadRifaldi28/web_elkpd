<style>
	/* ===== UI/UX OVERRIDES ===== */

	/* Card Statistics */
	.stats-card {
		transition: all 0.3s ease;
		border: none !important;
		border-radius: 10px !important;
		overflow: hidden;
	}
	.stats-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
	}
	.stats-icon {
		width: 48px;
		height: 48px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}

	/* Progress Bar Custom */
	.progress {
		height: 10px !important;
		border-radius: 5px !important;
		background-color: #e9ecef !important;
	}

	/* Table Styling */
	.table-responsive {
		border-radius: 8px;
		overflow: hidden; /* Round corner fix */
	}
	#uploadsTable {
		border-collapse: separate !important;
		border-spacing: 0;
		border: 1px solid #dee2e6;
	}
	#uploadsTable thead th {
		background: #f1f4f9 !important; /* Soft Gray-Blue */
		color: #4154f1 !important; /* NiceAdmin Primary */
		border-bottom: 2px solid #dee2e6 !important;
		padding: 15px !important;
		font-size: 14px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}
	#uploadsTable tbody td {
		border-bottom: 1px solid #eee !important;
		padding: 15px !important;
		vertical-align: middle !important;
	}
	#uploadsTable tbody tr:last-child td {
		border-bottom: none !important;
	}

	/* Avatar Circle for Student */
	.student-avatar {
		width: 40px;
		height: 40px;
		background: linear-gradient(45deg, #4154f1, #2eca6a);
		color: white;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
		font-size: 16px;
		margin-right: 12px;
		flex-shrink: 0;
		text-transform: uppercase;
	}
	.student-info-wrapper {
		display: flex;
		align-items: center;
	}

</style>

<div class="container-fluid">
	<div class="pagetitle mb-4">
		<nav>
			<ol class="breadcrumb mt-2">
				<li class="breadcrumb-item">
					<a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
						<i class="bi bi-grid-fill me-1"></i> Dashboard
					</a>
				</li>
				<li class="breadcrumb-item active"><?= htmlspecialchars($slot->description, ENT_QUOTES, 'UTF-8'); ?></li>
			</ol>
		</nav>
	</div>

	<div class="row mb-4">
		<div class="col-md-4">
			<div class="card stats-card shadow-sm h-100">
				<div class="card-body p-3 d-flex align-items-center">
					<div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
						<i class="bi bi-cloud-arrow-up-fill"></i>
					</div>
					<div>
						<h6 class="text-muted small mb-1">Total Upload</h6>
						<h3 class="mb-0 fw-bold" id="statTotal"><?= $stat_total; ?></h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card stats-card shadow-sm h-100">
				<div class="card-body p-3 d-flex align-items-center">
					<div class="stats-icon bg-success bg-opacity-10 text-success me-3">
						<i class="bi bi-check-circle-fill"></i>
					</div>
					<div>
						<h6 class="text-muted small mb-1">Sudah Dinilai</h6>
						<h3 class="mb-0 fw-bold" id="statGraded"><?= $stat_graded; ?></h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card stats-card shadow-sm h-100">
				<div class="card-body p-3 d-flex align-items-center">
					<div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
						<i class="bi bi-hourglass-split"></i>
					</div>
					<div>
						<h6 class="text-muted small mb-1">Perlu Dinilai</h6>
						<h3 class="mb-0 fw-bold" id="statPending"><?= $stat_pending; ?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-4 border-0 shadow-sm">
		<div class="card-body p-4">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-3 mb-lg-0">
					<h5 class="card-title py-0 mb-2">Progress Penilaian</h5>
					<div class="progress mb-1">
						<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
						id="gradingProgressBar" 
						role="progressbar" 
						style="width: <?= $progress_percent; ?>%" 
						aria-valuenow="<?= $progress_percent; ?>" 
						aria-valuemin="0" 
						aria-valuemax="100">
					</div>
				</div>
				<small class="text-muted" id="progressText"><?= $progress_percent; ?>% Selesai</small>
			</div>
			<div class="col-lg-6 text-lg-end">
				<a href="<?= base_url('guru/pbl/tahap3/' . $slot->class_id) ?>" class="btn btn-outline-secondary me-2">
					<i class="ri-arrow-go-back-line"></i> Kembali
				</a>
				<a href="<?= base_url($url_name . '/pbl_observasi/panduan_detail_observasi_tahap3/' . $class_id); ?>" class="btn btn-primary">
					<i class="bi bi-book-half me-1"></i> Panduan Observasi
				</a>
			</div>
		</div>
	</div>
</div>

</div>

<div class="card shadow-sm h-100 border-0">
	<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
		<h5 class="m-0 fw-bold text-primary">
			<i class="bi bi-table me-2"></i>Data Pengumpulan Siswa
		</h5>
	</div>

	<div class="card-body pt-3" id="observasiTableContainer">
		<div class="table-responsive">
			<table class="table table-hover align-middle" id="uploadsTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="text-center" style="width: 5%;">No</th>
						<th>Siswa & Detail File</th>
						<th class="text-center">Lampiran</th>
						<th class="text-center">Status & Nilai</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-0 shadow-lg">
			<form id="gradeForm">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title"><i class="bi bi-star-fill me-2"></i>Input Penilaian</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body p-4">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<input type="hidden" name="id" id="gradeId">
					<input type="hidden" name="observation_slot_id" value="<?= $slot->id; ?>">
					<input type="hidden" name="user_id" id="userIdInput">

					<div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
						<div class="student-avatar me-3" id="modalAvatar">SIS</div>
						<div>
							<small class="text-muted d-block">Siswa</small>
							<h5 class="mb-0 fw-bold" id="studentNameDisplay">Nama Siswa</h5>
						</div>
					</div>

					<div class="mb-3">
						<label class="form-label fw-bold">Nilai (0-100)</label>
						<input type="number" class="form-control form-control-lg fw-bold text-primary" name="score" id="scoreInput" min="0" max="100" placeholder="0" required>
					</div>

					<div class="mb-3">
						<label class="form-label fw-bold">Feedback</label>
						<textarea class="form-control" name="feedback" id="feedbackInput" rows="3" placeholder="Catatan untuk siswa..."></textarea>
					</div>
				</div>
				<div class="modal-footer bg-white border-top-0">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary px-4">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	window.BASE_URL = "<?= base_url(); ?>";
	window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
	window.SLOT_ID = "<?= $slot->id; ?>";
</script>
<script type="module" src="<?= base_url('assets/js/pbl_observasi_detail.js'); ?>"></script>