<!-- ===== PANDUAN DETAIL DISKUSI ===== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="m-0 fw-bold text-primary">
            <i class="bi bi-chat-dots"></i> Panduan Fitur Detail Observasi
        </h6>
    </div>
    <div class="card-body">
        <?php if ($is_admin_or_guru): ?>
        <p class="mb-3">
            Halaman ini merupakan bagian dari Aktivitas Interaktif yang berfungsi sebagai pusat manajemen data hasil
            penyelidikan mandiri yang telah dilakukan oleh siswa.
        </p>
        <?php endif; ?>

        <?php if ($url_name == 'siswa'): ?>
        <p class="mb-3">
            Halaman ini adalah tempat Anda mengunggah bukti autentik hasil observasi (studi lapangan, tinjauan
            literatur, atau media digital) yang telah Anda lakukan secara mandiri sesuai dengan instruksi yang
            diberikan.
        </p>
        <?php endif; ?>

        <div class="row">
            <!-- Panduan Siswa -->
            <div class="col-md-6 mb-3">
                <div class="border rounded p-3 h-100">
                    <h6 class="fw-bold text-success mb-2">
                        <i class="bi bi-person"></i> Panduan untuk Siswa
                    </h6>
                    <ul class="small mb-0">
                        <li>Pahami Instruksi: Sebelum mengunggah, pastikan Anda telah membaca judul dan instruksi
                            observasi agar data yang dikumpulkan sesuai dengan masalah yang sedang dibahas.

                        <li>Siapkan File Temuan: Pastikan hasil pengamatan Anda sudah dirangkum dalam bentuk file
                            (seperti gambar .jpg atau dokumen .docx) yang sistematis dan objektif.</li>

                        <li>Unggah Bukti: Gunakan fitur "upload file terbaru" untuk mengirimkan file hasil penyelidikan
                            mandiri Anda ke
                            sistem.</li>

                        <li>Berikan Deskripsi: Tambahkan catatan singkat pada kolom yang tersedia untuk menjelaskan inti
                            dari temuan yang Anda unggah.</li>

                        <li>Periksa Kembali: Pastikan file yang diunggah sudah benar dan deskripsi sudah sesuai sebelum
                            mengonfirmasi pengiriman.</li>
                    </ul>
                </div>
            </div>

            <!-- Panduan Guru -->
            <?php if ($is_admin_or_guru): ?>
            <div class="col-md-6 mb-3">
                <div class="border rounded p-3 h-100">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="bi bi-person-badge"></i> Panduan untuk Guru
                    </h6>
                    <ul class="small mb-0">
                        <li>Validasi Temuan: Gunakan tombol Unduh untuk memeriksa bukti observasi siswa guna memastikan
                            data
                            yang dikumpulkan bersifat sistematis dan objektif.</li>
                        <li>Evaluasi Proses: Klik Beri Nilai untuk mengapresiasi proses penyelidikan mandiri siswa.
                            Fokuslah
                            pada bagaimana siswa mengorganisasikan konsep, bukan sekadar jawaban akhir.
                        </li>
                        <li>Umpan Balik: Berikan catatan pada kolom penilaian untuk membantu siswa mempersiapkan dasar
                            diskusi kelompok pada tahap berikutnya.
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Penjelasan Fitur -->
        <?php if ($is_admin_or_guru): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Observasi (Guru)
            </h6>
            <ul class="small mb-0">
                <li>Daftar Upload & Penilaian: Tabel sistematis yang menampilkan riwayat pengiriman tugas observasi dari
                    setiap siswa.
                </li>

                <li>Identitas Siswa & File: Menampilkan nama siswa beserta nama file dokumen (seperti format .jpg atau
                    .docx) dan deskripsi singkat hasil temuan mereka.
                </li>

                <li>Unduh File: Fasilitas bagi guru untuk mengunduh bukti autentik hasil observasi (studi lapangan,
                    tinjauan literatur, atau media digital) yang telah diunggah oleh siswa.</li>
                <li>Status Penilaian: Indikator real-time yang menunjukkan apakah tugas tersebut "Belum Dinilai" atau
                    sudah
                    mendapatkan skor tertentu beserta catatan dari guru.
                </li>
                <li>Aksi Guru (Manajemen Nilai):
                    Beri Nilai / Edit Nilai: Guru dapat memberikan skor numerik dan catatan umpan balik kualitatif
                    berdasarkan kedalaman hasil observasi.
                </li>
                <li>Hapus Nilai / Hapus File: Fitur untuk mereset penilaian atau menghapus file jika terjadi
                    kesalahan
                    pengiriman atau kebutuhan perbaikan tugas.
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($url_name == 'siswa'): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Observasi (Siswa)
            </h6>
            <ul class="small mb-0">
                <li>Memilih Ruang Observasi: Buka menu Daftar Ruang Observasi dan pilih topik pengamatan yang sesuai
                    dengan
                    mengeklik tombol Detail pada kolom aksi.
                </li>

                <li>Membaca Instruksi Tugas: Sebelum mengunggah hasil, cermati bagian Instruksi Tugas di bagian atas
                    halaman
                    untuk memastikan data yang Anda kumpulkan sudah sesuai dengan arahan guru.
                </li>

                <li>Menyiapkan Bukti Temuan: Pastikan hasil pengamatan Anda sudah dirangkum dalam file pendukung
                    (seperti
                    format .pdf, .jpg, atau .docx) yang siap untuk dikirimkan.
                </li>

                <li>Mengunggah File: Gunakan fitur unggah pada halaman tersebut untuk memasukkan bukti observasi Anda ke
                    dalam sistem.
                </li>

                <li>Memberikan Keterangan: Isi kolom Keterangan saat mengunggah untuk memberikan penjelasan singkat
                    mengenai
                    inti dari temuan atau isi file yang Anda lampirkan.
                </li>

                <li>Memverifikasi Pengunggahan: Periksa tabel File Saya untuk memastikan file Anda sudah terdata
                    dengan
                    keterangan tanggal upload dan waktu yang sesuai.
                </li>

                <li>Memantau Status Penilaian: Setelah mengunggah, Anda dapat mengecek kembali secara berkala untuk
                    melihat
                    apakah guru sudah memberikan nilai atau umpan balik terhadap hasil observasi Anda.
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Catatan Penting -->
        <?php if ($is_admin_or_guru): ?>
        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong>
            Seluruh data pada halaman ini merupakan Hasil Tahap 2 yang akan diintegrasikan menjadi dasar analisis pada
            Tahap 3 dan rekapitulasi pada evaluasi akhir.
        </div>
        <?php endif; ?>

        <?php if ($url_name == 'siswa'): ?>
        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong>
            Pastikan file yang Anda unggah sudah benar dan deskripsi sudah sesuai sebelum mengonfirmasi pengiriman.
        </div>
        <?php endif; ?>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>
</div>