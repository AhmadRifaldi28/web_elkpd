<?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <style>
        #main { background: url('<?= base_url("assets/img/tema_2.png"); ?>') no-repeat top center !important; }
        /* Sembunyikan Judul Bawaan Template */
        .pagetitle { display: none !important; }

    </style>
    <?php endif ?>

    <link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

    <style>
        .page-spacer {height: 19vw;}
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
                <li class="breadcrumb-item active">Menyajikan Hasil Karya</li>
            </ol>
        </nav>
    </div>

    <?php if ($this->session->userdata('role') == 'Siswa'): ?>
        <div class="d-flex justify-content-center">
            <div class="fun-header">
                <h1 class="fun-title">
                    <i class="ri ri-file-edit-line text-dark-blue me-2"></i> <?= $title ?>
                </h1>
            </div>
        </div>
    <?php endif ?>

    <div class="kids-panel">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id) ?>" class="btn btn-fun btn-yellow">
            <i class="ri-arrow-go-back-line"></i> Kembali
        </a>
        <a href="<?= base_url($url_name . '/pbl/tahap5/' . $class_id); ?>" class="btn btn-fun btn-blue me-1">
            <i class="ri-line-chart-line"></i> Tahap 5
        </a>
    </div>


    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

    <?= $this->session->flashdata('message'); ?>

    <div class="alert alert-info border-0 shadow-sm">
        <i class="bi bi-info-circle-fill me-2"></i>
        Halaman ini menampilkan daftar esai. Klik tombol <strong>"Kerjakan" </strong>untuk melihat soal esai.
    </div>

    <!-- <ul class="nav nav-pills-custom m-3" id="pblTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="solusi-tab" data-bs-toggle="tab" data-bs-target="#solusi" type="button"
                role="tab">Aktivitas Esai Solusi</button>
        </li>
    </ul> -->

    <div class="tab-content" id="pblTabContent">

        <!-- Tab 1: Aktivitas Esai Solusi -->
        <div class="tab-pane fade show active" id="solusi" role="tabpanel">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="text-dark-blue">
                    <i class="ri-file-edit-line me-1"></i>
                    Aktivitas Esai
                </h5>
                <?php if ($is_admin_or_guru): ?>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm" id="btnAddEsai"><i class="bi bi-plus-circle me-1"></i> Tambah
                        Esai</button>
                    <a href="<?= base_url($url_name . '/pbl_esai/panduan_esai_tahap4/' . $class_id); ?>"
                        class="btn btn-info btn-sm">
                        Panduan Esai
                    </a>
                </div>
                <?php endif; ?>
                <?php if ($url_name == 'siswa'): ?>
                <a href="<?= base_url($url_name . '/pbl_esai/panduan_esai/' . $class_id); ?>"
                    class="btn btn-info btn-sm">
                    Panduan Esai
                </a>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-pbl" id="esaiTable">
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

    </div>

    </div> 
    <div class="page-spacer"></div>

</div>

<!-- Modal 1: Esai Solusi -->
<div class="modal fade" id="esaiModal" tabindex="-1" aria-labelledby="esaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <form id="esaiForm" autocomplete="off">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title mb-0" id="esaiModalLabel">Form Aktivitas Esai</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="esaiId">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label for="esaiTitle" class="form-label">Judul Aktivitas Esai</label>
                        <input type="text" name="title" id="esaiTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="esaiDescription" class="form-label">Deskripsi Esai</label>
                        <textarea name="description" id="esaiDescription" class="form-control" rows="5"></textarea>
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
<script type="module" src="<?= base_url('assets/js/pbl_tahap4.js'); ?>"></script>