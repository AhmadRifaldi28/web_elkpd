<style>
#postsTable.table> :not(caption)>*>* {
    /* Override Bootstrap: Hapus semua border antar baris */
    padding: 0;
    /* Hapus padding default sel */
    border-bottom-width: 0;
}

#postsTable thead {
    /* Sembunyikan header secara visual tapi biarkan berfungsi */
    display: none;
}

.post-content-cell {
    /* Beri padding di dalam div, bukan di <td> */
    padding: 0.75rem 0.5rem;
}

.post-actions-cell {
    /* Pusatkan tombol aksi secara vertikal */
    vertical-align: middle;
    text-align: right;
    padding-right: 0.5rem;
    width: 100px;
    /* Beri lebar tetap untuk kolom aksi */
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
                <li class="breadcrumb-item active"><?= htmlspecialchars($topic->description, ENT_QUOTES, 'UTF-8'); ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="<?= base_url($url_name . '/pbl/tahap3/' . $topic->class_id) ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="alert alert-info border-0 shadow-sm">
        <i class="bi bi-info-circle-fill me-2"></i>
        Halaman ini menampilkan daftar <span id="info-label" class="fw-bold">diskusi</span>.
        Klik tombol <strong>"Tulis Diskusi"</strong> untuk memulai percakapan.
    </div>

    <div class="mb-3">
        <button class="btn btn-primary" id="btnAddPost">
            <i class="bi bi-plus-circle me-1"></i> Tulis Diskusi
        </button>
        <?php if ($is_admin_or_guru): ?>
        <a href="<?= base_url($url_name . '/pbl_forum/panduan_detail_diskusi_tahap3/' . $class_id); ?>"
            class="btn btn-info btn-sm">
            Panduan Forum Diskusi
        </a>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body" id="postsTableContainer">
            <table class="table" id="postsTable">
                <thead>
                    <tr>
                        <th>Postingan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <form id="postForm" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0" id="postModalLabel">Tulis Balasan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="postId">
                    <input type="hidden" name="topic_id" value="<?= $topic->id; ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-3">
                        <label for="post_content" class="form-label">Isi Postingan</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="5"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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