<div class="container mt-4">
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <h3><?= isset($materi) ? 'Edit Materi' : 'Tambah Materi'; ?></h3>
    <form action="<?= isset($materi->id) ? site_url('guru/materi/edit/' . $materi->id) : site_url('guru/materi/create'); ?>"
        method="post"
        enctype="multipart/form-data">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= isset($materi) ? $materi->judul : set_value('judul'); ?>" required >
            <?= form_error('judul', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= isset($materi) ? $materi->deskripsi : set_value('deskripsi'); ?></textarea>
            <?= form_error('deskripsi', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label>File (PDF, Gambar, Video)</label>
            <input type="file" name="file" class="form-control">
            <?php if (isset($materi) && $materi->file_path): ?>
                <small class="text-muted">File saat ini: <?= str_replace("uploads/materi/", "", $materi->file_path) ?></small>
            <?php endif; ?>
            <?= form_error('file', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('guru/materi'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>