<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?= $title ?></h4>
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#kelasModal" id="addKelasBtn">
      <i class="bi bi-plus-circle"></i> Tambah Kelas
    </button>
  </div>

  <table class="table table-bordered" id="kelasTable">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Nama Kelas</th>
        <th>Kode Kelas</th>
        <th>Deskripsi</th>
        <th>Dibuat</th>
        <th width="20%">Aksi</th>
      </tr>
    </thead>
    <tbody id="kelasBody">
      <?php $no = 1;
      foreach ($kelas as $k): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($k->nama_kelas) ?></td>
          <td><?= htmlspecialchars($k->kode_kelas) ?></td>
          <td><?= htmlspecialchars($k->deskripsi) ?></td>
          <td><?= date('d M Y', strtotime($k->created_at)) ?></td>
          <td class="text-center">
            <button class="btn btn-warning btn-sm editKelasBtn" data-id="<?= $k->id ?>" data-nama="<?= $k->nama_kelas ?>" data-kode="<?= $k->kode_kelas ?>" data-deskripsi="<?= $k->deskripsi ?>"><i class="bi bi-pencil"></i></button>
            <a href="<?= base_url('guru/kelas/detail/' . $k->id) ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
            <button class="btn btn-danger btn-sm deleteKelasBtn" data-id="<?= $k->id ?>"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="kelasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="kelasForm">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTitle">Tambah Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="kelas_id">
          <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" required>
          </div>
          <div class="mb-3">
            <label>Kode Kelas</label>
            <input type="text" class="form-control" name="kode_kelas" id="kode_kelas" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="saveKelasBtn">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script>
  const base_url = "<?= base_url('guru/kelas/') ?>";
  const dataTable = new simpleDatatables.DataTable("#kelasTable");

  // reset form modal
  $("#addKelasBtn").on("click", function() {
    $("#kelasForm")[0].reset();
    $("#kelas_id").val("");
    $("#modalTitle").text("Tambah Kelas");
  });

  // simpan atau update
  $("#kelasForm").submit(function(e) {
    e.preventDefault();
    const id = $("#kelas_id").val();
    const url = id ? base_url + "update_kelas" : base_url + "add_kelas";
    $.post(url, $(this).serialize(), function(res) {
      Swal.fire('Berhasil', 'Data kelas disimpan', 'success').then(() => location.reload());
    });
  });

  // edit kelas
  $(".editKelasBtn").on("click", function() {
    $("#modalTitle").text("Edit Kelas");
    $("#kelas_id").val($(this).data('id'));
    $("#nama_kelas").val($(this).data('nama'));
    $("#kode_kelas").val($(this).data('kode'));
    $("#deskripsi").val($(this).data('deskripsi'));
    $("#kelasModal").modal('show');
  });

  // hapus kelas
  $(".deleteKelasBtn").on("click", function() {
    const id = $(this).data('id');
    Swal.fire({
      title: "Yakin hapus?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus"
    }).then(res => {
      if (res.isConfirmed) {
        $.get(base_url + "delete_kelas/" + id, function() {
          Swal.fire('Dihapus!', 'Kelas berhasil dihapus', 'success').then(() => location.reload());
        });
      }
    });
  });
</script>