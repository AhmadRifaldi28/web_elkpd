<style>
/* ===== UI/UX OVERRIDES & TABLE STYLING ===== */

/* Card Styling - NiceAdmin Style */
.card {
    border: none !important;
    border-radius: 8px !important;
    box-shadow: 0 0 20px rgba(1, 41, 112, 0.1) !important;
    margin-bottom: 30px !important;
}

.card-header {
    background-color: #fff !important;
    border-bottom: 2px solid #f6f9ff !important;
    padding: 20px !important;
}

.card-title {
    padding: 0 !important;
    font-size: 18px !important;
    font-weight: 600 !important;
    color: #012970 !important;
    font-family: "Poppins", sans-serif !important;
    margin-bottom: 0 !important;
}

/* Table Styling - Professional Look */
.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
    border-radius: 5px;
}

#teacherTable {
    min-width: 720px !important;
    width: 100% !important;
    border-collapse: collapse !important;
    border: 1px solid #dee2e6 !important;
}

#teacherTable th, #teacherTable td {
    border: 1px solid #dee2e6 !important;
    padding: 12px 15px !important;
    vertical-align: middle !important;
    color: #444444 !important;
}

#teacherTable thead th {
    background: #f6f9ff !important;
    color: #012970 !important;
    font-weight: 600 !important;
    font-family: "Poppins", sans-serif !important;
    border-bottom: 2px solid #dee2e6 !important;
    white-space: nowrap !important;
}

/* Hover Effect */
.table-hover tbody tr:hover {
    background-color: #f6f6f6 !important;
}

/* Action Buttons */
.action {
    width: 22%;
    text-align: center !important;
}

/* Modal Styling */
.modal-header-custom {
    background-color: #f6f9ff;
    border-bottom: 1px solid #dee2e6;
}
.input-group-text-custom {
    background-color: #eef2f8;
    color: #4154f1;
    border: 1px solid #ced4da;
}

/* Stats Card */
.stats-card {
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-5px);
}
.stats-icon {
    width: 48px; height: 48px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
</style>

<div class="container-fluid">
    <div class="pagetitle mb-4">
        <nav>
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Guru</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card h-100 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="ri-user-star-line"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1 fw-bold">Total Guru</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="statTotalTeachers">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card stats-card h-100 shadow-sm border-0 bg-primary text-white" style="background: linear-gradient(45deg, #4154f1, #2132bd);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">Tambah Guru Baru</h4>
                        <p class="mb-0 small opacity-75">Kelola data pengajar dengan mudah.</p>
                    </div>
                    <button class="btn btn-light text-primary fw-bold px-4 shadow-sm" id="btnAddTeacher">
                        <i class="ri-user-add-line me-2"></i>Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 text-primary">
                <i class="ri-team-line me-2"></i>Daftar Guru Pengajar
            </h5>
        </div>
        <div class="card-body pt-3 teacherContainer">
            <div class="table-responsive">
                <table id="teacherTable" class="table table-hover table-bordered align-middle" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username & Email</th>
                            <th>Sekolah Asal</th>
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

<div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-custom p-3">
                <h5 class="modal-title fw-bold text-primary" id="teacherModalLabel">
                    <i class="ri-user-settings-line me-2"></i>Form Data Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="teacherForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="teacherId" name="id">

                <div class="modal-body p-4">
                    <h6 class="fw-bold text-secondary mb-3 text-uppercase small border-bottom pb-2">Informasi Pribadi</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-user-line"></i></span>
                                <input type="text" class="form-control" id="teacherName" name="name" placeholder="Nama Guru" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Sekolah</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-building-line"></i></span>
                                <select class="form-select" id="teacherSchool" name="school_id" required>
                                    <option value="">-- Pilih Sekolah --</option>
                                    <?php foreach ($schools as $school) : ?>
                                        <option value="<?= $school->id; ?>"><?= htmlspecialchars($school->name, ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 text-uppercase small border-bottom pb-2">Informasi Akun</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Username</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-at-line"></i></span>
                                <input type="text" class="form-control" id="teacherUsername" name="username" placeholder="Username unik" required>
                            </div>
                            <div class="form-text small fst-italic text-primary" id="usernameHint"><i class="ri-error-warning-line me-1"></i>Hanya bisa diisi saat tambah baru.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Email</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-mail-line"></i></span>
                                <input type="email" class="form-control" id="teacherEmail" name="email" placeholder="alamat@email.com">
                            </div>
                        </div>
                        
                        <div class="col-12" id="passwordGroup">
                            <label class="form-label fw-bold small text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-lock-password-line"></i></span>
                                <input type="password" class="form-control" id="teacherPassword" name="password" placeholder="Password akun">
                            </div>
                            <div class="form-text small text-muted"><i class="ri-information-line me-1"></i>Default password: 'password' (jika kosong saat tambah).</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="ri-save-3-line me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.BASE_URL = '<?= base_url() ?>';
    window.CSRF_TOKEN_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
</script>
<script type="module" src="<?= base_url('assets/js/teacher.js') ?>"></script>