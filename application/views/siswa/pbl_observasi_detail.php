<style>
	/* ===== UI/UX OVERRIDES ===== */

	/* Card Styling - NiceAdmin Standard */
	.card {
		border: none !important;
		border-radius: 8px !important;
		box-shadow: 0 0 20px rgba(1, 41, 112, 0.1) !important;
		margin-bottom: 30px !important;
		overflow: hidden; /* Ensures headers align with borders */
	}

	.card-header {
		background-color: #fff !important;
		border-bottom: 2px solid #f6f9ff !important;
		padding: 15px 20px !important;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.card-title {
		padding: 0 !important;
		font-size: 18px !important;
		font-weight: 600 !important;
		color: #012970 !important;
		font-family: "Poppins", sans-serif !important;
		margin-bottom: 0 !important;
	}

	/* Table Styling - Professional Look */
	.table-responsive {
		border-radius: 5px;
	}

	#myUploadsTable {
		width: 100% !important;
		border-collapse: collapse !important;
		border: 1px solid #dee2e6 !important; /* Border keliling luar */
	}

	#myUploadsTable th, 
	#myUploadsTable td {
		border: 1px solid #dee2e6 !important; /* Border grid lengkap */
		padding: 12px 15px !important;
		vertical-align: middle !important;
		color: #444444 !important;
	}

	#myUploadsTable thead th {
		background: #f6f9ff !important; /* Soft Blue Header */
		color: #012970 !important;
		font-weight: 600 !important;
		font-family: "Poppins", sans-serif !important;
		border-bottom: 2px solid #dee2e6 !important;
		white-space: nowrap !important;
	}

	/* Hover Effect */
	.table-hover tbody tr:hover {
		background-color: #fcfdfe !important;
	}

	/* Result Card Special Styling */
	.result-score-box {
		background: linear-gradient(45deg, #e0f8e9, #f0fdf4);
		border-radius: 10px;
		padding: 20px;
		height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	/* Page Title Decoration */
	.pagetitle h1 {
		font-size: 24px;
		margin-bottom: 0;
		font-weight: 600;
		color: #012970;
	}

	/* Button & Action Styling */
	.btn-primary-soft {
		background-color: #e6f0ff !important;
		color: #0d6efd !important;
		border: none !important;
		font-weight: 600 !important;
	}
	.btn-primary-soft:hover {
		background-color: #0d6efd !important;
		color: #fff !important;
	}

	.step-card {
		transition: all 0.3s;
		border-left: 4px solid transparent;
	}
	.step-card.active {
		border-left-color: #0d6efd;
		background-color: #f8fbff;
	}
	.step-card.done {
		border-left-color: #198754;
	}
</style>

<div class="container-fluid">
	<div class="pagetitle mb-4">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				<nav>
					<ol class="breadcrumb mt-2">
						<li class="breadcrumb-item">
							<a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
								<i class="bi bi-grid-fill me-1"></i> PBL
							</a>
						</li>
						<li class="breadcrumb-item active"><?= htmlspecialchars($slot->description, ENT_QUOTES, 'UTF-8'); ?></li>
					</ol>
				</nav>
			</div>
			<div>
				<a href="<?= base_url('siswa/pbl/tahap3/' . $class_id) ?>" class="btn btn-outline-secondary">
					<i class="ri-arrow-go-back-line"></i> Kembali
				</a>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-md-4">
			<div class="card step-card shadow-sm h-100 <?= !empty($result) ? 'done' : 'active' ?>">
				<div class="card-body d-flex align-items-center p-3">
					<div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3">
						<i class="bi bi-cloud-upload-fill fs-4"></i>
					</div>
					<div>
						<h6 class="fw-bold mb-1">1. Upload Tugas</h6>
						<small class="text-muted">Unggah laporan observasi Anda.</small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card step-card shadow-sm h-100 <?= !empty($result) ? 'done' : '' ?>">
				<div class="card-body d-flex align-items-center p-3">
					<div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning me-3">
						<i class="bi bi-hourglass-split fs-4"></i>
					</div>
					<div>
						<h6 class="fw-bold mb-1">2. Menunggu Penilaian</h6>
						<small class="text-muted">Guru sedang memeriksa file.</small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card step-card shadow-sm h-100 <?= !empty($result) ? 'active border-success' : '' ?>">
				<div class="card-body d-flex align-items-center p-3">
					<div class="bg-success bg-opacity-10 p-3 rounded-circle text-success me-3">
						<i class="bi bi-award-fill fs-4"></i>
					</div>
					<div>
						<h6 class="fw-bold mb-1">3. Hasil & Nilai</h6>
						<small class="text-muted">Lihat skor dan feedback.</small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (!empty($result)) : ?>
		<div class="card mb-4 border-0 shadow-sm overflow-hidden">
			<div class="card-body p-0">
				<div class="row g-0">
					<div class="col-md-3 bg-success bg-opacity-10 p-4 d-flex flex-column justify-content-center align-items-center text-center">
						<h6 class="text-success fw-bold text-uppercase mb-2">Nilai Akhir</h6>
						<h1 class="display-3 fw-bold text-success mb-0"><?= $result->score; ?></h1>
						<span class="badge bg-success rounded-pill mt-2">Selesai</span>
					</div>
					<div class="col-md-9 p-4">
						<h5 class="text-primary fw-bold mb-3"><i class="bi bi-chat-quote-fill me-2"></i>Umpan Balik Guru</h5>
						<div class="alert alert-light border fst-italic text-dark">
							<?= !empty($result->feedback) ? nl2br(htmlspecialchars($result->feedback)) : 'Tidak ada catatan tambahan.'; ?>
						</div>
						<div class="text-muted small mt-2">
							<i class="bi bi-clock me-1"></i> Dinilai pada: <?= date('d M Y, H:i', strtotime($result->created_at)); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-lg-3 order-lg-2 mb-4">
			<div class="card h-100 border-0 shadow-sm">
				<div class="card-header bg-white py-3">
					<h5 class="card-title m-0"><i class="bi bi-info-circle text-info me-2"></i>Instruksi Tugas</h5>
				</div>
				<div class="card-body">
					<div class="p-3 bg-light rounded border mb-3">
						<?= nl2br(htmlspecialchars($slot->description)); ?>
					</div>
					<div class="alert alert-warning d-flex align-items-start small" role="alert">
						<i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
						<div>
							Pastikan file yang diunggah dapat dibaca (PDF/Word/Gambar). Maksimal ukuran 5MB.
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-9 order-lg-1">
			<div class="card h-100 border-0 shadow-sm">
				<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
					<h5 class="card-title m-0"><i class="bi bi-folder2-open text-primary me-2"></i>File Saya</h5>

					<button class="btn btn-primary btn-sm px-3 shadow-sm" id="btnAddUpload" data-bs-toggle="modal" data-bs-target="#uploadModal">
						<i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload File
					</button>
				</div>
				<div class="card-body pt-3 uploadContainer">

					<!-- <div id="uploadLimitMsg" class="alert alert-info small d-none mb-3">
						<i class="bi bi-info-circle me-1"></i> Anda sudah mengunggah file. Hapus file lama jika ingin mengganti.
					</div> -->

					<?php if (!empty($result)) : ?>

						<div id="uploadLimitMsg" class="alert alert-info small d-none mb-3">
							<i class="bi bi-info-circle me-1"></i> Tugas Anda telah dinilai.
						</div>
						
					<?php else: ?>

						<div id="uploadLimitMsg" class="alert alert-info small d-none mb-3">
							<i class="bi bi-info-circle me-1"></i> Anda sudah mengunggah file. Hapus file lama jika ingin mengganti.
						</div>
						
					<?php endif ?>

					<div class="table-responsive">
						<table class="table table-hover table-bordered align-middle" id="myUploadsTable" width="100%">
							<thead class="bg-light">
								<tr>
									<th class="text-center" width="6%">No</th>
									<th>Nama File</th>
									<th>Status</th>
									<th>Waktu Upload</th>
									<th class="text-center" width="24%">Aksi</th>
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

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-0 shadow">
			<form id="uploadForm" enctype="multipart/form-data">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="uploadModalLabel"><i class="bi bi-cloud-upload me-2"></i>Upload File</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-4">
					<input type="hidden" name="observation_slot_id" value="<?= $slot->id; ?>">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="text-center mb-4">
						<i class="bi bi-file-earmark-arrow-up display-4 text-muted"></i>
						<p class="small text-muted mt-2">Pilih dokumen laporan hasil observasi Anda</p>
					</div>

					<div class="mb-3">
						<label for="file_upload" class="form-label fw-bold">File Dokumen</label>
						<input class="form-control" type="file" id="file_upload" name="file_upload" required>
					</div>

					<div class="mb-3">
						<label for="description" class="form-label fw-bold">Catatan (Opsional)</label>
						<textarea class="form-control" id="description" name="description" rows="2" placeholder="Keterangan singkat..."></textarea>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary px-4">Kirim</button>
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

<script type="module" src="<?= base_url('assets/js/siswa/pbl_observasi_detail.js'); ?>"></script>