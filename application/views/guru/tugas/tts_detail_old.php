<link href="<?= base_url('assets/css/simple-datatables.css') ?>" rel="stylesheet">

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
</style>

<div class="container py-5">
  <div class="mb-4">
    <a href="<?= base_url('guru/tugas/tts_interaktif'); ?>" class="btn btn-secondary btn-sm mb-3">← Kembali</a>
    <h3 class="fw-bold text-primary mb-1"><?= $tts->judul; ?></h3>
    <p class="text-muted"><?= $tts->deskripsi; ?></p>
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
      <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPertanyaan">+ Tambah Pertanyaan</button>
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

<!-- ==================== MODAL TAMBAH ==================== -->
<div class="modal fade" id="modalTambahPertanyaan" tabindex="-1">
  <div class="modal-dialog">
    <form id="formTambahPertanyaan">
      <input type="hidden" name="tts_id" value="<?= $tts->id; ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pertanyaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Arah Soal</label>
            <select name="arah" class="form-select" required>
              <option value="">-- Pilih Arah --</option>
              <option value="mendatar">Mendatar</option>
              <option value="menurun">Menurun</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Pertanyaan</label>
            <textarea name="pertanyaan" class="form-control" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label>Jawaban</label>
            <input type="text" name="jawaban" class="form-control text-uppercase" required>
            <small class="text-muted">Jawaban otomatis diubah menjadi huruf besar.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/simple-datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>

<script>
$(document).ready(function() {
  const tts_id = <?= $tts->id ?>;
  const gridSize = <?= $tts->grid_size ?>;
  const gridContainer = document.getElementById('ttsGrid');
  // akan diisi saat renderGrid
  let placements = {}; // placements[questionId] = [{el: HTMLInputElement, index: Number}, ...]

  // ====== LOAD PERTANYAAN & RENDER ======
  function loadPertanyaan() {
    $.ajax({
      url: "<?= base_url('guru/tugas/get_questions/'); ?>" + tts_id,
      type: "GET",
      dataType: "json",
      success: function(data) {
        // render table
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
                  <button class="btn btn-sm btnHapus" data-id="${q.id}">🗑️</button>
                </td>
              </tr>`;
          });
        }
        $('#tablePertanyaan tbody').html(rows);

        // render preview grid (dan isi placements)
        renderGrid(data);
      }
    });
  }

  // ====== TAMBAH PERTANYAAN VIA AJAX ======
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
          loadPertanyaan();
        } else {
          Swal.fire('Gagal!', res.message ?? 'Terjadi kesalahan.', 'error');
        }
      }
    });
  });

  // ====== HAPUS PERTANYAAN ======
  $(document).on('click', '.btnHapus', function() {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Hapus pertanyaan ini?',
      text: 'Data tidak dapat dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url('guru/tugas/delete_question/'); ?>" + id,
          type: "POST",
          dataType: "json",
          success: function(res) {
            if (res.status === 'success') {
              Swal.fire('Terhapus!', 'Pertanyaan berhasil dihapus.', 'success');
              loadPertanyaan();
            } else {
              Swal.fire('Gagal!', 'Tidak dapat menghapus data.', 'error');
            }
          }
        });
      }
    });
  });

  // ====== RENDER GRID DENGAN PLACEMENTS ======
  function renderGrid(questions) {
    // reset placements
    placements = {};
    // kosongkan container
    gridContainer.innerHTML = '';

    // buat grid DOM (row-major)
    const wrappers = []; // optional if need refs
    let grid = [];
    for (let y = 0; y < gridSize; y++) {
      grid[y] = [];
      for (let x = 0; x < gridSize; x++) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('tts-cell-wrapper');

        const input = document.createElement('input');
        input.type = 'text';
        input.maxLength = 1;
        input.value = '';
        input.classList.add('tts-cell', 'disabled');
        input.disabled = true;

        wrapper.appendChild(input);
        gridContainer.appendChild(wrapper);

        grid[y][x] = input;
        wrappers.push(wrapper);
      }
    }

    // counters untuk peletakan otomatis
    let nextRowMendatar = 0;
    let nextColMenurun = 0;

    // letakkan kata satu per satu, simpan placement
    questions.forEach(q => {
      const qid = q.id;
      const answer = String(q.jawaban || '').trim().toUpperCase();
      const letters = answer.split('');
      let startX = 0, startY = 0;

      if (q.arah === 'mendatar') {
        startY = nextRowMendatar++;
        startX = 0;
      } else { // menurun
        startX = nextColMenurun++;
        startY = 0;
      }

      // pastikan array placements ada
      placements[qid] = placements[qid] || [];

      for (let i = 0; i < letters.length; i++) {
        const x = (q.arah === 'mendatar') ? startX + i : startX;
        const y = (q.arah === 'mendatar') ? startY : startY + i;
        const cell = grid[y] && grid[y][x];
        if (!cell) continue;

        // aktifkan cell
        cell.classList.add('filled');
        cell.classList.remove('disabled');
        cell.disabled = false;

        // simpan referensi sel untuk pertanyaan ini (bisa jadi sel sama untuk beberapa q)
        placements[qid].push({ el: cell, index: i });

        // nomor pertanyaan di sel pertama (jika belum ada)
        if (i === 0) {
          const existing = cell.parentElement.querySelector('.tts-number');
          if (!existing) {
            const numberLabel = document.createElement('span');
            numberLabel.classList.add('tts-number');
            numberLabel.textContent = q.nomor;
            cell.parentElement.appendChild(numberLabel);
          }
        }

        // huruf petunjuk: pertama / terakhir -> isi & kunci
        if (i === 0 || i === letters.length - 1) {
          // jika sudah ada nilai petunjuk yang berbeda, tetap gunakan letter (harus cocok antar kata)
          cell.value = letters[i];
          cell.readOnly = true;
          cell.style.backgroundColor = "#f8f9fa";
        } else {
          // kosongkan non-petunjuk
          // only clear if not readOnly (to avoid overwriting petunjuk from intersecting word)
          if (!cell.readOnly) cell.value = '';
          cell.readOnly = false;
          cell.style.backgroundColor = '';
        }

        // reset warna saat user mengetik
        cell.addEventListener('input', () => {
          cell.classList.remove('correct', 'wrong');
          // convert to uppercase automatically
          cell.value = (cell.value || '').toUpperCase();
        });
      }
    });

    // setelah semua placements dibuat, tambahkan event cek jawaban
    $('#cekJawaban').off('click').on('click', function() {
      // untuk setiap pertanyaan, ambil placements[qid], urutkan berdasarkan index lalu bandingkan
      questions.forEach(q => {
        const qid = q.id;
        const answer = String(q.jawaban || '').trim().toUpperCase();

        const place = placements[qid] || [];
        if (place.length === 0) return; // no cells

        // urutkan berdasarkan index numeric (safety)
        place.sort((a, b) => (a.index - b.index));

        // ambil nilai user sesuai urutan
        const userArr = place.map(p => {
          const v = (p.el.value || '').toUpperCase();
          return v; // empty string allowed
        });

        const userAnswer = userArr.join('');

        // benar jika persis sama dengan answer
        const isCorrect = userAnswer === answer;

        // beri warna pada sel-sel milik kata ini
        place.forEach(p => {
          p.el.classList.remove('correct', 'wrong');
          if (isCorrect) p.el.classList.add('correct');
          else p.el.classList.add('wrong');
        });
      });
    });
  }

  // initial load
  loadPertanyaan();
});
</script>

