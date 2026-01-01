<!-- ===== PANDUAN DETAIL DISKUSI ===== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="m-0 fw-bold text-primary">
            <i class="bi bi-chat-dots"></i> Panduan Fitur Orientasi
        </h6>
    </div>
    <div class="card-body">

        <p class="mb-3">
            Tahap ini bertujuan untuk membantu siswa memahami
            <strong>permasalahan nyata</strong> sebagai dasar pembelajaran.
        </p>

        <div class="row">
            <!-- Panduan Siswa -->
            <div class="col-md-6 mb-3">
                <div class="border rounded p-3 h-100">
                    <h6 class="fw-bold text-success mb-2">
                        <i class="bi bi-person"></i> Panduan untuk Siswa
                    </h6>
                    <ul class="small mb-0">
                        <li class="mb-2">Masuk ke kelas: "Akses ruang kelas digital Anda dengan memilih kelas yang
                            aktif melalui menu Dashboard."</li>
                        <li class="mb-2">Baca judul & refleksi: "Cermati Judul Skenario dan jawablah Pertanyaan
                            Refleksi Awal untuk memetakan pemahaman awal Anda.</li>
                        <li class="mb-2">Pelajari materi: "Buka dan pelajari Materi Pendukung (modul, video, atau
                            artikel) yang telah disediakan sebagai bekal pengerjaan."</li>
                        <li class="mb-2">Pahami masalah: "Pastikan Anda telah memahami inti permasalahan dalam
                            skenario sebelum menekan tombol Lanjut ke Tahap Berikutnya."</li>
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
                        <li class="mb-2">Tambahkan skenario: "Susun dan masukkan Skenario Masalah yang relevan dengan
                            topik pembelajaran pada kolom yang tersedia.</li>
                        <li class="mb-2">Tulis refleksi: "Buatlah Pertanyaan Pemantik (Refleksi) untuk memicu rasa
                            ingin tahu dan mengukur kesiapan awal siswa.</li>
                        <li class="mb-2">Unggah materi: "Lengkapi pembelajaran dengan mengunggah Materi Pendukung
                            (file PDF/Link) jika diperlukan.</li>
                        <li class="mb-2">Pastikan kesiapan: "Periksa kembali seluruh isi skenario; pastikan semua
                            informasi sudah lengkap dan benar sebelum membuka akses ke Tahap 2.</li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Penjelasan Fitur -->
        <?php if ($is_admin_or_guru): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Orientasi
            </h6>
            <ul class="small mb-0">
                <li>
                    <strong>Daftar Skenario Masalah</strong><br>
                    Menampilkan seluruh skenario PBL yang disiapkan oleh guru sebagai pemantik pembelajaran.
                </li>
                <li>
                    <strong>Kolom Judul & Refleksi Awal</strong><br>
                    Memberikan gambaran awal permasalahan untuk membantu siswa memahami konteks.
                </li>
                <li>
                    <strong>Tombol "Lihat"</strong><br>
                    Digunakan untuk membuka materi atau penjelasan lengkap dari skenario masalah.
                </li>
                <li>
                    <strong>Tombol "Tambah Skenario"</strong><br>
                    Digunakan guru untuk menambahkan skenario baru sesuai tujuan pembelajaran.
                </li>
                <li>
                    <strong>Pencarian & Jumlah Data</strong><br>
                    Memudahkan pengguna menemukan dan mengelola skenario.
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($url_name == 'siswa'): ?>
        <div class="mt-3">
            <h6 class="fw-bold text-secondary mb-2">
                <i class="bi bi-gear"></i> Penjelasan Fitur pada Halaman Orientasi Siswa
            </h6>
            <ul class="small mb-0">

                <li><strong>Panduan Tahap 1:</strong><br>
                    Tombol instruksional ini memberikan arahan langkah demi
                    langkah
                    agar Anda memahami
                    cara efektif dalam mengerjakan aktivitas di tahap orientasi masalah ini.</li>

                <li><strong>Langkah Penggunaan Simpel:</strong><br>
                    Cermati Judul: Baca judul skenario masalah yang tersedia pada tabel.<br>

                    Baca Refleksi: Pahami pernyataan pada kolom "Refleksi Awal" sebagai bekal cara berpikir Anda.
                    <br>
                    Pelajari Materi: Gunakan tombol Lihat untuk mempelajari materi pendukung sebelum Anda melanjutkan ke
                    tahap berikutnya.<br>
                </li>
                <li><strong>Materi Pembelajaran:</strong><br>
                    Klik tombol Lihat untuk mengakses materi pendukung yang relevan dengan skenario tersebut.
                    <br>
                    Materi dapat berupa dokumen (PDF) maupun gambar (JPG) yang disiapkan untuk membantu Anda mencapai
                    kompetensi pembelajaran.
                </li>

                <li><strong>Lanjut ke Tahap Berikutnya:</strong><br> Setelah memahami konteks masalah secara utuh, Anda
                    dapat beralih ke
                    aktivitas interaktif lainnya.</li>
            </ul>
        </div>
        <?php endif; ?>

        <div class="alert alert-info small mt-3 mb-0">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong>
            Tahap ini tidak menuntut jawaban akhir, fokus pada
            <strong>pemahaman masalah</strong> dan <strong>konteks pembelajaran</strong>.
        </div>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>
</div>