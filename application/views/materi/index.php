<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">
            Daftar Materi
        </h3>

        <?php if ($this->session->userdata('role_id') == 1): ?>
            <div>
                <a href="<?= site_url('guru/materi/create'); ?>" class="btn btn-success me-2 shadow-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Materi
                </a>
                <a href="<?= site_url('guru/dashboard'); ?>" class="btn btn-outline-secondary shadow-sm">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- 🔍 Form Search di Sebelah Kanan -->
    <div class="d-flex justify-content-end mb-4">
        <div class="input-group shadow-sm" style="max-width: 350px;">
            <input type="text" id="searchInput" name="q"
                class="form-control" placeholder="Cari materi..." autofocus>
            <button class="btn btn-primary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>


    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- 🔹 Daftar Materi -->
    <div id="materiContainer" class="row">
        <?php foreach ($materi as $m): ?>
            <div class="col-md-6 col-lg-4 mb-4 materi-item">
                <div class="card border-0 shadow-lg h-100 card-hover" style="border-radius: 15px;">
                    <div class="card-body d-flex flex-column bg-light bg-gradient">
                        <div class="mb-3 text-center">
                            <i class="bi bi-file-earmark-text text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title text-center fw-bold text-dark mb-2"><?= $m->judul; ?></h5>
                        <p class="card-text text-secondary small text-center flex-grow-1">
                            <?= $m->deskripsi; ?>
                        </p>
                        <div class="text-center mt-auto">
                            <?php if ($user['role_id'] == 1): ?>
                                <a href="<?= site_url('guru/materi/detail/' . $m->id); ?>"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                    <i class="bi bi-eye"></i> Lihat Materi
                                </a>
                                <a href="#"
                                    class="btn btn-danger btn-sm rounded-pill px-3 btn-hapus"
                                    data-id="<?= $m->id; ?>"
                                    data-judul="<?= htmlspecialchars($m->judul); ?>">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            <?php else: ?>
                                <a href="<?= site_url('siswa/materi/detail/' . $m->id); ?>"
                                class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                <i class="bi bi-eye"></i> Lihat Materi
                            </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Jika tidak ada materi -->
    <?php if (empty($materi)): ?>
        <div class="text-center text-muted mt-5">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Belum ada materi yang tersedia.</p>
        </div>
    <?php endif; ?>
</div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            let keyword = $(this).val().toLowerCase();

            // Jika kolom kosong, tampilkan semua
            if (keyword === "") {
                $(".materi-item").show();
                return;
            }

            $(".materi-item").filter(function() {
                let title = $(this).find(".card-title").text().toLowerCase();
                let desc = $(this).find(".card-text").text().toLowerCase();
                $(this).toggle(title.includes(keyword) || desc.includes(keyword));
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const btnHapus = document.querySelectorAll('.btn-hapus');
        btnHapus.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    html: "Materi <strong>" + judul + "</strong> akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash"></i> Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        confirmButton: 'rounded-pill px-4',
                        cancelButton: 'rounded-pill px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= site_url('guru/materi/delete/'); ?>" + id;
                    }
                });
            });
        });
    });
</script>

<style>
    .container {
        padding-top: 2em;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s ease-in-out;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
</style>