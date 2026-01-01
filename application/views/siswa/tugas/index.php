<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f6fa;
            font-family: "Poppins", sans-serif;
        }

        .container {
            max-width: 900px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-weight: 600;
            color: #2c3e50;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #e9f2ff;
        }

        .btn-primary {
            border-radius: 20px;
            font-size: 14px;
        }

        .header-bar {
            color: black;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #0d6efd;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>

    <div class="container mt-5 mb-5">
        <div class="header-bar text-center">
            <h3 class="mb-0">📘 Daftar Tugas Siswa</h3>
            <p class="mb-0">Lihat dan kumpulkan tugas yang diberikan oleh guru</p>
        </div>

        <div class="card p-4">
            <table class="table align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($tugas as $t): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($t->judul) ?></td>
                            <td><?= htmlspecialchars($t->deskripsi) ?></td>
                            <td><span class="badge bg-danger"><?= htmlspecialchars($t->deadline) ?></span></td>
                            <td>
                                <a href="<?= base_url('siswa/tugas/upload/' . $t->id) ?>" class="btn btn-primary btn-sm">
                                    Kumpulkan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        © <?= date('Y') ?> E-LKPD 2025
    </footer>

</body>

</html>