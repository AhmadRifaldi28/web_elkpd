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

/* Dekorasi Ikon Background */
.hero-icon-bg {
    position: absolute !important;
    right: -20px !important;
    bottom: -30px !important;
    font-size: 8rem !important;
    color: rgba(255, 255, 255, 0.1) !important;
    transform: rotate(-15deg) !important;
    pointer-events: none !important;
}

/* 2. Stat Cards (Quick Info) */
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
#questionTable thead th, #submissionsTable thead th {
    background-color: #f6f9ff !important;
    color: #012970 !important;
    border-bottom: 2px solid #dee2e6 !important;
    font-family: "Poppins", sans-serif;
}
#questionTable tbody td, #submissionsTable tbody td {
    vertical-align: middle !important;
    padding: 12px 15px !important;
}

/* 4. Modal Styling */
.modal-header-custom {
    background-color: #f6f9ff;
    border-bottom: 1px solid #dee2e6;
}
.input-group-text-custom {
    background-color: #eef2f8;
    color: #4154f1;
    border: 1px solid #ced4da;
    font-weight: 600;
}
.form-control:focus, .form-select:focus {
    border-color: #4154f1;
    box-shadow: 0 0 0 0.25rem rgba(65, 84, 241, 0.15);
}

/* Custom Buttons */
.btn-soft-primary {
    background-color: rgba(65, 84, 241, 0.1);
    color: #4154f1;
    border: none;
    font-weight: 600;
}
.btn-soft-primary:hover {
    background-color: #4154f1;
    color: white;
}
</style>

<div class="container-fluid">
    
    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">PBL</a>
                </li>
                <li class="breadcrumb-item active">Detail Kuis</li>
            </ol>
        </nav>
    </div>

    <div class="card hero-card">
        <div class="card-body p-4 hero-content">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <a href="<?= base_url('guru/pbl/tahap2/' . $quiz->class_id) ?>" class="btn btn-sm btn-light mb-3 rounded-pill px-3">
                        <i class="ri-arrow-go-back-line"></i> Kembali
                    </a>
                    <h2 class="fw-bold mb-2 text-white">Detail Kuis & Evaluasi</h2>
                    <p class="mb-0 opacity-75 text-white" style="max-width: 600px;">
                        <?= htmlspecialchars($quiz->description, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
                <div class="d-flex flex-column gap-2 align-items-end">
                    <button class="btn btn-light text-primary fw-bold shadow-sm" id="btnAddQuestion">
                        <i class="ri-add-circle-line me-1"></i> Tambah Soal
                    </button>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="ri-file-excel-2-line me-1"></i> Import
                        </button>
                        <a href="<?= base_url('guru/pbl_kuis/export_quiz/' . $quiz->id) ?>" class="btn btn-outline-light btn-sm">
                            <i class="ri-download-cloud-2-line me-1"></i> Export
                        </a>
                        <a href="<?= site_url('guru/pbl_kuis_evaluasi/panduan_detail_tahap2'); ?>" class="btn btn-outline-light btn-sm" title="Panduan">
                            <i class="ri-information-line"></i> Panduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <i class="ri-questionnaire-line hero-icon-bg"></i>
    </div>

    <?php if ($this->session->flashdata('import_success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="ri-checkbox-circle-fill me-1"></i>
        <strong>Berhasil!</strong> <?= $this->session->flashdata('import_success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="ri-question-answer-line"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0 font-weight-bold">Total Pertanyaan</h6>
                        <h3 class="mb-0 fw-bold" id="statTotalQuestions">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="ri-user-follow-line"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0 font-weight-bold">Siswa Mengumpulkan</h6>
                        <h3 class="mb-0 fw-bold" id="statTotalSubmissions">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="ri-bar-chart-grouped-line"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0 font-weight-bold">Status Kuis</h6>
                        <span class="badge bg-success bg-opacity-10 text-success">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 text-primary">
                        <i class="ri-list-check me-2"></i>Daftar Pertanyaan
                    </h5>
                    <span class="badge bg-light text-dark border">Bank Soal</span>
                </div>
                <div class="card-body pt-0" id="questionTableContainer">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0" id="questionTable" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Teks Pertanyaan</th>
                                    <th class="text-center" style="width: 10%;">Kunci</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 text-success">
                        <i class="ri-trophy-line me-2"></i>Hasil Evaluasi Siswa
                    </h5>
                    <span class="badge bg-light text-dark border">Rekap Nilai</span>
                </div>
                <div class="card-body pt-0" id="submissionsTableContainer">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped align-middle mb-0" id="submissionsTable" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th>Nama Siswa</th>
                                    <th class="text-center">Nilai Akhir</th>
                                    <th class="text-center">Waktu Submit</th>
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
    </div>
</div>

<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="questionForm">
                <div class="modal-header modal-header-custom p-3">
                    <h5 class="modal-title fw-bold text-primary" id="questionModalLabel">
                        <i class="ri-edit-circle-line me-2"></i>Form Soal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="questionId">
                    <input type="hidden" name="quiz_id" value="<?= $quiz->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Pertanyaan</label>
                        <textarea class="form-control" id="question_text" name="question_text" rows="3" placeholder="Ketik pertanyaan Anda di sini..." required style="resize: none;"></textarea>
                    </div>

                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Pilihan Jawaban</label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">A</span>
                                <input type="text" class="form-control" id="option_a" name="option_a" placeholder="Opsi A" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">B</span>
                                <input type="text" class="form-control" id="option_b" name="option_b" placeholder="Opsi B" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">C</span>
                                <input type="text" class="form-control" id="option_c" name="option_c" placeholder="Opsi C" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">D</span>
                                <input type="text" class="form-control" id="option_d" name="option_d" placeholder="Opsi D" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded border border-success border-opacity-25">
                        <label for="correct_answer" class="form-label fw-bold text-success mb-2">
                            <i class="ri-key-2-fill me-1"></i>Kunci Jawaban Benar
                        </label>
                        <select class="form-select border-success text-success fw-bold" id="correct_answer" name="correct_answer" required>
                            <option value="" disabled selected>-- Pilih Kunci --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="ri-save-3-line me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= base_url('guru/pbl_kuis/import_quiz'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="ri-file-excel-2-fill me-2"></i>Import Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <input type="hidden" name="quiz_id_import" value="<?= $quiz->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">
                    
                    <div class="mb-3">
                        <i class="ri-upload-cloud-2-line display-1 text-warning opacity-50"></i>
                    </div>
                    <p class="text-muted mb-4">Pilih file Excel/CSV untuk mengunggah soal secara massal.</p>

                    <input class="form-control form-control-lg mb-3" type="file" id="import_file" name="import_file" required>
                </div>
                <div class="modal-footer bg-light justify-content-center">
                    <button type="submit" class="btn btn-warning text-dark px-5 fw-bold">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
window.QUIZ_ID = "<?= $quiz->id; ?>";
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
</script>
<script type="module" src="<?= base_url('assets/js/kuis_detail.js'); ?>"></script>