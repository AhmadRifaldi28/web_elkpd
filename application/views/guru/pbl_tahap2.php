<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#quizTable,
#ttsTable {
    min-width: 720px !important;
}

#quizTable thead th,
#ttsTable thead th {
    background: #e0efff !important;
}

.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
}

.action {
    width: 20%;
}

/* Responsive Styles */
@media (max-width: 1051px) {
    .action {
        width: 28%;
    }
}

@media (max-width: 768px) {

    #quizTable thead th,
    #ttsTable thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }
}

@media (max-width: 576px) {
    #quizTable td {
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
                <li class="breadcrumb-item active">Organisasi Belajar</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url($url_name . '/pbl/index/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap
            1</a>
        <a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id); ?>" class="btn btn-outline-primary me-1">
            <i class="bi bi-list-task"></i> Lanjut ke Tahap 3
        </a>
    </div>

    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

    <div class="alert alert-info border-0 shadow-sm">
        <i class="bi bi-info-circle-fill me-2"></i>
        Halaman ini menampilkan daftar <span id="info-label" class="fw-bold">kuis</span>.
        Klik tombol <strong>"Detail"</strong> untuk melihat soal.
    </div>

    <ul class="nav nav-tabs mb-3" id="pblTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button"
                role="tab">Kuis</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tts-tab" data-bs-toggle="tab" data-bs-target="#tts" type="button"
                role="tab">Teka-Teki Silang</button>
        </li>
    </ul>

    <div class="tab-content" id="pblTabContent">
        <div class="tab-pane fade show active" id="quiz" role="tabpanel">
            <div class="d-flex justify-content-between mb-2">
                <h5>
                    <i class="bi bi-card-checklist me-1"></i>
                    <strong class="text-dark">Daftar Kuis</strong>
                </h5>
                <div class="d-flex gap-2 m-2">
                    <?php if ($url_name == 'guru'): ?>
                    <button class="btn btn-success btn-sm" id="btnAddQuiz">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Kuis
                    </button>
                    <a href="<?= site_url('guru/pbl_kuis/panduan_tahap2'); ?>" class="btn btn-info btn-sm">
                        Panduan Tahap 2
                    </a>
                    <?php endif; ?>

                    <?php if ($url_name == 'siswa'): ?>
                    <a href="<?= site_url('siswa/pbl_kuis/panduan_tahap2'); ?>" class="btn btn-info btn-sm">
                        Panduan Kuis Evaluasi
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="quizTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th class="action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="tts" role="tabpanel">
            <div class="d-flex justify-content-between mb-2">
                <h5>
                    <i class="bi bi-dice-3-fill me-1"></i>
                    <strong class="text-dark">Daftar Teka-Teki Silang</strong>
                </h5>
                <?php if ($is_admin_or_guru): ?>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm" id="btnAddTts"><i class="bi bi-plus-circle me-1"></i>
                        Tambah TTS</button>
                    <a href="<?= site_url('guru/Tts/panduan_tahap2_tts'); ?>" class="btn btn-info btn-sm">
                        Panduan TTS
                    </a>
                </div>
                <?php endif; ?>
                <?php if ($url_name == 'siswa'): ?>
                <a href="<?= site_url('siswa/pbl_tts/panduan_tahap2_tts'); ?>" class="btn btn-info btn-sm">
                    Panduan Teka-Teki Silang
                </a>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="ttsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>Judul</th>
                            <th>Grid</th>
                            <th class="action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <form id="quizForm" autocomplete="off">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0" id="quizModalLabel">Form Kuis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="quizId">
                    <input type="hidden" name="class_id" id="quizClassId" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label for="quizTitle" class="form-label">Judul Kuis</label>
                        <input type="text" name="title" id="quizTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizDescription" class="form-label">Deskripsi</label>
                        <textarea name="description" id="quizDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ttsModal" tabindex="-1" aria-labelledby="ttsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <form id="ttsForm" autocomplete="off">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0" id="ttsModalLabel">Form Teka-Teki Silang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="ttsId">
                    <input type="hidden" name="class_id" id="ttsClassId" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label for="ttsTitle" class="form-label">Judul TTS</label>
                        <input type="text" name="title" id="ttsTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ttsGridData" class="form-label">Data Grid</label>
                        <input type="number" name="grid_data" id="ttsGridData" class="form-control">
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
window.URL_NAME = '<?= $url_name; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/pbl_tahap2.js'); ?>"></script>