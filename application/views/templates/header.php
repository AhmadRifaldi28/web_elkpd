<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
  <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">
  
  <title><?= isset($title) ? $title : 'E-LKPD'; ?></title>

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/favicon.png'); ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/remixicon/remixicon.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/simple-datatables/style.css'); ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">

  <style>

  :root {
    scroll-behavior: smooth;
    /* Warna utama (Violet) */
    --bd-violet-bg: #712cf9; 
    --bd-violet-rgb: 113, 44, 249;
    
    /* Warna Accent */
    --bd-accent: #ffe484;
    --bd-accent-rgb: 255, 228, 132;
    
    /* Warna text dark */
    --bd-dark: #212529; 

    /* High Contrast Blue Gradient (> Ratio 9:1 with white text) */
    --bg-header-gradient: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%); 
    /* Alternatif Deep Blue yang lebih "hidup" tapi tetap high contrast */
    --bg-deep-blue: linear-gradient(45deg, #003366, #004080);
  }

  /* ===== 2. GLOBAL OVERRIDES FOR HEADER & SIDEBAR ===== */
  
  /* Background Header Custom */
  .bg-primary-app {
    background: var(--bg-deep-blue) !important;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  /* Override Sidebar agar match dengan header (jika file sidebar terpisah) */
  .sidebar {
    background: var(--bg-deep-blue) !important;
    box-shadow: 2px 0 20px rgba(0,0,0,0.05);
  }

    /* ===== 3. HEADER COMPONENTS ===== */

  /* Logo */
  .header .logo span {
    color: #fff !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    letter-spacing: 1px;
  }

  .header .toggle-sidebar-btn {
    color: #fff !important;
  }

  /* Search Bar Glassmorphism */
  .search-bar .search-form input {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    border-radius: 20px;
    padding: 8px 15px 8px 35px;
    transition: 0.3s;
  }
  /*.search-bar .search-form input:focus {
    background: rgba(255, 255, 255, 0.2);
    border-color: var(--bd-accent);
    box-shadow: 0 0 0 4px rgba(255, 228, 132, 0.1);
    width: 250px;
  }*/
  .search-bar .search-form input::placeholder {
    /*color: rgba(255, 255, 255, 0.6);*/
    color: #fff;
  }
  .search-bar .search-form button {
    /*color: rgba(255, 255, 255, 0.8);*/
    color: #fff;
  }

  /* Navbar Icons */
  .header-nav .nav-icon {
    color: rgba(255, 255, 255, 0.85);
  }
  .header-nav .nav-icon:hover {
    color: #fff;
  }

  /* Badge Notification */
  .badge-number {
    background-color: var(--bd-accent) !important;
    color: var(--bd-dark) !important;
    font-weight: 800;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  }

  /* Profile Dropdown */
  .nav-profile {
    background: rgba(255,255,255,0.1);
    padding: 5px 15px 5px 5px;
    border-radius: 30px;
    transition: 0.3s;
  }
  .nav-profile:hover {
    background: rgba(255,255,255,0.2);
  }
  .nav-profile span {
    color: #fff !important;
  }

  /* Info Widget (Jam & Tanggal) */
  .header-info-widget {
    color: rgba(255,255,255,0.8);
    font-size: 0.85rem;
    border-right: 1px solid rgba(255,255,255,0.2);
    padding-right: 15px;
    margin-right: 15px;
    display: flex;
    flex-direction: column;
    align-items: end;
    line-height: 1.2;
  }
  .header-info-widget small {
    font-size: 0.7rem;
    opacity: 0.7;
  }

  /* ===== NEW: HERO BANNER STYLE (IPAS BACKGROUND) ===== */
  /*.pagetitle-hero {
    background: linear-gradient(
                  to right, 
                  rgba(1, 41, 112, 0.9),
                  rgba(65, 84, 241, 0.6) 
                ),
                url('</?= base_url("assets/img/ipas.png"); ?>'); 
    
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat;
    
    border-radius: 15px;
    padding: 40px 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(1, 41, 112, 0.15);
    position: relative;
    overflow: hidden;
    color: white;
  }

  .pagetitle-hero h1 {
    color: #fff !important;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .pagetitle-hero .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
  }
  .pagetitle-hero .breadcrumb-item, 
  .pagetitle-hero .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
  }
  .pagetitle-hero .breadcrumb-item.active {
    color: #fff;
    font-weight: 600;
  }
  .pagetitle-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);*/
  }

  /* ===== TABLE RESPONSIVE PBL ===== */
  #siswaTable, #quizTable, #ttsTable, #myUploadsTable, #questionTable, #schoolTable, #teacherTable, #studentTable {
    min-width: 720px !important;
  }

  #siswaTable thead th, #quizTable thead th, #ttsTable thead th, #myUploadsTable thead th, #questionTable thead th, #schoolTable thead th, #teacherTable thead th, #studentTable thead th {
    background: #e0efff !important;
  }

  .table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
  }

  .action { width: 20%; }

  /* Responsive Styles */
  @media (max-width: 1051px) {
    .action { width: 28%; }
  }

  @media (max-width: 576px) {
    #siswaTable td, #quizTable td, #myUploadsTable td, #action td, #schoolTable td, #teacherTable td, #studentTable td { white-space: nowrap; }
  }


  @media (max-width: 1199px) {
    .header .search-bar {
      background: #ffffff !important;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Ubah warna teks input menjadi gelap saat mobile */
    .search-bar .search-form input {
      color: #012970 !important;            /* Warna biru tua (Dark Text) */
      background-color: #f6f9ff !important; /* Background abu-abu muda */
      border: 1px solid #ced4da !important; /* Border standar */
      box-shadow: none !important;
    }

    /* Ubah warna placeholder (teks bayangan) agar terlihat */
    .search-bar .search-form input::placeholder {
      color: #6c757d !important;
    }

    /* Ubah warna ikon kaca pembesar menjadi gelap/ungu */
    .search-bar .search-form button i {
      color: var(--bd-violet-bg) !important;
    }
    
    /* Efek fokus pada input mobile */
    /*.search-bar .search-form input:focus {
      border-color: var(--bd-violet-bg) !important;
      background-color: #fff !important;
    }*/
  }
  </style>

  <!-- <script src="</?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script> -->
  <!-- <script src="</?= base_url('assets/js/csrf.js'); ?>"></script> -->
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center bg-primary-app">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= base_url(); ?>" class="logo d-flex align-items-center">
        <div class="bg-white rounded p-1 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            <img class="mx-2" src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo" style="max-height: 24px;">
        </div>
        <span class="d-none d-lg-block">E-LKPD</span>
      </a>
      <i class="ri-menu-2-fill toggle-sidebar-btn fs-4" style="cursor: pointer;"></i>
    </div>
    <?php if ($user['role'] === 'Guru' || $user['role'] === 'Siswa'): ?>
      <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="GET" action="<?= base_url('search'); ?>">
          <input type="text" name="query" placeholder="Cari materi atau siswa..." title="Enter search keyword" required>
          <button type="submit" title="Search"><i class="ri-search-line"></i></button>
        </form>
      </div>
    <?php endif ?>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <?php if ($user['role'] === 'Guru' || $user['role'] === 'Siswa'): ?>
          <li class="nav-item d-block d-xl-none">
            <a class="nav-link nav-icon search-bar-toggle" href="#">
              <i class="ri-search-line"></i>
            </a>
          </li>
        <?php endif ?>
        
        <li class="nav-item d-none d-md-block">
            <div class="header-info-widget text-light">
                <span id="headerClock" class="fw-bold mt-2">00:00</span>
                <p><?= date('l, d M Y'); ?></p>
            </div>
        </li>

        <?php 
          // Panggil Helper
          $notif_items = get_dynamic_notifications(); 
          $notif_count = count($notif_items);
        ?>

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="ri-notification-3-line"></i>
            <?php if($notif_count > 0): ?>
              <span class="badge badge-number bg-danger"><?= $notif_count ?></span>
            <?php endif; ?>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Anda memiliki <?= $notif_count ?> notifikasi baru
              <?php if($notif_count > 0): ?>
                <!-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat Semua</span></a> -->
              <?php endif; ?>
            </li>
            <li><hr class="dropdown-divider"></li>

            <?php if (!empty($notif_items)): ?>
                
                <?php foreach ($notif_items as $notif): ?>
                    <li class="notification-item">
                      <i class="bi <?= $notif['icon']; ?>"></i>
                      <div>
                        <a href="<?= $notif['link']; ?>" class="text-decoration-none text-dark">
                            <h4 class="fw-bold fs-6"><?= $notif['title']; ?></h4>
                            <p class="mb-1"><?= $notif['message']; ?></p>
                            <p class="small text-muted mb-0"><?= $notif['time']; ?></p>
                        </a>
                      </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                <?php endforeach; ?>

            <?php else: ?>
                <li class="notification-item">
                    <i class="bi bi-info-circle text-primary"></i>
                    <div>
                        <h4>Tidak ada notifikasi</h4>
                        <p>Belum ada aktivitas terbaru.</p>
                    </div>
                </li>
            <?php endif; ?>
            <!-- <li class="dropdown-footer">
              <a href="#">Tampilkan semua notifikasi</a>
            </li> -->

          </ul>
        </li>
        <li class="nav-item dropdown pe-3 ms-2">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= base_url('profile/photo/') .  (isset($user['image']) ? $user['image'] : 'foto.jpg'); ?>" alt="Profile" class="rounded-circle border border-2 border-white">
            <span class="d-none d-md-block dropdown-toggle ps-2 fw-semibold"><?= $user['username'] ?? 'User'; ?></span>
          </a><ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile shadow-lg border-0">
            <li class="dropdown-header">
              <h6 class="text-primary"><?= $user['name'] ?? 'User'; ?></h6>
              <!-- <span class="badge bg-light text-dark border"></?= ($user['role'] ?? '' == "Guru") ? 'Guru Pengajar' : 'Siswa'; ?></span> -->
              <span class="badge bg-light text-dark border">
                <?php if ($user['role'] === 'Admin'): ?>
                  Admin
                <?php elseif ($user['role'] === 'Guru'): ?>
                    Guru Pengajar                  
                <?php else: ?>
                  Siswa
                <?php endif ?>
              </span>

            </li>
            <li><hr class="dropdown-divider"></li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('profile') ?>">
                <i class="ri-user-settings-line me-2 text-primary"></i>
                <span>Profile Saya</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li> 

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('auth/logout') ?>">
                <i class="ri-logout-box-r-line me-2 text-danger"></i>
                <span>Keluar Aplikasi</span>
              </a>
            </li>

          </ul>
          <!-- </li></?php endif ?> -->

      </ul>
    </nav></header>
  <script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const clockElement = document.getElementById('headerClock');
        if(clockElement) {
            clockElement.textContent = `${hours}:${minutes}`;
        }
    }
    setInterval(updateClock, 1000);
    updateClock(); // Run immediately
  </script>
  <!-- End Header -->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1><?= $title ?? 'E-LKPD'; ?></h1>
    </div><!-- End Page Title -->