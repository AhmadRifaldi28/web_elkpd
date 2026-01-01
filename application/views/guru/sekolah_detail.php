<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#kelasTable {
  min-width: 720px !important;
}

.table-responsive {
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch;
}

#kelasTable thead th {
  background: #e0efff !important;
}

/*#kelasTable tbody td {
  text-align: right;
}*/

/* Responsive Styles */

.action {width: 28%;}

/*@media (max-width: 1051px) {
    .action { width: 25%; }
}*/

@media (max-width: 768px) {
  #kelasTable thead th{
    position: sticky;
    top: 0;
    z-index: 2;
  }

  .action {width: 30%;}
}

@media (max-width: 576px) {
  #kelasTable td { white-space: nowrap; }
}
</style>

<div class="container-fluid">
  <div class="pagetitle mb-3">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url('guru/dashboard') ?>">Sekolah</a>
        </li>
        <li class="breadcrumb-item active">Detail Sekolah</li>
      </ol>
    </nav>
  </div>

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <a href="<?= base_url('guru/dashboard') ?>" class="btn btn-secondary my-3">← Kembali ke Dashboard</a>
      <button class="btn btn-success" id="btnAddClass">
                <i class="fas fa-plus"></i> Tambah Kelas Baru
            </button>
  </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="alert alert-info border-0 shadow-sm">
                <i class="bi bi-info-circle-fill me-2"></i>
                Halaman ini menampilkan daftar <span id="info-label" class="fw-bold">kelas</span>. 
                Klik tombol <strong>"Detail"</strong> untuk melihat halaman detail kelas.
              </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas Anda di <?= htmlspecialchars($sekolah->name, ENT_QUOTES, 'UTF-8'); ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="kelasTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No</th>
                                    <th>Nama kelas</th>
                                    <th>Kode kelas</th>
                                    <th class="action">Aksi</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classModalLabel">Form Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="classForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                
                <input type="hidden" id="classId" name="id">

                <input type="hidden" id="schoolId" name="school_id" value="<?= $sekolah->id; ?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="className" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="className" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="classCode" class="form-label">Kode Kelas</label>
                        <input type="text" class="form-control" id="classCode" name="code" aria-describedby="codeHelp">
                        <div id="codeHelp" class="form-text">Bisa berupa kode unik (misal: "4-A"). Kosongkan untuk kode acak.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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