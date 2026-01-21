<div class="container-fluid">
	<div class="pagetitle mb-4">
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
				<li class="breadcrumb-item active">Search</li>
			</ol>
		</nav>
	</div>

	<section class="section">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body pt-4">

						<?php if($keyword): ?>
							<h5 class="card-title">Menampilkan hasil untuk: "<?= html_escape($keyword); ?>"</h5>
						<?php endif; ?>

						<?php if (!empty($results)) : ?>
							<div class="list-group list-group-flush">
								<?php foreach ($results as $row) : ?>
									<a href="<?= $row['url']; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
										<div>
											<div class="d-flex w-100 justify-content-between">
												<h6 class="mb-1 fw-bold text-primary"><?= $row['title']; ?></h6>
											</div>
											<small class="text-muted"><?= $row['desc']; ?></small>
										</div>
										<span class="badge bg-secondary rounded-pill"><?= $row['type']; ?></span>
									</a>
								<?php endforeach; ?>
							</div>
							<?php else : ?>
								<div class="alert alert-warning d-flex align-items-center" role="alert">
									<i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
									<div>
										Tidak ada data yang ditemukan untuk kata kunci tersebut.
									</div>
								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>
		</section>
	</div>