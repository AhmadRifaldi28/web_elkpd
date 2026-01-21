<style>
/* ===== 1. HERO SECTION (Desktop Style - Sesuai Pilihan Anda) ===== */
.dashboard-hero {
    background: linear-gradient(135deg, var(--bd-violet-bg) 0%, #4a148c 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(113, 44, 249, 0.2);
    margin-bottom: 40px;
    min-height: 340px; /* Sedikit ditambah agar gambar lebih leluasa */
    display: flex;
    align-items: center;
}

.dashboard-hero-content {
    position: relative;
    z-index: 2;
    max-width: 65%; /* Teks mengambil 65% lebar di desktop */
}

.dashboard-hero-img {
    position: absolute;
    right: 20px; /* Digeser masuk sedikit agar wajah karakter tidak terpotong */
    bottom: -30px; /* Naikkan sedikit */
    height: 106%; /* Ukuran disesuaikan agar proporsional */
    object-fit: contain;
    transform: rotate(-5deg); /* Efek miring yang Anda suka */
    opacity: 1; /* Opacity 1 agar jelas (tidak transparan) */
    z-index: 1;
    pointer-events: none;
    transition: all 0.5s ease;
    filter: drop-shadow(0 10px 10px rgba(0,0,0,0.3)); /* Bayangan agar gambar "pop-up" */
}

/* Efek Hover di Desktop */
.dashboard-hero:hover .dashboard-hero-img {
    transform: rotate(0deg) scale(1.05); /* Tegak & membesar saat mouse lewat */
    right: 10px;
}

/* ===== 2. RESPONSIVE FIX (Agar Jelas di HP) ===== */
@media (max-width: 768px) {
    .dashboard-hero {
        display: block; /* Ubah flex ke block agar elemen menumpuk natural */
        min-height: auto; /* Tinggi otomatis mengikuti konten */
        padding-bottom: 0; /* Hilangkan padding bawah agar gambar nempel */
    }

    .dashboard-hero-content {
        max-width: 100%; /* Teks ambil selebar layar */
        margin-bottom: 180px; /* Beri ruang kosong di bawah untuk gambar */
        text-align: left;
    }

    .dashboard-hero-img {
        /* Reset posisi untuk Mobile */
        height: 270px; /* Tinggi fix agar pas di layar HP */
        width: auto;
        
        right: -10px; /* Tempel ke kanan */
        bottom: 0; /* Tempel ke dasar */
        top: auto;
        
        transform: none; /* Hilangkan miring agar terlihat jelas tegak */
        opacity: 1;
    }
}
</style>

<div class="container-fluid">

    <div class="dashboard-hero">
        <div class="dashboard-hero-content">
            <span class="badge bg-warning text-dark mb-2 px-3 rounded-pill fw-bold">
                <i class="ri-star-smile-fill me-1"></i> E-LKPD Interaktif
            </span>
            <h2 class="fw-bold display-6 mb-2">Selamat Datang, Guru Hebat!</h2>
            <p class="mb-4 fs-6 opacity-75" style="line-height: 1.5;">
                Kelola kelas dan pantau perkembangan literasi siswa kelas 5 dengan materi IPAS yang menyenangkan.
            </p>
            
            <div class="d-flex gap-3 align-items-center">
                <div class="bg-white bg-opacity-25 px-3 py-2 rounded-3 border border-white border-opacity-25">
                    <h4 class="fw-bold mb-0 m-0"><?= count($sekolah_list ?? []) ?></h4>
                    <small class="opacity-75" style="font-size: 0.75rem">Sekolah</small>
                </div>
            </div>
        </div>
        
        <img src="<?= base_url('assets/img/IPAS.png'); ?>" alt="IPAS Cover" class="dashboard-hero-img">
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold text-dark m-0">Daftar Sekolah Anda</h5>
        <span class="badge bg-light text-primary border">Tahun Ajaran Aktif</span>
    </div>

    <div class="row">
        <?php if (!empty($sekolah_list)): ?>
            <?php foreach ($sekolah_list as $sekolah): ?>
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="ri-building-4-fill fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0 text-truncate" style="max-width: 200px;"><?= htmlspecialchars($sekolah->name); ?></h6>
                                    <small class="text-muted"><i class="ri-map-pin-line me-1"></i><?= htmlspecialchars($sekolah->address); ?></small>
                                </div>
                            </div>
                            <a href="<?= base_url('guru/dashboard/detail/' . $sekolah->id) ?>" class="btn btn-outline-primary w-100 rounded-pill">
                                Masuk Kelas <i class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                    <i class="ri-information-line fs-4 me-2"></i>
                    <div>Anda belum terhubung dengan sekolah manapun.</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <img src="<?= base_url('assets/img/IPAS.png'); ?>" alt="IPAS Cover">
    </div>

</div>