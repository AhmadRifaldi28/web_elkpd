<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#siswaTable {
  min-width: 720px !important;
}

.table-responsive {
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch;
}

#siswaTable thead th {
  background: #e0efff !important;
}

/*#siswaTable tbody td {
  text-align: right;
}*/

/* Responsive Styles */
@media (max-width: 768px) {
  #siswaTable thead th{
    position: sticky;
    top: 0;
    z-index: 2;
  }
}

@media (max-width: 576px) {
  #siswaTable td { white-space: nowrap; }
}

</style>
<div class="container-fluid">
  <div class="pagetitle mb-3">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url('guru/dashboard/detail/' . $sekolah->school_id) ?>">Kelas</a>
        </li>
        <li class="breadcrumb-item active">Detail Kelas</li>
      </ol>
    </nav>
  </div>

    <div class="card shadow">
        <div class="p-2">
            <h5 class="mt-4"><?= htmlspecialchars($kelas->name, ENT_QUOTES, 'UTF-8'); ?></h5>
            <p><strong>Kode Kelas:</strong> <span class="badge bg-primary"><?= htmlspecialchars($kelas->code, ENT_QUOTES, 'UTF-8'); ?></span></p>
            <p>Jumlah Siswa: <span id="jumlah-siswa"><?= $kelas->student_count; ?></span></p>
        </div>
        <a href="<?= base_url('guru/dashboard/detail/' . $sekolah->school_id) ?>" class="btn btn-secondary">← Kembali ke Daftar Kelas</a>
        <a href="<?= base_url('guru/pbl/index/' . $kelas->id); ?>" class="btn btn-outline-primary mt-3">
          <i class="fas fa-lightbulb"></i> Tahap 1 – Orientasi Masalah (PBL)
      </a>
  </div>

  <div class="alert alert-info border-0 shadow-sm">
    <i class="bi bi-info-circle-fill me-2"></i>
    Halaman ini menampilkan daftar <span id="info-label" class="fw-bold">Siswa</span>. 
    Klik tombol <strong>"Tambah"</strong> untuk menambahkan Siswa.
  </div>

  <div class="d-flex justify-content-between mb-2">
    <h5>Daftar Siswa</h5>
    <button class="btn btn-success btn-sm" id="btnAddStudent" data-bs-toggle="modal" data-bs-target="#siswaModal">
        <i class="fas fa-user-plus"></i> Tambah Siswa
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body" id="siswaTableContainer">
        <div class="table-responsive">
            <table class="table table-bordered" id="siswaTable" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<div class="modal fade" id="siswaModal" tabindex="-1" aria-labelledby="siswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="studentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="siswaModalLabel">Tambah Siswa ke Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="class_id" id="classIdHidden" value="<?= $kelas->id; ?>">
                    
                    <div class="mb-3">
                        <label for="studentSelect" class="form-label">Pilih Siswa</label>
                        <select class="form-select" id="studentSelect" name="student_id" required>
                            <option value="">-- Pilih Siswa (yang belum punya kelas) --</option>
                            <?php foreach($siswa_list as $s): ?>
                                <option value="<?= $s->id; ?>">
                                    <?= htmlspecialchars($s->name, ENT_QUOTES, 'UTF-8'); ?> (<?= htmlspecialchars($s->username, ENT_QUOTES, 'UTF-8'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveStudent">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    window.BASE_URL = '<?= base_url() ?>';
    window.CSRF_TOKEN_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
    window.IS_ADMIN_OR_GURU = 'true';
    window.CURRENT_CLASS_ID = '<?= $kelas->id; ?>';
</script>

<script type="module" src="<?= base_url('assets/js/class_detail.js') ?>"></script>
