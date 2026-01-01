<div class="content-wrapper p-4">
    <h2><?= $title; ?></h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Judul Materi</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Upload File (PDF, Gambar, Video)</label>
            <input type="file" name="file_materi" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Upload</button>
        <a href="<?= site_url('materi'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>