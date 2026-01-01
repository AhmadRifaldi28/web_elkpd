<style>
    .tts-grid {
        display: grid;
        grid-template-columns: repeat(<?= $tts->grid_size ?>, 30px);
        grid-gap: 2px;
        justify-content: center;
    }

    .cell {
        width: 30px;
        height: 30px;
        border: 1px solid #ccc;
        text-align: center;
        text-transform: uppercase;
    }

    .filled {
        background: #f9f9f9;
    }
</style>

<div class="container mt-4">
    <h4><?= $tts->judul ?></h4>
    <p><?= $tts->deskripsi ?></p>

    <form action="<?= site_url('siswa/Tugas/submit_jawaban') ?>" method="post" id="ttsForm">
        <input type="hidden" name="tts_id" value="<?= $tts->id ?>">

        <div class="tts-grid" id="grid"></div>

        <h5 class="mt-4">Pertanyaan</h5>
        <ul>
            <?php foreach ($questions as $q): ?>
                <li><b><?= $q->nomor ?> (<?= ucfirst($q->arah) ?>):</b> <?= $q->pertanyaan ?></li>
            <?php endforeach; ?>
        </ul>

        <button type="submit" class="btn btn-success mt-3">Kirim Jawaban</button>
    </form>
</div>

<script>
    const gridSize = <?= $tts->grid_size ?>;
    const questions = <?= json_encode($questions) ?>;
    const grid = document.getElementById('grid');

    // Buat grid kosong
    const cells = [];
    for (let i = 0; i < gridSize * gridSize; i++) {
        const cell = document.createElement('input');
        cell.maxLength = 1;
        cell.classList.add('cell');
        grid.appendChild(cell);
        cells.push(cell);
    }

    // Tampilkan posisi huruf berdasarkan soal
    questions.forEach(q => {
        let x = parseInt(q.start_x);
        let y = parseInt(q.start_y);
        const jawabanLength = q.jawaban.length;

        for (let i = 0; i < jawabanLength; i++) {
            const index = y * gridSize + x;
            const c = cells[index];
            if (c) c.classList.add('filled');

            if (q.arah === 'mendatar') x++;
            else if (q.arah === 'menurun') y++;
        }
    });

    // Saat submit, ambil jawaban setiap nomor
    document.getElementById('ttsForm').addEventListener('submit', e => {
        e.preventDefault();

        const answers = {};
        questions.forEach(q => {
            let x = parseInt(q.start_x);
            let y = parseInt(q.start_y);
            let text = '';

            for (let i = 0; i < q.jawaban.length; i++) {
                const index = y * gridSize + x;
                const val = cells[index].value.toUpperCase() || '-';
                text += val;
                if (q.arah === 'mendatar') x++;
                else y++;
            }
            answers[q.nomor + '_' + q.arah] = text;
        });

        // Buat form data
        const form = e.target;
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'jawaban';
        input.value = JSON.stringify(answers);
        form.appendChild(input);
        form.submit();
    });
</script>