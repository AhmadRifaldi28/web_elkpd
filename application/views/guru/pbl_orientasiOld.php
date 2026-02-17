<style>
/* ===== 1. TEMA ANAK SD (COLOR PALETTE) ===== */
:root {
    --kid-blue: #4facfe;
    --kid-green: #00f2fe;
    --kid-orange: #f093fb;
    --kid-yellow: #f5576c;
    --kid-font: "Nunito", sans-serif;
}

/* Sembunyikan Judul Bawaan Template agar tidak Double */
.pagetitle { display: none !important; }

/* ===== 2. BACKGROUND UTAMA (IPAS.png) ===== */
#main {
    /* Gunakan gambar sebagai background */
    background: url('<?= base_url("assets/img/tema.png"); ?>') no-repeat top center !important;
    
    /* Desktop: Lebar 100%, Tinggi Auto (Memanjang ke bawah) */
    background-size: 100% auto !important;
    
    /* Scroll: Background ikut bergerak agar bisa lihat bagian bawah gambar */
    background-attachment: scroll !important;
    
    /* Container minimal setinggi layar */
    min-height: 100vh; 
    
    position: relative;
    padding-bottom: 50px;
}

/* Overlay tipis agar teks lebih kontras */
#main::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.1); 
    pointer-events: none;
    z-index: 0;
    height: 100%;
}

/* ===== 3. PANEL KONTEN (GLASS EFFECT) ===== */
.kids-panel {
    background-color: rgba(255, 255, 255, 0.7); /* Agak transparan */
    backdrop-filter: blur(7px);
    -webkit-backdrop-filter: blur(7px);
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border: 3px solid rgba(255,255,255,0.8);
    margin-top: 10px;
    position: relative;
    z-index: 2;
}

/* ===== 4. JUDUL HALAMAN (HEADER) ===== */
.fun-header {
    background: #fff;
    border-radius: 50px;
    padding: 15px 40px;
    display: inline-block;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 4px solid #fff;
    border-left: 10px solid var(--kid-blue); /* Aksen biru di kiri */
    margin-bottom: 25px;
    position: relative;
    z-index: 2;
}

