<div class="pagetitle">
  <!-- <h1>Dashboard</h1> -->
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Admin</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">

<div class="row">

<!-- </?php var_dump ($students_school);
die(); ?> -->
<!-- INFO BOX -->
<?php
$cards = [
  ['Sekolah', $total_schools, 'bi-building', 'primary'],
  ['Guru', $total_teachers, 'bi-person-badge', 'success'],
  ['Siswa', $total_students, 'bi-people', 'info'],
  ['Kelas', $total_classes, 'bi-journal', 'warning']
];
foreach ($cards as $c):
?>
<div class="col-xl-3 col-md-6">
  <div class="card info-card <?= $c[3] ?>-card">
    <div class="card-body">
      <h5 class="card-title"><?= $c[0] ?></h5>
      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle">
          <i class="bi <?= $c[2] ?>"></i>
        </div>
        <div class="ps-3">
          <h6 class="counter" data-count="<?= $c[1] ?>">0</h6>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

</div>

<!-- CHART -->
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Guru per Sekolah</h5>
        <canvas id="teacherChart"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Siswa per Sekolah</h5>
        <canvas id="studentSchoolChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- WARNING -->
<div class="row">
  <div class="row">
    <div class="col-lg-6">
      <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        Guru belum terdaftar sebagai guru:
        <strong><?= $unregistered_teachers ?></strong>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="alert alert-danger">
        <i class="bi bi-person-x"></i>
        Siswa belum terdaftar ke kelas:
        <strong><?= $unregistered_students ?></strong>
      </div>
    </div>
  </div>
  
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Distribusi Siswa per Kelas</h5>
        <canvas id="studentClassChart"></canvas>
      </div>
    </div>
  </div>



</div>

</section>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script src="<?= base_url('assets/vendor/chart.js/chart.umd.js'); ?>"></script>

<script>
// COUNTER
document.querySelectorAll('.counter').forEach(el => {
  let target = +el.dataset.count;
  let count = 0;
  let step = Math.ceil(target / 50);

  let interval = setInterval(() => {
    count += step;
    if (count >= target) {
      el.innerText = target;
      clearInterval(interval);
    } else {
      el.innerText = count;
    }
  }, 20);
});

// CHART DATA
const teacherData = <?= json_encode($teachers_school) ?>;
const labels = teacherData.map(i => i.label);
const totals = teacherData.map(i => i.total);

new Chart(document.getElementById('teacherChart'), {
  type: 'bar',
  data: {
    labels,
    datasets: [{
      label: 'Guru',
      data: totals,
      backgroundColor: '#4154f1'
    }]
  }
});

// ======================
// SISWA PER SEKOLAH
// ======================
const studentSchoolData = <?= json_encode($students_school) ?>;

new Chart(document.getElementById('studentSchoolChart'), {
  type: 'bar',
  data: {
    labels: studentSchoolData.map(i => i.label),
    datasets: [{
      label: 'Siswa',
      data: studentSchoolData.map(i => i.total),
      backgroundColor: '#2eca6a'
    }]
  }
});

// ======================
// SISWA PER KELAS (DONUT)
// ======================
const studentClassData = <?= json_encode($students_class) ?>;

new Chart(document.getElementById('studentClassChart'), {
  type: 'doughnut',
  data: {
    labels: studentClassData.map(i => i.label),
    datasets: [{
      data: studentClassData.map(i => i.total),
      backgroundColor: [
        '#4154f1', '#2eca6a', '#ff771d',
        '#dc3545', '#6f42c1', '#20c997'
      ]
    }]
  },
  options: {
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  }
});

</script>
