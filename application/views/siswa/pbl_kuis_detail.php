<?php if ($this->session->userdata('role') == 'Siswa'): ?>
    <style>
        #main { background: url('<?= base_url("assets/img/tema_4.png"); ?>') no-repeat top center !important; }
        /* Sembunyikan Judul Bawaan Template */
        .pagetitle { display: none !important; }

    </style>
    <?php endif ?>

    <link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

    <style>
        .page-spacer {height: 16vw;}

        .datatable-input {display: none;  }

        /* Breadcrumb Playful */
.breadcrumb {
    background: var(--white-glass);
    padding: 12px 25px;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    display: inline-flex;
}

.breadcrumb-item a {
    color: var(--pbl-blue);
    text-decoration: none;
    font-weight: 600;
}

/* Card Hasil Pengerjaan (Glassmorphism) */
.result-card {
    background: var(--white-glass);
    border: 4px solid var(--pbl-green);
    border-radius: 30px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.display-3 {
    color: var(--pbl-dark-blue);
    font-weight: 600;
    text-shadow: 3px 3px 0px #fff;
}

/* Tombol Bubble Style */
.btn-bubble {
    border-radius: 20px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    color: white;
}

.btn-bubble-secondary {
    background: var(--pbl-red);
    border-bottom: 5px solid #D65A46;
}

.btn-bubble-primary {
    background: var(--pbl-blue);
    border-bottom: 5px solid #3d84c6;
}

.btn-bubble:hover {
    transform: translateY(3px);
    border-bottom-width: 2px;
    color: white;
}

/* Question Cards yang di-render JS */
.question-card {
    background: var(--white-glass) !important;
    border: none !important;
    border-radius: 25px !important;
    padding: 25px !important;
    margin-bottom: 25px !important;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    backdrop-filter: blur(5px);
}

/* Review States */
.review-correct {
    border: 5px solid var(--pbl-green) !important;
}

.review-wrong {
    border: 5px solid var(--pbl-red) !important;
}

.emote-badge {
    font-size: 3rem;
    position: absolute;
    top: 15px;
    right: 25px;
}

/* Table Cleanup */
#questionsTable thead { display: none; }
.table > :not(caption) > * > * { background: transparent; border: none; }

    </style>

<div class="container-fluid">
    <div class="pagetitle mb-4">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
                        <i class="bi bi-grid-fill"></i> PBL
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    <?= htmlspecialchars($quiz->description, ENT_QUOTES, 'UTF-8'); ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-center">
        <div class="fun-header">
            <h1 class="fun-title">
                <i class="ri-question-line text-warning me-2"></i> <?= $title ?>
            </h1>
        </div>
    </div>

    <div class="kids-panel">

    <div class="mb-4">
        <a href="<?= base_url('siswa/pbl/tahap2/' . $class_id) ?>" class="btn btn-fun btn-yellow">
            <i class="ri-arrow-go-back-line"></i> Kembali
        </a>
    </div>

    <?php if ($result): ?>
    <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center">
            <div class="result-card">
                <div class="mb-3">
                    <span style="font-size: 4.5rem;">🏆</span>
                </div>
                <h4 class="fw-bold mb-1">HASIL PENGERJAAN</h4>
                <h1 class="display-3 mb-3"><?= $result->score; ?></h1>
                
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <span class="badge rounded-pill bg-success p-2 px-4 fs-5">
                        <i class="bi bi-check-circle"></i> Benar: <?= $result->total_correct; ?>
                    </span>
                    <span class="badge rounded-pill bg-secondary p-2 px-4 fs-5">
                        <i class="bi bi-list-ol"></i> Total: <?= $result->total_questions; ?>
                    </span>
                </div>
            </div>
            
            <div class="alert mt-4 shadow-sm" style="background: var(--pbl-yellow); border-radius: 15px; border: none;">
                <i class="bi bi-stars"></i> <b>Yuk, periksa jawabanmu di bawah ini!</b>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <form id="quizSubmissionForm">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">

        <div id="questionsTableContainer">
            <table class="table table-borderless" id="questionsTable">
                <thead>
                    <tr><th>Data</th></tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>

        <?php if (!$result): ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 d-grid">
                <button type="submit" class="btn btn-fun btn-cyan btn-lg py-3" id="btnSubmitQuiz">
                    <i class="ri ri-send-plane-fill fs-5"></i> KIRIM JAWABAN
                </button>
            </div>
        </div>
        <?php endif; ?>
    </form>
    </div>
    <div class="page-spacer"></div>
</div>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.QUIZ_ID = "<?= $quiz->id; ?>";
window.IS_DONE = <?= $is_done ? 'true' : 'false'; ?>;
</script>

<script type="module" src="<?= base_url('assets/js/siswa/pbl_kuis_detail.js'); ?>"></script>