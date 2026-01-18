<style>
/* ===== CLASS DETAIL – NICEADMIN UI ENHANCEMENT ===== */

/* Page header */
.class-header {
  border-bottom: 1px solid #e5e7eb !important;
  padding-bottom: 1rem !important;
  margin-bottom: 1.5rem !important;
}

/* Badge */
.class-badge {
  font-size: .75rem !important;
  letter-spacing: .5px !important;
}

/* Card animation */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.card {
  animation: fadeUp .4s ease-out both !important;
}

/* Table */
#siswaTable {
  min-width: 720px !important;
  border: 1px solid #dee2e6 !important;
}

#siswaTable thead th,
#siswaTable tbody td {
  border: 1px solid #dee2e6 !important;
  vertical-align: middle !important;
}

#siswaTable tbody tr {
  transition: background-color .2s ease !important;
}

#siswaTable tbody tr:hover {
  background-color: #f8f9fa !important;
}

/* Responsive */
.table-responsive {
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch !important;
}

/* Action button */
.btn-add-student {
  box-shadow: 0 4px 12px rgba(25,135,84,.3) !important;
}

.btn-add-student:hover {
  box-shadow: 0 6px 18px rgba(25,135,84,.45) !important;
  transform: translateY(-1px) !important;
}

/* Info alert */
.alert-info {
  background-color: #eef6ff !important;
}

/* ===== MINI STAT CHART ===== */
#studentChart {
  max-height: 180px !important;
}

.card-title {
  font-size: .9rem !important;
  font-weight: 600 !important;
}

</style>

<div class="container-fluid py-3">

  <!-- ===== HEADER ===== -->
  <div class="class-header d-flex justify-content-between align-items-start flex-wrap gap-3">
    <!-- <div>
      <h4 class="mb-1">
        <i class="bi bi-people-fill text-primary me-2"></i>
        Detail Kelas
      </h4>
      <span class="badge bg-info text-dark class-badge">Manajemen Kelas</span>
    </div> -->

    <div class="d-flex gap-2">
      <a href="<?= base_url('guru/dashboard/detail/' . $sekolah->school_id) ?>"
         class="btn btn-secondary">
        <i class="ri-arrow-go-back-line"></i> Daftar Kelas
      </a>

      <a href="<?= base_url('guru/pbl/index/' . $kelas->id); ?>"
         class="btn btn-outline-primary">
        <i class="ri-book-2-line"></i> Tahap 1
      </a>
    </div>
  </div>

  <!-- ===== CLASS INFO CARD ===== -->
  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <h5 class="fw-semibold my-2">
        <?= htmlspecialchars($kelas->name, ENT_QUOTES, 'UTF-8'); ?>
      </h5>

      <div class="d-flex flex-wrap gap-4">
        <div>
          <small class="text-muted">Kode Kelas</small><br>
          <span class="badge bg-primary">
            <?= htmlspecialchars($kelas->code, ENT_QUOTES, 'UTF-8'); ?>
          </span>
        </div>

        <div>
          <small class="text-muted">Jumlah Siswa</small><br>
          <span class="fw-bold" id="jumlah-siswa">
            <?= $kelas->student_count; ?>
          </span>
        </div>

        <div>
          <small class="text-muted">Guru Pengampu</small><br>
          <span class="fw-semibold">
            <i class="ri-admin-line me-1 text-primary"></i>
            <?= htmlspecialchars($this->session->userdata('name'), ENT_QUOTES, 'UTF-8'); ?>
          </span>
        </div>

      </div>
    </div>
  </div>

  <!-- ===== INFO ===== -->
  <div class="alert alert-info border-0 shadow-sm">
    <i class="bi bi-info-circle-fill me-2"></i>
    Halaman ini menampilkan daftar <strong>Siswa</strong>.
    Gunakan tombol <strong>Tambah Siswa</strong> untuk menambahkan siswa ke kelas ini.
  </div>

  <!-- <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h6 class="card-title text-muted mb-3">
            <i class="bi bi-bar-chart-line me-1"></i>
            Statistik Kelas
          </h6>
          <canvas id="studentChart" height="160"></canvas>
        </div>
      </div>
    </div>

  </div> -->

  <!-- ===== STUDENT TABLE ===== -->
  <div class="card shadow mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="ri-team-fill me-2 text-success"></i>
        Daftar Siswa
      </h5>

      <button class="btn btn-success btn-sm btn-add-student"
              id="btnAddStudent"
              data-bs-toggle="modal"
              data-bs-target="#siswaModal">
        <i class="ri-ri-download-cloud-2-line"></i> Tambah Siswa
      </button>
    </div>

    <div class="card-body p-3" id="siswaTableContainer">
      <div class="table-responsive">
        <table class="table mb-0" id="siswaTable" style="width:100%">
          <thead class="table-light">
            <tr>
              <th style="width:5%">#</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Email</th>
              <th style="width:15%">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- ===== MODAL ===== -->
<div class="modal fade" id="siswaModal" tabindex="-1" aria-labelledby="siswaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow border-0">

      <form id="studentForm">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="siswaModalLabel">
            Tambah Siswa ke Kelas
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                 value="<?= $this->security->get_csrf_hash(); ?>">
          <input type="hidden" name="class_id" id="classIdHidden" value="<?= $kelas->id; ?>">

          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Siswa</label>
            <select class="form-select" id="studentSelect" name="student_id" required>
              <option value="">-- Pilih Siswa (belum memiliki kelas) --</option>
              <?php foreach($siswa_list as $s): ?>
                <option value="<?= $s->id; ?>">
                  <?= htmlspecialchars($s->name, ENT_QUOTES, 'UTF-8'); ?>
                  (<?= htmlspecialchars($s->username, ENT_QUOTES, 'UTF-8'); ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="btnSaveStudent">
            <i class="ri-download-cloud-2-line"></i> Simpan
          </button>
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

<!-- <script src="<?= base_url('assets/vendor/chart.js/chart.umd.js'); ?>"></script> -->

<script>
document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('studentChart');
  if (!ctx) return;

  const studentCount = <?= (int)$kelas->student_count ?>;

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jumlah Siswa'],
      datasets: [{
        data: [studentCount],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: (ctx) => ` ${ctx.raw} siswa`
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5
          }
        }
      }
    }
  });
});
</script>


<script type="module" src="<?= base_url('assets/js/class_detail.js') ?>"></script>
