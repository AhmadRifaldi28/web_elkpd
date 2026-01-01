<div class="container mt-4">
  <h4><?= $forum ? 'Edit Forum' : 'Tambah Forum'; ?></h4>
  <form action="<?= base_url('forum/save'); ?>" method="post">
    <input type="hidden" name="id" value="<?= $forum ? $forum->id : ''; ?>">
    <div class="mb-3">
      <label class="form-label">Judul Forum</label>
      <input type="text" name="judul" class="form-control" value="<?= $forum ? htmlentities($forum->judul) : ''; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Materi Terkait (Opsional)</label>
      <input type="text" name="materi_id" class="form-control" placeholder="ID Materi (opsional)" value="<?= $forum ? $forum->materi_id : ''; ?>">
    </div>

    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
    <a href="<?= base_url('forum/kelola'); ?>" class="btn btn-secondary">Kembali</a>
  </form>
</div>
