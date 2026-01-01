<div class="container mt-4">

    <!-- Header Judul -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-journal-text"></i> Daftar Materi
        </h3>

        <!-- Form Pencarian -->
        <form method="get" action="<?= site_url('materi'); ?>" class="d-flex" style="max-width: 350px;">
            <div class="input-group shadow-sm">
                <input type="text" name="q" value="<?= htmlspecialchars($this->input->get('q')); ?>"
                    class="form-control" placeholder="Cari materi..." autofocus>
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Notifikasi -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Daftar Materi -->
    <div class="row">
        <?php if (!empty($materi)): ?>
            <?php foreach ($materi as $m): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold text-dark mb-2"><?= htmlspecialchars($m->judul); ?></h5>
                            <p class="card-text text-muted mb-3" style="font-size: 0.9rem;">
                                <?= $m->deskripsi; ?>
                            </p>
                            <a href="<?= site_url('siswa/materi/view/' . $m->id); ?>" class="btn btn-outline-primary mt-auto">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                        <div class="card-footer bg-light text-end">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event"></i>
                                <?= date('d M Y', strtotime($m->created_at ?? 'now')); ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center mt-4">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076500.png" width="100" class="mb-3 opacity-75">
                <p class="text-muted">Belum ada materi yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol Kembali ke Dashboard -->
    <div class="mt-3">
        <a href="<?= site_url('dashboard/siswa'); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>
    </div>
</div>