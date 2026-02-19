<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">

<style>
    .pagetitle { display: none !important; }

    /* ===== PERBAIKAN LAYOUT & OVERLAP ===== */
    #main {
        background: url('<?= base_url("assets/img/observasi.png"); ?>') no-repeat center top !important;
        background-size: 100% auto !important;
        background-attachment: fixed !important; /* Agar background tetap saat scroll */
        padding-top: 100px; /* Memberi ruang agar tidak tertutup topbar */
    }

    /*.page-spacer {height: 76vw;}*/

    .datatable-input {display: none;  }

    /* Panel Utama agar tidak menumpuk */
    .kids-panel-custom {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 30px !important;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        border: 4px solid #ffffff !important;
        margin-bottom: 20px;
        position: relative;
    }

    /* ===== MODAL GAYA BUKU CATATAN AJAIB ===== */
    .modal-content-notebook {
        border-radius: 30px !important;
        border: 8px solid #ffbf00 !important; /* Warna kuning emas */
        background-color: #fffdf0 !important; /* Kertas krem muda */
        box-shadow: 0 20px 50px rgba(0,0,0,0.2) !important;
        font-family: 'Nunito', sans-serif;
    }

    .modal-header-notebook {
        background: #ffbf00 !important;
        border-bottom: 4px dashed #e67e22 !important;
        border-radius: 20px 20px 0 0 !important;
        padding: 20px !important;
    }

    .modal-title-notebook {
        font-family: 'Fredoka', cursive;
        color: #fff !important;
        text-shadow: 2px 2px #d35400;
        font-size: 24px;
    }

    /* Garis-garis buku pada body modal */
    .modal-body-notebook {
        background-image: linear-gradient(#e1e1e1 1px, transparent 1px);
        background-size: 100% 30px; /* Memberi efek garis buku */
        padding: 30px !important;
    }

    /* Penyesuaian Tabel agar tidak gepeng */
    #myUploadsTable {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        width: 100% !important;
    }

    #myUploadsTable thead th {
        background-color: #4facfe !important;
        color: white !important;
        font-family: 'Fredoka', cursive;
        border: none !important;
        padding: 15px !important;
    }

    #myUploadsTable tbody td {
        background-color: #ffffff !important;
        border-top: 2px solid #f0f0f0 !important;
        border-bottom: 2px solid #f0f0f0 !important;
        padding: 15px !important;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">
<!-- <main id="main" class="main"> -->
    <div class="container-fluid">
        <div class="fun-header mb-4">
            <h1 class="fun-title text-primary">
                <i class="bi bi-rocket-takeoff-fill me-2"></i><?= $title ?? 'Observasi Seru!'; ?>
            </h1>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card step-card shadow-sm mb-3 <?= !empty($result) ? 'done' : 'active' ?>" style="border-radius: 20px;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3"><i class="bi bi-cloud-upload fs-4"></i></div>
                        <div><h6 class="fw-bold mb-0">1. Kirim Tugas</h6></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card shadow-sm mb-3 <?= !empty($result) ? 'done' : '' ?>" style="border-radius: 20px;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning me-3"><i class="bi bi-hourglass-split fs-4"></i></div>
                        <div><h6 class="fw-bold mb-0">2. Cek Guru</h6></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card shadow-sm mb-3 <?= !empty($result) ? 'active border-success' : '' ?>" style="border-radius: 20px;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success me-3"><i class="bi bi-star-fill fs-4"></i></div>
                        <div><h6 class="fw-bold mb-0">3. Hasil Nilai</h6></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($result)) : ?>
            <div class="kids-panel-custom mb-4">
                <div class="row align-items-center text-center text-md-start">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="p-3 bg-success bg-opacity-10 rounded-4">
                            <h6 class="text-success fw-bold small text-uppercase">Nilai Kamu</h6>
                            <h1 class="display-4 fw-bold text-success m-0" style="font-family: 'Fredoka';"><?= $result->score; ?></h1>
                            <span class="badge bg-success rounded-pill">Hebat!</span>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h5 class="text-primary fw-bold"><i class="bi bi-chat-heart me-2"></i>Pesan Guru:</h5>
                        <div class="alert-info mt-2">"<?= !empty($result->feedback) ? nl2br(htmlspecialchars($result->feedback)) : 'Keren sekali!'; ?>"</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="kids-panel-custom">
                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-journal-text me-2"></i>Cara Kerja</h5>
                    <div class="p-3 bg-white rounded-4 border border-info border-2 mb-3">
                        <?= nl2br(htmlspecialchars($slot->description)); ?>
                    </div>
                    <a href="<?= base_url('siswa/pbl/tahap3/' . $class_id) ?>" class="btn btn-fun btn-yellow w-100">
                        <i class="bi bi-arrow-left-circle-fill me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="col-lg-8 order-lg-1">
                <div class="kids-panel-custom uploadContainer">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-dark m-0"><i class="bi bi-folder-fill text-warning me-2"></i>Laporanku</h5>
                        <?php if (empty($result)) : ?>
                            <button id="btnAddUpload" class="btn btn-fun btn-blue shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="bi bi-plus-circle-fill me-2"></i> Tambah File
                            </button>
                        <?php endif; ?>
                    </div>
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
        <div class="page-spacer"></div>
    </div>
<!-- </main> -->

<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-notebook">
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="modal-header modal-header-notebook">
                    <h5 class="modal-title modal-title-notebook">
                        <i class="bi bi-pencil-square me-2"></i> Catatan Tugasku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-notebook">
                    <input type="hidden" name="observation_slot_id" value="<?= $slot->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-4 text-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-2">
                            <i class="bi bi-file-earmark-arrow-up text-warning display-5"></i>
                        </div>
                        <p class="fw-bold text-muted">Ayo, masukkan laporan hasil observasimu!</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-file-earmark-check me-1"></i> Pilih File :</label>
                        <input class="form-control rounded-pill border-2 border-warning" type="file" name="file_upload" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-chat-left-dots me-1"></i> Cerita Singkat :</label>
                        <textarea class="form-control rounded-4 border-2 border-warning" name="description" rows="3" placeholder="Tuliskan sedikit tentang tugasmu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-white" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-fun btn-blue px-5">Kirim Tugas!</button>
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