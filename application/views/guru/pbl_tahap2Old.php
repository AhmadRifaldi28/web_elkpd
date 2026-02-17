<style>
/* ===== 1. PALET WARNA CERIA (KIDS THEME) ===== */
:root {
    --kid-orange: #FF9F1C;
    --kid-yellow: #FFBF00;
    --kid-teal: #2EC4B6;
    --kid-blue: #CBF3F0;
    --kid-white: #FFFFFF;
    --kid-font: "Nunito", sans-serif;
}

/* Sembunyikan Judul Bawaan Template */
.pagetitle { display: none !important; }

/* ===== 2. BACKGROUND UTAMA (TEMA_4.PNG) ===== */
#main {
    /* Background Tema 4 */
    background: url('<?= base_url("assets/img/tema_4.png"); ?>') no-repeat top center !important;
    
    /* Agar gambar terlihat penuh (lebar 100%, tinggi menyesuaikan) dan bisa di-scroll */
    background-size: 100% auto !important;
    background-attachment: scroll !important;
    
    min-height: 100vh;
    position: relative;
    padding-bottom: 100px; /* Ruang ekstra di bawah */
}

/* Overlay tipis agar teks lebih jelas */
#main::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.2); 
    pointer-events: none;
    z-index: 0;
    height: 100%;
}

/* ===== 3. PANEL KONTEN (GLASS BUBBLE) ===== */
.kids-panel {
    background-color: rgba(255, 255, 255, 0.92); /* Putih susu */
    backdrop-filter: blur(5px);
    border-radius: 30px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border: 5px solid #fff;
    margin-top: 20px;
    position: relative;
    z-index: 2;
}

/* ===== 4. HEADER JUDUL ===== */
.fun-header {
    background: #fff;
    border-radius: 50px;
    padding: 15px 30px;
    display: inline-block;
    box-shadow: 0 5px 0 rgba(0,0,0,0.1);
    border: 3px solid var(--kid-teal);
    margin-bottom: 25px;
    text-align: center;
}

