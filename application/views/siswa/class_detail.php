<style>
/* ===== UI ENHANCEMENTS ===== */

/* 1. Hero Card untuk Info Kelas */
.class-hero-card {
    background: linear-gradient(135deg, var(--bd-violet-bg) 0%, #4a148c 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(113, 44, 249, 0.2);
    margin-bottom: 25px;
}

.class-hero-icon {
    position: absolute;
    right: 20px;
    bottom: -10px;
    font-size: 8rem;
    color: rgba(255, 255, 255, 0.1);
    transform: rotate(-15deg);
    pointer-events: none;
}

/* 2. Stat Card Kecil */
.stat-widget {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    height: 100%;
    transition: transform 0.3s;
}
.stat-widget:hover {
    transform: translateY(-5px);
}
.stat-icon-box {
    width: 50px; height: 50px;
    border-radius: 12px;
    background: #e0f8e9;
    color: #2eca6a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 15px;
}

/* 3. Table Styling */
.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}
#siswaTable thead th {
    background-color: #f6f9ff !important;
    color: #012970;
    border-bottom: 2px solid #dee2e6;
    font-family: "Nunito", sans-serif;
}
#siswaTable tbody td {
    vertical-align: middle;
    padding: 12px 15px;
}

/* 4. Modal Styles */
.modal-header-custom {
    background-color: #f6f9ff;
    border-bottom: 1px solid #dee2e6;
}
</style>

<div class="container-fluid">
    
    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url('siswa/dashboard/') ?>">Kelas</a>
                </li>
                <li class="breadcrumb-item active">Detail Kelas</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-4 align-items-stretch">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="class-hero-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-white text-primary mb-2 px-3 py-1 rounded-pill">
                            <i class="ri-qr-code-line me-1"></i> Kode: <?= htmlspecialchars($kelas->code, ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </div>
                    <h2 class="fw-bold mb-1"><?= htmlspecialchars($kelas->name, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p class="opacity-75 mb-0">Kelola siswa dan materi pembelajaran di kelas ini.</p>
                </div>
                
                <div class="mt-4 d-flex gap-2">
                    <a href="<?= base_url('siswa/dashboard') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="ri-arrow-go-back-line"></i> Kembali
                    </a>
                    <a href="<?= base_url('siswa/pbl/index/' . $kelas->id); ?>" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
                        <i class="ri-lightbulb-flash-line me-1"></i> Mulai Belajar (PBL)
                    </a>
                </div>
                
                <i class="ri-presentation-line class-hero-icon"></i>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-widget">
                <div class="stat-icon-box">
                    <i class="ri-group-line"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-0 text-uppercase fw-bold">Total Siswa</h6>
                    <h2 class="mb-0 fw-bold text-dark" id="displayCount"><?= $kelas->student_count; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 text-primary fw-bold">
                <i class="ri-team-line me-2"></i>Daftar Siswa
            </h5>

            <?php if ($is_admin_or_guru): ?>
                <button class="btn btn-primary btn-sm shadow-sm" id="btnAddStudent" data-bs-toggle="modal" data-bs-target="#siswaModal">
                    <i class="ri-user-add-line me-1"></i> Tambah Siswa
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0" id="siswaTableContainer">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="siswaTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <?php if ($is_admin_or_guru): ?>
                                <th class="text-center" width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php if ($is_admin_or_guru): ?>
    <div class="modal fade" id="siswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                
                <div class="modal-header modal-header-custom p-3">
                    <h5 class="modal-title fw-bold text-primary" id="siswaModalLabel">
                        <i class="ri-user-add-line me-2"></i>Tambah Siswa ke Kelas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form id="studentForm">
                    <div class="modal-body p-4">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="class_id" id="classIdHidden" value="<?= $kelas->id; ?>">

                        <div class="alert alert-info d-flex align-items-center small p-2 mb-3">
                            <i class="ri-information-fill me-2 fs-5"></i>
                            <div>Hanya menampilkan siswa yang belum memiliki kelas.</div>
                        </div>

                        <div class="mb-3">
                            <label for="studentSelect" class="form-label fw-bold small text-muted">Pilih Siswa</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ri-search-line"></i></span>
                                <select class="form-select" id="studentSelect" name="student_id" required>
                                    <option value="">-- Cari Nama Siswa --</option>
                                    <?php foreach($siswa_list as $s): ?>
                                        <option value="<?= $s->id; ?>">
                                            <?= htmlspecialchars($s->name, ENT_QUOTES, 'UTF-8'); ?> (@<?= htmlspecialchars($s->username, ENT_QUOTES, 'UTF-8'); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" id="btnSaveStudent">
                            <i class="ri-save-3-line me-1"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    window.BASE_URL = '<?= base_url() ?>';
    window.CSRF_TOKEN_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
    window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
    window.CURRENT_CLASS_ID = '<?= $kelas->id; ?>';
</script>

<script type="module" src="<?= base_url('assets/js/class_detail.js') ?>"></script>