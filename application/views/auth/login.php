<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
    <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">
    <title>Masuk | Dunia Belajar E-LKPD</title>
    <!-- Favicons -->
    <link href="<?= base_url('assets/img/favicon.png'); ?>" rel="icon">
    <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

    <link rel="stylesheet" href="<?= base_url('assets/css/font.css'); ?>">

    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/remixicon/remixicon.css') ?>">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet"> -->

    <style>
        :root {
            --primary-dark: #2C5F8A; /* Biru lebih gelap untuk kontras teks */
            --sky-blue: #70C1FF;
            --accent-orange: #c15819; /* Orange lebih gelap agar teks putih kontras */
            --soft-white: rgba(255, 255, 255, 0.92);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Fredoka', sans-serif;
            color: #333;
            font-size: 1.15rem;
        }

        .login-bg {
            min-height: 100vh;
            background: url('<?= base_url("assets/img/Bg-learning.png"); ?>') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            /*padding: 20px;*/
        }

        .login-card {
            background: var(--soft-white);
            backdrop-filter: blur(8px);
            border-radius: 40px;
            border: 5px solid var(--sky-blue);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            max-width: 450px;
        }

        .login-title {
            color: var(--accent-orange);
            font-weight: 700;
        }

        /* PERBAIKAN KONTRAS TEKS */
        .text-high-contrast {
            color: #444 !important; /* Abu-abu sangat gelap */
            font-weight: 500;
        }

        .form-label {
            color: var(--primary-dark);
            font-weight: 600;
            margin-left: 5px;
        }

        /* INPUT STYLING */
        .input-group-text {
            background-color: var(--sky-blue);
            color: #000; /* Ikon lebih gelap agar terlihat */
            border: 2px solid var(--sky-blue);
            border-radius: 20px 0 0 20px !important;
        }

        .form-control {
            border: 2px solid var(--sky-blue);
            border-radius: 0 20px 20px 0 !important;
            padding: 12px;
            color: #000; /* Teks input hitam pekat */
            font-weight: 600;
            font-size: 1.126rem;
        }

        /* KHUSUS INPUT PASSWORD */
        .password-toggle {
            cursor: pointer;
            background: #fff;
            border: 2px solid var(--sky-blue);
            border-left: none;
            border-radius: 0 20px 20px 0 !important;
            color: var(--primary-dark);
            padding: 0 15px;
            display: flex;
            align-items: center;
        }
        
        #password {
            border-right: none !important;
            border-radius: 0 !important;
        }

        /* TOMBOL BUBBLY */
        .btn-masuk {
            background: var(--accent-orange);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 15px;
            font-size: 1.3rem;
            letter-spacing: 1px;
            box-shadow: 0 6px 0 #A04A15;
            transition: all 0.1s;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .btn-masuk:hover {
            background: #FF7B2D;
            color: white;
            transform: translateY(2px);
            box-shadow: 0 4px 0 #A04A15;
        }

        .btn-masuk:active {
            transform: translateY(6px);
            box-shadow: 0 0 0 #A04A15;
        }

        .link-daftar {
            color: var(--primary-dark);
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-bg">
        <div class="container d-flex justify-content-center">
            
            <div class="card login-card border-0 w-100 shadow-lg">
                <div class="card-body p-4 p-md-4">

                    <div class="text-center mb-0">
                        <img src="<?= base_url('assets/img/logo.png') ?>" width="85" class="mb-0">
                        <h2 class="login-title">Halo, Teman! 👋</h2>
                        <p class="text-high-contrast">Ayo masuk untuk mulai petualangan belajar!</p>
                    </div>

                    <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger d-flex align-items-center m-0 p-2">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                            <?php endif; ?>

                    <?= form_open('auth'); ?>

                    <div class="mb-4">
                        <label class="form-label">E-mail atau Username</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-pencil-fill fs-4"></i>
                            </span>
                            <input type="text" name="username" class="form-control" placeholder="emailmu di sini..." required>
                        </div>
                        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kata Sandi (Password)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-shield-user-fill fs-4"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Sandi rahasia..." required>
                            <span class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye-slash-fill" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-masuk w-100 fw-bold">
                        AYO MASUK! <i class="ri ri-send-plane-fill"></i>
                    </button>

                    <?= form_close(); ?>

                    <div class="text-center mt-4">
                        <p class="text-high-contrast mb-0">
                            Belum punya akun? 
                            <a href="<?= site_url('auth/register'); ?>" class="fw-bold link-daftar">Daftar di sini ya!</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle ikon
            if (type === 'text') {
                eyeIcon.classList.remove('bi-eye-slash-fill');
                eyeIcon.classList.add('bi-eye-fill');
            } else {
                eyeIcon.classList.remove('bi-eye-fill');
                eyeIcon.classList.add('bi-eye-slash-fill');
            }
        });
    </script>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>