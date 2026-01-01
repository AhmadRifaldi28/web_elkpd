<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
    $data['url_name'] = 'siswa';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();

    $role_id = $this->session->userdata('role_id');    
    $allowed_roles = ['Guru', 'Admin'];

    $data['is_admin_or_guru'] = $this->User_model->check_user_role($role_id, $allowed_roles);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
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
      $config['allowed_types'] = 'jpg|jpeg|png|mp4|mp3|wav|pdf';
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
        echo json_encode(['status'=>'error','message'=>'materi tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
  		echo json_encode(['status'=>'error','message'=>'Gagal hapus materi!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
    $data['url_name'] = 'siswa';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

	  $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
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
        echo json_encode(['status'=>'error','message'=>'Kuis tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
      echo json_encode(['status'=>'error','message'=>'Gagal hapus Kuis!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
        echo json_encode(['status'=>'error','message'=>'Teka teki tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
      echo json_encode(['status'=>'error','message'=>'Gagal hapus teka teki!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
    $data['url_name'] = 'siswa';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
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
        echo json_encode(['status'=>'error','message'=>'Observasi tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
      echo json_encode(['status'=>'error','message'=>'Gagal hapus observasi!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
        echo json_encode(['status'=>'error','message'=>'Forum tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
      echo json_encode(['status'=>'error','message'=>'Gagal hapus forum!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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

    $data['title'] = 'Tahap 4 – Pengembangan Solusi';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'siswa';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    // $this->load->view('templates/sidebar');
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
        echo json_encode(['status'=>'error','message'=>'Esai tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
      echo json_encode(['status'=>'error','message'=>'Gagal hapus Esai!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
        echo json_encode(['status'=>'error','message'=>'Kuis tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
      echo json_encode(['status'=>'error','message'=>'Gagal hapus kuis!', 'csrf_hash' => $this->security->get_csrf_hash()]);
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
        if (!$class_id) redirect('siswa/dashboard');

        $user = $this->session->userdata();
        $this->load->model('Refleksi_model');

        // CEK AKSES: Apakah guru sudah lock/publish nilai?
        $can_access = $this->Refleksi_model->check_student_access($class_id, $user['user_id']);

        if (!$can_access) {
            // Jika belum di-publish, tendang balik ke Tahap 4 atau tampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-warning" alert-dismissible fade show role="alert">Refleksi dan Nilai Akhir belum dipublikasikan oleh Guru.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect('siswa/pbl/tahap4/' . $class_id);
            return;
        }

        // Jika lolos, lanjut load view...
        $data['title'] = 'Tahap 5 – Refleksi & Evaluasi Akhir';
        $data['class_id'] = $class_id;
        $data['user'] = $user;
        $data['url_name'] = 'siswa';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('siswa/pbl_tahap5', $data);
        $this->load->view('templates/footer');
    }

  // [AJAX] Get Data Rekap untuk Siswa
  public function get_my_recap($class_id)
{
    // Ambil User ID dari Session (Siswa yang sedang login)
    // Pastikan key session sesuai dengan login system Anda, biasanya 'id' atau 'user_id'
    $user_id = $this->session->userdata('user_id'); 

    if (!$class_id || !$user_id) {
        // Return array kosong jika data tidak valid
        echo json_encode([]); 
        return;
    }

    $this->load->model('Refleksi_model');
    
    // Panggil fungsi KHUSUS SATU SISWA
    $student_data = $this->Refleksi_model->getSingleStudentScore($class_id, $user_id);
    
    // Return JSON
    echo json_encode($student_data);
}

  /* CRUD REFLEKSI AKHIR */
  public function get_reflections($class_id)
  {
    $data = $this->Pbl_tahap5_model->get_reflections($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_reflection()
  {
    $this->form_validation->set_rules('title', 'Judul Refleksi', 'required');

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
      $getData = $this->Pbl_tahap5_model->get_reflection($id);
      if (!$getData) {
        echo json_encode(['status'=>'error','message'=>'Refleksi tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }

      $this->Pbl_tahap5_model->update_reflection($id, $payload);
      $msg = 'Refleksi diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap5_model->insert_reflection($payload);
      $msg = 'Refleksi ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_reflection($id = null)
  {
    $getData = $this->Pbl_tahap5_model->get_reflection($id);
    if (!$getData) {
      echo json_encode(['status'=>'error','message'=>'Gagal hapus refleksi!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }
    if ($id) {
      $this->Pbl_tahap5_model->delete_reflection($id);
      $msg = 'Refleksi dihapus.';
      $status = 'success';
    }
    echo json_encode([
      'status' => $status,
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  /* CRUD TTS PENUTUP */
  public function get_closing_tts($class_id)
  {
    $data = $this->Pbl_tahap5_model->get_closing_tts_list($class_id);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function save_closing_tts()
  {
    $this->form_validation->set_rules('title', 'Judul TTS', 'required');
    $this->form_validation->set_rules('grid_data', 'Ukuran Grid', 'required|integer');

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
      'grid_data' => $this->input->post('grid_data')
    ];

    if ($id) {
      $getData = $this->Pbl_tahap5_model->get_closing_tts($id);
      if (!$getData) {
        echo json_encode(['status'=>'error','message'=>'TTS Penutup tidak ada!', 'csrf_hash' => $this->security->get_csrf_hash()]);
        return;
      }
      $this->Pbl_tahap5_model->update_closing_tts($id, $payload);
      $msg = 'TTS Penutup diperbarui';
    } else {
      $payload['id'] = generate_ulid();
      $this->Pbl_tahap5_model->insert_closing_tts($payload);
      $msg = 'TTS Penutup ditambahkan';
    }
    echo json_encode([
      'status' => 'success',
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }

  public function delete_closing_tts($id = null)
  {
    $getData = $this->Pbl_tahap5_model->get_closing_tts($id);
    if (!$getData) {
      echo json_encode(['status'=>'error','message'=>'Gagal hapus TTS penutup!', 'csrf_hash' => $this->security->get_csrf_hash()]);
      return;
    }
    if ($id) {
      $this->Pbl_tahap5_model->delete_closing_tts($id);
      $msg = 'TTS Penutup dihapus.';
      $status = 'success';
    }
    echo json_encode([
      'status' => $status,
      'message' => $msg,
      'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }
  public function panduan_tahap1($class_id = null)
	{
    $data['title'] = 'Panduan Orientasi Masalah – Tahap 1';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'siswa';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);
    
    $this->load->view('templates/header', $data);
    $this->load->view('guru/panduan/tahap1_orientasi', $data);
    $this->load->view('templates/footer');
	}
}

/* End of file Pbl.php */
/* Location: ./application/controllers/Guru/Pbl.php */