<div class="container mt-4">
    <h3 class="mb-3"><?= $title ?></h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Judul TTS</th>
                <th>Skor</th>
                <th>Tanggal Dikerjakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rekap_nilai)) : ?>
                <?php $no = 1;
                foreach ($rekap_nilai as $r) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r->nama_siswa ?? '-') ?></td>
                        <td><?= htmlspecialchars($r->judul ?? '-') ?></td>
                        <td><strong><?= $r->skor ?></strong></td>
                        <td><?= date('d-m-Y H:i', strtotime($r->submitted_at)) ?></td>
                        <td>
                            <a href="<?= base_url('guru/tts/nilai/' . $r->tts_id) ?>" class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data nilai siswa.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>