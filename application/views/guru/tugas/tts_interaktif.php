<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><?= $title; ?></h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahTTS">➕ Tambah TTS</button>
  </div>

  <!-- Table Data -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered align-middle text-center" id="tableTTS">
        <thead class="table-light">
          <tr>
            <th width="5%">No</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Grid</th>
            <th>Tanggal</th>
            <th width="15%">Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahTTS" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formTambahTTS">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah TTS Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Judul TTS</label>
            <input type="text" class="form-control" name="judul" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label>Ukuran Grid (misal: 10)</label>
            <input type="number" class="form-control" name="grid_size" value="10" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>

<script>
$(document).ready(function() {
  const dataTable = new simpleDatatables.DataTable("#tableTTS");
  loadTTS();

  // === LOAD DATA ===
  function loadTTS() {
    $.ajax({
      url: "<?= base_url('guru/tugas/get_all'); ?>",
      type: "GET",
      dataType: "json",
      success: function(data) {
        let rows = '';
        if (data.length === 0) {
          rows = '<tr><td colspan="6" class="text-muted">Belum ada data TTS.</td></tr>';
        } else {
          $.each(data, function(i, item) {
            rows += `
              <tr>
                <td>${i+1}</td>
                <td>${item.judul}</td>
                <td>${item.deskripsi ?? '-'}</td>
                <td>${item.grid_size}</td>
                <td>${item.created_at}</td>
                <td>
                  <a href="<?= base_url('guru/tugas/detail/'); ?>${item.id}" class="btn btn-sm btn-primary">
                    🔍 Detail
                  </a>
                  <a href="<?= base_url('guru/tugas/preview/') ?>${item.id}" class="btn btn-sm btn-primary">👁️ Preview</a>
                  <button class="btn btn-sm btn-danger btnHapus" data-id="${item.id}">
                    🗑️ Hapus
                  </button>
                </td>
              </tr>
            `;
          });
        }
        $('#tableTTS tbody').html(rows);
      }
    });
  }

  // === TAMBAH DATA ===
  $('#formTambahTTS').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= base_url('guru/tugas/store'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        if (res.status === 'success') {
          Swal.fire('Berhasil!', 'TTS berhasil ditambahkan.', 'success');
          $('#modalTambahTTS').modal('hide');
          $('#formTambahTTS')[0].reset();
          loadTTS();
        } else {
          Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
        }
      }
    });
  });

  // === HAPUS DATA ===
  $(document).on('click', '.btnHapus', function() {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Hapus TTS ini?',
      text: 'Data yang dihapus tidak dapat dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url('guru/tugas/delete/'); ?>" + id,
          type: "POST",
          dataType: "json",
          success: function(res) {
            if (res.status === 'success') {
              Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
              loadTTS();
            } else {
              Swal.fire('Gagal!', 'Tidak dapat menghapus data.', 'error');
            }
          }
        });
      }
    });
  });

});
</script>
