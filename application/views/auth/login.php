<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
    <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">
    <title>Login | E-LKPD</title>

    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    /* FULL BACKGROUND (TETAP SEPERTI SEBELUMNYA) */
    .login-bg {
        min-height: 100vh;
<<<<<<< HEAD
        background: linear-gradient(rgba(0, 0, 0, 0.6),
                rgba(0, 0, 0, 0.6)),
            url("<?= base_url('assets/img/tema_3.png'); ?>") center/cover no-repeat;
=======
        position: relative;
        background: url('<?= base_url('assets/img/Bg-learning.png'); ?>') center/cover no-repeat;
>>>>>>> d7fa5c795b6dea33230aca4f8545b629e685f4b5
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* CONTENT */
    .login-container {
        width: 100%;
        max-width: 1200px;
        padding: 40px;
    }

    /* BRANDING */
    .branding {
        color: #fff;
    }

    .branding h1 {
        font-size: 3.5rem;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .branding p {
        font-size: 1.15rem;
        opacity: 0.95;
    }

    /* LOGIN CARD (DIBUAT LEBIH LUCU) */
    .login-card {
        max-width: 420px;
        border-radius: 28px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.34);
        background: #ffffff35;
        border: 4px solid #8295ffff;
    }

    /* HEADER */
    .login-card h4 {
        color: #005effff;
    }

    /* INPUT */
    .form-control {
        border-radius: 18px;
        padding: 11px 14px;
    }

    .input-group-text {
        background: #82b6ffff;
        border: none;
        border-radius: 18px 0 0 18px;
    }

    /* BUTTON */
    .btn-primary {
        background-color: #003cffff;
        border: none;
        border-radius: 22px;
        padding: 12px;
        font-size: 1.05rem;
    }

    .btn-primary:hover {
        background-color: #003cffff;
    }

    /* ALERT */
    .alert {
        border-radius: 18px;
    }

    /* LINK */
    a {
        color: #0066ffff;
    }

    a:hover {
        color: #0045f5ff;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .branding {
            display: none;
        }
    }

    /* ANIMASI MASUK CARD */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card {
        animation: fadeUp 0.8s ease;
    }

    /* ANIMASI JUDUL */
    @keyframes wave {

        0%,
        100% {
            transform: rotate(0);
        }

        25% {
            transform: rotate(3deg);
        }

        75% {
            transform: rotate(-3deg);
        }
    }

    .login-title span {
        display: inline-block;
        animation: wave 1.5s infinite ease-in-out;
    }

    /* INPUT FOCUS LUCU */
    .form-control:focus {
        border-color: #0004ffff;
        box-shadow: 0 0 0 0.2rem rgba(7, 36, 255, 0.25);
    }

    /* BUTTON POP */
    .btn-primary {
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 8px 18px rgba(0, 13, 255, 0.4);
    }

    /* ICON GOYANG */
    .input-group-text i {
        transition: transform 0.3s ease;
    }

    .input-group:hover i {
        transform: rotate(-10deg) scale(1.1);
    }
    </style>
</head>

<body>

    <div class="login-bg">
        <div class="login-container">
            <div class="row align-items-center">

                <!-- LEFT BRANDING -->
                <div class="col-lg-7 branding">
                    <h1>E-LKPD</h1>
                    <p class="mt-2">(E-Lembar Kerja Peserta Didik)</p>
                    <p class="mt-4">
                        Media pembelajaran digital untuk mendukung proses belajar yang
                        interaktif, efektif, dan terstruktur.
                    </p>
                </div>

                <!-- RIGHT LOGIN FORM -->
                <div class="col-lg-5 d-flex justify-content-end">
                    <div class="card login-card border-0 w-100">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-4">
                                <img src="<?= base_url('assets/img/logo.png') ?>" width="90" class="mb-3">
                                <h4 class="fw-bold login-title">
                                    Halo, Teman <span>👋</span>
                                </h4>

                                <p class="text-muted mb-0">Ayo masuk dan belajar bersama 📚✨</p>
                            </div>

                            <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                            <?php endif; ?>

                            <?= form_open('auth'); ?>

                            <div class="mb-3">
                                <label class="form-label">Username atau Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold mt-2">
                                Masuk
                            </button>

                            <?= form_close(); ?>

                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    Belum punya akun?
                                    <a href="<?= site_url('auth/register'); ?>" class="fw-bold text-decoration-none">
                                        Daftar sekarang
                                    </a>
                                </small>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>