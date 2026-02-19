<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Nunito:wght@400;700&family=Quicksand:wght@500;700&display=swap" rel="stylesheet">


<style>
    #main {
        background: url('<?= base_url("assets/img/esai.png"); ?>') no-repeat center top !important;
    }
    
    .esai-panel {
    background-color: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 30px; /* TARGET: Rounded corners lebih besar */
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border: 4px solid rgba(255,255,255,0.9);
    /*margin-top: 20px;*/
    margin: 0;
    padding: 0;
    position: relative;
    z-index: 2;
}

/* UI Komponen Baru */
.icon-box-small {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.icon-box-large {
    width: 70px;
    height: 70px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
}

/* Grade Display (Efek Skor Game) */
.grade-badge-container {
    background: white;
    padding: 20px;
    border-radius: 25px;
    border: 3px solid var(--pbl-blue);
    display: inline-block;
    min-width: 180px;
    position: relative;
}

.grade-label {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--pbl-blue);
    color: white;
    padding: 2px 15px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: bold;
    font-family: var(--font-heading);
}

.grade-score {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--pbl-dark-blue);
    font-family: var(--font-heading);
    line-height: 1;
}

.feedback-bubble {
    font-family: 'Nunito';
    font-size: 0.95rem;
    font-style: italic;
    color: #666;
    background: #fdf2e9;
    padding: 10px 15px;
    border-radius: 15px;
    border-left: 5px solid var(--pbl-orange);
}
/* ===== STEP INDICATOR (MAP PETUALANGAN) ===== */

/* Container Utama */
.step-indicator {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    padding: 20px 0;
    /*margin-bottom: 20px;*/
}

/* Garis Jalur Penghubung */
.step-line {
    position: absolute;
    top: 45px; /* Menyesuaikan posisi tengah lingkaran */
    left: 10%;
    right: 10%;
    height: 6px;
    background: #e0e5ee; /* Warna dasar jalur */
    z-index: 1;
    border-radius: 10px;
}

/* Item Per Langkah */
.step-item {
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: all 0.3s ease;
}

/* Lingkaran Ikon */
.step-circle {
    width: 50px;
    height: 50px;
    background-color: white;
    border: 4px solid #e0e5ee;
    color: #cbd5e0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    /*margin-bottom: 12px;*/
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Label Teks di Bawah */
.step-label {
    font-family: 'Fredoka', cursive; /* Font bulat untuk anak-anak */
    font-size: 1rem;
    font-weight: 600;
    color: #a0aec0;
}

/* --- STATE: ACTIVE (Sedang Dikerjakan) --- */
.step-item.active .step-circle {
    background-color: #fff;
    border-color: var(--pbl-blue);
    color: var(--pbl-blue);
    transform: scale(1.15);
    box-shadow: 0 0 20px rgba(79, 172, 254, 0.3);
}

.step-item.active .step-label {
    color: var(--pbl-dark-blue);
}

/* --- STATE: DONE (Selesai) --- */
.step-item.done .step-circle {
    background-color: var(--pbl-green);
    border-color: #e0f9f0;
    color: white;
}

.step-item.done .step-label {
    color: var(--pbl-green);
}

/* Animasi untuk step yang sedang aktif */
.step-item.active .step-circle i {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
    40% {transform: translateY(-5px);}
    60% {transform: translateY(-3px);}
}

/* Table Customization for Essay Questions */
#questionTable tbody td {
    padding: 20px !important;
}

#questionTable tbody td:first-child {
    background: #f0f4f8;
    color: var(--pbl-blue);
    font-weight: 800;
}
</style>

<link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

<style>
    .page-spacer {height: 16vw;}
</style>

    <?php 
        $step1 = 'done'; 
        $step2 = $submission ? 'done' : 'active'; 
        $step3 = ($submission && $submission->grade !== null) ? 'done' : ($submission ? 'active' : ''); 
    ?>
