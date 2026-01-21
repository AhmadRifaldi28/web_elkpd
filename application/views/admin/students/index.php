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

#studentTable {
    min-width: 720px !important;
    width: 100% !important;
    border-collapse: collapse !important;
    border: 1px solid #dee2e6 !important;
}

#studentTable th, #studentTable td {
    border: 1px solid #dee2e6 !important;
    padding: 12px 15px !important;
    vertical-align: middle !important;
    color: #444444 !important;
}

#studentTable thead th {
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
    width: 15%;
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
                <li class="breadcrumb-item active">Kelola Siswa</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card h-100 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="ri-user-smile-line"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1 fw-bold">Total Siswa</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="statTotalStudents">0</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card stats-card h-100 shadow-sm border-0 bg-primary text-white" style="background: linear-gradient(45deg, #2eca6a, #198754);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">Tambah Siswa Baru</h4>
                        <p class="mb-0 small opacity-75">Daftarkan akun siswa baru ke dalam sistem.</p>
                    </div>
                    <button class="btn btn-light text-success fw-bold px-4 shadow-sm" id="btnAddStudent">
                        <i class="ri-user-add-line me-2"></i>Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 text-primary">
                <i class="ri-group-2-line me-2"></i>Daftar Akun Siswa
            </h5>
        </div>
        <div class="card-body pt-3 studentContainer">
            <div class="table-responsive">
                <table id="studentTable" class="table table-hover table-bordered align-middle" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username & Email</th>
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

<div class="modal fade" id="studentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-custom p-3">
                <h5 class="modal-title fw-bold text-primary" id="studentModalLabel">
                    <i class="ri-user-add-line me-2"></i>Form Data Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="studentForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="studentId" name="id">

                <div class="modal-body p-4">
                    <h6 class="fw-bold text-secondary mb-3 text-uppercase small border-bottom pb-2">Identitas</h6>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom"><i class="ri-user-line"></i></span>
                            <input type="text" class="form-control" id="studentName" name="name" placeholder="Nama Siswa" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Email</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom"><i class="ri-mail-line"></i></span>
                            <input type="email" class="form-control" id="studentEmail" name="email" placeholder="alamat@email.com">
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mt-4 mb-3 text-uppercase small border-bottom pb-2">Informasi Login</h6>
                    
                    <div class="row g-3">
                        <div class="col-md-6" id="usernameGroup">
                            <label class="form-label fw-bold small text-muted">Username</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-at-line"></i></span>
                                <input type="text" class="form-control" id="studentUsername" name="username" placeholder="Username unik">
                            </div>
                            <div class="form-text small fst-italic text-primary"><i class="ri-error-warning-line me-1"></i>Hanya saat tambah baru.</div>
                        </div>
                        
                        <div class="col-md-6" id="passwordGroup">
                            <label class="form-label fw-bold small text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="ri-lock-password-line"></i></span>
                                <input type="password" class="form-control" id="studentPassword" name="password" placeholder="Password">
                            </div>
                            <div class="form-text small text-muted">Default: 'password'</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="ri-save-3-line me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.BASE_URL = '<?= base_url() ?>';
    window.CSRF_TOKEN_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
</script>
<script type="module" src="<?= base_url('assets/js/student.js') ?>"></script>