.fun-title {
    margin: 0;
    font-weight: 800;
    color: #012970;
    font-size: 1.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ===== 5. TOMBOL WARNA-WARNI ===== */
.btn-fun {
    border-radius: 50px;
    font-weight: 700;
    padding: 10px 25px;
    border: none;
    color: white !important;
    box-shadow: 0 4px 0 rgba(0,0,0,0.1); /* Efek 3D */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.btn-fun:active { transform: translateY(4px); box-shadow: none; }

.btn-yellow { background-color: #ffc107; color: #444 !important; }
.btn-blue   { background-color: #0d6efd; }
.btn-blue:hover   { background-color: #0d6efd; }
.btn-green  { background-color: #198754; }
.btn-cyan   { background-color: #0dcaf0; color: #fff !important;}

/* ===== 6. TABEL LUCU ===== */
#pblTable {
    border-collapse: separate;
    border-spacing: 0 15px; 
}

#pblTable thead th {
    color: #0d6efd !important;
    border: none;
    font-weight: 800;
    text-transform: uppercase;
    padding: 15px;
    font-size: 0.9rem;
    white-space: nowrap; /* Mencegah header turun baris */
}

#pblTable tbody tr {
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0,0,0,0.05); 
    transition: transform 0.2s;
}

#pblTable tbody td {
    border: none; 
    padding: 15px;
    vertical-align: middle;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.95rem;
}

#pblTable tbody td:first-child { border-left: 1px solid #f0f0f0; border-radius: 20px 0 0 20px; }
#pblTable tbody td:last-child { border-right: 1px solid #f0f0f0; border-radius: 0 20px 20px 0; }

/* ===== DUMMY SPACER ===== */
.page-spacer {
    /* Tinggi dinamis untuk menampilkan sisa background */
    height: 60vw; 
    width: 100%;
    display: block;
    pointer-events: none;
}

/* =========================================
   MOBILE OPTIMIZATION (MAX-WIDTH 768PX) 
   ========================================= */
@media (max-width: 768px) {
    /* 1. Background Mobile: Tetap 100% lebar, tinggi otomatis */
    #main {
        background-size: 100% auto !important;
        padding: 15px; /* Kurangi padding container utama */
    }

    /* 2. Header Judul Lebih Kecil & Rapi */
    .fun-header {
        width: 100%;
        text-align: center;
        padding: 12px 20px;
        margin-bottom: 15px;
        border-left: 5px solid var(--kid-blue); /* Perkecil border aksen */
    }
    .fun-title {
        font-size: 1.2rem; /* Font judul lebih kecil */
    }

    /* 3. Panel Konten Lebih Padat */
    .kids-panel {
        padding: 20px 15px; /* Kurangi padding dalam */
        border-radius: 15px;
    }

    /* 4. Tombol Full Width di HP */
    .btn-fun {
        width: 100%; /* Tombol memenuhi lebar layar */
        margin-bottom: 8px; /* Jarak antar tombol */
        font-size: 0.9rem;
        padding: 10px;
    }
    
    /* Container tombol agar urutannya bagus */
    .d-flex.gap-2.flex-wrap {
        width: 100%;
        flex-direction: column; /* Tombol jadi vertikal */
    }

    /* 5. Tabel Scrollable */
    .table-responsive {
        border-radius: 10px;
        /* Scrollbar halus */
        scrollbar-width: thin; 
    }
    
    /* Font tabel lebih kecil di HP */
    #pblTable thead th { font-size: 0.8rem; padding: 10px; }
    #pblTable tbody td { font-size: 0.85rem; padding: 12px; }

    /* 6. Spacer Extra Besar di HP */
    /* Ini penting agar user bisa scroll jauh ke bawah dan melihat gambar anak-anak di cover */
    .page-spacer {
        height: 50vw; /* Sama dengan lebar layar (kotak) */
    }
}
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-center">
        <div class="fun-header">
            <h1 class="fun-title">
                <i class="ri-compass-3-line text-warning me-2"></i> Orientasi Masalah
            </h1>
        </div>
    </div>

    <div class="kids-panel">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            
            <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>" class="btn btn-fun btn-yellow">
                <i class="ri-arrow-left-fill"></i> Kembali ke Kelas
            </a>

            <div class="d-flex gap-2 flex-wrap">
                <?php if ($is_admin_or_guru): ?>
                    <button class="btn btn-fun btn-green" id="btnAddPbl">
                        <i class="ri-add-circle-fill"></i> Tambah Masalah
                    </button>
                    <a href="<?= site_url('guru/pbl/panduan_tahap1'); ?>" class="btn btn-fun btn-cyan">
                        <i class="ri-book-open-line"></i> Panduan
                    </a>
                <?php endif; ?>
                
                <a href="<?= base_url($url_name . '/pbl/tahap2/' . $class_id); ?>" class="btn btn-fun btn-blue">
                    Tahap 2 <i class="ri-arrow-right-circle-line"></i>
                </a>
            </div>
        </div>

        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

        <div class="alert alert-light border border-info border-2 rounded-4 text-primary d-flex align-items-center mb-4 shadow-sm p-3">
            <i class="ri-information-fill fs-1 me-3 text-info"></i> <div class="fw-bold small lh-sm">
                Ayo baca skenario masalah di bawah ini dengan teliti, lalu lihat materinya ya!
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="pblTable" width="100%">
                <thead>
                    <tr>
                        <th style="width:50px" class="text-center">No</th>
                        <th>Judul Masalah</th>
                        <th>Refleksi</th>
                        <th width="20%" class="text-center">Materi</th>
                        <?php if ($is_admin_or_guru): ?>
                            <th style="width:100px" class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>

    </div>

    <div class="page-spacer"></div>

</div>

<div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="ri-eye-line me-2"></i> Lihat Materi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="filePreviewContent" style="min-height: 400px; background: #f8f9fa;">
                </div>
        </div>
    </div>
</div>

<?php if ($is_admin_or_guru): ?>
<div class="modal fade" id="pblModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="pblModalLabel">Form Masalah PBL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="pblForm" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" id="pblId" name="id">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Masalah</label>
                        <input type="text" class="form-control rounded-3" id="pblTitle" name="title" placeholder="Contoh: Banjir di Sekolahku" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Refleksi Awal</label>
                        <textarea class="form-control rounded-3" id="pblReflection" name="reflection" rows="3" placeholder="Tuliskan pertanyaan pemantik..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Materi Pendukung</label>
                        <input type="file" class="form-control rounded-3" id="pblFile" name="file">
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
</script>

<script type="module" src="<?= base_url('assets/js/pbl_orientasi.js'); ?>"></script>