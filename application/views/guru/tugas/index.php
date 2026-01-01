<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Aktivitas Interaktif Tahap 2</h2>
        <p class="text-muted">Silakan pilih aktivitas yang ingin dibuat atau dikerjakan.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Card TTS -->
        <div class="col-md-5">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 mb-3">🧠</div>
                    <h5 class="card-title fw-bold">Teka-Teki Silang</h5>
                    <p class="text-muted">Buat atau kerjakan TTS tentang konsep dasar masalah.</p>
                    <a href="<?= base_url('guru/tugas/tts_interaktif'); ?>" class="btn btn-primary w-100">
                        Buka TTS
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Kuis Esai -->
        <div class="col-md-5">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 mb-3">✏️</div>
                    <h5 class="card-title fw-bold">Kuis Esai</h5>
                    <p class="text-muted">Buat atau kerjakan kuis pemahaman dasar dalam bentuk esai.</p>
                    <a href="<?= base_url('guru/tugas/kuis'); ?>" class="btn btn-success w-100">
                        Buka Kuis Esai
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>