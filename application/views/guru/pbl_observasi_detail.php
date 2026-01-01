<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#uploadsTable {
    min-width: 720px !important;
}

#uploadsTable thead th {
    background: #e0efff !important;
}

.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
}

.action {
    width: 15%;
}

/* Responsive Styles */
@media (max-width: 1051px) {
    .action {
        width: 22%;
    }
}

@media (max-width: 768px) {
    #uploadsTable thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }
}

@media (max-width: 576px) {
    #uploadsTable td {
        white-space: nowrap;
    }
}
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
                <li class="breadcrumb-item active"><?= htmlspecialchars($slot->description, ENT_QUOTES, 'UTF-8'); ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url('guru/pbl/tahap3/' . $slot->class_id) ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <!-- Info Tugas -->
    <!-- <div class="card shadow-sm mb-4 border-left-primary">
		<div class="card-body">
			<h5 class="card-title text-primary font-weight-bold"><?= htmlspecialchars($slot->title); ?></h5>
			<p class="card-text"><?= nl2br(htmlspecialchars($slot->description)); ?></p>
		</div>
	</div> -->

    <!-- Tabel Upload Siswa + Penilaian -->
    <div class="card shadow-sm h-100">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-file-earmark-arrow-up"></i> Daftar Upload &
                Penilaian</h6>
            <a href="<?= base_url($url_name . '/pbl_observasi/panduan_detail_observasi_tahap3/' . $class_id); ?>"
                class="btn btn-info btn-sm mt-2">
                <i class="bi bi-book me-1"></i> Panduan Detail Observasi
            </a>
        </div>
        <div class="card-body" id="observasiTableContainer">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="uploadsTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Siswa & File</th>
                            <th>File</th>
                            <th>Status Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Penilaian -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="gradeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradeModalLabel">Input Penilaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">

                    <!-- ID Grade (Jika edit) -->
                    <input type="hidden" name="id" id="gradeId">
                    <!-- Slot ID -->
                    <input type="hidden" name="observation_slot_id" value="<?= $slot->id; ?>">
                    <!-- User ID (Diisi via JS) -->
                    <input type="hidden" name="user_id" id="userIdInput">

                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <input type="text" class="form-control" id="studentNameDisplay" readonly disabled>
                    </div>

                    <div class="mb-3">
                        <label for="scoreInput" class="form-label">Nilai (0-100)</label>
                        <input type="number" class="form-control" name="score" id="scoreInput" min="0" max="100"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="feedbackInput" class="form-label">Feedback / Masukan</label>
                        <textarea class="form-control" name="feedback" id="feedbackInput" rows="3"
                            placeholder="Berikan catatan untuk siswa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.SLOT_ID = "<?= $slot->id; ?>";
</script>

<script type="module" src="<?= base_url('assets/js/pbl_observasi_detail.js'); ?>"></script>