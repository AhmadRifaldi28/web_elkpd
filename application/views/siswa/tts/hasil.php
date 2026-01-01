<div class="container mt-4">
    <h3 class="mb-4 text-left"><?= $title; ?></h3>

    <!-- Informasi Umum -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title text-primary mb-3"><?= $tts->judul ?? 'TTS'; ?></h5>

            <?php
            $total_soal = count($questions);
            $skor = $hasil->skor;
            $persentase = ($total_soal > 0) ? round(($skor / $total_soal) * 100, 2) : 0;
            $status = ($persentase >= 70) ? 'LULUS' : 'TIDAK LULUS';
            $badge_status = ($status == 'LULUS') ? 'success' : 'danger';
            ?>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tanggal Dikerjakan:</strong> <?= date('d M Y H:i', strtotime($hasil->submitted_at)); ?></p>
                    <p><strong>Total Soal:</strong> <?= $total_soal; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Skor Benar:</strong>
                        <span class="badge bg-success"><?= $skor; ?> / <?= $total_soal; ?></span>
                    </p>
                    <p><strong>Persentase Nilai:</strong>
                        <span class="badge bg-info text-dark"><?= $persentase; ?>%</span>
                    </p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?= $badge_status; ?>"><?= $status; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Jawaban -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Detail Jawaban Siswa</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor Soal</th>
                            <th>Arah</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban Siswa</th>
                            <th>Jawaban Benar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $no = 1;
                        foreach ($questions as $q):
                            $key = $q->nomor . '_' . $q->arah;
                            $jawaban_siswa = isset($jawaban_siswa[$key]) ? strtoupper(trim($jawaban_siswa[$key])) : '-';
                            $jawaban_benar = strtoupper(trim($q->jawaban));
                            $benar = ($jawaban_siswa === $jawaban_benar);
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $q->nomor; ?></td>
                                <td><?= ucfirst($q->arah); ?></td>
                                <td class="text-start"><?= $q->pertanyaan; ?></td>
                                <td><?= $jawaban_siswa; ?></td>
                                <td><?= $jawaban_benar; ?></td>
                                <td>
                                    <?php if ($benar): ?>
                                        <span class="badge bg-success">Benar</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Salah</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Navigasi -->
    <div class="mt-4 text-center">
        <a href="<?= base_url('siswa/Tugas'); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Tugas
        </a>
    </div>
</div>