<div class="container mt-4">
    <h4>Daftar Kuis TTS</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Ukuran Grid</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tts_list as $t): ?>
                <tr>
                    <td><?= $t->judul ?></td>
                    <td><?= $t->deskripsi ?></td>
                    <td><?= $t->grid_size ?> x <?= $t->grid_size ?></td>
                    <td>
                        <a href="<?= site_url('siswa/Tugas/mulai/' . $t->id) ?>" class="btn btn-primary btn-sm">Mulai</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>