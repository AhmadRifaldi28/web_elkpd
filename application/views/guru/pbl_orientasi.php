<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#pblTable {
    min-width: 720px !important;
}

.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
}

#pblTable thead th {
    background: #e0efff !important;
}

/* ===== PREVIEW MODAL RESPONSIVE ===== */
#filePreviewModal .modal-dialog {
    max-width: 95vw !important;
}

#filePreviewModal .modal-body {
    max-height: 75vh !important;
    overflow: auto !important;
    padding: 0.75rem !important;
}

/* iframe / video / image */
#filePreviewModal iframe,
#filePreviewModal video {
    width: 100% !important;
    height: 70vh !important;
}

#filePreviewModal img {
    max-width: 100% !important;
    height: auto !important;
}

@media (max-width: 768px) {
    #pblTable thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f8f9fa !important;
    }

    .badge {
        display: none;
    }
}

@media (max-width: 576px) {
    .btn-preview {
        width: 100% !important;
    }

    #pblTable td {
        white-space: nowrap;
    }
}
</style>


<div class="container-fluid">

    <!-- ================= HEADER HALAMAN ================= -->
    <div class="pagetitle mb-3">
        <!-- <h1 class="d-flex align-items-center gap-2">
			<i class="bi bi-compass text-primary"></i>
			Tahap 1 – Orientasi Masalah
		</h1> -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
                        PBL
                    </a>
                </li>
                <li class="breadcrumb-item active">Orientasi Masalah</li>
            </ol>
        </nav>
    </div>

    <!-- ================= NAVIGASI ATAS ================= -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Kelas
        </a>

        <a href="<?= base_url($url_name . '/pbl/tahap2/' . $class_id); ?>" class="btn btn-outline-primary">
            <i class="bi bi-list-task me-1"></i>
            Lanjut ke Tahap 2
        </a>
    </div>

    <!-- CSRF -->
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

    <!-- ================= INFO ================= -->
    <div class="alert alert-info d-flex align-items-center shadow-sm border-0">
        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
        <div>
            Halaman ini menampilkan <strong>skenario masalah PBL</strong>.
            Klik tombol <strong>Lihat</strong> untuk melihat materi pembelajaran.
        </div>
    </div>

    <!-- ================= CARD TABLE ================= -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-journal-text me-1"></i>
                <strong class="text-dark">Daftar Skenario Masalah</strong>
            </h5>
            <div class="d-flex align-items-center gap-2 ">
                <?php if ($is_admin_or_guru): ?>
                <button class="btn btn-success btn-sm" id="btnAddPbl">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Skenario
                </button>
                <a href="<?= site_url('guru/pbl/panduan_tahap1'); ?>" class="btn btn-info btn-sm">
                    Panduan Orientasi Masalah
                </a>
                <?php endif; ?>
            </div>
            <?php if ($url_name == 'siswa'): ?>
            <a href="<?= site_url('siswa/pbl/panduan_tahap1'); ?>" class="btn btn-info btn-sm">
                Panduan Tahap 1
            </a>
            <?php endif; ?>

        </div>
    </div>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="pblTable" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Judul</th>
                        <th>Refleksi Awal</th>
                        <th style="width:20%">Materi</th>
                        <?php if ($is_admin_or_guru): ?>
                        <th style="width:120px">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- ================= MODAL PREVIEW FILE ================= -->
<div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-1"></i> Preview Materi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="filePreviewContent">
                <!-- diisi via JS -->
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL FORM ================= -->
<?php if ($is_admin_or_guru): ?>
<div class="modal fade" id="pblModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="pblForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="pblModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="pblId" name="id">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" id="pblTitle" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Refleksi Awal</label>
                        <textarea class="form-control" id="pblReflection" name="reflection" rows="3"
                            required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Materi</label>
                        <input type="file" class="form-control" id="pblFile" name="file">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
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