.fun-title {
    margin: 0;
    font-weight: 800;
    color: #012970;
    font-size: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ===== 5. NAVIGASI TABS (GAYA TOMBOL GAME) ===== */
.nav-pills-custom {
    background: #f1f8ff;
    padding: 10px;
    border-radius: 50px;
    display: inline-flex;
    gap: 10px;
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
}

.nav-pills-custom .nav-link {
    border-radius: 40px;
    color: #555;
    font-weight: 700;
    padding: 10px 25px;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.nav-pills-custom .nav-link:hover {
    background: #fff;
    color: var(--kid-teal);
}

.nav-pills-custom .nav-link.active {
    background-color: var(--kid-teal);
    color: white;
    box-shadow: 0 4px 10px rgba(46, 196, 182, 0.4);
    transform: scale(1.05);
}

/* Tab TTS warna oranye */
.nav-pills-custom .nav-link#tts-tab.active {
    background-color: var(--kid-orange);
    box-shadow: 0 4px 10px rgba(255, 159, 28, 0.4);
}

/* ===== 6. TOMBOL WARNA-WARNI ===== */
.btn-fun {
    border-radius: 50px;
    font-weight: 800;
    border: none;
    padding: 10px 20px;
    box-shadow: 0 4px 0 rgba(0,0,0,0.15);
    transition: all 0.2s;
    color: white !important;
    text-transform: uppercase;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-fun:active { transform: translateY(4px); box-shadow: none; }
.btn-fun:hover { filter: brightness(1.1); }

.btn-yellow { background-color: #ffd166; color: #5c4500 !important; }
.btn-blue   { background-color: #118ab2; }
.btn-green  { background-color: #06d6a0; }
.btn-purple { background-color: #8338ec; }

/* ===== 7. TABEL GAYA KARTU ===== */
.table-custom {
    border-collapse: separate;
    border-spacing: 0 15px; /* Spasi antar baris */
    width: 100%;
}

.table-custom thead th {
    border: none;
    color: #888;
    font-size: 0.8rem;
    text-transform: uppercase;
    padding: 0 15px;
}

.table-custom tbody tr {
    background: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}

.table-custom tbody tr:hover {
    transform: scale(1.01);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.table-custom tbody td {
    border: none;
    padding: 20px;
    vertical-align: middle;
    border-top: 2px solid #f0f0f0;
    border-bottom: 2px solid #f0f0f0;
}

/* Sudut bulat untuk baris */
.table-custom tbody td:first-child { 
    border-left: 2px solid #f0f0f0; 
    border-radius: 20px 0 0 20px; 
}
.table-custom tbody td:last-child { 
    border-right: 2px solid #f0f0f0; 
    border-radius: 0 20px 20px 0; 
}

/* Dekorasi Ikon di Tabel */
.row-icon {
    width: 50px; height: 50px;
    background: #e0f7fa;
    color: var(--kid-teal);
    border-radius: 15px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    margin-right: 15px;
}

.row-icon-tts {
    background: #fff3e0;
    color: var(--kid-orange);
}

/* ===== DUMMY SPACER ===== */
.page-spacer {
    height: 50vw; /* Agar background bawah terlihat di desktop/mobile */
    width: 100%;
    pointer-events: none;
}

/* Responsive */
@media (max-width: 768px) {
    #main { background-size: 100% auto !important; padding: 15px; }
    .fun-header { width: 100%; }
    .kids-panel { padding: 15px; border-radius: 20px; }
    .nav-pills-custom { width: 100%; justify-content: center; }
    .btn-fun { width: 100%; justify-content: center; margin-bottom: 5px; }
    .page-spacer { height: 100vw; } /* Spacer lebih tinggi di HP */
    .table-responsive { border-radius: 15px; }
}
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-center">
        <div class="fun-header">
            <h1 class="fun-title">
                <i class="ri-team-fill text-warning me-2"></i> Organisasi Belajar
            </h1>
        </div>
    </div>

    <div class="kids-panel">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <a href="<?= base_url($url_name . '/pbl/index/' . $class_id) ?>" class="btn btn-fun btn-yellow">
                <i class="ri-arrow-left-fill"></i> Kembali
            </a>
            
            <a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id); ?>" class="btn btn-fun btn-blue">
                Tahap 3 <i class="ri-arrow-right-circle-fill"></i>
            </a>
        </div>

        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

        <div class="alert alert-light border border-info border-2 rounded-4 text-info d-flex align-items-center mb-4 shadow-sm p-3">
            <i class="ri-lightbulb-flash-fill fs-1 me-3 text-warning"></i>
            <div class="fw-bold lh-sm">
                Pilih salah satu kegiatan di bawah ini: <strong>Kuis</strong> untuk latihan soal, atau <strong>Teka-Teki Silang</strong> untuk bermain kata!
            </div>
        </div>

        <div class="text-center mb-4">
            <ul class="nav nav-pills-custom" id="pblTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab">
                        <i class="ri-question-answer-line me-1"></i> KUIS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tts-tab" data-bs-toggle="tab" data-bs-target="#tts" type="button" role="tab">
                        <i class="ri-grid-fill me-1"></i> TEKA-TEKI SILANG
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pblTabContent">
            
            <div class="tab-pane fade show active" id="quiz" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h5 class="fw-bold text-dark m-0"><i class="ri-pencil-ruler-2-line text-success"></i> Daftar Kuis</h5>
                    
                    <div class="d-flex gap-2">
                        <?php if ($url_name == 'guru'): ?>
                            <button class="btn btn-fun btn-green" id="btnAddQuiz">
                                <i class="ri-add-circle-fill"></i> Buat Kuis
                            </button>
                            <a href="<?= site_url('guru/pbl_kuis/panduan_tahap2'); ?>" class="btn btn-fun btn-purple">
                                <i class="ri-book-read-line"></i> Panduan
                            </a>
                        <?php endif; ?>

                        <?php if ($url_name == 'siswa'): ?>
                            <a href="<?= site_url('siswa/pbl_kuis/panduan_tahap2'); ?>" class="btn btn-fun btn-purple">
                                <i class="ri-book-read-line"></i> Panduan Kuis
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom" id="quizTable">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">No</th>
                                <th>Judul Kuis</th>
                                <th>Keterangan</th>
                                <th class="text-center">Mulai</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tts" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h5 class="fw-bold text-dark m-0"><i class="ri-gamepad-line text-warning"></i> Daftar TTS</h5>
                    
                    <div class="d-flex gap-2">
                        <?php if ($is_admin_or_guru): ?>
                            <button class="btn btn-fun btn-green" id="btnAddTts">
                                <i class="ri-add-circle-fill"></i> Buat TTS
                            </button>
                            <a href="<?= site_url('guru/Tts/panduan_tahap2_tts'); ?>" class="btn btn-fun btn-purple">
                                <i class="ri-book-read-line"></i> Panduan
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($url_name == 'siswa'): ?>
                            <a href="<?= site_url('siswa/pbl_tts/panduan_tahap2_tts'); ?>" class="btn btn-fun btn-purple">
                                <i class="ri-book-read-line"></i> Panduan TTS
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom" id="ttsTable">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">No</th>
                                <th>Judul TTS</th>
                                <th>Grid</th>
                                <th class="text-center">Main</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div> </div> <div class="page-spacer"></div>

</div>

<div class="modal fade" id="quizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="quizModalLabel">📝 Form Kuis Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quizForm" autocomplete="off">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="quizId">
                    <input type="hidden" name="class_id" id="quizClassId" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Kuis</label>
                        <input type="text" name="title" id="quizTitle" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="description" id="quizDescription" class="form-control rounded-3" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ttsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold" id="ttsModalLabel"> Form Teka-Teki Silang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="ttsForm" autocomplete="off">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="ttsId">
                    <input type="hidden" name="class_id" id="ttsClassId" value="<?= $class_id; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul TTS</label>
                        <input type="text" name="title" id="ttsTitle" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ukuran Kotak (Grid)</label>
                        <input type="number" name="grid_data" id="ttsGridData" class="form-control rounded-3" placeholder="Contoh: 10 (Maks 25)">
                        <div class="form-text text-muted small">Masukkan angka 8 sampai 25.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
window.URL_NAME = '<?= $url_name; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/pbl_tahap2.js'); ?>"></script>