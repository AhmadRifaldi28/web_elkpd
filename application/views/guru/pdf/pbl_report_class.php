<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        
        /* KOP SURAT */
        .header { 
            text-align: center; 
            border-bottom: 3px double #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        /* INFO KELAS */
        .meta-info { margin-bottom: 20px; }
        .meta-info table { width: 100%; border: none; }
        .meta-info td { padding: 4px 2px; }

        /* JUDUL TABEL */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #0d6efd; /* Warna Biru Utama */
            text-transform: uppercase;
        }

        /* TABEL STYLE */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6; /* Border abu-abu halus */
            padding: 8px;
            vertical-align: middle;
        }
        .table th {
            background-color: #e0efff; /* Header Biru Muda sesuai gambar */
            color: #333;
            text-align: center;
            font-weight: bold;
            text-transform: capitalize;
        }
        
        /* UTILITY */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        
        /* BADGES */
        .badge-score {
            background-color: #0d6efd;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            font-size: 11px;
        }

        .badge-published {
            background-color: #198754;
            color: #fff;
            font-size: 9px;
            padding: 2px 5px;
            border-radius: 3px;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 4px;
        }

        /* PAGE BREAK */
        .page-break { page-break-before: always; }
    </style>
</head>
<body>

    <div class="header">
        <h2><?= isset($school->name) ? $school->name : 'NAMA SEKOLAH'; ?></h2>
        <?php if(!empty($school->address)): ?>
            <p><?= $school->address; ?></p>
        <?php endif; ?>
        <p style="margin-top:8px; font-weight:bold;">LAPORAN HASIL PEMBELAJARAN BERBASIS PROYEK (PBL)</p>
    </div>

    <div class="meta-info">
        <table style="width: 100%;">
            <tr>
                <td width="15%"><strong>Kelas</strong></td>
                <td width="2%">:</td>
                <td width="40%"><?= $class->name; ?> (<?= $class->code; ?>)</td>
                
                <td width="15%"><strong>Guru Pengampu</strong></td>
                <td width="2%">:</td>
                <td><?= $this->session->userdata('name'); ?></td>
            </tr>
            <tr>
                <td><strong>Tahun Ajaran</strong></td>
                <td>:</td>
                <td><?= date('Y'); ?></td> <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?= date('d F Y'); ?></td>
            </tr>
        </table>
    </div>

    <div class="section-title">I. Rekap Nilai Siswa</div>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%" style="text-align: left;">Nama Siswa</th>
                <th width="12%">Quiz (Avg)</th>
                <th width="12%">TTS (Avg)</th>
                <th width="12%">Observasi</th>
                <th width="12%">Esai</th>
                <th width="15%">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($students)): ?>
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data yang dipublikasikan.</td>
                </tr>
            <?php else: ?>
                <?php foreach($students as $i => $s): 
                    $quiz = floatval($s->quiz_score);
                    $tts = floatval($s->tts_score);
                    $obs = floatval($s->obs_score);
                    $essay = floatval($s->essay_score);
                    // Hitung rata-rata
                    $final = ($quiz + $tts + $obs + $essay) / 4;
                ?>
                <tr>
                    <td class="text-center"><?= $i + 1; ?></td>
                    <td><strong><?= $s->student_name; ?></strong></td>
                    <td class="text-center"><?= number_format($quiz, 0); ?></td>
                    <td class="text-center"><?= number_format($tts, 0); ?></td>
                    <td class="text-center"><?= number_format($obs, 0); ?></td>
                    <td class="text-center"><?= number_format($essay, 0); ?></td>
                    <td class="text-center">
                        <span class="badge-score"><?= number_format($final, 2); ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-bottom: 30px;"></div>

    <div class="section-title">II. Refleksi & Umpan Balik</div>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%" style="text-align: left;">Nama Siswa</th>
                <th width="35%" style="text-align: left;">Refleksi Guru</th>
                <th width="35%" style="text-align: left;">Umpan Balik Siswa</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($students)): ?>
                <tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>
            <?php else: ?>
                <?php foreach($students as $i => $s): ?>
                <tr>
                    <td class="text-center" style="vertical-align: top;"><?= $i + 1; ?></td>
                    <td style="vertical-align: top;">
                        <strong><?= $s->student_name; ?></strong><br>
                        <!-- <span class="badge-published">Published</span> -->
                    </td>
                    <td style="vertical-align: top;">
                        <?= !empty($s->teacher_reflection) ? nl2br($s->teacher_reflection) : '<em style="color:#999">-</em>'; ?>
                    </td>
                    <td style="vertical-align: top;">
                        <?= !empty($s->student_feedback) ? nl2br($s->student_feedback) : '<em style="color:#999">-</em>'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; page-break-inside: avoid;">
        <table style="width: 100%; border: none;">
            <tr>
                <td width="60%"></td>
                <td width="40%" class="text-center">
                    <p>Mengetahui,<br>Guru Pengampu</p>
                    <br><br><br><br>
                    <p style="text-decoration: underline; font-weight: bold;">
                        <?= $this->session->userdata('name'); ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>