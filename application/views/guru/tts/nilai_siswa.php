<div class="container mt-4">
    <h3 class="mb-4 text-center"><?= $title; ?></h3>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Nilai Siswa - <?= $tts->judul; ?></strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Username</th>
                        <th>Skor</th>
                        <th>Persentase</th>
                        <th>Status</th>
                        <th>Tanggal Dikerjakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hasil_siswa)): ?>
                        <?php $no = 1;
                        foreach ($hasil_siswa as $row):
                            $persentase = ($row->skor / count(json_decode($row->jawaban_json, true))) * 100;
                            $status = ($persentase >= 70) ? 'Lulus' : 'Tidak Lulus';
                            $badge = ($status == 'Lulus') ? 'success' : 'danger';
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row->nama_siswa; ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->skor; ?></td>
                                <td><?= round($persentase, 2); ?>%</td>
                                <td><span class="badge bg-<?= $badge; ?>"><?= $status; ?></span></td>
                                <td><?= date('d M Y H:i', strtotime($row->submitted_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Belum ada siswa yang mengerjakan TTS ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="<?= base_url('guru/Tts/nilai'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar TTS
                </a>
            </div>
        </div>
    </div>
</div>