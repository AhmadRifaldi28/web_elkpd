<div class="content-wrapper p-4">
    <h3><?= $materi->judul; ?></h3>
    <p><?= $materi->deskripsi; ?></p>
    <p><small>Diupload oleh <?= $materi->created_by; ?> pada <?= date('d M Y H:i', strtotime($materi->created_at)); ?></small></p>

    <?php
    $ext = pathinfo($materi->file_path, PATHINFO_EXTENSION);
    if ($ext == 'pdf'): ?>
        <iframe src="<?= base_url($materi->file_path); ?>" width="100%" height="600"></iframe>

    <?php elseif (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
        <img src="<?= base_url($materi->file_path); ?>" class="img-fluid">

    <?php elseif (in_array($ext, ['mp4', 'mov', 'avi'])): ?>
        <video controls width="100%">
            <source src="<?= base_url($materi->file_path); ?>" type="video/mp4">
        </video>
    <?php else: ?>
        <p>File tidak dapat ditampilkan, silakan unduh: <a href="<?= base_url($materi->file_path); ?>">Download</a></p>
    <?php endif; ?>
</div>