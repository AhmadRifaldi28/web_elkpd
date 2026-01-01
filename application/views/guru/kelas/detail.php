<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">

<div class="container py-4">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?= $title ?></h4>
    <a href="<?= base_url('guru/kelas'); ?>" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Informasi Kelas -->
  <div class="card mb-4">
    <div class="card-body">
      <h5><?= $kelas->nama_kelas; ?></h5>
      <p><strong>Kode Kelas:</strong> <span class="badge bg-primary"><?= $kelas->kode_kelas; ?></span></p>
      <p><?= $kelas->deskripsi; ?></p>
    </div>
  </div>

  <!-- ======================== SISWA SECTION ======================== -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h5>Daftar Siswa</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#siswaModal">
      <i class="bi bi-person-plus"></i> Tambah Siswa
    </button>
  </div>

  <table class="table table-bordered" id="siswaTable">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Email</th>
        <th width="10%">Aksi</th>
      </tr>
    </thead>
    <tbody id="tbody-siswa">
      <?php $no = 1;
      foreach ($siswa as $s): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $s->name ?></td>
          <td><?= $s->username ?></td>
          <td><?= $s->email ?></td>
          <td>
            <button class="btn btn-danger btn-sm delete-siswa" data-id="<?= $s->id ?>">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Modal Tambah Siswa -->
  <div class="modal fade" id="siswaModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="siswaForm">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Tambah Siswa</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="kelas_id" value="<?= $kelas->id ?>">
            <div class="mb-3">
              <label>Pilih Siswa</label>
              <select name="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>
                <?php foreach ($siswa_list as $s): ?>
                  <option value="<?= $s->id ?>"><?= $s->name ?> (<?= $s->username ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <hr class="my-4">

  <!-- ======================== MATERI SECTION ======================== -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h5>Daftar Materi</h5>
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#materiModal">
      <i class="bi bi-file-earmark-plus"></i> Tambah Materi
    </button>
  </div>

  <table class="table table-bordered" id="materiTable">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>File</th>
        <th>Tanggal</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody id="tbody-materi">
      <?php $no = 1;
      foreach ($materi as $m): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $m->judul ?></td>
          <td><?= nl2br(htmlspecialchars($m->deskripsi)) ?></td>
          <td>
            <?php if ($m->file_path): ?>
              <button class="btn btn-outline-success btn-sm" onclick="openPreview('<?= base_url($m->file_path) ?>')">
                <i class="bi bi-eye"></i> Lihat
              </button>
            <?php else: ?>
              <span class="text-muted">Tidak ada file</span>
            <?php endif; ?>
          </td>
          <td><?= date('d M Y', strtotime($m->created_at)) ?></td>
          <td>
            <button class="btn btn-danger btn-sm delete-materi" data-id="<?= $m->id ?>">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Modal Tambah Materi -->
  <div class="modal fade" id="materiModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="materiForm" enctype="multipart/form-data">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Tambah Materi</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="kelas_id" value="<?= $kelas->id ?>">
            <div class="mb-3">
              <label>Judul</label>
              <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Deskripsi</label>
              <textarea name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
              <label>File (opsional)</label>
              <input type="file" name="file" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<!-- Modal Preview File -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Preview File Materi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center" id="previewContent">Memuat...</div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

<script>
  const base_url = "<?= base_url('guru/kelas/') ?>";

  // === Tambah siswa ===
  $('#siswaForm').submit(function(e) {
    e.preventDefault();
    $.post(base_url + 'add_siswa', $(this).serialize(), function(res) {
      const data = JSON.parse(res);
      if (data.status === 'exists') {
        Swal.fire('Gagal', 'Siswa sudah ada di kelas ini!', 'warning');
      } else {
        Swal.fire('Berhasil', 'Siswa ditambahkan!', 'success').then(() => location.reload());
      }
    });
  });

  // === Hapus siswa ===
  $('.delete-siswa').click(function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus siswa?',
        icon: 'warning',
        showCancelButton: true
      })
      .then(res => {
        if (res.isConfirmed) {
          $.get(base_url + 'remove_siswa/' + id, function() {
            Swal.fire('Dihapus', 'Siswa berhasil dihapus', 'success').then(() => location.reload());
          });
        }
      });
  });

  // === Tambah materi ===
  $('#materiForm').submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
      url: base_url + 'add_materi',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function() {
        Swal.fire('Berhasil', 'Materi ditambahkan!', 'success').then(() => location.reload());
      }
    });
  });

  // === Hapus materi ===
  $('.delete-materi').click(function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus materi?',
        icon: 'warning',
        showCancelButton: true
      })
      .then(res => {
        if (res.isConfirmed) {
          $.get(base_url + 'delete_materi/' + id, function() {
            Swal.fire('Dihapus', 'Materi dihapus', 'success').then(() => location.reload());
          });
        }
      });
  });

  // === Preview file ===
  function openPreview(url) {
    const ext = url.split('.').pop().toLowerCase();
    let content = '';
    if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
      content = `<img src="${url}" class="img-fluid rounded shadow">`;
    } else if (ext === 'pdf') {
      content = `<iframe src="${url}" width="100%" height="600px" style="border:none;"></iframe>`;
    } else if (['mp4', 'webm', 'mov'].includes(ext)) {
      content = `<video controls width="100%" class="rounded shadow"><source src="${url}" type="video/${ext}"></video>`;
    } else {
      content = `<p>Tipe file tidak bisa dipreview. <a href="${url}" download>Download</a></p>`;
    }
    $('#previewContent').html(content);
    new bootstrap.Modal('#previewModal').show();
  }
</script>