<!-- <main id="main" class="main" style=""> -->
<div class="container-fluid">

    <div class="fun-header mb-4 w-100">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <a href="<?= base_url('siswa/pbl/tahap4/' . $class_id); ?>" class="btn-fun btn-yellow mb-3">
                    <i class="ri-arrow-left-circle-line"></i> Kembali
                </a>
                <h2 class="fun-title d-block"><?= html_escape($essay->title); ?></h2>
                <p class="text-muted mb-0 mt-2" style="font-family: 'Nunito'; font-size: 1.1rem; max-width: 800px;">
                    <i class="bi bi-stars text-warning"></i> <?= html_escape($essay->description); ?>
                </p>
            </div>
            <div class="d-none d-md-block">
                <i class="bi bi-journal-check text-primary opacity-25" style="font-size: 5rem;"></i>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="step-indicator">
                    <div class="step-line"></div>
                    <div class="step-item <?= $step1; ?>">
                        <div class="step-circle"><i class="bi bi-search"></i></div>
                        <div class="step-label">1. Baca Soal</div>
                    </div>
                    <div class="step-item <?= $step2; ?>">
                        <div class="step-circle"><i class="bi bi-pencil-fill"></i></div>
                        <div class="step-label">2. Tulis Jawaban</div>
                    </div>
                    <div class="step-item <?= $step3; ?>">
                        <div class="step-circle"><i class="bi bi-stars"></i></div>
                        <div class="step-label">3. Lihat Nilai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="currentEssayId" value="<?= $essay->id; ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

    <!-- <div class="esai-panel"> -->
        
    </div>
    <div class="kids-panel shadow-lg mb-5">
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card border-0" style="background: transparent;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box-small bg-primary me-3"><i class="bi bi-chat-left-dots-fill text-white"></i></div>
                        <h4 class="fun-title mb-0" style="font-size: 1.4rem;">Tantangan Pertanyaan</h4>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table-pbl" id="questionTable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="15%">No</th>
                                    <th>Apa yang harus dijawab?</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card border-0 rounded-4 h-100" style="background: #f8faff; border: 3px dashed #cbd5e0 !important;">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box-large mb-3 mx-auto">
                            <i class="bi bi-pencil-square text-success"></i>
                        </div>
                        <h4 class="fun-title mb-3" style="font-size: 1.3rem;">Lembar Jawabanmu</h4>

                        <?php if ($submission): ?>
                            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                                <h6 class="fw-bold mb-1"><i class="bi bi-check-circle-fill"></i> Hebat! Kamu sudah kirim.</h6>
                                <small>Dikirim pada: <?= date('d M Y, H:i', strtotime($submission->created_at)); ?></small>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4 text-start">
                                <h6 class="fw-bold mb-1">Ayo Mulai!</h6>
                                <small>Klik tombol di bawah untuk menulis jawabanmu ya.</small>
                            </div>
                        <?php endif; ?>

                        <?php if ($submission && $submission->grade !== null): ?>
                            <div class="grade-badge-container mb-4">
                                <span class="grade-label">NILAI KAMU</span>
                                <div class="grade-score"><?= $submission->grade; ?></div>
                                <?php if ($submission->feedback): ?>
                                    <div class="feedback-bubble mt-3">
                                        <i class="bi bi-chat-quote-fill me-2"></i> "<?= html_escape($submission->feedback); ?>"
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-3">
                            <?php 
                            $is_graded = ($submission && $submission->grade !== null);
                            $btn_text = $submission ? 'Ubah Jawaban' : 'Mulai Menulis Esai';
                            $btn_color = $submission ? 'btn-cyan' : 'btn-blue';
                            ?>

                            <?php if (!$is_graded): ?>
                                <button class="btn-fun <?= $btn_color; ?> py-3 w-100" id="btnOpenAnswerModal"
                                    data-id="<?= $submission ? $submission->id : ''; ?>"
                                    data-content="<?= $submission ? html_escape($submission->submission_content) : ''; ?>">
                                    <i class="bi bi-stars me-2"></i> <?= $btn_text; ?>
                                </button>
                            <?php else: ?>
                                <button class="btn-fun btn-secondary w-100" disabled style="opacity: 0.7;">
                                    <i class="bi bi-lock-fill"></i> Jawaban Terkunci
                                </button>
                                <button class="btn btn-bd-primary text-white fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#readOnlyModal">
                <i class="bi bi-eye-fill me-1"></i> Lihat hasil Kerja 
              </button>
                            <?php endif; ?>
                        </div>

                        <div class="text-start mt-4 bg-white p-3 rounded-4 shadow-sm">
                            <p class="mb-2 fw-bold text-dark" style="font-family: 'Fredoka'; font-size: 0.95rem;">
                                <i class="bi bi-lightbulb text-warning me-1"></i> Tips Pintar:
                            </p>
                            <ul class="list-unstyled small mb-0 text-muted" style="line-height: 1.4;">
                                <li class="mb-2"><i class="bi bi-check2-circle text-success me-1"></i> Pakai nomor (1, 2) biar rapi.</li>
                                <li><i class="bi bi-check2-circle text-success me-1"></i> Cek lagi sebelum kirim ya!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; overflow: hidden;">
                <form id="answerForm">
                    <div class="modal-header border-0 bg-primary text-white p-4">
                        <h5 class="modal-title fun-title text-white" style="font-size: 1.5rem;">
                            <i class="bi bi-pencil-fill me-2"></i> Lembar Jawaban Pintar
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <input type="hidden" name="essay_id" value="<?= $essay->id; ?>">
                        <input type="hidden" name="submission_id" id="submissionId">
                        <div class="alert alert-warning rounded-4 border-0 mb-3 small">
                            <strong><i class="bi bi-info-circle"></i> Cara Menjawab:</strong> Tulis jawabanmu satu per satu sesuai nomor soal di samping ya!
                        </div>
                        <textarea name="submission_content" id="submissionContent" 
                            class="form-control" rows="12" 
                            placeholder="1. Jawaban soal pertama...&#10;2. Jawaban soal kedua..."
                            style="border-radius: 20px; padding: 20px; font-size: 1.1rem; font-family: 'Nunito'; border: 3px solid #dee2e6;"></textarea>
                    </div>
                    <div class="modal-footer border-0 bg-light p-4">
                        <button type="button" class="btn-fun btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-fun btn-blue px-5 shadow">
                            Kirim Sekarang <i class="bi bi-send-check-fill ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if($submission): ?>
    <div class="modal fade" id="readOnlyModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Jawaban Saya</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="p-3 bg-light border rounded">
              <?= nl2br(html_escape($submission->submission_content)); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

    <div class="page-spacer"></div>

</div>
<!-- </main> -->
    <script>
        window.BASE_URL = "<?= base_url(); ?>";
        window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
        window.CURRENT_ESSAY_ID = "<?= $essay->id; ?>";
    </script>
    <script type="module" src="<?= base_url('assets/js/pbl_esai_detail_siswa.js'); ?>"></script>