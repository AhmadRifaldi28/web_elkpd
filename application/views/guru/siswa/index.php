<div class="row">
  <div class="col-lg-12">

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <button class="btn btn-primary" id="btnAddSiswa">
          <i class="fas fa-plus"></i> Tambah Siswa Baru
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="siswaTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th style="width: 10%;">Status</th>
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

<div class="modal fade" id="siswaModal" tabindex="-1" aria-labelledby="siswaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="siswaModalLabel">Tambah Siswa Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="siswaForm">
        <div class="modal-body">
          <input type="hidden" name="id" id="siswaId">

          <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <small class="text-muted">Password default untuk siswa baru adalah: <strong>password</strong></small>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
            <label class="form-check-label" for="is_active">
              Status Aktif
            </label>
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
  $(document).ready(function() {

    const base_url = '<?= base_url() ?>';
        let dataTable; // Variabel untuk menyimpan instance simple-datatable

        // --- Referensi Elemen jQuery ---
        const $siswaModal = new bootstrap.Modal(document.getElementById('siswaModal'));
        const $siswaForm = $('#siswaForm');
        const $siswaModalLabel = $('#siswaModalLabel');
        const $siswaId = $('#siswaId');
        
        // Referensi Form Fields
        const $name = $('#name');
        const $username = $('#username');
        const $email = $('#email');
        const $is_active = $('#is_active');

        // Referensi elemen statis untuk event delegation
        const $cardBody = $('.card-body');

        /**
         * Inisialisasi simple-datatables
         */
         const initDataTable = () => {
          if (dataTable) {
                dataTable.destroy(); // Hancurkan tabel lama
            }
            dataTable = new simpleDatatables.DataTable("#siswaTable", {
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
         * Fungsi untuk memuat data dari controller (via AJAX)
         * dan membangun tabel
         */
         const loadSiswaData = () => {
            // Mengasumsikan 'guru/siswa' (Siswa::index) akan merespons JSON jika via AJAX
            $.getJSON(base_url + 'guru/siswa')
            .done(function(data) {
              const formattedData = data.map((siswa, index) => {

                const status = siswa.is_active == 1
                ? `<span class="badge bg-success">Aktif</span>`
                : `<span class="badge bg-danger">Nonaktif</span>`;

                const buttons = `
                <button class="btn btn-warning btn-sm btn-edit" 
                data-id="${siswa.id}">
                <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm btn-delete" 
                data-id="${siswa.id}" 
                data-name="${siswa.name}">
                <i class="fas fa-trash"></i> Hapus
                </button>
                `;

                return [
                index + 1,
                siswa.name,
                siswa.username,
                siswa.email,
                status,
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
              console.error('Failed to load siswa data:', textStatus, errorThrown);
              Swal.fire('Error', 'Gagal memuat data siswa. Pastikan Controller `index()` bisa merespons AJAX.', 'error');
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
        $('#btnAddSiswa').on('click', function() {
            $siswaForm[0].reset(); // Kosongkan form
            $siswaId.val(''); // Pastikan ID kosong
            $is_active.prop('checked', true); // Default aktif
            $siswaModalLabel.text('Tambah Siswa Baru');
            $siswaModal.show();
        });

        // --- 2. SAVE (Create & Update) ---
        $siswaForm.on('submit', function(e) {
          e.preventDefault();

            const formData = $(this).serialize(); // Ambil data form

            $.ajax({
              url: base_url + 'guru/siswa/save',
              type: 'POST',
              data: formData,
              dataType: 'json',
              success: function(response) {
                if (response.status === 'success') {
                  $siswaModal.hide();
                  showToast('success', response.message);
                        loadSiswaData(); // Reload data tabel
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

            // Panggil controller get($id)
            $.getJSON(base_url + 'guru/siswa/get/' + id)
            .done(function(data) {
              if (data) {
                        // Isi form modal
                        $siswaId.val(data.id);
                        $name.val(data.name);
                        $username.val(data.username);
                        $email.val(data.email);
                        // Atur status switch
                        $is_active.prop('checked', data.is_active == 1); 
                        
                        $siswaModalLabel.text('Edit Data Siswa');
                        $siswaModal.show();
                    } else {
                      Swal.fire('Error', 'Data siswa tidak ditemukan.', 'error');
                    }
                })
            .fail(function() {
              Swal.fire('Error', 'Gagal mengambil data siswa.', 'error');
            });
        });

        // Event untuk tombol DELETE
        $cardBody.on('click', '.btn-delete', function() {
          const id = $(this).data('id');
          const name = $(this).data('name');

          Swal.fire({
            title: 'Anda Yakin?',
            text: `Siswa "${name}" akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              deleteSiswa(id);
            }
          });
        });

        /**
         * Fungsi untuk eksekusi delete via AJAX
         */
         const deleteSiswa = (id) => {
          $.ajax({
            url: base_url + 'guru/siswa/delete/' + id,
                type: 'POST', // Gunakan POST untuk delete
                dataType: 'json',
                success: function(response) {
                  if (response.status === 'success') {
                    showToast('success', response.message);
                        loadSiswaData(); // Reload data tabel
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
        loadSiswaData();

    });
</script>