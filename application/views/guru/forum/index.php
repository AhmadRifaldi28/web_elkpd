<h1 class="h3 mb-4 text-gray-800">Kelola <?= $title; ?></h1>

<div class="row">
	<div class="col-lg-12">

		<?= $this->session->flashdata('message'); ?>

		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<button class="btn btn-primary" id="btnAddForum">
					<i class="fas fa-plus"></i> Buat Topik Forum Baru
				</button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="forumTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th style="width: 5%;">No</th>
								<th>Judul Topik</th>
								<th style="width: 20%;">Dibuat Oleh</th>
								<th style="width: 20%;">Tanggal</th>
								<th style="width: 15%;">Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="forumModal" tabindex="-1" aria-labelledby="forumModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="forumModalLabel">Topik Forum Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="forumForm">
				<div class="modal-body">
					<input type="hidden" name="id" id="forumId">
					
					<div class="mb-3">
						<label for="judul" class="form-label">Judul Topik</label>
						<input type="text" class="form-control" id="judul" name="judul" required>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
    // Pastikan skrip berjalan setelah DOM (dan jQuery) dimuat
    $(document).ready(function() {

    	const base_url = '<?= base_url() ?>';
        let dataTable; // Variabel untuk menyimpan instance simple-datatable

        // --- Referensi Elemen jQuery ---
        const $forumModal = new bootstrap.Modal(document.getElementById('forumModal'));
        const $forumForm = $('#forumForm');
        const $forumModalLabel = $('#forumModalLabel');
        const $forumId = $('#forumId');
        const $judul = $('#judul');

        // Referensi elemen statis untuk event delegation
        const $cardBody = $('.card-body');

        /**
         * Inisialisasi simple-datatables
         */
         const initDataTable = () => {
         	if (dataTable) {
                dataTable.destroy(); // Hancurkan tabel lama
              }
              dataTable = new simpleDatatables.DataTable("#forumTable", {
              	searchable: true,
              	fixedHeight: false,
              	labels: {
              		placeholder: "Cari...",
              		perPage: "",
              		noResults: "Tidak ada data ditemukan",
              		noRows: "Tidak ada data ditemukan",
              		info: "Menampilkan {start} sampai {end} dari {rows} data",
              	}
              });
            };

        /**
         * Fungsi untuk memformat tanggal (agar lebih rapi)
         */
         const formatTanggal = (tanggalDB) => {
         	if (!tanggalDB) return '';
         	const options = {
         		year: 'numeric',
         		month: 'long',
         		day: 'numeric',
         		hour: '2-digit',
         		minute: '2-digit'
         	};
         	return new Date(tanggalDB).toLocaleString('id-ID', options);
         };

        /**
         * Fungsi untuk memuat data dari controller (via AJAX)
         * dan membangun tabel
         */
         const loadForumData = () => {
            // Controller index() akan merespons JSON jika via AJAX
            $.getJSON(base_url + 'guru/forum') // atau 'forum/index'
            .done(function(data) {
            	const formattedData = data.map((forum, index) => {
            		
                    // Menggunakan variabel JavaScript ${base_url} dan ${forum.id}
                    const buttons = `
                    <div class="btn-group" role="group" aria-label="Aksi Forum">
                    <a href="${base_url}guru/forum/thread/${forum.id}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-chat-text"></i> Buka
                    </a>
                    <button class="btn btn-warning btn-sm btn-edit" 
                    data-id="${forum.id}">
                    <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm btn-delete" 
                    data-id="${forum.id}" 
                    data-judul="${forum.judul}">
                    <i class="fas fa-trash"></i> Hapus
                    </button>
                    </div>
                    `;
                    // === AKHIR PERUBAHAN ===
                    
                    return [
                    index + 1,
                    forum.judul,
                    forum.nama_guru,
                    formatTanggal(forum.tanggal),
                    buttons
                    ];
                  });

                // Inisialisasi atau re-inisialisasi tabel
                initDataTable();

                // Masukkan data baru ke tabel
                if (formattedData.length > 0) {
                	dataTable.insert({
                		data: formattedData
                	});
                }
              })
            .fail(function(jqXHR, textStatus, errorThrown) {
            	console.error('Failed to load forum data:', textStatus, errorThrown);
            	Swal.fire('Error', 'Gagal memuat data forum.', 'error');
            });
          };

        /**
         * Menampilkan Notifikasi Toast (SweetAlert2)
         */
         const showToast = (icon, title) => {
         	Swal.fire({
         		icon: icon,
         		title: title,
         		toast: true,
         		position: 'top-end',
         		showConfirmButton: false,
         		timer: 3000,
         		timerProgressBar: true
         	});
         };

        // --- 1. CREATE (Tampilkan Modal) ---
        $('#btnAddForum').on('click', function() {
            $forumForm[0].reset(); // Kosongkan form
            $forumId.val(''); // Pastikan ID kosong
            $forumModalLabel.text('Topik Forum Baru');
            $forumModal.show();
          });

        // --- 2. SAVE (Create & Update) ---
        $forumForm.on('submit', function(e) {
        	e.preventDefault();
        	
            const formData = $(this).serialize(); // Ambil data form

            $.ajax({
            	url: base_url + 'guru/forum/save',
            	type: 'POST',
            	data: formData,
            	dataType: 'json',
            	success: function(response) {
            		if (response.status === 'success') {
            			$forumModal.hide();
            			showToast('success', response.message);
                        loadForumData(); // Reload data tabel
                      } else {
                      	Swal.fire('Gagal!', response.message, 'error');
                      }
                    },
                    error: function() {
                    	Swal.fire('Error', 'Terjadi kesalahan saat menyimpan.', 'error');
                    }
                  });
          });

        // --- 3. EDIT (Show Modal) & 4. DELETE (Confirmation) ---
        // PENTING: Gunakan event delegation pada $cardBody (induk statis)
        
        // Event untuk tombol EDIT
        $cardBody.on('click', '.btn-edit', function() {
        	const id = $(this).data('id');

            // Panggil controller get_forum($id) untuk data terbaru
            $.getJSON(base_url + 'guru/forum/get_forum/' + id)
            .done(function(data) {
            	if (data.error) {
            		Swal.fire('Error', data.error, 'error');
            	} else {
                        // Isi form modal
                        $forumId.val(data.id);
                        $judul.val(data.judul);
                        $forumModalLabel.text('Edit Topik Forum');
                        $forumModal.show();
                      }
                    })
            .fail(function() {
            	Swal.fire('Error', 'Gagal mengambil data forum.', 'error');
            });
          });

        // Event untuk tombol DELETE
        $cardBody.on('click', '.btn-delete', function() {
        	const id = $(this).data('id');
        	const judul = $(this).data('judul');

        	Swal.fire({
        		title: 'Anda Yakin?',
        		text: `Topik "${judul}" akan dihapus permanen!`,
        		icon: 'warning',
        		showCancelButton: true,
        		confirmButtonColor: '#d33',
        		cancelButtonColor: '#3085d6',
        		confirmButtonText: 'Ya, hapus!',
        		cancelButtonText: 'Batal'
        	}).then((result) => {
        		if (result.isConfirmed) {
                    // Jika dikonfirmasi, panggil fungsi delete
                    deleteForum(id);
                  }
                });
        });

        /**
         * Fungsi untuk eksekusi delete via AJAX
         */
         const deleteForum = (id) => {
         	$.ajax({
         		url: base_url + 'guru/forum/delete/' + id,
                type: 'POST', // Gunakan POST untuk delete demi keamanan
                dataType: 'json',
                success: function(response) {
                	if (response.status === 'success') {
                		showToast('success', response.message);
                        loadForumData(); // Reload data tabel
                      } else {
                      	Swal.fire('Gagal!', response.message, 'error');
                      }
                    },
                    error: function() {
                    	Swal.fire('Error', 'Terjadi kesalahan saat menghapus.', 'error');
                    }
                  });
         };

        // --- Inisialisasi Awal ---
        // Muat data saat halaman pertama kali dibuka
        loadForumData();

      });
    </script>