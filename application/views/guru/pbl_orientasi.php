<?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <style>
        #main { background: url('<?= base_url("assets/img/tema.png"); ?>') no-repeat top center !important; }
        /* Sembunyikan Judul Bawaan Template */
        .pagetitle { display: none !important; }

    </style>
    <?php endif ?>

    <link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

    <div class="container-fluid px-md-5">

    <?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <div class="d-flex justify-content-center mb-3">
        <div class="fun-header text-center">
            <h1 class="fun-title">
                <i class="ri-compass-3-line text-dark-blue me-2"></i> Orientasi Masalah
            </h1>
        </div>
    </div>
    <?php endif ?>

    <div class="kids-panel">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            

            <?php if ($this->session->userdata('role') == 'Siswa'): ?>
                <a href="<?= base_url('siswa/dashboard') ?>" class="btn btn-fun btn-yellow">
                    <i class="ri-arrow-go-back-line"></i> Kembali
                </a>
            <?php else: ?>
                <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>" class="btn btn-fun btn-yellow">
                    <i class="ri-arrow-go-back-line"></i> Kembali ke Kelas
                </a>
            <?php endif ?>

            <div class="d-flex gap-2 flex-wrap">
                <?php if ($is_admin_or_guru): ?>
                    <button class="btn btn-fun btn-green" id="btnAddPbl">
                        <i class="ri-add-circle-fill"></i> Tambah Masalah
                    </button>
                    <a href="<?= site_url('guru/pbl/panduan_tahap1'); ?>" class="btn btn-fun btn-cyan">
                        <i class="ri-book-open-line"></i> Panduan
                    </a>
                <?php endif; ?>
                
            </div>
            <a href="<?= base_url($url_name . '/pbl/tahap2/' . $class_id); ?>" class="btn btn-fun btn-blue text-dark">
                Tahap 2 <i class="ri-palette-fill fs-3"></i>
            </a>
        </div>

        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

        <div class="alert alert-info d-flex align-items-center mb-4 shadow-sm">
            <i class="ri-information-fill fs-3 me-3"></i> 
            <div>
                Ayo baca skenario masalah di bawah ini dengan teliti, lalu lihat materinya ya!
            </div>
        </div>

        <div class="table-responsive orientationContainer">
            <table class="table table-pbl" id="pblTable" width="100%">
                <thead>
                    <tr>
                        <th style="width:60px" class="text-center">No</th>
                        <th>Judul</th>
                        <th>Refleksi</th>
                        <th width="20%" class="text-center">Materi</th>
                        <?php if ($is_admin_or_guru): ?>
                            <th style="width:120px" class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>

    </div>

    <div class="page-spacer"></div>

    </div>

    <div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-5 border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold font-heading fs-4">
                    <i class="ri-eye-fill me-2"></i> Lihat Materi Belajar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" id="filePreviewContent" style="min-height: 400px; background: #eef2f5;">
                </div>
        </div>
    </div>
    </div>

    <?php if ($is_admin_or_guru): ?>
    <div class="modal fade" id="pblModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0 shadow-lg">
            <div class="modal-header bg-success text-white border-0 py-3">
                <h5 class="modal-title fw-bold fs-4 font-heading" id="pblModalLabel">Form Masalah PBL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="pblForm" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" id="pblId" name="id">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark fs-5">Judul</label>
                        <input type="text" class="form-control form-control-lg rounded-pill" id="pblTitle" name="title" placeholder="Contoh: Banjir di Sekolahku" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark fs-5">Refleksi Awal</label>
                        <textarea class="form-control rounded-4" id="pblReflection" name="reflection" rows="4" placeholder="Tuliskan pertanyaan pemantik untuk siswa..." required style="resize: none;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-5">Upload Materi Pendukung</label>
                        <input type="file" class="form-control form-control-lg rounded-pill" id="pblFile" name="file">
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2 fw-bold shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <?php endif; ?>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
</script>

<script type="module" src="<?= base_url('assets/js/pbl_orientasi.js'); ?>"></script>