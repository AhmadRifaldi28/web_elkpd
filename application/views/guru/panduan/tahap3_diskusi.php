<!-- ===== PANDUAN DETAIL DISKUSI ===== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="m-0 fw-bold text-primary">
            <i class="bi bi-chat-dots"></i> Panduan Fitur Forum Diskusi
        </h6>
    </div>
    <div class="card-body">
        <?php if ($is_admin_or_guru): ?>
        <p class="mb-3">
            Tahap Organisasi Belajar melalui Teka-Teki Silang (TTS) bertujuan membantu siswa mengelola pemahaman awal
            terhadap istilah dan konsep kunci dalam skenario masalah sebelum masuk ke tahap observasi dan diskusi lebih
            mendalam.
        </p>
        <?php endif; ?>

        <?php if ($url_name == 'siswa'): ?>
        <p class="mb-3">
            Halaman ini adalah ruang digital bagi Anda untuk berkomunikasi dengan guru dan teman sekelompok dalam
            memecahkan masalah.
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
                        <li></li>Masuk ke Forum: Pilih menu Forum Diskusi pada tab aktivitas, lalu klik tombol Detail
                        pada topik
                        diskusi yang ingin Anda ikuti.
                        </li>

                        <li>Memulai Topik Baru: Jika Anda ingin menyampaikan ide atau pertanyaan baru, klik tombol Tulis
                            Diskusi di bagian pojok kiri atas.</li>
                        <li>Membaca Pesan: Perhatikan isi pesan yang dikirimkan oleh guru atau teman Anda; setiap pesan
                            menampilkan nama pengirim serta waktu pengirimannya untuk memudahkan pelacakan percakapan.
                        </li>

                        <li>Mencari Pembahasan: Gunakan kotak Cari... di bagian kanan atas untuk menemukan kembali kata
                            kunci atau topik tertentu yang pernah dibahas sebelumnya.</li>

                        <li> Berbagi Temuan: Sampaikan argumen atau solusi Anda di forum ini dengan merujuk pada hasil
                            Observasi yang telah Anda lakukan di tahap sebelumnya agar diskusi menjadi lebih berbobot.
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
                        <li>Membuat Aktivitas Baru: Klik tombol Tambah TTS untuk mulai menyusun tantangan teka-teki baru
                            bagi siswa. </li>

                        <li> Menyesuaikan Konten: Gunakan tombol Ubah (ikon pensil) untuk menyesuaikan pertanyaan atau
                            ukuran Grid agar sesuai dengan tujuan pembelajaran. </li>

                        <li>Manajemen Daftar: Jika sebuah aktivitas sudah tidak relevan atau ingin diganti, gunakan
                            tombol Hapus (ikon merah) untuk membersihkan daftar.

                        <li>Pencarian Cepat: Gunakan kolom Cari... untuk memantau atau mengelola topik TTS tertentu yang
                            telah Anda buat sebelumnya. </li>

                        <li>Pemantauan: Gunakan hasil pengerjaan siswa untuk memantau sejauh mana mereka memahami
                            istilah-istilah kunci dalam materi. </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Penjelasan Fitur -->
        <?php if ($is_admin_or_guru): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Kuis
            </h6>
            <ul class="small mb-0">
                <li>
                    <strong>Tambah TTS</strong>
                    Tombol khusus bagi guru untuk membuat instrumen evaluasi TTS baru guna mendukung
                    pemecahan masalah atau analisis konsep.
                </li>
                <li>
                    <strong>Judul & Deskripsi</strong>
                    Menjelaskan fokus TTS dan tujuan TTS.
                </li>
                <li>
                    <strong>Daftar TTS</strong>
                    Menampilkan seluruh instrumen TTS yang telah dibuat oleh guru untuk kelas tersebut.
                </li>
                <li>
                    <strong>Detail:</strong>
                    Digunakan oleh siswa untuk membuka dan mengerjakan soal sesuai instruksi, atau oleh guru
                    untuk meninjau isi TTS.
                </li>
                <li>
                    <strong>Ubah (Ikon Pensil):</strong>
                    Memungkinkan guru untuk menyunting konten TTS agar tetap relevan dengan tujuan
                    pembelajaran.
                </li>
                <li>
                    <strong>Hapus (Ikon Tempat Sampah):</strong>
                    Fasilitas untuk mengelola daftar dengan menghapus
                    instrumen yang sudah
                    tidak diperlukan.
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($url_name == 'siswa'): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Kuis
            </h6>
            <ul class="small mb-0">
                <li>Mengakses Forum: Pilih menu Forum Diskusi dan klik tombol Detail pada topik yang ingin Anda ikuti
                    untuk
                    masuk ke ruang percakapan.</li>

                <li>Memulai Percakapan Baru: Klik tombol Tulis Diskusi yang berwarna biru di pojok kiri atas jika Anda
                    ingin
                    membuat topik atau pertanyaan baru untuk dibahas bersama kelompok.
                </li>

                <li>Memulai Percakapan Baru: Klik tombol Tulis Diskusi yang berwarna biru di pojok kiri atas jika Anda
                    ingin
                    membuat topik atau pertanyaan baru untuk dibahas bersama kelompok.
                </li>

                <li>Membaca Pesan: Cermati setiap pesan yang dikirim oleh anggota kelompok atau guru, yang dilengkapi
                    dengan
                    identitas pengirim dan waktu pengiriman pesan.
                </li>
                <li>Mencari Topik Spesifik: Gunakan kolom Cari... di pojok kanan atas untuk menemukan pesan atau kata
                    kunci
                    tertentu dalam riwayat diskusi yang sudah panjang.
                </li>
                <li>Berdiskusi Secara Aktif: Sampaikan argumen, tanggapan, atau solusi Anda berdasarkan data yang telah
                    Anda
                    kumpulkan pada tahap observasi sebelumnya.
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong>
            Tahap ini adalah ruang untuk berbagi temuan dan membangun argumen bersama. Fokus utama bukan hanya pada
            jawaban benar, melainkan pada proses komunikasi dua arah untuk memecahkan masalah secara kelompok.
        </div>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>
</div>