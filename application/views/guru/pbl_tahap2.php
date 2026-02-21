<?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <style>
        #main { background: url('<?= base_url("assets/img/tema_2.png"); ?>') no-repeat top center !important; }
        /* Sembunyikan Judul Bawaan Template */
        .pagetitle { display: none !important; }

    </style>
    <?php endif ?>

    <link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

    <style>
        .page-spacer {height: 19vw;}
    </style>

    <div class="container-fluid">

    <?php if ($this->session->userdata('role') == 'Siswa'): ?>
	    <div class="d-flex justify-content-center">
	        <div class="fun-header">
	            <h1 class="fun-title">
	                <i class="ri-palette-fill text-dark-blue me-2"></i> Organisasi Belajar
	            </h1>
	        </div>
	    </div>
		<?php endif ?>

    <div class="kids-panel">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <a href="<?= base_url($url_name . '/pbl/index/' . $class_id) ?>" class="btn btn-fun btn-yellow">
                <i class="ri-arrow-go-back-line"></i> Kembali
            </a>
            
            <a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id); ?>" class="btn btn-fun btn-blue">
                Tahap 3 <i class="ri-team-fill"></i>
            </a>
        </div>

        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

        <div class="alert alert-info border border-info border-2 rounded-4 d-flex align-items-center mb-4 shadow-sm p-3">
            <i class="ri-information-fill fs-3 me-3"></i>
            <div>
                Pilih salah satu kegiatan di bawah ini: <strong>Kuis</strong> untuk latihan soal, atau <strong>Teka-Teki Silang</strong> untuk bermain kata!
            </div>
        </div>

        <div class="text-center mb-4">
            <ul class="nav nav-pills-custom" id="pblTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab">
                        <i class="ri-question-line fs-4 me-1"></i> KUIS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tts-tab" data-bs-toggle="tab" data-bs-target="#tts" type="button" role="tab">
                        <i class="bi bi-dice-3-fill me-1"></i> TEKA-TEKI SILANG
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pblTabContent">
            
            <div class="tab-pane fade show active" id="quiz" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h5 class="text-dark-blue m-0">
                        <i class="ri-question-line fs-4 me-1"></i>
                     Daftar Kuis</h5>
                    
                    <div class="d-flex gap-2">
                        <?php if ($url_name == 'guru'): ?>
                            <button class="btn btn-fun btn-green" id="btnAddQuiz">
                                <i class="ri-add-circle-fill"></i> Buat Kuis
                            </button>
                            <a href="<?= site_url('guru/pbl_kuis/panduan_tahap2'); ?>" class="btn btn-fun btn-cyan">
                                <i class="ri-information-line fs-5"></i> Panduan
                            </a>
                        <?php endif; ?>

                        <?php if ($url_name == 'siswa'): ?>
                            <a href="<?= site_url('siswa/pbl_kuis/panduan_tahap2'); ?>" class="btn btn-fun btn-cyan">
                                <i class="ri-information-line fs-5"></i> Panduan Kuis
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-pbl table-custom" id="quizTable">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">No</th>
                                <th>Nama Kuis</th>
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
                    <h5 class="text-dark-blue m-0"> 
                        <i class="bi bi-dice-3-fill me-1"></i>
                    Daftar TTS</h5>
                    
                    <div class="d-flex gap-2">
                        <?php if ($is_admin_or_guru): ?>
                            <button class="btn btn-fun btn-green" id="btnAddTts">
                                <i class="ri-add-circle-fill"></i> Buat TTS
                            </button>
                            <a href="<?= site_url('guru/Tts/panduan_tahap2_tts'); ?>" class="btn btn-fun btn-cyan">
                                <i class="ri-information-line fs-5"></i> Panduan
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($url_name == 'siswa'): ?>
                            <a href="<?= site_url('siswa/pbl_tts/panduan_tahap2_tts'); ?>" class="btn btn-fun btn-cyan">
                                <i class="ri-information-line fs-5"></i> Panduan TTS
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-pbl table-custom" id="ttsTable">
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

        </div> 
    </div> 
    <div class="page-spacer"></div>

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
                        <label class="form-label fw-bold">Nama Kuis</label>
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