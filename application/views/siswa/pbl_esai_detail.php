<style>
/* ===== UI/UX ENHANCEMENTS ===== */

/* 1. Hero Card (Header Judul) */
.hero-card {
    background: linear-gradient(45deg, #4154f1, #2132bd) !important;
    color: white !important;
    border: none !important;
    border-radius: 10px !important;
    position: relative !important;
    overflow: hidden !important;
    box-shadow: 0 5px 15px rgba(65, 84, 241, 0.3) !important;
}

.hero-content {
    position: relative;
    z-index: 2;
}

/* Dekorasi Ikon Background */
.hero-icon-bg {
    position: absolute !important;
    right: -20px !important;
    bottom: -30px !important;
    font-size: 10rem !important;
    color: rgba(255, 255, 255, 0.1) !important;
    transform: rotate(-15deg) !important;
    pointer-events: none !important;
}

/* 2. Step Indicator (Progress Visual) */
.step-indicator {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    position: relative;
}
.step-item {
    text-align: center;
    position: relative;
    z-index: 1;
    flex: 1;
}
.step-circle {
    width: 35px;
    height: 35px;
    background-color: #e0e5ee;
    color: #012970;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px auto;
    font-weight: bold;
    transition: all 0.3s;
}
.step-item.active .step-circle {
    background-color: #4154f1;
    color: white;
    box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.2);
}
.step-item.done .step-circle {
    background-color: #198754;
    color: white;
}
.step-label {
    font-size: 12px;
    font-weight: 600;
    color: #6c757d;
}
/* Garis penghubung steps */
.step-line {
    position: absolute;
    top: 17px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #e0e5ee;
    z-index: 0;
}

/* 3. Helper Components */
.instruction-list li {
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: #555;
    padding-left: 5px;
}
.instruction-icon {
    color: #4154f1;
    margin-right: 8px;
    font-weight: bold;
}

/* Table Styling */
#questionTable thead th {
    background-color: #f6f9ff !important;
    color: #012970 !important;
    border-bottom: 2px solid #dee2e6 !important;
}
#questionTable tbody td {
    vertical-align: top !important;
    padding: 15px !important;
}
.question-badge {
    background-color: #e6f0ff;
    color: #012970;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    font-size: 0.85rem;
}

/* Custom Utilities */
.text-justify {
    text-align: justify;
}
</style>

