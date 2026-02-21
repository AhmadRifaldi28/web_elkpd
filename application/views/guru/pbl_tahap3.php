<?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <style>
        #main { background: url('<?= base_url("assets/img/tema_3.png"); ?>') no-repeat top center !important; }
        /* Sembunyikan Judul Bawaan Template */
        .pagetitle { display: none !important; }

    </style>
    <?php endif ?>

    <link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

<div class="container-fluid">
    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
                        PBL
                    </a>
                </li>
                <li class="breadcrumb-item active">Penyelidikan Mandiri & Kelompok</li>
            </ol>
        </nav>
    </div>

    <?php if ($this->session->userdata('role') == 'Siswa'): ?>
        <div class="d-flex justify-content-center">
            <div class="fun-header">
                <h1 class="fun-title">
                    <i class="ri-team-fill text-dark-blue me-2"></i> <?= $title ?>
                </h1>
            </div>
        </div>
    <?php endif ?>

    <div class="kids-panel">
        
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url($url_name . '/pbl/tahap2/' . $class_id) ?>" class="btn btn-fun btn-yellow">
            <i class="ri-arrow-go-back-line"></i> Kembali
        </a>
        <a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id); ?>" class="btn btn-fun btn-blue me-1">
            <i class="ri-file-edit-line"></i> Tahap 4
        </a>
    </div>

    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

    <div class="alert alert-info border-0 shadow-sm">
        <i class="bi bi-info-circle-fill me-2"></i>
        Halaman ini menampilkan daftar <span id="info-label" class="fw-bold">ruang observasi</span>.
        Klik tombol <strong>"Mulai"</strong> untuk melihat detail ruang <span id="info-label2"
            class="fw-bold">observasi</span>.
    </div>

    <div class="text-center mb-4">
        <ul class="nav nav-pills-custom" id="pblTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="observasi-tab" data-bs-toggle="tab" data-bs-target="#observasi"
                    type="button" role="tab">Ruang Observasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="diskusi-tab" data-bs-toggle="tab" data-bs-target="#diskusi" type="button"
                    role="tab">Forum Diskusi</button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="pblTabContent">

        <!-- Tab 1: Ruang Observasi -->
        <div class="tab-pane fade show active" id="observasi" role="tabpanel">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="text-dark-blue">
                    <i class="ri-survey-line me-1"></i>
                    Ruang Observasi
                </h5>
                <div class="d-flex gap-2">
                    <?php if ($is_admin_or_guru): ?>
                    <button class="btn btn-success btn-sm" id="btnAddObservasi"><i class="bi bi-plus-circle me-1"></i>
                        Tambah Ruang</button>
                    <a href="<?= base_url($url_name . '/pbl_observasi/panduan_observasi_tahap3/' . $class_id); ?>"
                        class="btn btn-info btn-sm">
                        Panduan Observasi
                    </a>
                    <?php endif; ?>

                    <?php if ($url_name == 'siswa'): ?>
                    <a href="<?= site_url('siswa/pbl_observasi/panduan_observasi'); ?>" class="btn btn-info btn-sm">
                        Panduan Observasi
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-pbl" id="observasiTable">
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

        <!-- Tab 2: Forum Diskusi -->
        <div class="tab-pane fade" id="diskusi" role="tabpanel">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="text-dark-blue">
                    <i class="bi bi-chat-text me-1"></i>
                    Topik Diskusi
                </h5>
                <?php if ($is_admin_or_guru): ?>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm" id="btnAddDiskusi"><i class="bi bi-plus-circle me-1"></i>
                        Tambah Topik</button>
                    <a href="<?= base_url($url_name . '/pbl_forum/panduan_diskusi_tahap3/' . $class_id); ?>"
                        class="btn btn-info btn-sm">
                        Panduan Diskusi
                    </a>
                </div>
                <?php endif; ?>

                <?php if ($url_name == 'siswa'): ?>
                <a href="<?= site_url('siswa/pbl_forum/panduan_diskusi'); ?>" class="btn btn-info btn-sm">
                    Panduan Forum Diskusi
                </a>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-pbl" id="diskusiTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>Judul</th>
                            <th>Deskripsi Singkat</th>
                            <th class="action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
    <div class="page-spacer"></div>
</div>

<!-- Modal 1: Observasi -->
<div class="modal fade" id="observasiModal" tabindex="-1" aria-labelledby="observasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <form id="observasiForm" autocomplete="off">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title mb-0" id="observasiModalLabel">Form Ruang Observasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="observasiId">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label for="observasiTitle" class="form-label">Judul Ruang Observasi</label>
                        <input type="text" name="title" id="observasiTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="observasiDescription" class="form-label">Deskripsi / Instruksi</label>
                        <textarea name="description" id="observasiDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Diskusi -->
<div class="modal fade" id="diskusiModal" tabindex="-1" aria-labelledby="diskusiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <form id="diskusiForm" autocomplete="off">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title mb-0" id="diskusiModalLabel">Form Topik Diskusi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="diskusiId">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label for="diskusiTitle" class="form-label">Judul Topik Diskusi</label>
                        <input type="text" name="title" id="diskusiTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="diskusiDescription" class="form-label">Deskripsi Diskusi</label>
                        <textarea name="description" id="diskusiDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
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
<script type="module" src="<?= base_url('assets/js/pbl_tahap3.js'); ?>"></script>