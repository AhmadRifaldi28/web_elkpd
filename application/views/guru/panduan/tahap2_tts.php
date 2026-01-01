<!-- ===== PANDUAN DETAIL DISKUSI ===== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="m-0 fw-bold text-primary">
            <i class="bi bi-chat-dots"></i> Panduan Fitur Teka-Teki Silang
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
            Halaman ini merupakan ruang aktivitas interaktif tempat Anda menguji pemahaman konsep melalui permainan
            teka-teki silang.
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
                        <li>Tampilan Kotak TTS: Di sisi kiri halaman, terdapat kotak-kotak TTS yang harus Anda isi
                            dengan
                            huruf-huruf yang tepat sesuai dengan pertanyaan yang diberikan.
                        </li>

                        <li>Daftar Pertanyaan: Di sisi kanan, terdapat daftar pertanyaan yang dibagi menjadi dua
                            kategori
                            utama:<br>
                            Mendatar: Pertanyaan untuk kata yang ditulis menyamping secara horizontal.

                            Menurun: Pertanyaan untuk kata yang ditulis mengarah ke bawah secara vertikal.
                        </li>
                        <li>Cara Mengisi: Anda cukup mengeklik pada kotak yang ingin diisi, lalu ketikkan huruf yang
                            sesuai
                            dengan jawaban dari pertanyaan mendatar atau menurun tersebut.
                        </li>
                        <li>Mengirim Jawaban: Setelah seluruh kotak terisi dan Anda merasa yakin dengan jawaban
                            tersebut,
                            klik tombol Kirim Jawaban yang berwarna hijau di bagian bawah untuk menyimpannya ke sistem.
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
        </div>
        <?php endif; ?>

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
                    <strong>Daftar TTS</strong>
                    Menampilkan seluruh instrumen TTS yang telah dibuat oleh guru untuk kelas tersebut.
                </li>
                <li>
                    <strong>Tambah Pertanyaan:</strong>
                    Guru dapat menambahkan butir soal baru ke dalam grid TTS dengan mengisi detail pada
                    jendela pop-up.
                </li>

                <li><strong>Pengaturan Nomor & Arah:</strong>
                    Guru menentukan nomor urut soal dan memilih arah jawaban, apakah Mendatar atau
                    Menurun, untuk membentuk kerangka teka-teki.</li>

                <li><strong>Input Pertanyaan & Jawaban:</strong>
                    Tersedia kolom khusus untuk menuliskan narasi pertanyaan dan kunci jawaban
                    yang harus diisi oleh siswa nantinya.</li>

                <li><strong>Penentuan Koordinat Grid:</strong>
                    Guru dapat mengatur posisi huruf pertama jawaban secara akurat dengan
                    memasukkan nilai Koordinat X (Kolom) dan Koordinat Y (Baris) pada grid.</li>

                <li><strong>Visualisasi Grid Otomatis:</strong>
                    Sistem menyediakan pratampilan kotak-kotak TTS yang akan terisi secara
                    otomatis sesuai dengan koordinat dan arah yang telah diatur oleh Guru.
                </li>

                <li><strong>Simpan & Batal:</strong>
                    Guru dapat membatalkan pengaturan atau menyimpan butir pertanyaan yang telah disusun
                    agar muncul dalam daftar aktivitas siswa.</li>

                <li>
                    <strong>Detail:</strong>
                    Digunakan oleh guru untuk membuka atau menambah isi tts,dan
                    untuk meninjau isi TTS.
                </li>
                <li>
                    <strong>Ubah:</strong>
                    Memungkinkan guru untuk menyunting konten TTS agar tetap relevan dengan tujuan
                    pembelajaran.
                </li>
                <li>
                    <strong>Hapus:</strong>
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
                <li>Pilih Topik: Pada halaman Daftar TTS, pilih judul yang sesuai lalu klik tombol Detail.</li>

                <li>Baca Petunjuk: Cermati pertanyaan pada kolom Mendatar dan Menurun.</li>

                <li>Isi Kotak: Klik pada kotak di papan TTS dan ketikkan huruf-huruf yang membentuk kata jawaban
                    yang dianggap benar.</li>

                <li>Finalisasi: Setelah semua kotak terisi, klik tombol Kirim Jawaban untuk menyelesaikan aktivitas.
                </li>
            </ul>
        </div>
        <?php endif; ?>
        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong>
            Tahap ini tidak menuntut jawaban akhir yang sempurna, melainkan berfokus pada penguasaan istilah kunci dan
            pemahaman konteks pembelajaran melalui pengenalan konsep secara interaktif.
        </div>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>
</div>