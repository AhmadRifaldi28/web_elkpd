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

    <style>
    body {
        margin: 0;
        min-height: 100vh;
    }

    /* FULL BACKGROUND */
    .login-bg {
        min-height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.6),
                rgba(0, 0, 0, 0.6)),
            url("<?= base_url('assets/img/bg-elearning.jpg'); ?>") center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* CONTENT WRAPPER */
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
        font-size: 1.2rem;
        opacity: 0.9;
    }

    /* LOGIN CARD */
    .login-card {
        max-width: 420px;
        border-radius: 18px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    }

    @media (max-width: 991px) {
        .branding {
            display: none;
        }
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
                                <h4 class="fw-bold">Selamat Datang</h4>
                                <p class="text-muted mb-0">Silakan login untuk melanjutkan</p>
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