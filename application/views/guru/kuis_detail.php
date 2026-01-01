<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#questionTable,
#submissionsTable {
    min-width: 720px !important;
}

#questionTable thead th,
#submissionsTable thead th {
    background: #e0efff !important;
}

.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
}

.action {
    width: 15%;
}

/* Responsive Styles */
@media (max-width: 1051px) {
    .action {
        width: 22%;
    }
}

@media (max-width: 768px) {

    #questionTable thead th,
    #submissionsTable thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }
}

@media (max-width: 576px) {
    #questionTable td {
        white-space: nowrap;
    }
}
</style>

<div class="container-fluid">
    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
                        PBL
                    </a>
                </li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($quiz->description, ENT_QUOTES, 'UTF-8'); ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url('guru/pbl/tahap2/' . $quiz->class_id) ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <?php if ($this->session->flashdata('import_success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> <?= $this->session->flashdata('import_success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-3">
        <div class="d-flex flex-wrap gap-2 p-3">
            <button class="btn btn-primary" id="btnAddQuestion">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pertanyaan
            </button>
            <a href="<?= base_url('guru/pbl_kuis/export_quiz/' . $quiz->id) ?>" class="btn btn-success">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export
            </a>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload"></i> Import
            </button>
            <a href="<?= site_url('guru/pbl_kuis_evaluasi/panduan_detail_tahap2'); ?>" class="btn btn-info btn-sm">
                Panduan Kuis Detail
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Tabel Pertanyaan -->
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary">Daftar Pertanyaan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="questionTable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Pertanyaan</th>
                                <th style="width: 10%;">Jawaban</th>
                                <th class="action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel Nilai Siswa -->
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Daftar Nilai Siswa</h5>
            </div>
            <div class="card-body" id="submissionsTableContainer">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="submissionsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Siswa</th>
                                <th>Nilai</th>
                                <th>Waktu</th>
                                <th class="action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Diisi oleh JavaScript submissionHandler -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Pertanyaan & Import tetap sama -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="questionForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionModalLabel">Tambah Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="questionId">
                    <input type="hidden" name="quiz_id" value="<?= $quiz->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-3">
                        <label for="question_text" class="form-label">Teks Pertanyaan</label>
                        <textarea class="form-control" id="question_text" name="question_text" rows="3"
                            required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="option_a" class="form-label">Opsi A</label>
                            <input type="text" class="form-control" id="option_a" name="option_a" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="option_b" class="form-label">Opsi B</label>
                            <input type="text" class="form-control" id="option_b" name="option_b" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="option_c" class="form-label">Opsi C</label>
                            <input type="text" class="form-control" id="option_c" name="option_c" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="option_d" class="form-label">Opsi D</label>
                            <input type="text" class="form-control" id="option_d" name="option_d" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Jawaban Benar</label>
                        <select class="form-select" id="correct_answer" name="correct_answer" required>
                            <option value="" disabled selected>-- Pilih Jawaban --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('guru/pbl_kuis/import_quiz'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="quiz_id_import" value="<?= $quiz->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">Pilih file (Excel/CSV)</label>
                        <input class="form-control" type="file" id="import_file" name="import_file" required>
                    </div>
                    <p class="form-text">
                        Pastikan file Anda memiliki kolom: `question_text`, `option_a`, `option_b`, `option_c`,
                        `option_d`, `correct_answer`.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
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