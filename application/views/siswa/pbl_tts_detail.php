<style>
	/* ... (CSS Grid Container & Cell lama TETAP SAMA) ... */
	#ttsGridContainer {
		display: grid;
		background-color: #333;
		padding: 2px;
		border: 2px solid #333;
		margin: 0 auto;
	}
	.tts-cell {
		position: relative;
		background-color: #222;
		width: 30px;
		height: 30px;
		border: 1px solid #555;
	}
	.tts-cell.active-cell { background-color: #fff; }
	
	.tts-cell input {
		width: 100%; height: 100%; border: none;
		text-align: center; font-weight: bold;
		text-transform: uppercase; font-size: 14px;
		outline: none; background: transparent;
		padding: 0; cursor: text; position: absolute;
		top: 0; left: 0; z-index: 1;
	}
	.tts-cell input:focus { background-color: #e3f2fd; }
	
	.num-label {
		position: absolute; top: 0px; left: 1px;
		font-size: 9px; line-height: 2; color: #333;
		pointer-events: none; z-index: 2; font-family: sans-serif;
	}
	.num-label.down { left: auto; right: 1px; }

	/* --- CSS BARU UNTUK MODE REVIEW --- */
	.tts-cell.cell-correct { background-color: #d4edda !important; } /* Hijau Muda */
	.tts-cell.cell-wrong { background-color: #f8d7da !important; }   /* Merah Muda */
	
	.tts-cell.cell-correct input { color: #155724; }
	.tts-cell.cell-wrong input { color: #721c24; }

	.clue-item {
		cursor: pointer; padding: 8px;
		border-bottom: 1px solid #eee; font-size: 0.9rem;
		display: flex; justify-content: space-between; align-items: center;
	}
	.clue-item:hover { background-color: #f1f3f5; }
	.clue-item.active-clue { background-color: #d1e7ff; font-weight: bold; }

	.emote-icon { font-size: 1.2rem; margin-left: 8px; }
</style>

<div class="container-fluid">
  <div class="pagetitle mb-3">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
            PBL
          </a>
        </li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($tts->title, ENT_QUOTES, 'UTF-8'); ?></li>
      </ol>
    </nav>
  </div>
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
			<p class="text-muted">
				<?= $is_done ? 'Berikut adalah hasil pengerjaan Anda.' : 'Isi teka-teki silang berikut.'; ?>
			</p>
		</div>
		<a href="<?= base_url('siswa/pbl/tahap2/' . $class_id) ?>" class="btn btn-secondary">Kembali</a>
	</div>

	<?php if ($result): ?>
		<div class="alert <?= ($result->score >= 70) ? 'alert-success' : 'alert-warning'; ?> text-center shadow-sm mb-4">
			<h4 class="alert-heading">
				<i class="bi <?= ($result->score >= 70) ? 'bi-emoji-smile-fill' : 'bi-emoji-frown-fill'; ?>"></i> 
				Selesai!
			</h4>
			<h1 class="display-4 fw-bold"><?= $result->score; ?></h1>
			<p class="mb-0">Benar: <?= $result->total_correct; ?> dari <?= $result->total_questions; ?> Soal</p>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-lg-7 mb-4 text-center">
			<div class="card shadow-sm">
				<div class="card-body overflow-auto d-flex justify-content-center">
					<div id="ttsGridContainer"></div>
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="card shadow-sm h-100">
				<div class="card-header bg-primary text-white">
					<h6 class="m-0">Daftar Pertanyaan</h6>
				</div>
				<div class="card-body p-0">
			    <div id="clueContent" style="height: 450px; overflow-y: auto;">
		        <div class="p-3 pb-0">
		            <h6 class="fw-bold text-primary border-bottom pb-2 mb-2 position-sticky top-0 bg-white" style="z-index: 10;">
		                <i class="bi bi-arrow-right-circle"></i> Mendatar
		            </h6>
		            <div class="list-group list-group-flush mb-4" id="listAcross">
		                </div>
		        </div>

		        <div class="p-3 pt-0">
		            <h6 class="fw-bold text-danger border-bottom pb-2 mb-2 position-sticky top-0 bg-white" style="z-index: 10;">
		                <i class="bi bi-arrow-down-circle"></i> Menurun
		            </h6>
		            <div class="list-group list-group-flush" id="listDown">
		                </div>
		        </div>
			    </div>
				</div>
				<?php if (!$is_done): ?>
					<div class="card-footer">
						<button class="btn btn-success w-100" id="btnSubmitTTS">
							<i class="bi bi-send"></i> Kirim Jawaban
						</button>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<form id="ttsSubmissionForm">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
	<input type="hidden" name="tts_id" value="<?= $tts->id; ?>">
</form>

<script>
	window.BASE_URL = "<?= base_url(); ?>";
	window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
	window.TTS_ID = "<?= $tts->id; ?>";
	window.GRID_SIZE = <?= (int)$tts->grid_size; ?>;
	window.IS_DONE = <?= $is_done ? 'true' : 'false'; ?>;
</script>

<script type="module" src="<?= base_url('assets/js/siswa/pbl_tts_detail.js'); ?>"></script>