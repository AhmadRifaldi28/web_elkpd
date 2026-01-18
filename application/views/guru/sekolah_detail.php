<style>

/* ===== 2. HERO CARD ===== */
.hero-card {
    background: linear-gradient(135deg, var(--bd-violet-bg) 0%, #4a148c 100%) !important;
    color: white !important;
    border: none !important;
    border-radius: 12px !important;
    position: relative !important;
    overflow: hidden !important;
    box-shadow: 0 8px 20px rgba(113, 44, 249, 0.25) !important;
    margin-bottom: 25px;
}
.hero-content { position: relative; z-index: 2; }
.hero-icon-bg {
    position: absolute !important;
    right: -20px !important;
    bottom: -40px !important;
    font-size: 10rem !important;
    color: rgba(255, 255, 255, 0.1) !important;
    transform: rotate(-15deg) !important;
    pointer-events: none !important;
}

/* ===== 3. STAT CARDS ===== */
.stat-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s;
    background: #fff;
}
.stat-card:hover { transform: translateY(-5px); }
.stat-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.bg-violet-soft { background-color: rgba(113, 44, 249, 0.1); color: var(--bd-violet-bg); }

/* ===== 4. TABLE STYLING ===== */
.card-table {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}
#kelasTable { min-width: 720px !important; }
#kelasTable thead th {
    background: #f8f9fa !important;
    color: #444;
    border-bottom: 2px solid #eee;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    padding: 15px;
}
#kelasTable tbody td {
    padding: 15px;
    vertical-align: middle;
    color: #555;
}
.table-responsive {
    border-radius: 10px;
}

/* ===== 5. MODAL STYLING ===== */
.modal-content { border: none; border-radius: 12px; }
.modal-header-custom {
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
}
.form-control:focus {
    border-color: var(--bd-violet-bg);
    box-shadow: 0 0 0 0.25rem rgba(113, 44, 249, 0.15);
}
.input-group-text { background-color: #fff; border-right: none; color: var(--bd-violet-bg); }
.form-control { border-left: none; }

/* Responsive */
.action { width: 25%; }
@media (max-width: 768px) {
    .action { width: 35%; }
}
</style>

<div class="container-fluid">
    
    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('guru/dashboard') ?>">Sekolah</a></li>
                <li class="breadcrumb-item active">Detail Sekolah</li>
            </ol>
        </nav>
    </div>

    <div class="card hero-card">
        <div class="card-body p-4 hero-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <a href="<?= base_url('guru/dashboard') ?>" class="btn btn-sm btn-light mb-2 rounded-pill px-3">
                        <i class="ri-arrow-go-back-line me-1"></i> Kembali ke Dashboard
                    </a>
                    <h2 class="fw-bold mb-1 text-white"><?= htmlspecialchars($sekolah->name, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p class="mb-0 text-white opacity-75"><i class="ri-map-pin-line me-1"></i> Detail Manajemen Kelas</p>
                </div>
                <div>
                    <button class="btn btn-light text-primary fw-bold shadow-sm py-2 px-4" id="btnAddClass">
                        <i class="ri-add-circle-fill me-2 text-primary"></i>Tambah Kelas
                    </button>
                </div>
            </div>
        </div>
        <i class="ri-building-4-line hero-icon-bg"></i>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card stat-card h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stat-icon-wrapper bg-violet-soft me-3">
                        <i class="ri-artboard-line"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0 font-weight-bold text-uppercase">Total Kelas</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="statTotalClasses">0</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-8">
            <div class="card stat-card h-100 bg-light border-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <i class="ri-information-fill fs-3 text-info me-3"></i>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Informasi</h6>
                        <small class="text-muted">Gunakan tombol <strong>"Detail"</strong> pada tabel di bawah untuk masuk ke dalam kelas dan mengelola siswa.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-table mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="m-0 font-weight-bold" style="color: var(--bd-violet-bg);">
                        <i class="ri-list-check me-2"></i>Daftar Kelas
                    </h6>
                    </div>
                <div class="card-body pt-0 kelasContainer">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="kelasTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 8%;" class="text-center">No</th>
                                    <th>Nama Kelas</th>
                                    <th>Kode Kelas</th>
                                    <th class="action text-center">Aksi</th>
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

<div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header modal-header-custom p-3">
                <h5 class="modal-title fw-bold" style="color: var(--bd-violet-bg);" id="classModalLabel">
                    <i class="ri-edit-2-line me-2"></i>Form Data Kelas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="classForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="classId" name="id">
                <input type="hidden" id="schoolId" name="school_id" value="<?= $sekolah->id; ?>">

                <div class="modal-body p-4">
                    <div class="alert alert-light border-start border-4 border-info shadow-sm p-3 mb-4">
                        <small class="text-muted"><i class="ri-lightbulb-line me-1"></i> Tips: Gunakan nama yang mudah dikenali siswa, misal: "Kelas 5A - Matematika".</small>
                    </div>

                    <div class="mb-4">
                        <label for="className" class="form-label fw-bold small text-uppercase text-muted">Nama Kelas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-layout-grid-fill"></i></span>
                            <input type="text" class="form-control form-control-lg" id="className" name="name" placeholder="Contoh: 4-A" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="classCode" class="form-label fw-bold small text-uppercase text-muted">Kode Kelas (Opsional)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-qr-code-line"></i></span>
                            <input type="text" class="form-control" id="classCode" name="code" placeholder="Otomatis jika kosong">
                        </div>
                        <div class="form-text mt-2"><i class="ri-lock-password-line me-1"></i> Kode unik untuk akses siswa.</div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-bd-primary px-4 shadow-sm">
                        <i class="ri-save-3-line me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.BASE_URL = '<?= base_url() ?>';
    window.CSRF_TOKEN_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
</script>

<script type="module" src="<?= base_url('assets/js/kelas.js') ?>"></script>