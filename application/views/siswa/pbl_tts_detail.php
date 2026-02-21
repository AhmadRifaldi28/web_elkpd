<?php if ($this->session->userdata('role') == 'Siswa'): ?>
	<style>
		#main { background: url('<?= base_url("assets/img/tema_5.png"); ?>') no-repeat top center !important; }
		/* Sembunyikan Judul Bawaan Template */
		.pagetitle { display: none !important; }

	</style>
<?php endif ?>

<link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

<style>
	.page-spacer {height: 52vw;}

	/* 4. TTS Grid Engine Styling */
	#ttsGridContainer {
		display: grid;
		background-color: #555; /* Bingkai lebih lembut */
		padding: 4px;
		border-radius: 8px;
		box-shadow: 0 10px 25px rgba(0,0,0,0.15);
		margin: 20px auto;
	}

	.tts-cell {
		position: relative;
		background-color: #333; /* Warna dasar sel mati */
		width: 35px; /* Sedikit lebih besar untuk jari anak-anak */
		height: 35px;
		border: 1px solid #444;
		transition: transform 0.2s;
	}

	.tts-cell.active-cell { 
		background-color: #fff; 
		border: 1px solid #ddd;
	}

	.tts-cell input {
		width: 100%; height: 100%; border: none;
		text-align: center; font-weight: 800;
		text-transform: uppercase; font-size: 16px;
		outline: none; background: transparent;
		padding: 0; cursor: text; position: absolute;
		top: 0; left: 0; z-index: 1;
		color: #2D3436;
	}

	.tts-cell input:focus { 
		background-color: #fffde7; /* Kuning cerah saat fokus */
		box-shadow: inset 0 0 5px rgba(255, 191, 0, 0.5);
	}

	.num-label {
		position: absolute; top: 1px; left: 2px;
		font-size: 10px; font-weight: 700; color: #4facfe;
		pointer-events: none; z-index: 2; font-family: 'Fredoka', sans-serif;
	}

	/* Mode Review Styles */
	.tts-cell.cell-correct { background-color: #c8e6c9 !important; border: 1px solid #81c784; }
	.tts-cell.cell-wrong { background-color: #ffcdd2 !important; border: 1px solid #e57373; }
	.tts-cell.cell-correct input { color: #2e7d32; }
	.tts-cell.cell-wrong input { color: #c62828; }

	/* 5. Clue List (Questions) */
	.clue-header {
		font-family: 'Fredoka', sans-serif;
		padding: 15px;
		font-size: 1.1rem;
		border-bottom: none;
	}

	.clue-item {
		cursor: pointer; 
		padding: 12px 15px;
		margin: 5px 10px;
		border-radius: 15px;
		border: 2px solid transparent;
		transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
		background: rgba(255,255,255,0.5);
	}

	.clue-item:hover { 
		background-color: #e3f2fd; 
		transform: translateX(5px);
	}

	.clue-item.active-clue { 
		background-color: #4facfe !important; 
		color: white !important;
		box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
	}

	/* 7. Score Alert */
	.score-badge {
		background: white;
		border-radius: 30px;
		border: 5px solid #ffbf00;
		padding: 10px;
		max-width: 378px
		/*margin-bottom: 25px;*/
	}

	.emote-icon{margin: 0 10px;}

	.display-4 { font-family: 'Fredoka', sans-serif; }

	/* Custom Scrollbar for Clues */
	#clueContent::-webkit-scrollbar { width: 8px; }
	#clueContent::-webkit-scrollbar-track { background: transparent; }
	#clueContent::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }

	@media (max-width: 768px) {
		.page-spacer {height: 29vw;}
	}
</style>

<div class="container-fluid pb-5">
	<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
		<div class="fun-header">
            <h1 class="fun-title">
                <i class="bi bi-dice-3-fill text-dark-blue me-2"></i> <?= $title ?>
            </h1>
		</div>
		
	</div>

	<?php if ($result): ?>
		<div class="score-badge text-center shadow-sm">
			<h4 class="mb-0 text-dark">
				<i class="bi <?= ($result->score >= 70) ? 'bi-stars text-dark-green' : 'bi-emoji-smile-upside-down'; ?>"></i> 
				<?= ($result->score >= 70) ? 'Hebat! Skor Kamu:' : 'Maaf! Skor Kamu:'; ?>
			</h4>
			<div class="display-4 fw-bold text-dark-green"><?= $result->score; ?></div>
			<p class="text-muted mb-0">Kamu berhasil menjawab <?= $result->total_correct; ?> dari <?= $result->total_questions; ?> soal!</p>
		</div>
		<?php else: ?>
			<div class="d-flex justify-content-between">
				<div class="alert alert-info border-0 shadow-sm text-center mb-4" style="border-radius: 20px; background: rgba(227, 242, 253, 0.9);">
					<i class="bi bi-lightbulb-fill text-warning"></i> <?= $is_done ? 'Berikut adalah hasil pengerjaan Anda.' : 'Ayo selesaikan teka-teki silang di bawah ini!'; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-lg-7 mb-4">
				<div class="kids-card kids-panel text-center p-4">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<span class="badge rounded-pill bg-primary px-3 py-2"><i class="bi bi-grid-3x3"></i> Papan Teka-Teki</span>
                        <a href="<?= base_url('siswa/pbl/tahap2/' . $class_id) ?>" class="badge rounded-pill bg-warning text-dark px-3 py-2">
                            <i class="ri-arrow-go-back-line"></i> Kembali
                        </a>
					</div>
					<div class="overflow-auto py-3">
						<div id="ttsGridContainer"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-5">
				<div class="kids-card kids-panel h-100">
					<div class="card-header clue-header bg-primary text-white d-flex align-items-center">
						<i class="bi bi-list-stars me-2 fs-4"></i>
						<h6 class="m-0 fw-bold">Daftar Pertanyaan</h6>
					</div>
					<div class="card-body p-0">
						<div id="clueContent" style="height: 480px; overflow-y: auto;">
							<div class="p-3 pb-0">
								<h6 class="fw-bold text-primary border-bottom p-2 m-2 position-sticky top-0 bg-white" style="z-index: 10;">
									<i class="bi bi-arrow-right-circle-fill fs-5"></i> Mendatar (Across)
								</h6>
								<div class="list-group list-group-flush mb-4" id="listAcross"></div>
							</div>

							<div class="p-3 pt-0">
								<h6 class="fw-bold text-danger border-bottom p-2 m-2 position-sticky top-0 bg-white" style="z-index: 10;">
									<i class="bi bi-arrow-down-circle-fill fs-5"></i> Menurun (Down)
								</h6>
								<div class="list-group list-group-flush" id="listDown"></div>
							</div>
						</div>
					</div>

					<?php if (!$is_done): ?>
						<!-- <div class="card-footer bg-white border-0 p-3"> -->
							<button class="btn btn-fun btn-cyan btn-lg w-100 justify-content-center py-3 fs-5" id="btnSubmitTTS">
								<i class="ri ri-send-plane-fill fs-5"></i> KIRIM JAWABAN
							</button>
						<!-- </div> -->
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="page-spacer"></div>
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