<!-- ===== PANDUAN DETAIL DISKUSI ===== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="m-0 fw-bold text-primary">
            <i class="bi bi-chat-dots"></i> Panduan Fitur Esai – Tahap 4
        </h6>
    </div>
    <div class="card-body">
        <p class="mb-3">
            Halaman ini merupakan ruang bagi siswa untuk mengerjakan tugas esai sebagai bentuk evaluasi mendalam
            terhadap solusi dari skenario masalah yang diberikan.
        </p>

        <div class="row">
            <!-- Panduan Siswa -->
            <div class="col-md-6 mb-3">
                <div class="border rounded p-3 h-100">
                    <h6 class="fw-bold text-success mb-2">
                        <i class="bi bi-person"></i> Panduan untuk Siswa
                    </h6>
                    <ul class="small mb-0">
                        <li>Pahami setiap butir Soal Esai yang disajikan agar solusi yang Anda berikan relevan dengan
                            masalah.</li>
                        <li>Klik Kerjakan Esai untuk mulai menuangkan gagasan atau hasil analisis Anda.</li>
                        <li>Pastikan Status Pengumpulan berubah menjadi hijau sebagai tanda jawaban telah tersimpan di
                            server.</li>
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
                        <li>Gunakan fitur Tambah Soal untuk memberikan pertanyaan pemantik yang mendorong siswa
                            memberikan
                            solusi logis dan sistematis.
                        </li>
                        <li>Pantau kemajuan kelas melalui tabel Jawaban & Nilai Siswa untuk melihat siapa saja yang
                            belum
                            mengumpulkan tugas.
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
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Esai (Guru)
            </h6>
            <ul class="small mb-0">
                <li>
                    <strong>Daftar Pertanyaan:</strong>
                    Tabel yang menampilkan seluruh butir pertanyaan esai yang telah dibuat untuk
                    memecahkan skenario masalah tertentu.
                </li>
                <li>
                    <strong>Tambah Soal:</strong>
                    Fasilitas utama bagi guru untuk menyusun butir pertanyaan esai yang menantang kemampuan
                    berpikir kritis siswa.
                </li>
                <li>
                    <strong>Ubah:</strong> Memberikan kendali kepada guru untuk menyunting atau memperbarui redaksi
                    pertanyaan agar tetap
                    relevan dengan tujuan pembelajaran.
                </li>
                <li>
                    <strong>Hapus:</strong> Fitur untuk mengeliminasi butir pertanyaan yang sudah tidak diperlukan dalam
                    evaluasi.
                </li>
                <li>
                    <strong>Jawaban & Nilai Siswa:</strong> Sub-halaman khusus yang memungkinkan guru untuk memantau
                    status
                    pengumpulan
                    tugas, melihat waktu pengiriman, serta memberikan penilaian secara objektif kepada setiap siswa.
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Penjelasan Fitur Siswa -->
        <?php if ($url_name == 'siswa'): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Esai (Siswa)
            </h6>
            <ul class="small mb-0">
                <li>
                    Daftar Soal Esai: Menampilkan daftar pertanyaan esai yang telah disusun oleh guru untuk memandu alur
                    berpikir dan analisis siswa.
                </li>
                <li>
                    Status Pengumpulan: Panel indikator di sisi kanan yang memberikan informasi real-time apakah jawaban
                    Anda "Belum mengumpulkan jawaban" atau sudah berhasil dikirimkan.
                </li>
                <li>
                    Tombol Kerjakan Esai: Tombol utama bagi siswa untuk mulai menuliskan jawaban atau solusi naratif
                    mereka
                    ke dalam sistem.</li>

                <li>Riwayat Pengiriman: Jika sudah mengumpulkan, sistem akan mencatat waktu pengiriman secara otomatis
                    dan menampilkannya di bagian bawah area jawaban.
                </li>

                <li>Edit Jawaban: Memberikan kesempatan kepada siswa untuk melakukan penyuntingan atau perbaikan pada
                    solusi
                    yang telah dikirimkan selama batas waktu pengerjaan masih tersedia.
                </li>

                <li>Pencarian Soal: Memudahkan siswa menemukan pertanyaan spesifik dengan menggunakan kata kunci pada
                    kolom
                    Cari... di bagian atas tabel soal.</li>
            </ul>
        </div>
        <?php endif; ?>

        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Informasi Tambahan:</strong> Seluruh aktivitas pada halaman detail esai ini dirancang untuk membantu
            peserta didik
            mengukur pemahamannya secara mandiri melalui analisis yang lebih kompleks dibandingkan kuis atau TTS.
        </div>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>
</div>