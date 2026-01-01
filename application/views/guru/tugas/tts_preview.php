  <style>
    .tts-grid {
      display: grid;
      grid-template-columns: repeat(<?= $tts->grid_size ?>, 35px);
      gap: 2px;
      justify-content: center;
      margin-bottom: 25px;
    }
  .tts-cell-wrapper {
    position: relative;
  }
  .tts-cell {
    width: 35px;
    height: 35px;
    text-align: center;
    font-weight: bold;
    border: 1px solid #bbb;
    text-transform: uppercase;
  }
  .tts-number {
    position: absolute;
    top: 2px;
    left: 3px;
    font-size: 10px;
    color: #555;
    font-weight: bold;
    pointer-events: none;
  }

    .tts-cell.filled { background: #fff; }
    .tts-cell.disabled { background: #ddd; }
    .tts-cell.correct { background: #c8e6c9 !important; }   /* hijau */
    .tts-cell.wrong { background: #ffcdd2 !important; }     /* merah */

  </style>

<div class="container py-5">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary"><?= $tts->judul; ?></h3>
    <p class="text-muted"><?= $tts->deskripsi; ?></p>
  </div>

  <div id="ttsGrid" class="tts-grid"></div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="mb-3">🧩 Daftar Pertanyaan</h5>
      <ul class="list-group">
        <?php foreach ($questions as $q): ?>
          <li class="list-group-item">
            <b><?= $q->nomor; ?>. <?= ucfirst($q->arah); ?></b> — <?= $q->pertanyaan; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="text-center mt-4">
    <button class="btn btn-success" id="cekJawaban">Periksa Jawaban</button>
    <a href="<?= base_url('guru/tugas/tts_interaktif'); ?>" class="btn btn-secondary">Kembali</a>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
const gridSize = <?= $tts->grid_size ?>;
const pertanyaan = <?= json_encode($questions) ?>;
const gridContainer = document.getElementById('ttsGrid');

// ====== Buat Grid Kosong ======
// === Buat Grid Kosong ===
let grid = [];
for (let y = 0; y < gridSize; y++) {
  grid[y] = [];
  for (let x = 0; x < gridSize; x++) {
    const wrapper = document.createElement('div');
    wrapper.classList.add('tts-cell-wrapper');

    const input = document.createElement('input');
    input.maxLength = 1;
    input.classList.add('tts-cell', 'disabled');
    input.disabled = true;

    wrapper.appendChild(input);
    gridContainer.appendChild(wrapper);
    grid[y][x] = input;
  }
}


// ====== Tempatkan Soal Secara Otomatis ======
// (Guru tidak perlu koordinat manual)
let nextRowMendatar = 0;
let nextColMenurun = 0;

pertanyaan.forEach(q => {
  const answer = q.jawaban.trim().split('');
  let startX = 0, startY = 0;

  if (q.arah === 'mendatar') {
    startY = nextRowMendatar++;
    startX = 0;
  } else {
    startX = nextColMenurun++;
    startY = 0;
  }

  for (let i = 0; i < answer.length; i++) {
    const x = (q.arah === 'mendatar') ? startX + i : startX;
    const y = (q.arah === 'mendatar') ? startY : startY + i;
    const cell = grid[y]?.[x];
    if (!cell) continue;

    cell.classList.add('filled');
    cell.classList.remove('disabled');
    cell.disabled = false;
    cell.dataset.qid = q.id; // untuk mengelompokkan cell berdasarkan pertanyaan

    // Tambah nomor di kotak pertama
    if (i === 0) {
  const numberLabel = document.createElement('span');
  numberLabel.classList.add('tts-number');
  numberLabel.textContent = q.nomor;
  cell.parentElement.appendChild(numberLabel);
}


    // Huruf petunjuk: huruf pertama atau terakhir
    if (i === 0 || i === answer.length - 1) {
      cell.value = answer[i];
      cell.readOnly = true;
      cell.style.backgroundColor = "#f8f9fa";
    }

    // Reset warna jika user mengetik
    cell.addEventListener('input', () => {
      cell.classList.remove('correct', 'wrong');
    });
  }
});

// ====== Fungsi Cek Jawaban Dinamis ======
document.getElementById('cekJawaban').addEventListener('click', () => {
  pertanyaan.forEach(q => {
    const answer = q.jawaban.trim().toUpperCase().split('');
    let collected = [];

    // Ambil semua cell yang punya data qid sesuai pertanyaan ini
    const cells = Array.from(document.querySelectorAll(`[data-qid="${q.id}"]`));
    if (cells.length === 0) return;

    // Susun jawaban dari user
    cells.forEach(cell => {
      collected.push(cell.value ? cell.value.toUpperCase() : '_');
    });

    const userAnswer = collected.join('');
    const isCorrect = userAnswer === q.jawaban.toUpperCase();

    // Update warna dinamis
    cells.forEach(cell => {
      cell.classList.remove('correct', 'wrong');
      if (isCorrect) {
        cell.classList.add('correct');
      } else {
        // jika ada perbedaan karakter, beri warna merah
        cell.classList.add('wrong');
      }
    });
  });
});
</script>