<div class="container-fluid">
    
    <div class="pagetitle mb-3">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url('siswa/dashboard/class_detail/' . $class_id) ?>">PBL</a>
                </li>
                <li class="breadcrumb-item active">Tahap 4 (Esai)</li>
            </ol>
        </nav>
    </div>

    <div class="card hero-card mb-4">
        <div class="card-body p-4 hero-content">
            <div class="d-flex justify-content-between align-items-start">
                <div class="col-md-9">
                    <a href="<?= base_url('siswa/pbl/tahap4/' . $class_id); ?>" class="btn btn-sm btn-light mb-2 rounded-pill px-3">
                        <i class="ri-arrow-go-back-line"></i> Kembali
                    </a>
                    <h2 class="fw-bold mb-2"><?= html_escape($essay->title); ?></h2>
                    <p class="mb-0 opacity-75" style="max-width: 700px; line-height: 1.6;">
                        <?= html_escape($essay->description); ?>
                    </p>
                </div>
            </div>
        </div>
        <i class="bi bi-journal-richtext hero-icon-bg"></i>
    </div>

    <input type="hidden" id="currentEssayId" value="<?= $essay->id; ?>">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

    <?php 
        $step1 = 'done'; // Baca Soal (Asumsi selalu done jika sudah masuk halaman ini)
        $step2 = $submission ? 'done' : 'active'; // Kerjakan
        $step3 = ($submission && $submission->grade !== null) ? 'done' : ($submission ? 'active' : ''); // Dinilai
    ?>
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="step-indicator">
                <div class="step-line"></div>
                <div class="step-item <?= $step1; ?>">
                    <div class="step-circle"><i class="bi bi-book"></i></div>
                    <div class="step-label">Pahami Soal</div>
                </div>
                <div class="step-item <?= $step2; ?>">
                    <div class="step-circle"><i class="bi bi-pencil"></i></div>
                    <div class="step-label">Kerjakan Esai</div>
                </div>
                <div class="step-item <?= $step3; ?>">
                    <div class="step-circle"><i class="bi bi-award"></i></div>
                    <div class="step-label">Hasil & Nilai</div>
                </div>
            </div>
        </div>
    </div>

  <div class="row">
        <div class="col-lg-7 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white py-3 border-bottom">
          <h5 class="card-title mb-0 text-primary fw-bold">
                        <i class="bi bi-list-task me-2"></i>Daftar Pertanyaan
                    </h5>
        </div>
        <div class="card-body pt-3" id="questionTableContainer">
          <div class="table-responsive">
            <table class="table table-hover" id="questionTable">
              <thead>
                <tr>
                  <th class="text-center" width="10%">No</th>
                  <th>Butir Pertanyaan</th>
                </tr>
              </thead>
              <tbody>
                                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Lembar Kerja Siswa
                    </h5>
        </div>
        <div class="card-body pt-4">
                    <div class="mb-4">
            <?php if ($submission): ?>
              <div class="alert alert-success d-flex align-items-center shadow-sm border-0" role="alert">
                <i class="ri-check-line fs-4 me-3"></i>
                <div>
                                    <strong>Sudah Dikumpulkan!</strong><br>
                                    <small class="text-muted">Pada: <?= date('d M Y, H:i', strtotime($submission->created_at)); ?></small>
                                </div>
              </div>
                        <?php else: ?>
                            <div class="alert alert-warning d-flex align-items-center shadow-sm border-0" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                                <div>
                                    <strong>Belum Mengerjakan</strong><br>
                                    <small class="text-muted">Silakan jawab pertanyaan di samping.</small>
                                </div>
                            </div>
            <?php endif; ?>
          </div>

                    <?php if ($submission && $submission->grade !== null): ?>
                        <div class="text-center p-3 mb-4 rounded bg-light border border-dashed">
                            <h6 class="text-uppercase text-muted small fw-bold">Nilai Akhir</h6>
                            <h1 class="display-3 fw-bold text-primary mb-0"><?= $submission->grade; ?></h1>
                            <?php if ($submission->feedback): ?>
                                <hr class="my-2">
                                <p class="small text-muted fst-italic mb-0">"<?= html_escape($submission->feedback); ?>"</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2">
            <?php 
            $is_graded = ($submission && $submission->grade !== null);
            $btn_text = $submission ? 'Edit Jawaban Saya' : 'Mulai Kerjakan Esai';
            $btn_cls = $submission ? 'btn-outline-primary' : 'btn-primary btn-lg shadow';
                        $icon = $submission ? 'bi-pencil' : 'bi-play-fill';
            
            $sub_id = $submission ? $submission->id : '';
            $sub_content = $submission ? html_escape($submission->submission_content) : '';
            ?>

            <?php if (!$is_graded): ?>
              <button class="btn <?= $btn_cls; ?> py-3 fw-bold" id="btnOpenAnswerModal"
                data-id="<?= $sub_id; ?>"
                data-content="<?= $sub_content; ?>">
                <i class="bi <?= $icon; ?> me-1"></i> <?= $btn_text; ?>
              </button>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>
                                <i class="bi bi-lock-fill"></i> Terkunci
                            </button>
              <button class="btn btn-bd-primary text-white fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#readOnlyModal">
                <i class="bi bi-eye-fill me-1"></i> Lihat Jawaban Saya
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>

            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Tips Mengerjakan</h6>
                    <ul class="list-unstyled instruction-list mb-0">
                        <li><i class="bi bi-check2 instruction-icon"></i> Baca setiap soal dengan teliti sebelum menjawab.</li>
                        <li><i class="bi bi-check2 instruction-icon"></i> Gunakan format nomor (1, 2, dst) agar jawaban rapi.</li>
                        <li><i class="bi bi-check2 instruction-icon"></i> Periksa kembali ejaan sebelum menekan tombol kirim.</li>
                        <li><i class="bi bi-check2 instruction-icon"></i> Jawaban dapat diedit selama belum dinilai oleh guru.</li>
                    </ul>
                </div>
            </div>

    </div>
  </div>

    <div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg">
        <form id="answerForm">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="answerModalLabel"><i class="bi bi-pencil-fill me-2"></i>Form Jawaban</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <input type="hidden" name="essay_id" value="<?= $essay->id; ?>">
            <input type="hidden" name="submission_id" id="submissionId">
            
                        <div class="d-flex align-items-start bg-light p-3 rounded border mb-3">
                            <i class="bi bi-info-circle-fill text-primary me-2 fs-5"></i>
                            <small class="text-muted">
                                <strong>Petunjuk:</strong> Jawablah pertanyaan secara berurutan. Gunakan nomor soal (misal: 1., 2.) untuk memisahkan jawaban agar mudah dikoreksi oleh guru.
                            </small>
                        </div>

            <div class="mb-3">
              <label for="submissionContent" class="form-label fw-bold text-dark">Jawaban Anda:</label>
              <textarea name="submission_content" id="submissionContent" class="form-control font-monospace" rows="12" placeholder="1. Jawaban soal pertama...&#10;2. Jawaban soal kedua..." required style="line-height: 1.6;"></textarea>
            </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-send-fill me-1"></i> Kirim Jawaban</button>
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

    <script>
        window.BASE_URL = "<?= base_url(); ?>";
        window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
        window.CURRENT_ESSAY_ID = "<?= $essay->id; ?>";
    </script>
    <script type="module" src="<?= base_url('assets/js/pbl_esai_detail_siswa.js'); ?>"></script>
</div>