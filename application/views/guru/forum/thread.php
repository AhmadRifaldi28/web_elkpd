<div class="container py-4">

  <!-- Header thread -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <h3 class="fw-bold text-primary mb-3">
        <i class="bi bi-chat-dots"></i> <?= htmlentities($thread->judul); ?>
      </h3>
      <p class="text-muted mb-0">
        <i class="bi bi-calendar-event"></i>
        <?= date('d M Y, H:i', strtotime($thread->tanggal)); ?>
        <span class="ms-3">
          <i class="bi bi-person-circle"></i>
          <?= htmlentities($thread->nama_guru ?? 'Guru Tidak Diketahui'); ?>
        </span>
      </p>
    </div>
  </div>

  <!-- Alert  -->
  <?php if($this->session->flashdata('komentar_sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      Komentar berhasil dikirim!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Komentar -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-light d-flex align-items-center">
      <h5 class="mb-0 fw-bold"><i class="bi bi-chat-left-text"></i> Diskusi</h5>
    </div>

    <div class="card-body" id="comment-section">

      <?php if (!empty($comments)): ?>
        <?php foreach($comments as $c): ?>
          <div class="d-flex align-items-start mb-3 p-2 border-bottom">
            <div class="flex-shrink-0">
              <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
              style="width:40px; height:40px; font-weight:bold;">
              <?= strtoupper(substr($c->nama_user ?? 'U', 0, 1)); ?>
            </div>
          </div>
          <div class="ms-3 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
  <h6 class="fw-semibold mb-0"><?= htmlentities($c->nama_user ?? 'User'); ?></h6>
  <div class="d-flex align-items-center gap-2">
    <small class="text-muted"><?= date('d M Y H:i', strtotime($c->tanggal)); ?></small>

    <?php if ($this->session->userdata('user_id') == $c->user_id || $this->session->userdata('role') == 'guru'): ?>
      <button class="btn btn-sm btn-outline-danger btnHapusKomentar"
              data-id="<?= $c->id; ?>" title="Hapus Komentar">
        <i class="bi bi-trash"></i>
      </button>
    <?php endif; ?>
  </div>
</div>

            <p class="mb-1"><?= nl2br(htmlentities($c->isi_komentar)); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
      <?php else: ?>
        <div class="text-center text-muted py-3">
          <i class="bi bi-chat-left-dots"></i> Belum ada komentar. Jadilah yang pertama berkomentar!
        </div>
      <?php endif; ?>

    </div>
  </div>

  <!-- Form komentar -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-light">
      <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Tambahkan Komentar</h5>
    </div>
    <div class="card-body">
      <form action="<?= site_url('guru/forum/komentar'); ?>" method="post">
        <input type="hidden" name="forum_id" value="<?= $thread->id; ?>">
        <div class="mb-3">
          <textarea name="isi_komentar" rows="3" class="form-control" placeholder="Tulis komentar kamu di sini..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-send"></i> Kirim Komentar
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // const alertEl = document.getElementById("alertKomentar");
    const alertEl = document.querySelector('.alert-success');
    if (alertEl) {
      setTimeout(() => {
        const alert = bootstrap.Alert.getOrCreateInstance(alertEl);
        alert.close();
      }, 3000); // 3 detik
    }
  });
</script>

<!-- Tambahkan di akhir file thread.php -->
<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
$(document).ready(function() {

  // Hapus komentar
  $(document).on('click', '.btnHapusKomentar', function() {
    const komentarId = $(this).data('id');
    const row = $(this).closest('.d-flex.align-items-start');

    Swal.fire({
      title: 'Yakin ingin menghapus komentar ini?',
      text: 'Komentar akan dihapus permanen.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= base_url("guru/forum/hapus_komentar/") ?>' + komentarId,
          type: 'POST',
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
              });
              row.fadeOut(300, function() { $(this).remove(); });
            } else {
              Swal.fire('Gagal', res.message, 'error');
            }
          },
          error: function() {
            Swal.fire('Error', 'Gagal menghapus komentar.', 'error');
          }
        });
      }
    });
  });

});
</script>


<!-- <script src="</?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
  </?php if($this->session->flashdata('komentar_sukses')): ?>
    Swal.fire({
      icon: 'success',
      title: 'Komentar Terkirim!',
      text: 'Komentarmu berhasil ditambahkan.',
      timer: 2000,
      showConfirmButton: false
    });
  </?php endif; ?>
</script> -->