<style>
	/* ===== 1. CUSTOM VARIABLES & THEME ===== */
	:root {
		scroll-behavior: smooth;
		/* Warna utama (Violet) */
		--bd-violet-bg: #712cf9;
		--bd-violet-rgb: 113, 44, 249;

		/* Warna Accent (Kuning/Orange) */
		--bd-accent: #ffe484;
		--bd-accent-rgb: 255, 228, 132;

		/* Warna text dark */
		--bd-dark: #212529;
	}

	/* Gradient Background Class */
	./*bg-primary-app {
		background: linear-gradient(135deg, #4154f1 0%, #2132bd 100%) !important;
		color: white;
	}*/

	.bg-violet-app {
		background: linear-gradient(135deg, var(--bd-violet-bg) 0%, #4a148c 100%) !important;
		color: white;
	}

	/* ===== 2. PROFILE CARD STYLING ===== */
	.card {
		border: none;
		border-radius: 12px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
		overflow: hidden;
	}

	/* Header Background di kartu profil */
	.profile-header-bg {
		height: 120px;
		width: 100%;
		position: relative;
	}

	.profile-card-body {
		margin-top: -60px; /* Menarik konten ke atas menimpa banner */
		position: relative;
		text-align: center;
		padding-bottom: 30px;
	}

	.profile-img-preview {
		width: 120px;
		height: 120px;
		object-fit: cover;
		border-radius: 50%;
		border: 4px solid #fff; /* Border putih agar kontras dengan banner */
		box-shadow: 0 4px 10px rgba(0,0,0,0.15);
		background-color: #fff;
	}

	/* Social/Info Icons di bawah profil */
	.profile-social-links a {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 36px;
		height: 36px;
		border-radius: 50%;
		background: rgba(113, 44, 249, 0.1);
		color: var(--bd-violet-bg);
		margin: 0 5px;
		transition: 0.3s;
		text-decoration: none;
	}
	.profile-social-links a:hover {
		background: var(--bd-violet-bg);
		color: #fff;
	}

	/* ===== 3. TABS & FORM STYLING ===== */
	.nav-tabs-custom .nav-link {
		color: #6c757d;
		font-weight: 600;
		border: none;
		border-bottom: 3px solid transparent;
		padding: 12px 20px;
	}

	.nav-tabs-custom .nav-link:hover {
		color: var(--bd-violet-bg);
	}

	.nav-tabs-custom .nav-link.active {
		color: var(--bd-violet-bg);
		border-bottom: 3px solid var(--bd-violet-bg);
		background-color: transparent;
	}

	/* Input Group Styling */
	.input-group-text {
		background-color: #f8f9fa;
		border-right: none;
		color: var(--bd-violet-bg);
	}
	.form-control {
		border-left: none;
		padding-left: 0;
	}
	.form-control:focus {
		box-shadow: none;
		border-color: #ced4da; /* Tetap standar atau ubah ke violet */
	}
	.input-group:focus-within .input-group-text,
	.input-group:focus-within .form-control {
		border-color: var(--bd-violet-bg);
	}
	.input-group:focus-within .input-group-text {
		background-color: rgba(113, 44, 249, 0.05);
	}

	/* Detail Row Styling */
	.detail-row {
		padding: 12px 0;
		border-bottom: 1px solid #f0f0f0;
		display: flex;
		align-items: center;
	}
	.detail-row:last-child {
		border-bottom: none;
	}
	.detail-icon {
		width: 40px;
		height: 40px;
		background: #f8f9fa;
		border-radius: 8px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: var(--bd-violet-bg);
		font-size: 1.2rem;
		margin-right: 15px;
	}

	/* Button Custom */
	.btn-violet {
		background-color: var(--bd-violet-bg);
		color: white;
		border: none;
		padding: 10px 30px;
		border-radius: 50px;
		font-weight: 600;
		box-shadow: 0 4px 15px rgba(113, 44, 249, 0.3);
		transition: all 0.3s;
	}
	.btn-violet:hover {
		background-color: #5a23c8;
		transform: translateY(-2px);
		color: white;
	}
</style>

<div class="container-fluid">
	<div class="pagetitle mb-4">
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
				<li class="breadcrumb-item active">Profile</li>
			</ol>
		</nav>
	</div>

	<div class="row">
		<div class="col-xl-4 mb-4">
			<div class="card h-100">
				<div class="profile-header-bg bg-primary-app"></div>

				<div class="card-body profile-card-body">
					<img src="<?= base_url('profile/photo'); ?>" 
					class="profile-img-preview mb-3" 
					id="mainProfileImg"
					alt="Profile">

					<h3 id="displayName" class="fw-bold mb-1" style="color: var(--bd-dark);"><?= html_escape($user_db->name ?? $user['name']) ?></h3>
					<span class="badge bg-violet-app rounded-pill px-3 py-2 mb-3 shadow-sm">
						<?= html_escape($user_db->role) ?>
					</span>

					<div class="profile-social-links mt-2">
					    <a href="mailto:<?= html_escape($user_db->email) ?>" 
					       class="btn-action" 
					       title="Kirim Email ke <?= html_escape($user_db->email) ?>" 
					       data-bs-toggle="tooltip" 
					       data-bs-placement="bottom">
					        <i class="ri-mail-line"></i>
					    </a>

					    <a href="javascript:void(0);" 
					       onclick="activateEditTab()" 
					       class="btn-action" 
					       title="Edit Profil Saya" 
					       data-bs-toggle="tooltip" 
					       data-bs-placement="bottom">
					        <i class="ri-settings-3-line"></i>
					    </a>

					    <a href="javascript:void(0);" 
					       class="btn-action" 
					       title="Bergabung sejak: <?= date('d F Y', strtotime($user_db->created_at ?? date('Y-m-d'))) ?>" 
					       data-bs-toggle="tooltip" 
					       data-bs-placement="bottom" 
					       style="cursor: help;">
					        <i class="ri-time-line"></i>
					    </a>
					</div>
				</div>

				<div class="card-footer bg-white border-0 text-center pb-4">
					<small class="text-muted">Member sejak: <?= date('F Y', strtotime($user_db->created_at ?? date('Y-m-d'))); ?></small>
				</div>
			</div>
		</div>

		<div class="col-xl-8 mb-4">
			<div class="card h-100">
				<div class="card-body pt-3">
					<ul class="nav nav-tabs nav-tabs-custom mb-4">
						<li class="nav-item">
							<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">
								<i class="ri-eye-line me-2"></i>Overview
							</button>
						</li>
						<li class="nav-item">
							<button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit">
								<i class="ri-edit-box-line me-2"></i>Edit Profile
							</button>
						</li>
					</ul>

					<div class="tab-content pt-2">

						<div class="tab-pane fade show active" id="overview">
							<h5 class="fw-bold mb-3" style="color: var(--bd-violet-bg);">Detail Akun</h5>

							<div class="detail-row">
								<div class="detail-icon"><i class="ri-user-smile-line"></i></div>
								<div>
									<div class="text-muted small text-uppercase fw-bold">Nama Lengkap</div>
									<div class="fw-bold fs-5"><?= html_escape($user_db->name) ?></div>
								</div>
							</div>

							<div class="detail-row">
								<div class="detail-icon"><i class="ri-mail-send-line"></i></div>
								<div>
									<div class="text-muted small text-uppercase fw-bold">Email</div>
									<div class="fw-medium"><?= html_escape($user_db->email) ?></div>
								</div>
							</div>

							<div class="detail-row">
								<div class="detail-icon"><i class="ri-shield-user-line"></i></div>
								<div>
									<div class="text-muted small text-uppercase fw-bold">Username</div>
									<div class="fw-medium" id="displayUsername"><?= html_escape($user_db->username) ?></div>
								</div>
							</div>

							<div class="detail-row">
								<div class="detail-icon"><i class="ri-shield-keyhole-line"></i></div>
								<div>
									<div class="text-muted small text-uppercase fw-bold">Role / Peran</div>
									<div class="fw-medium text-capitalize"><?= html_escape($user_db->role) ?></div>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="edit">
							<form id="formProfile" enctype="multipart/form-data">

								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
								value="<?= $this->security->get_csrf_hash(); ?>" 
								id="csrfToken">

								<div class="row mb-4">
									<label class="col-md-4 col-lg-3 col-form-label fw-bold">Foto Profil</label>
									<div class="col-md-8 col-lg-9">
										<div class="d-flex align-items-center gap-3">
											<img src="<?= base_url('profile/photo'); ?>" id="formProfileImg" class="rounded-circle" style="width: 60px; height: 60px; object-fit:cover;">
											<div class="flex-grow-1">
												<input type="file" name="image" class="form-control" accept="image/*" onchange="previewFile(this)">
												<small class="text-muted">Max 2MB (JPG/PNG)</small>
											</div>
										</div>
									</div>
								</div>

								<div class="row mb-4">
									<label class="col-md-4 col-lg-3 col-form-label fw-bold">Username</label>
									<div class="col-md-8 col-lg-9">
										<div class="input-group">
											<span class="input-group-text"><i class="ri-at-line"></i></span>
											<input type="text" name="username" class="form-control" value="<?= html_escape($user_db->username); ?>" required>
										</div>
									</div>
								</div>

								<hr class="my-4 border-light">
								<h6 class="fw-bold mb-3" style="color: var(--bd-violet-bg);">Ganti Password</h6>

								<div class="row mb-3">
									<label class="col-md-4 col-lg-3 col-form-label fw-bold">Password Baru</label>
									<div class="col-md-8 col-lg-9">
										<div class="input-group">
											<span class="input-group-text"><i class="ri-lock-password-line"></i></span>
											<input type="password" name="password" id="password" class="form-control" autocomplete="new-password" placeholder="Biarkan kosong jika tidak diganti">
											<span class="input-group-text bg-white" onclick="togglePassword()" style="cursor:pointer">
												<i class="ri-eye-line" id="toggleIcon"></i>
											</span>
										</div>
									</div>
								</div>

								<div class="row mb-4">
									<label class="col-md-4 col-lg-3 col-form-label fw-bold">Konfirmasi</label>
									<div class="col-md-8 col-lg-9">
										<div class="input-group">
											<span class="input-group-text"><i class="ri-lock-2-line"></i></span>
											<input type="password" name="password_confirm" class="form-control" autocomplete="new-password" placeholder="Ulangi password baru">
										</div>
									</div>
								</div>

								<div class="text-end">
									<button type="submit" class="btn btn-violet">
										<i class="ri-save-3-line me-1"></i> Simpan Perubahan
									</button>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>

<script>
// 1. Preview Gambar Lokal
function previewFile(input) {
	const file = input.files[0];
	if (file) {
		if (file.size > 2097152) {
			Swal.fire('Error', 'Ukuran file terlalu besar (Maks 2MB)', 'error');
			input.value = ''; 
			return;
		}

		const reader = new FileReader();
		reader.onload = function(e) {
			$('#formProfileImg').attr('src', e.target.result); 
		}
		reader.readAsDataURL(file);
	}
}

// 2. Toggle Password Visibility
function togglePassword() {
	const pass = document.getElementById('password');
	const icon = document.getElementById('toggleIcon');
	if (pass.type === 'password') {
		pass.type = 'text';
		icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
	} else {
		pass.type = 'password';
		icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
	}
}

// 3. AJAX Submission
$('#formProfile').on('submit', function(e) {
	e.preventDefault();

	const formData = new FormData(this);
	const csrfName = '<?= $this->security->get_csrf_token_name(); ?>';

	Swal.fire({
		title: 'Konfirmasi Simpan',
		text: "Pastikan data yang Anda masukkan sudah benar.",
		icon: 'question',
		showCancelButton: true,
        confirmButtonColor: '#712cf9', // Violet color
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal'
      }).then((result) => {
      	if (result.isConfirmed) {
      		$.ajax({
      			url: "<?= base_url('profile/update_ajax'); ?>",
      			type: "POST",
      			data: formData,
      			processData: false,
      			contentType: false,
      			dataType: "json",
      			beforeSend: function() {
      				Swal.fire({
      					title: 'Menyimpan...',
      					allowOutsideClick: false,
      					didOpen: () => Swal.showLoading()
      				});
      			},
      			success: function(res) {
      				$('#csrfToken').val(res.csrf_token); 
      				$('input[name="'+csrfName+'"]').val(res.csrf_token); 

      				if (res.status) {
      					Swal.fire({
      						icon: 'success',
      						title: 'Berhasil',
      						text: res.message,
      						timer: 1500,
      						showConfirmButton: false
      					});

      					if (res.image_url) {
      						$('#mainProfileImg').attr('src', res.image_url);
      						$('#formProfileImg').attr('src', res.image_url);
      						$('.header-profile-user').attr('src', res.image_url);
      					}

      					if (res.new_name) {
                            $('#displayName').text(res.new_name); // Update nama di banner juga jika ada field nama
                          }
                        if (res.new_username) { // Asumsi controller mengembalikan new_username
                        	$('#displayUsername').text(res.new_username);
                        }
                        
                        $('input[type="password"]').val('');

                      } else {
                      	Swal.fire({
                      		icon: 'error',
                      		title: 'Gagal',
                      		html: res.message
                      	});
                      }
                    },
                    error: function(xhr, status, error) {
                    	Swal.fire('Error', 'Terjadi kesalahan server: ' + status, 'error');
                    }
                  });
      	}
      });
    });

		// Fungsi untuk pindah ke Tab Edit Profile
		function activateEditTab() {
		    // Cari tombol trigger tab edit
		    const triggerEl = document.querySelector('button[data-bs-target="#edit"]');
		    // Inisialisasi tab Bootstrap
		    const tab = new bootstrap.Tab(triggerEl);
		    // Tampilkan tab
		    tab.show();
		    // Scroll sedikit agar user fokus ke form
		    document.querySelector('.nav-tabs-custom').scrollIntoView({ behavior: 'smooth' });
		}

		// Inisialisasi Tooltip Bootstrap (Agar title muncul cantik)
		document.addEventListener('DOMContentLoaded', function () {
		    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		        return new bootstrap.Tooltip(tooltipTriggerEl)
		    })
		});
  </script>