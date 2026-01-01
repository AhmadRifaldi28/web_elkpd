<div class="container">
    <h3 class="mb-4 text-center mt-5">Forum Diskusi</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Guru</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($forum as $f): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($f->judul); ?></td>
                    <td><?= htmlspecialchars($f->nama_guru); ?></td>
                    <td><?= $f->tanggal; ?></td>
                    <td><a href="<?= base_url('siswa/forum/detail/' . $f->id); ?>" class="btn btn-sm btn-primary">Lihat</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
