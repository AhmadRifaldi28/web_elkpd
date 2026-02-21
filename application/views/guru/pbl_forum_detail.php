<style>
/* ===== TEMA KONSISTEN PBL ANAK SD ===== */
:root {
    --pbl-blue: #4facfe;
    --pbl-light-blue: #e3f2fd;
    --pbl-orange: #ff9f1c;
    --pbl-green: #52B788;
    --pbl-purple: #8338ec;
    --font-heading: "Fredoka", sans-serif;
    --font-body: "Nunito", sans-serif;
}

/* 1. Layout Dasar & Background */
#main {
    background: url('<?= base_url("assets/img/diskusi.png"); ?>') no-repeat center top !important;
    background-size: 100% auto !important;
    background-attachment: fixed !important;
    min-height: 100vh;
    font-family: var(--font-body);
}

.datatable-input {display: none;  }

/* 2. Panel Konten (Glassmorphism Effect) */
.kids-panel {
    background-color: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    padding: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border: 4px solid #ffffff;
    margin-top: 20px;
}

/* 3. Header Halaman yang Fun */
.fun-header {
    background: #fff;
    border-radius: 50px;
    padding: 10px 30px;
    display: inline-block;
    border-left: 10px solid var(--pbl-blue);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.fun-title {
    font-family: var(--font-heading);
    font-weight: 600;
    color: #012970;
    margin: 0;
    font-size: 1.5rem;
}

/* 4. Tabel / Daftar Diskusi Gaya "Bubble Chat" */
#postsTableContainer {
    padding: 0;
}

#postsTable {
    border-collapse: separate;
    border-spacing: 0 15px; /* Memberi jarak antar baris */
}

#postsTable thead {
    display: table-header-group; /* Tampilkan kembali dengan style baru */
}

#postsTable thead th {
    background-color: var(--pbl-light-blue) !important;
    /*color: white !important;*/
    color: #003366 !important;
    font-family: var(--font-heading);
    border: none !important;
    padding: 15px 20px !important;
    font-size: 18px;
}

/* 6. Modal Gaya "Buku Catatan" */
.modal-content {
    border-radius: 30px;
    border: 6px solid var(--pbl-light-blue);
}

.modal-header {
    background: #0052cc;
    color: white;
    border-radius: 20px 20px 0 0;
    font-family: var(--font-heading);
}

/* Breadcrumb Styling */
.breadcrumb { font-family: var(--font-heading); background: transparent; }
</style>
<link rel="stylesheet" href="<?= base_url('assets/css/pbl.css'); ?>">

<style>
    .page-spacer {height: 20vw;}
</style>

<!-- <main id="main" class="main"> -->
    <div class="container-fluid">

        <div class="kids-panel">

            <div class="alert alert-info border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <i class="bi bi-chat-heart-fill me-2 fs-5"></i>
                Halo Teman-teman! Di sini kamu bisa <span class="fw-bold">bertanya</span> dan <span class="fw-bold">berbagi ide</span>. 
                Klik tombol <span class="badge bg-primary">Tulis Diskusi</span> di bawah ya!
            </div>

            <div class="d-flex flex-wrap gap-3 mb-4">
                <button class="btn btn-fun btn-purple shadow-sm" id="btnAddPost">
                    Tulis Diskusi
                </button>
                <?php if ($is_admin_or_guru): ?>
                    <a href="<?= base_url($url_name . '/pbl_forum/panduan_detail_diskusi_tahap3/' . $class_id); ?>" class="btn btn-fun btn-orange-fun mx-2">
                        <i class="bi bi-book me-1"></i> Panduan Guru
                    </a>
                <?php endif; ?>

                <a href="<?= base_url($url_name . '/pbl/tahap3/' . $topic->class_id) ?>" class="btn btn-fun btn-yellow">
                    <i class="ri-arrow-go-back-line"></i> Kembali
                </a>
            </div>

            <div class="card border-0 bg-transparent">
                <div class="card-body" id="postsTableContainer">
                    <table class="table" id="postsTable">
                        <thead>
                            <tr>
                                <th>Apa yang sedang dibahas?</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="page-spacer"></div>
    </div>
<!-- </main> -->

<div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <form id="postForm" autocomplete="off">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title mb-0" id="postModalLabel">✏️ Tulis Pikiranmu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="postId">
                    <input type="hidden" name="topic_id" value="<?= $topic->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-3">
                        <label for="post_content" class="form-label fw-bold fs-5">Tulis di sini ya:</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="5" 
                                  placeholder="Contoh: Halo teman-teman, saya ingin bertanya tentang..."
                                  style="border-radius: 20px; border: 2px solid var(--pbl-light-blue); padding: 15px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-fun btn-yellow" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-fun btn-cyan px-5">Kirim <i class="ri ri-send-plane-fill fs-5"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
window.BASE_URL = "<?= base_url(); ?>";
window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
window.CURRENT_TOPIC_ID = "<?= $topic->id; ?>";
window.CURRENT_USER_ID = "<?= $this->session->userdata('user_id'); ?>";
window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
window.URL_NAME = '<?= $url_name; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/pbl_forum_detail.js'); ?>"></script>