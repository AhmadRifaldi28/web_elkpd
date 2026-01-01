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
  .tts-cell.correct { background: #c8e6c9 !important; }
  .tts-cell.wrong { background: #ffcdd2 !important; }

  .tts-cell-wrapper.selected {
    outline: 2px solid #007bff;
    border-radius: 3px;
  }

</style>

<div class="container py-5">
  <div class="mb-4">
    <a href="<?= base_url('guru/tugas/tts_interaktif'); ?>" class="btn btn-secondary btn-sm mb-3">← Kembali</a>
    <h3 class="fw-bold text-primary mb-1"><?= $tts->judul; ?></h3>
    <p class="text-muted"><?= $tts->deskripsi; ?></p>
  </div>

  <!-- ==================== FORM TAMBAH (NON-MODAL, DI ATAS GRID) ==================== -->
<div class="card shadow-sm mb-4" id="cardTambahPertanyaan" style="display:none;">
  <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
    <span>➕ Tambah Pertanyaan Baru</span>
    <button type="button" id="btnTutupForm" class="btn btn-light btn-sm">Tutup ✖</button>
  </div>
  <div class="card-body">
    <form id="formTambahPertanyaan">
      <input type="hidden" name="tts_id" value="<?= $tts->id; ?>">

      <div class="row mb-3">
        <div class="col-md-3">
          <label class="form-label">Nomor Soal</label>
          <input type="number" name="nomor" class="form-control" min="1" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Arah Soal</label>
          <select name="arah" class="form-select" required>
            <option value="">-- Pilih Arah --</option>
            <option value="mendatar">Mendatar</option>
            <option value="menurun">Menurun</option>
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label">Jawaban</label>
          <input type="text" name="jawaban" class="form-control text-uppercase" required>
          <small class="text-muted">Huruf otomatis menjadi huruf besar.</small>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Pertanyaan</label>
        <textarea name="pertanyaan" class="form-control" rows="2" required></textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Posisi X (Kolom)</label>
          <input type="number" name="start_x" id="inputX" class="form-control"  placeholder="Klik grid untuk memilih" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Posisi Y (Baris)</label>
          <input type="number" name="start_y" id="inputY" class="form-control"  placeholder="Klik grid untuk memilih" required>
        </div>
      </div>

      <p class="text-muted small mb-3">
        Klik sel pada grid untuk memilih posisi awal huruf (koordinat otomatis terisi).
      </p>

      <div class="text-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-primary">💾 Simpan Pertanyaan</button>
      </div>
    </form>
  </div>
</div>


  <!-- ==================== PREVIEW TTS GRID ==================== -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-bold">Preview Kotak TTS</div>
    <div class="card-body text-center">
      <div id="ttsGrid" class="tts-grid"></div>
      <button class="btn btn-success mt-3" id="cekJawaban">Periksa Jawaban</button>
    </div>
  </div>

  <!-- ==================== DAFTAR PERTANYAAN ==================== -->
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <span>Daftar Pertanyaan</span>
      <!-- <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPertanyaan">+ Tambah Pertanyaan</button> -->
      <button class="btn btn-light btn-sm" id="btnTambahPertanyaan">+ Tambah Pertanyaan</button>

    </div>
    <div class="card-body">
      <table class="table table-bordered align-middle text-center" id="tablePertanyaan">
        <thead class="table-light">
          <tr>
            <th width="5%">No</th>
            <th>Arah</th>
            <th>Pertanyaan</th>
            <th>Jawaban</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
  // === Toggle Form Tambah Pertanyaan ===
$('#btnTambahPertanyaan').on('click', function() {
  $('#cardTambahPertanyaan').slideToggle(200);
});

$('#btnTutupForm').on('click', function() {
  $('#cardTambahPertanyaan').slideUp(200);
});


  $(document).ready(function() {
    const tts_id = <?= $tts->id ?>;
    const gridSize = <?= $tts->grid_size ?>;
    const gridContainer = document.getElementById('ttsGrid');
    let grid = [];
    let placements = {};

  // ==================== LOAD & RENDER ====================
  function loadPertanyaan() {
    $.ajax({
      url: "<?= base_url('guru/tugas/get_questions/'); ?>" + tts_id,
      type: "GET",
      dataType: "json",
      success: function(data) {
        let rows = '';
        if (data.length === 0) {
          rows = '<tr><td colspan="5" class="text-muted">Belum ada pertanyaan.</td></tr>';
        } else {
          $.each(data, function(i, q) {
            rows += `
            <tr>
            <td>${q.nomor}</td>
            <td>${q.arah}</td>
            <td class="text-start">${q.pertanyaan}</td>
            <td><b>${q.jawaban}</b></td>
            <td>
            <button class="btn btn-sm btn-danger btnHapus" data-id="${q.id}">🗑️</button>
            </td>
            </tr>`;
          });
        }
        $('#tablePertanyaan tbody').html(rows);
        renderGrid(data);
      }
    });
  }

  // ==================== TAMBAH DATA ====================
  $('#formTambahPertanyaan').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= base_url('guru/tugas/store_question'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        if (res.status === 'success') {
          Swal.fire('Berhasil!', 'Pertanyaan berhasil ditambahkan.', 'success');
          $('#modalTambahPertanyaan').modal('hide');
          $('#formTambahPertanyaan')[0].reset();
          clearHighlight();
          loadPertanyaan();
        } else {
          Swal.fire('Gagal!', res.message ?? 'Terjadi kesalahan.', 'error');
        }
      }
    });
  });

  // ==================== HAPUS DATA ====================
  $(document).on('click', '.btnHapus', function() {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Hapus pertanyaan ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Ya, hapus!'
    }).then(result => {
      if (result.isConfirmed) {
        $.post("<?= base_url('guru/tugas/delete_question/'); ?>" + id, res => {
          loadPertanyaan();
          Swal.fire('Dihapus!', 'Pertanyaan berhasil dihapus.', 'success');
        }, 'json');
      }
    });
  });

  // ==================== RENDER GRID ====================
  function renderGrid(questions) {
    gridContainer.innerHTML = '';
    placements = {};
    grid = [];

    for (let y = 0; y < gridSize; y++) {
      grid[y] = [];
      for (let x = 0; x < gridSize; x++) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('tts-cell-wrapper');
        wrapper.dataset.x = x;
        wrapper.dataset.y = y;

        const input = document.createElement('input');
        input.type = 'text';
        input.maxLength = 1;
        input.classList.add('tts-cell', 'disabled');
        input.disabled = true;

        // Klik sel → update koordinat form
        wrapper.addEventListener('click', () => {
          clearHighlight();
          wrapper.classList.add('selected');
          $('#inputX').val(x);
          $('#inputY').val(y);
        });

        wrapper.appendChild(input);
        gridContainer.appendChild(wrapper);
        grid[y][x] = input;
      }
    }

    // Tampilkan pertanyaan yang sudah ada
    questions.forEach(q => {
      const ans = q.jawaban.trim().toUpperCase();
      const letters = ans.split('');
      const startX = parseInt(q.start_x);
      const startY = parseInt(q.start_y);

      placements[q.id] = [];

      for (let i = 0; i < letters.length; i++) {
        const x = (q.arah === 'mendatar') ? startX + i : startX;
        const y = (q.arah === 'mendatar') ? startY : startY + i;
        const cell = grid[y] && grid[y][x];
        if (!cell) continue;

        cell.classList.add('filled');
        cell.classList.remove('disabled');
        cell.disabled = false;
        placements[q.id].push(cell);

        if (i === 0) {
          const label = document.createElement('span');
          label.classList.add('tts-number');
          label.textContent = q.nomor;
          cell.parentElement.appendChild(label);
        }

        // Petunjuk awal & akhir
        if (i === 0 || i === letters.length - 1) {
          cell.value = letters[i];
          cell.readOnly = true;
          cell.style.backgroundColor = "#f8f9fa";
        }

        cell.addEventListener('input', () => {
          cell.value = cell.value.toUpperCase();
          cell.classList.remove('correct', 'wrong');
        });
      }
    });
  }

  // ==================== HIGHLIGHT KOORDINAT MANUAL ====================
  function clearHighlight() {
    $('.tts-cell-wrapper').removeClass('selected');
  }

  function highlightCoord(x, y) {
    clearHighlight();
    const target = $(`.tts-cell-wrapper[data-x="${x}"][data-y="${y}"]`);
    if (target.length > 0) {
      target.addClass('selected');
    }
  }

  // Jika guru mengisi koordinat manual → sorot otomatis
  $('#inputX, #inputY').on('input', function() {
    const x = parseInt($('#inputX').val());
    const y = parseInt($('#inputY').val());
    if (!isNaN(x) && !isNaN(y) && x >= 0 && y >= 0 && x < gridSize && y < gridSize) {
      highlightCoord(x, y);
    } else {
      clearHighlight();
    }
  });

  // ==================== CEK JAWABAN ====================
  $('#cekJawaban').on('click', () => {
    $.ajax({
      url: "<?= base_url('guru/tugas/get_questions/'); ?>" + tts_id,
      dataType: 'json',
      success: function(data) {
        data.forEach(q => {
          const ans = q.jawaban.trim().toUpperCase();
          const cells = placements[q.id] || [];
          const userAnswer = cells.map(c => (c.value || '').toUpperCase()).join('');
          const isCorrect = userAnswer === ans;
          cells.forEach(c => {
            c.classList.remove('correct', 'wrong');
            c.classList.add(isCorrect ? 'correct' : 'wrong');
          });
        });
      }
    });
  });

  // Inisialisasi pertama
  loadPertanyaan();
});
</script>

