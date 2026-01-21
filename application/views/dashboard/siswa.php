<style>
/* ===== 1. HERO SECTION (Desktop Style) ===== */
.dashboard-hero {
    background: linear-gradient(135deg, var(--bd-violet-bg) 0%, #4a148c 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(113, 44, 249, 0.2);
    margin-bottom: 40px;
    /*min-height: 240px;*/
    min-height: 340px;
    display: flex;
    align-items: center;
}

.dashboard-hero-content {
    position: relative;
    z-index: 2;
    max-width: 65%;
}

.dashboard-hero-img {
    position: absolute;
    right: 20px;
    bottom: -30px;
    /*height: 130%;*/
    height: 106%;
    object-fit: contain;
    transform: rotate(-5deg);
    opacity: 1;
    z-index: 1;
    pointer-events: none;
    transition: all 0.5s ease;
    filter: drop-shadow(0 10px 10px rgba(0,0,0,0.3));
}

.dashboard-hero:hover .dashboard-hero-img {
    transform: rotate(0deg) scale(1.05);
    right: 10px;
}

/* ===== 2. CARD STYLING ===== */
.school-card {
    border: none;
    border-radius: 15px;
    background: #fff;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    height: 100%;
    border-top: 5px solid transparent;
}

.school-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border-top-color: var(--bd-violet-bg);
}

.school-icon-wrapper {
    width: 65px;
    height: 65px;
    background-color: #f6f9ff;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    color: var(--bd-violet-bg);
    font-size: 32px;
    transition: 0.3s;
}

.school-card:hover .school-icon-wrapper {
    background-color: var(--bd-violet-bg);
    color: white;
    box-shadow: 0 10px 20px rgba(113, 44, 249, 0.3);
}

.btn-action {
    background-color: #f0f2f5;
    color: var(--bd-dark);
    font-weight: 700;
    border-radius: 12px;
    padding: 12px 20px;
    transition: 0.3s;
    border: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-action:hover {
    background-color: var(--bd-violet-bg);
    color: white;
    transform: scale(1.02);
}

/* ===== 3. RESPONSIVE (Mobile Fix) ===== */
@media (max-width: 768px) {
    .dashboard-hero {
        display: block;
        min-height: auto;
        padding-bottom: 0;
    }

    .dashboard-hero-content {
        max-width: 100%;
        margin-bottom: 180px; /* Ruang untuk gambar di bawah */
        text-align: left;
    }

    .dashboard-hero-img {
        /*height: 220px;*/
        height: 270px;
        width: auto;
        right: -10px;
        bottom: 0;
        top: auto;
        transform: none;
        opacity: 1;
    }
}
</style>

<div class="container-fluid">

    <div class="dashboard-hero">
        <div class="dashboard-hero-content">
            <span class="badge bg-warning text-dark mb-2 px-3 rounded-pill fw-bold">
                <i class="ri-rocket-2-fill me-1"></i> Semangat Belajar!
            </span>
            <h2 class="fw-bold display-6 mb-2">Halo, Siswa Berprestasi!</h2>
            <p class="mb-4 fs-6 opacity-75" style="line-height: 1.5;">
                Akses materi pelajaran IPAS dan kerjakan tugas-tugasmu dengan mudah dan menyenangkan di sini.
            </p>
            
            <div class="d-flex gap-3 align-items-center">
                <div class="bg-white bg-opacity-25 px-3 py-2 rounded-3 border border-white border-opacity-25">
                    <h4 class="fw-bold mb-0 m-0"><?= count($kelas_murid ?? []) ?></h4>
                    <small class="opacity-75" style="font-size: 0.75rem">Kelas Terdaftar</small>
                </div>
            </div>
        </div>
        
        <img src="<?= base_url('assets/img/IPAS.png'); ?>" alt="IPAS Cover" class="dashboard-hero-img">
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold text-dark m-0">Kelas Saya</h5>
        <span class="badge bg-light text-primary border">Semester Aktif</span>
    </div>

    <div class="row">
        <?php if (!empty($kelas_murid)): ?>
            <?php foreach ($kelas_murid as $kelas): ?>
                <div class="col-md-6 col-xl-4 mb-4">
                    
                    <div class="card school-card p-4">
                        <div class="card-body p-0 d-flex flex-column h-100">
                            
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="school-icon-wrapper">
                                    <i class="ri-book-open-line"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn text-muted p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-fill fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li><a class="dropdown-item" href="#">Lihat Info Kelas</a></li>
                                    </ul>
                                </div>
                            </div>

                            <h5 class="card-title text-truncate fs-5 mb-1" title="<?= htmlspecialchars($kelas->name); ?>">
                                <?= htmlspecialchars($kelas->name, ENT_QUOTES, 'UTF-8'); ?>
                            </h5>
                            
                            <p class="card-text mb-4 text-muted">
                                <span class="badge text-primary border border-info rounded-pill">
                                    <i class="ri-qr-code-line me-1"></i> Kode: <?= htmlspecialchars($kelas->code, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </p>

                            <div class="mt-auto">
                                <a href="<?= base_url('siswa/dashboard/class_detail/' . $kelas->id) ?>" class="btn btn-action w-100">
                                    <span>Masuk Kelas</span>
                                    <i class="ri-arrow-right-circle-fill fs-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5 bg-light rounded-4">
                    <div class="card-body">
                        <div class="mb-3 text-muted opacity-25">
                            <i class="ri-folder-unknow-line" style="font-size: 5rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Belum Ada Kelas</h4>
                        <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                            Kamu belum terhubung dengan kelas manapun. Silakan minta <strong>Kode Kelas</strong> kepada gurumu.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <img src="<?= base_url('assets/img/IPAS.png'); ?>" alt="IPAS Cover">
    </div>

</div>