<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Pbl extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index($class_id = null)
  {
    if (!$class_id) redirect('guru/dashboard');
    $data['title'] = 'Tahap 1 – Orientasi Masalah';
    $data['url_name'] = 'guru';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();

    $role_id = $this->session->userdata('role_id');
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('guru/pbl_orientasi', $data);
    $this->load->view('templates/footer');
  }

  public function get_data($class_id)
  {
    $data = $this->Pbl_model->get_all($class_id);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save()
  {
    $id = $this->input->post('id');
    $class_id = $this->input->post('class_id');
    $title = $this->input->post('title');
    $reflection = $this->input->post('reflection');
    $file_path = '';

    // Upload file (opsional)
    if (!empty($_FILES['file']['name'])) {
      $config['upload_path'] = './uploads/pbl/';
      $config['allowed_types'] = 'jpg|jpeg|png|mp4|mp3|wav|pdf|docx';
      $config['max_size'] = 10240;
      $config['file_name'] = generate_ulid();
      if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

      $this->upload->initialize($config);
      if ($this->upload->do_upload('file')) {
        $file_path = 'uploads/pbl/' . $this->upload->data('file_name');
      } else {
        echo json_encode(['status' => false, 'msg' => $this->upload->display_errors()]);
        return;
      }
    }

    if ($id == '') {
      // Create
      $data = [
        'id' => generate_ulid(),
        'class_id' => $class_id,
        'title' => $title,
        'reflection' => $reflection,
        'file_path' => $file_path,
        'created_at' => date('Y-m-d H:i:s')
      ];
      $insert = $this->Pbl_model->insert($data);
      $status = $insert ? ['status' => true, 'msg' => 'Data berhasil ditambahkan'] : ['status' => false, 'msg' => 'Gagal menambah data'];
      $msg = 'Data berhasil ditambahkan';
    } else {
      $getData = $this->Pbl_model->get_orientasi($id);
      if (!$getData) {
        echo json_encode(['status' => 'error', 'message' => 'materi tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      // Update
      $data = [
        'title' => $title,
        'reflection' => $reflection
      ];
      if ($file_path) $data['file_path'] = $file_path;
      $update = $this->Pbl_model->update($id, $data);
      $status = $update ? ['status' => true, 'msg' => 'Data berhasil diperbarui'] : ['status' => false, 'msg' => 'Gagal memperbarui data'];
      $msg = 'Data berhasil diperbarui';
    }

    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete($id)
  {
    $getData = $this->Pbl_model->get_orientasi($id);
    if (!$getData) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus materi!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    $result = $this->Pbl_model->delete($id);
    if ($result) {
      $message = 'Materi dihapus';
      $status = 'success';
    }

    echo json_encode([
      'status' => $status,
      'message' => $message,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function tahap2($class_id = null)
  {
    if (!$class_id) redirect('guru/dashboard');
    $data['title'] = 'Tahap 2 – Organisasi Belajar';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('guru/pbl_tahap2', $data);
    $this->load->view('templates/footer');
  }

  /*  CRUD KUIS  */
  public function get_quizzes($class_id)
  {
    $data = $this->Pbl_tahap2_model->get_quizzes($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_quiz()
  {
    $id = $this->input->post('id');
    $payload = [
      'class_id' => $this->input->post('class_id'),
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description')
    ];
    if ($id) {
      $getQuiz = $this->Pbl_tahap2_model->get_quiz_by_id($id);
      if (!$getQuiz) {
        echo json_encode(['status' => 'error', 'message' => 'Kuis tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      $this->Pbl_tahap2_model->update_quiz($id, $payload);
      $msg = 'Kuis diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap2_model->insert_quiz($payload);
      $msg = 'Kuis ditambahkan';
    }

    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_quiz()
  {
    $id = $this->input->post('id'); // Ambil dari POST, bukan URL

    $getQuiz = $this->Pbl_tahap2_model->get_quiz_by_id($id);
    if (!$getQuiz) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus Kuis!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    $this->Pbl_tahap2_model->delete_quiz($id);

    echo json_encode([
      'status' => 'success',
      'message' => 'kuis dihapus',
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }


  /*  CRUD TTS  */
  public function get_tts($class_id)
  {
    $data = $this->Pbl_tahap2_model->get_tts($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_tts()
  {
    $this->form_validation->set_rules('grid_data', 'Data Grid', 'required|trim|numeric', [
      'required' => 'Data Grid wajib diisi!',
    ]);

    if ($this->form_validation->run() === FALSE) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => validation_errors()]));
      return;
    }

    $grid_val = (int)$this->input->post('grid_data');
    // Cek 3: Minimal 8
    if ($grid_val < 8) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => 'Ukuran Grid minimal adalah 8.']));
      return;
    }
    // Cek 4: Maksimal 25
    if ($grid_val > 25) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => 'Ukuran Grid maksimal adalah 25.']));
      return;
    }

    $payload = [
      'class_id' => $this->input->post('class_id'),
      'title' => $this->input->post('title'),
      'grid_data' => $this->input->post('grid_data')
    ];
    $id = $this->input->post('id');
    if ($id) {
      $getTts = $this->Pbl_tts_model->get_tts_by_id($id);
      if (!$getTts) {
        echo json_encode(['status' => 'error', 'message' => 'Teka teki tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      $this->Pbl_tahap2_model->update_tts($id, $payload);
      $msg = 'TTS diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap2_model->insert_tts($payload);
      $msg = 'TTS ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_tts($id)
  {
    $getTts = $this->Pbl_tts_model->get_tts_by_id($id);
    if (!$getTts) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus teka teki!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    $this->Pbl_tahap2_model->delete_tts($id);
    echo json_encode([
      'status' => 'success',
      'message' => 'TTS dihapus!',
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   *  Halaman utama untuk Tahap 3
   */
  public function tahap3($class_id = null)
  {
    if (!$class_id) {
      redirect('guru/dashboard'); // Arahkan ke dashboard jika class_id tidak ada
    }

    $data['title'] = 'Tahap 3 – Penyelidikan Mandiri & Kelompok';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();

    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('guru/pbl_tahap3', $data);
    $this->load->view('templates/footer');
  }

  /*   CRUD RUANG OBSERVASI  */
  public function get_observations($class_id)
  {
    $data = $this->Pbl_tahap3_model->get_observations($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_observation()
  {
    $this->form_validation->set_rules('title', 'Judul', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => validation_errors()]));
      return;
    }

    $id = $this->input->post('id');
    $payload = [
      'class_id' => $this->input->post('class_id'),
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description')
    ];

    if ($id) {
      $getData = $this->Pbl_tahap3_model->get_observation($id);
      if (!$getData) {
        echo json_encode(['status' => 'error', 'message' => 'Observasi tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      $this->Pbl_tahap3_model->update_observation($id, $payload);
      $msg = 'Ruang Observasi diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap3_model->insert_observation($payload);
      $msg = 'Ruang Observasi ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }
  

  public function delete_observation($id = null)
  {
    $getData = $this->Pbl_tahap3_model->get_observation($id);
    if (!$getData) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus observasi!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    if ($id) {
      $this->Pbl_tahap3_model->delete_observation($id);
      $msg = 'Ruang Observasi dihapus.';
      $status = 'success';
    }

    echo json_encode([
      'status' => $status,
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  /*   CRUD FORUM DISKUSI  */
  public function get_discussions($class_id)
  {
    $data = $this->Pbl_tahap3_model->get_discussions($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_discussion()
  {
    $this->form_validation->set_rules('title', 'Judul Topik', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => validation_errors()]));
      return;
    }

    $id = $this->input->post('id');
    $payload = [
      'class_id' => $this->input->post('class_id'),
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description')
    ];

    if ($id) {
      $getData = $this->Pbl_tahap3_model->get_discussion($id);
      if (!$getData) {
        echo json_encode(['status' => 'error', 'message' => 'Forum tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      $this->Pbl_tahap3_model->update_discussion($id, $payload);
      $msg = 'Topik Diskusi diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap3_model->insert_discussion($payload);
      $msg = 'Topik Diskusi ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_discussion($id = null)
  {
    $getData = $this->Pbl_tahap3_model->get_discussion($id);
    if (!$getData) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus forum!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    if ($id) {
      $this->Pbl_tahap3_model->delete_discussion($id);
      $msg = 'Topik Diskusi dihapus.';
      $status = 'success';
    }
    echo json_encode([
      'status' => $status,
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   *  Halaman utama untuk Tahap 4
   */
  public function tahap4($class_id = null)
  {
    if (!$class_id) {
      redirect('guru/dashboard');
    }

    $data['title'] = 'Tahap 4 – Menyajikan Hasil Karya';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('guru/pbl_tahap4', $data);
    $this->load->view('templates/footer');
  }

  /*   CRUD ESAI SOLUSI  */
  public function get_solution_essays($class_id)
  {
    $data = $this->Pbl_tahap4_model->get_solution_essays($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_solution_essay()
  {
    $this->form_validation->set_rules('title', 'Judul Esai', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => validation_errors()]));
      return;
    }

    $id = $this->input->post('id');
    $payload = [
      'class_id' => $this->input->post('class_id'),
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description')
    ];

    if ($id) {
      $getData = $this->Pbl_tahap4_model->get_solution_essay($id);
      if (!$getData) {
        echo json_encode(['status' => 'error', 'message' => 'Esai tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      $this->Pbl_tahap4_model->update_solution_essay($id, $payload);
      $msg = 'Aktivitas Esai diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap4_model->insert_solution_essay($payload);
      $msg = 'Aktivitas Esai ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_solution_essay($id = null)
  {
    $getData = $this->Pbl_tahap4_model->get_solution_essay($id);
    if (!$getData) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus Esai!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    if ($id) {
      $this->Pbl_tahap4_model->delete_solution_essay($id);
      $msg = 'Aktivitas Esai dihapus.';
      $status = 'success';
    }
    echo json_encode([
      'status' => $status,
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  /*   CRUD KUIS EVALUASI  */
  public function get_evaluation_quizzes($class_id)
  {
    $data = $this->Pbl_tahap4_model->get_evaluation_quizzes($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_evaluation_quiz()
  {
    $this->form_validation->set_rules('title', 'Judul Kuis', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'error', 'message' => validation_errors()]));
      return;
    }

    $id = $this->input->post('id');
    $payload = [
      'class_id' => $this->input->post('class_id'),
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description')
    ];

    if ($id) {
      $getData = $this->Pbl_tahap4_model->get_evaluation_quiz($id);
      if (!$getData) {
        echo json_encode(['status' => 'error', 'message' => 'Kuis tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }

      $this->Pbl_tahap4_model->update_evaluation_quiz($id, $payload);
      $msg = 'Kuis Evaluasi diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap4_model->insert_evaluation_quiz($payload);
      $msg = 'Kuis Evaluasi ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_evaluation_quiz($id = null)
  {
    $getData = $this->Pbl_tahap4_model->get_evaluation_quiz($id);
    if (!$getData) {
      echo json_encode(['status' => 'error', 'message' => 'Gagal hapus kuis!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }

    if ($id) {
      $this->Pbl_tahap4_model->delete_evaluation_quiz($id);
      $msg = 'Kuis Evaluasi dihapus.';
      $status = 'success';
    }
    echo json_encode([
      'status' => $status,
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * Halaman utama untuk Tahap 5
   */
  public function tahap5($class_id = null)
  {
    if (!$class_id) {
      redirect('guru/dashboard');
    }

    $data['title'] = 'Tahap 5 – Refleksi & Evaluasi Akhir';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('guru/pbl_tahap5', $data);
    $this->load->view('templates/footer');
  }

  // [AJAX] Mengambil data rekap nilai untuk tabel
  public function get_student_recap($class_id)
  {
    $students = $this->Refleksi_model->getAllStudentScores($class_id);

    // Return JSON langsung untuk ditangkap fetch JS
    echo json_encode($students);
  }

  public function get_final_recap($class_id)
  {
    if (!$class_id) {
      show_404();
    }

    $data = $this->Refleksi_model->getFinalRecapByClass($class_id);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function get_reflection_recap($class_id)
  {
    if (!$class_id) show_404();

    $data = $this->Refleksi_model->getReflectionRecapByClass($class_id);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function toggle_lock()
  {
    // Validasi
    $class_id = $this->input->post('class_id');
    $user_id  = $this->input->post('user_id');
    $status   = $this->input->post('status'); // 1 atau 0

    if (!$class_id || !$user_id) {
      echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
      return;
    }

    $this->load->model('Refleksi_model');

    // Cek apakah bisa dikunci (harus ada data dulu)
    $success = $this->Refleksi_model->set_lock_status($class_id, $user_id, $status);

    if ($success) {
      $msg = ($status == 1) ? 'Nilai dipublikasikan ke siswa.' : 'Nilai ditarik kembali (Draft).';
      echo json_encode([
        'status' => 'success',
        'message' => $msg,
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Gagal! Pastikan Refleksi Guru sudah diisi sebelum mempublikasikan.',
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    }
  }

  public function export_report($class_id)
  {
    // Cek Login & Role Guru
    if (!$this->session->userdata('role_id')) redirect('auth');

    $this->load->library('pdf');
    $this->load->model('Refleksi_model');

    // 1. Ambil Data Sekolah & Kelas
    $school = $this->Refleksi_model->getSchoolByClassId($class_id);
    $class  = $this->Refleksi_model->getClassInfo($class_id);

    if (!$school || !$class) {
      show_error('Data Sekolah atau Kelas tidak ditemukan.');
    }

    // 2. Ambil Data Siswa (Hanya yang LOCKED / Final)
    // Parameter kedua 'true' mengaktifkan filter is_locked = 1
    $students = $this->Refleksi_model->getAllStudentScores($class_id, true);

    if (empty($students)) {
      $this->session->set_flashdata('message', '<div class="alert alert-warning">Belum ada nilai siswa yang dipublikasikan (dikunci).</div>');
      redirect('guru/pbl/tahap5/' . $class_id);
    }

    // 3. Siapkan Data View
    $data = [
      'school'   => $school,
      'class'    => $class,
      'students' => $students,
      'title'    => 'Laporan Hasil Belajar PBL - ' . $class->name
    ];

    // 4. Load View ke Variable HTML
    $html = $this->load->view('guru/pdf/pbl_report_class', $data, true);

    // 5. Generate PDF (Landscape agar muat tabel narasi)
    $this->pdf->generate($html, 'Laporan_PBL_' . $class->name, 'A4', 'landscape');
  }

  public function save_teacher_reflection()
  {
    $this->load->model('Refleksi_model');

    $class_id = $this->input->post('class_id');
    $user_id  = $this->input->post('user_id');

    if (!$class_id || !$user_id) {
      $this->_jsonError('Data tidak lengkap');
      return;
    }

    // Cek lock
    if ($this->Refleksi_model->isLocked($class_id, $user_id)) {
      $this->_jsonError('Refleksi sudah dikunci');
      return;
    }

    $data = [
      'class_id' => $class_id,
      'user_id'  => $user_id,
      'teacher_reflection' => $this->input->post('teacher_reflection'),
      'teacher_feedback'   => $this->input->post('teacher_feedback'),
      'student_feedback'   => $this->input->post('student_feedback'),
    ];

    $saved = $this->Refleksi_model->save_reflection($data);

    if ($saved) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Refleksi guru berhasil disimpan',
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    } else {
      $this->_jsonError('Gagal menyimpan refleksi');
    }
  }

  private function _jsonError($msg)
  {
    echo json_encode([
      'status' => 'error',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }



  public function save_class_reflection()
  {
    $this->form_validation->set_rules('class_id', 'ID Kelas', 'required');

    if ($this->form_validation->run() === FALSE) {
      echo json_encode([
        'status' => 'error',
        'message' => validation_errors(),
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
      return;
    }


    $data = [
      'class_id' => $this->input->post('class_id'),
      'teacher_id' => $this->session->userdata('user_id'),
      'strengths' => $this->input->post('strengths'),
      'obstacles' => $this->input->post('obstacles'),
      'competency_achievement' => $this->input->post('competency_achievement'),
    ];

    $saved = $this->Refleksi_model->save_class_reflection($data);

    echo json_encode([
      'status' => $saved ? 'success' : 'error',
      'message' => $saved ? 'Refleksi kelas berhasil disimpan.' : 'Gagal menyimpan refleksi.',
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  // [AJAX] Simpan Refleksi
  public function save_reflection()
  {
    // 1. HAPUS baris pengecekan is_ajax_request yang menyebabkan error "No direct script..."

    // 2. Validasi Input (Opsional tapi disarankan)
    $this->form_validation->set_rules('user_id', 'ID Siswa', 'required');
    $this->form_validation->set_rules('class_id', 'ID Kelas', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => 'error',
          'message' => validation_errors(),
          'csrf_hash' => $this->security->get_csrf_hash() // Update CSRF
        ]));
      return;
    }


    // Cek apakah checkbox dicentang? Jika ya valuenya '1', jika tidak null (maka kita set 0)
    $is_locked = $this->input->post('is_locked') ? 1 : 0;

    $data = [
      'class_id' => $this->input->post('class_id'),
      'user_id' => $this->input->post('user_id'),
      'teacher_reflection' => $this->input->post('teacher_reflection'),
      'student_feedback' => $this->input->post('student_feedback'),
      'is_locked' => $is_locked // Tambahkan field ini
    ];

    // 4. Simpan ke Database
    // Model akan menangani logika Insert (jika baru) atau Update (jika sudah ada)
    $saved = $this->Refleksi_model->save_reflection($data);

    // 5. Return JSON sukses + CSRF Hash baru
    if ($saved) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Refleksi dan Feedback berhasil disimpan.',
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menyimpan data ke database.',
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    }
  }

  public function export_excel($class_id)
  {
    // 1. Cek Login & Data
    if (!$this->session->userdata('role_id')) redirect('auth');
    $this->load->model('Refleksi_model');

    $school = $this->Refleksi_model->getSchoolByClassId($class_id);
    $class  = $this->Refleksi_model->getClassInfo($class_id);
    // Ambil siswa yang LOCKED (Published)
    $students = $this->Refleksi_model->getAllStudentScores($class_id, true);

    if (!$school || !$class) show_error('Data Sekolah/Kelas tidak ditemukan.');
    if (empty($students)) {
      $this->session->set_flashdata('message', '<div class="alert alert-warning">Belum ada nilai yang dipublikasikan.</div>');
      redirect('guru/pbl/tahap5/' . $class_id);
    }

    // 2. Inisialisasi Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // --- STYLING VARIABLES ---
    $styleHeader = [
      'font' => ['bold' => true, 'size' => 12],
      'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ];
    $styleTableHead = [
      'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
      'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0EFFF']], // Biru muda
      'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
      'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ];
    $styleBorder = [
      'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
      'alignment' => ['vertical' => Alignment::VERTICAL_TOP] // Text rata atas
    ];

    // --- BAGIAN 1: KOP SURAT ---
    $sheet->mergeCells('A1:G1');
    $sheet->setCellValue('A1', strtoupper($school->name));
    $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

    $sheet->mergeCells('A2:G2');
    $sheet->setCellValue('A2', $school->address);
    $sheet->getStyle('A2')->applyFromArray(['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

    $sheet->mergeCells('A3:G3');
    $sheet->setCellValue('A3', 'LAPORAN HASIL PEMBELAJARAN BERBASIS PROYEK (PBL)');
    $sheet->getStyle('A3')->applyFromArray($styleHeader);

    // --- BAGIAN 2: INFO KELAS ---
    $row = 5;
    $sheet->setCellValue('A' . $row, 'Kelas');
    $sheet->setCellValue('B' . $row, ': ' . $class->name . ' (' . $class->code . ')');
    $sheet->setCellValue('E' . $row, 'Guru Pengampu');
    $sheet->setCellValue('F' . $row, ': ' . $this->session->userdata('name'));

    $row++;
    $sheet->setCellValue('A' . $row, 'Tahun Ajaran');
    $sheet->setCellValue('B' . $row, ': ' . date('Y'));
    $sheet->setCellValue('E' . $row, 'Tanggal Cetak');
    $sheet->setCellValue('F' . $row, ': ' . date('d F Y'));

    // --- BAGIAN 3: TABEL REKAP NILAI ---
    $row += 2; // Spasi
    $sheet->setCellValue('A' . $row, 'I. REKAP NILAI SISWA');
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);

    $row++;
    $tableStart = $row;
    // Header Tabel Nilai
    $headers1 = ['No', 'Nama Siswa', 'Quiz (Avg)', 'TTS (Avg)', 'Observasi', 'Esai', 'Nilai Akhir'];
    $col = 'A';
    foreach ($headers1 as $h) {
      $sheet->setCellValue($col . $row, $h);
      $sheet->getColumnDimension($col)->setAutoSize(true);
      $col++;
    }
    $sheet->getStyle("A$row:G$row")->applyFromArray($styleTableHead);

    // Isi Data Tabel Nilai
    $no = 1;
    $row++;
    foreach ($students as $s) {
      $quiz = floatval($s->quiz_score);
      $tts = floatval($s->tts_score);
      $obs = floatval($s->obs_score);
      $essay = floatval($s->essay_score);
      $final = ($quiz + $tts + $obs + $essay) / 4;

      $sheet->setCellValue('A' . $row, $no++);
      $sheet->setCellValue('B' . $row, $s->student_name);
      $sheet->setCellValue('C' . $row, $quiz);
      $sheet->setCellValue('D' . $row, $tts);
      $sheet->setCellValue('E' . $row, $obs);
      $sheet->setCellValue('F' . $row, $essay);
      $sheet->setCellValue('G' . $row, number_format($final, 2));

      // Center alignment untuk nilai
      $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C$row:G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $row++;
    }
    // Apply Border Tabel 1
    $sheet->getStyle("A$tableStart:G" . ($row - 1))->applyFromArray($styleBorder);


    // --- BAGIAN 4: TABEL REFLEKSI & FEEDBACK ---
    $row += 2; // Spasi antar tabel
    $sheet->setCellValue('A' . $row, 'II. REFLEKSI & UMPAN BALIK');
    $sheet->getStyle('A' . $row)->getFont()->setBold(true);

    $row++;
    $tableStart2 = $row;
    // Header Tabel Refleksi
    // Merge cells untuk kolom Refleksi dan Feedback agar lebih lebar
    $sheet->setCellValue('A' . $row, 'No');
    $sheet->setCellValue('B' . $row, 'Nama Siswa');
    $sheet->setCellValue('C' . $row, 'Refleksi Guru');
    $sheet->mergeCells("C$row:D$row"); // Gabung C & D
    $sheet->setCellValue('E' . $row, 'Umpan Balik Siswa');
    $sheet->mergeCells("E$row:G$row"); // Gabung E, F, G

    $sheet->getStyle("A$row:G$row")->applyFromArray($styleTableHead);

    // Isi Data Tabel Refleksi
    $no = 1;
    $row++;
    foreach ($students as $s) {
      $sheet->setCellValue('A' . $row, $no++);
      $sheet->setCellValue('B' . $row, $s->student_name);

      // Refleksi Guru
      $sheet->setCellValue('C' . $row, $s->teacher_reflection ?: '-');
      $sheet->mergeCells("C$row:D$row");

      // Feedback Siswa
      $sheet->setCellValue('E' . $row, $s->student_feedback ?: '-');
      $sheet->mergeCells("E$row:G$row");

      // Wrap Text (PENTING AGAR TEXT PANJANG TURUN KE BAWAH)
      $sheet->getStyle("C$row:E$row")->getAlignment()->setWrapText(true);

      $row++;
    }
    // Apply Border Tabel 2
    $sheet->getStyle("A$tableStart2:G" . ($row - 1))->applyFromArray($styleBorder);

    // Atur Lebar Kolom Manual untuk area teks agar wrap text berfungsi baik
    $sheet->getColumnDimension('C')->setWidth(40);
    $sheet->getColumnDimension('E')->setWidth(40);
    $sheet->getColumnDimension('B')->setAutoSize(true);


    // 3. Output File Download
    $filename = 'Laporan_PBL_' . preg_replace('/[^A-Za-z0-9]/', '_', $class->name) . '_' . date('Ymd');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }

  // --- AJAX: Save Grade ---
  public function save_grade()
  {
    $this->form_validation->set_rules('final_score', 'Nilai Akhir', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
    $this->form_validation->set_rules('feedback', 'Feedback', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published]');

    if ($this->form_validation->run() === FALSE) {
      echo json_encode(['status' => 'error', 'message' => validation_errors()]);
      return;
    }

    $data = [
      'class_id'    => $this->input->post('class_id'),
      'user_id'     => $this->input->post('user_id'),
      'final_score' => $this->input->post('final_score'),
      'feedback'    => $this->input->post('feedback'),
      'status'      => $this->input->post('status')
    ];

    if ($this->Pbl_tahap5_model->save_grade($data)) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Nilai berhasil disimpan.',
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menyimpan database.',
        'csrf_hash' => $this->security->get_csrf_hash()
      ]);
    }
  }
  public function panduan_tahap1($class_id = null)
  {
    $data['title'] = 'Panduan Tahap 1 – Orientasi Masalah';
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('guru/panduan/tahap1_orientasi', $data);
    $this->load->view('templates/footer');
  }
}

/* End of file Pbl.php */
/* Location: ./application/controllers/Guru/Pbl.php */