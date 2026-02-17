<?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <style>
        #main { background: url('<?= base_url("assets/img/tema_4.png"); ?>') no-repeat top center !important; }
        /* Sembunyikan Judul Bawaan Template */
        .pagetitle { display: none !important; }

    </style>
    <?php endif ?>

    <link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

    <style>
        .page-spacer {height: 68vw;}
    </style>

<div class="container-fluid">

    <?= $this->session->flashdata('message'); ?>

    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">PBL</a>
                </li>
                <li class="breadcrumb-item active">Refleksi & Evaluasi Akhir</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex justify-content-center">
        <div class="fun-header">
            <h1 class="fun-title">
                <i class="ri-line-chart-line text-warning me-2"></i> <?= $title ?>
            </h1>
        </div>
    </div>

    <div class="kids-panel">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id) ?>" class="btn btn-secondary">
            <i class="ri-arrow-go-back-line"></i> Kembali
        </a>
        <button class="btn btn-success disabled" disabled><i class="bi bi-check-circle"></i> Project Selesai</button>
    </div>


    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">
    <input type="hidden" id="currentUserId" value="<?= $user['user_id']; ?>">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 card-title text-primary"><i class="bi bi-bar-chart-line me-1"></i> Nilai Akhir Saya</h5>
            <?php if ($url_name == 'siswa'): ?>
            <a href="<?= site_url('siswa/pbl_refleksi_akhir/panduan_evaluasi'); ?>" class="btn btn-info btn-sm">
                Panduan Refleksi & Evaluasi
            </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle table-pbl" id="rekapTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Quiz (Avg)</th>
                            <th>TTS (Avg)</th>
                            <th>Observasi</th>
                            <th>Esai</th>
                            <th class="fw-bold text-primary">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 reflectionContainer">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 card-title text-success"><i class="bi bi-envelope-paper me-1"></i> Refleksi & Umpan Balik
            </h5>
            <small class="text-muted">Berikut adalah catatan dan masukan dari Guru untuk Anda.</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle table-pbl" id="reflectionTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Refleksi Guru</th>
                            <th>Umpan Balik Guru</th>
                            <th width="15%">Aksi</th>
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

<div class="modal fade" id="refleksiModal" tabindex="-1" aria-labelledby="refleksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <form id="refleksiForm" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="refleksiModalLabel"><i class="bi bi-eye"></i> Detail Refleksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <input type="hidden" name="user_id" id="modalUserId">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Nama Siswa:</label>
                        <input type="text" class="form-control-plaintext border-bottom fw-bold" id="modalStudentName"
                            readonly value="-">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Catatan Refleksi Guru</label>
                            <textarea name="teacher_reflection" class="form-control bg-white" rows="6" readonly
                                disabled></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Umpan Balik Untuk Anda</label>
                            <textarea name="student_feedback" class="form-control bg-white" rows="6" readonly
                                disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/siswa/pbl_tahap5.js'); ?>"></script>