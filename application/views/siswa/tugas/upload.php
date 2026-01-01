<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumpulkan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #dfe9f3);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-primary {
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 500;
        }

        .btn-secondary {
            border-radius: 30px;
        }

        .task-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .task-header i {
            font-size: 1.6rem;
            color: #0d6efd;
        }

        .alert {
            border-radius: 0.75rem;
        }

        .file-upload {
            background: #f8f9fa;
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: 0.3s;
        }

        .file-upload:hover {
            background-color: #f1f3f4;
            border-color: #0d6efd;
        }

        footer {
            margin-top: 60px;
            text-align: center;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">

                <!-- Judul dan Deskripsi -->
                <div class="task-header mb-3">
                    <i class="bi bi-journal-text"></i>
                    <h4 class="fw-bold mb-0"><?= htmlspecialchars($tugas->judul) ?></h4>
                </div>
                <p class="text-muted"><?= nl2br(htmlspecialchars($tugas->deskripsi)) ?></p>

                <p>
                    <i class="bi bi-calendar2-week text-primary"></i>
                    <strong>Deadline:</strong>
                    <?= date('d M Y', strtotime($tugas->deadline)) ?>
                </p>

                <hr>

                <!-- Notifikasi -->
                <?php if (isset($success)): ?>
                    <div class="alert alert-success shadow-sm"><i class="bi bi-check-circle me-2"></i><?= $success ?></div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger shadow-sm"><i class="bi bi-x-circle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <!-- Jika sudah upload -->
                <?php if ($pengumpulan): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Anda sudah mengumpulkan tugas ini pada
                        <strong><?= date('d M Y H:i', strtotime($pengumpulan->uploaded_at)) ?></strong>.
                        <br>
                        <a href="<?= base_url('uploads/tugas/' . $pengumpulan->file) ?>" target="_blank" class="btn btn-outline-primary mt-2">
                            <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                        </a>
                    </div>

                    <!-- Jika belum upload -->
                <?php else: ?>
                    <?= form_open_multipart() ?>
                    <div class="file-upload mb-3">
                        <i class="bi bi-cloud-upload display-6 text-primary"></i>
                        <p class="mt-2 mb-1 fw-semibold">Upload File Tugas Anda</p>
                        <p class="text-muted small">Format yang diterima: PDF, DOC, DOCX, JPG, PNG</p>
                        <input type="file" name="file" class="form-control mt-2" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Kirim Tugas
                    </button>
                    <?= form_close() ?>
                <?php endif; ?>

                <a href="<?= base_url('siswa/tugas') ?>" class="btn btn-secondary mt-4">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

            </div>
        </div>

        <footer class="mt-4">
            © <?= date('Y') ?> Sistem E-Learning | Dibuat dengan ❤️ oleh Learner Team
        </footer>
    </div>

</body>

</html>