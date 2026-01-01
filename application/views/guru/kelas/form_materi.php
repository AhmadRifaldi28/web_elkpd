<div class="container mt-4">
    <h4><?= isset($materi) ? 'Edit Materi' : 'Tambah Materi' ?></h4>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= isset($materi) ? $materi->judul : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required><?= isset($materi) ? $materi->deskripsi : '' ?></textarea>
        </div>
        <div class="mb-3">
            <label>File Materi (opsional)</label>
            <input type="file" name="file" class="form-control">
            <?php if (isset($materi) && $materi->file_path): ?>
                <p class="mt-2">File lama: <a href="<?= base_url($materi->file_path) ?>" target="_blank">Lihat File</a></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('guru/kelas/detail/' . $kelas->id) ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>