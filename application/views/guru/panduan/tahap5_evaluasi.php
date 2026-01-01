<!-- ===== PANDUAN DETAIL DISKUSI ===== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="m-0 fw-bold text-primary">
            <i class="bi bi-chat-dots"></i> Panduan Fitur Evaluasi & Refleksi
        </h6>
    </div>
    <div class="card-body">
        <p class="mb-3">
            Halaman ini merupakan tahap final dalam alur pembelajaran PBL (Problem-Based Learning) yang berfungsi
            sebagai pusat rekapitulasi capaian belajar, pemberian umpan balik, dan finalisasi proyek. </p>

        <div class="row">
            <!-- Panduan Siswa -->
            <div class="col-md-6 mb-3">
                <div class="border rounded p-3 h-100">
                    <h6 class="fw-bold text-success mb-2">
                        <i class="bi bi-person"></i> Panduan untuk Siswa
                    </h6>
                    <ul class="small mb-0">
                        <li> Lihat Capaian: Masuk ke halaman Evaluasi untuk melihat Nilai Akhir.</li>

                        <li>Baca Refleksi: Cermati catatan dari guru pada kolom refleksi sebagai bahan perbaikan belajar
                            Anda di masa depan.
                        </li>

                        <li>Umpan Balik: Tuliskan kesan atau kendala yang Anda rasakan selama mengerjakan e-LKPD ini
                            pada kolom yang tersedia.</li>

                        <li>Selesai: Pastikan telah melihat seluruh hasil evaluasi sebelum guru menutup proyek
                            pembelajaran.
                        </li>
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
                        <li>Memberi Umpan Balik: Klik tombol Input atau Ubah untuk menuliskan catatan dan masukan dari
                            Anda
                            kepada siswa atas hasil kerja mereka.
                        </li>

                        <li>Melihat Rekap Nilai: Pantau tabel Rekap Nilai Siswa yang secara otomatis menggabungkan nilai
                            Quiz, TTS, Observasi, dan Esai menjadi Nilai Akhir.
                        </li>

                        <li><i class="bi bi-key"></i> Mengatur Fitur Kunci: Klik ikon Kunci pada kolom aksi untuk
                            menampilkan nilai dan umpan balik di
                            akun siswa.

                        <li>Terkunci: Nilai sudah final dan bisa dilihat oleh siswa.</li>

                        <li>Terbuka: Nilai masih diproses dan disembunyikan dari siswa.</li>

                        <li>Cetak & Selesai: Klik Export (PDF/Excel) untuk mengunduh laporan nilai, lalu tekan Project
                            Selesai jika seluruh rangkaian pembelajaran telah berakhir..</li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Penjelasan Fitur -->
        <?php if ($is_admin_or_guru): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Evaluasi & Refleksi (guru)
            </h6>
            <ul class="small mb-0">
                <li> Quiz & TTS (Avg): Menampilkan nilai rata-rata dari aktivitas kuis dan teka-teki silang pada Tahap
                    2.</li>
                <li> Observasi: Menampilkan nilai hasil penyelidikan mandiri siswa pada Tahap 3.</li>
                <li> Esai: Menampilkan penilaian dari solusi naratif yang disusun siswa pada tahap analisis.</li>
                <li> Nilai Akhir: Kalkulasi total dari seluruh komponen penilaian untuk menentukan tingkat kelberhasilan
                    siswa</li>
                <li> Umpan Balik Siswa: Kolom untuk memasukkan tanggapan atau komentar siswa terhadap proses</li>
                <li> Refleksi Guru: Kolom untuk memasukkan catatan refleksi guru terhadap proses pembelajaran yang</li>
                <li> Fungsi Kunci (Kunci/Buka): Digunakan oleh guru untuk menentukan apakah nilai dan refleksi sudah
                    dapat
                    ditampilkan atau masih disembunyikan dari akun siswa.</li>
                <li>Transparansi Nilai: Saat dikunci, siswa dapat melihat hasil akhir mereka sebagai bentuk
                    transparansi;
                    saat dibuka (atau belum dikunci), nilai hanya terlihat di sisi guru untuk kebutuhan pengolahan
                    internal.
                </li>
                <li>Export Laporan (Excel/PDF): Guru dapat mengunduh rekapitulasi nilai dan refleksi sebagai dokumen
                    resmi.</li>
                <li>Project Selesai: Menandai bahwa seluruh rangkaian e-LKPD telah resmi diselesaikan oleh kelas.</li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($is_admin_or_guru): ?>
        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong>
            Berikan umpan balik yang memotivasi siswa sebelum mengaktifkan fitur kunci agar mereka langsung mendapatkan
            arahan perbaikan saat melihat nilai.
        </div>
        <?php endif; ?>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>
</div>