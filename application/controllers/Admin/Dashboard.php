<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Dashboard_model', 'dashboard');
	}

	public function index()
	{
		$data['user'] = $this->session->userdata();
		$data['title'] = 'Dashboard Admin';

		$data['total_schools']  = $this->dashboard->count_all('schools');
    $data['total_teachers'] = $this->dashboard->count_all('teachers');
    $data['total_students'] = $this->dashboard->count_all('students');
    $data['total_classes']  = $this->dashboard->count_all('classes');

    $data['teachers_school'] = $this->dashboard->teachers_per_school();
    $data['students_school'] = $this->dashboard->students_per_school();
    $data['students_class']  = $this->dashboard->students_per_class();

    $data['unregistered_teachers'] = $this->dashboard->unregistered_teachers();
    $data['unregistered_students'] = $this->dashboard->unregistered_students();

    // View khusus guru
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('dashboard/admin', $data);
		$this->load->view('templates/footer');
	}

	// Sekolah
	public function schools()
	{
		$data['schools'] = $this->Sekolah_model->get_all();
		$data['title'] = 'Kelola Sekolah';
		$data['user'] = $this->session->userdata();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('admin/schools/index', $data);
		$this->load->view('templates/footer');
	}

	public function getSchoolList()
	{
		$data = $this->Sekolah_model->get_all();
		echo json_encode($data);
	}

	public function school_save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Nama Sekolah', 'required|trim');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode([
				'status' => 'error',
				'message' => validation_errors(),
				'csrf_hash' => $this->security->get_csrf_hash()
			]);
			return;
		}

		$id = $this->input->post('id', TRUE);
		$payload = [
			'name' => $this->input->post('name', TRUE),
			'address' => $this->input->post('address', TRUE)
		];

		if ($id) {
			$this->Sekolah_model->update($id, $payload);
			$msg = 'Sekolah diperbarui';
		} else {
			$payload['id'] = generate_ulid();
			$this->Sekolah_model->insert($payload);
			$msg = 'Sekolah ditambahkan';
		}

		echo json_encode([
			'status' => 'success',
			'message' => $msg,
			'csrf_hash' => $this->security->get_csrf_hash()
		]);
	}

	public function school_delete($id)
	{
		    // $id = $this->input->post('id', TRUE);
		if (!$id) {
			echo json_encode([
				'status' => 'error',
				'message' => 'ID kosong',
				'csrf_hash' => $this->security->get_csrf_hash()
			]);
			return;
		}

		$this->Sekolah_model->delete($id);
		echo json_encode([
			'status' => 'success',
			'message' => 'Sekolah dihapus',
			'csrf_hash' => $this->security->get_csrf_hash()
		]);
	}


	// ========== Guru =============
	public function teachers()
	{
		$data['teachers'] = $this->Guru_model->get_all_with_user_and_school();
		$data['schools'] = $this->Sekolah_model->get_all();
		$data['user'] = $this->session->userdata();
		$data['title'] = 'Manajemen Guru';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('admin/teachers/index', $data);
		$this->load->view('templates/footer');
	}

	// Tambahkan ini di admin/dashboard.php
	public function getTeacherList()
	{
	    // Gunakan model yang sama dengan method teachers()
		$data = $this->Guru_model->get_all_with_user_and_school();

	    // Kirim sebagai JSON
	    // Jangan lupa set header jika perlu
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function teacher_save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('name','Nama','required|trim');
	  $id = $this->input->post('id', TRUE); // teacher id for update
	  if (!$id) {
			$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[users.email]', [
				'is_unique' => 'Email sudah terdaftar!'
			]);
	  }

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(['status'=>'error','message'=>validation_errors(), 'csrf_hash' => $this->security->get_csrf_hash()]);
			return;
		}
	    $username = $this->input->post('username', TRUE);
	    $email = $this->input->post('email', TRUE);
	    $password = $this->input->post('password', TRUE);
	    $school_id = $this->input->post('school_id', TRUE);

	    if ($id) {
	        // update teacher info (update user too)
	    	$teacher = $this->Guru_model->get($id);
	    	if (!$teacher) { echo json_encode(['status'=>'error','message'=>'Guru tidak ditemukan']); return; }
	    	$this->User_model->update($teacher->user_id, ['name'=>$this->input->post('name', TRUE), 'email'=>$email]);
	    	$this->Guru_model->update($id, ['school_id'=>$school_id]);
	    	echo json_encode(['status'=>'success','message'=>'Guru diperbarui', 'csrf_hash' => $this->security->get_csrf_hash()]);
	    	return;
	    } else {

	      // create user + teacher
	    	$uid = generate_ulid();
	    	$user_payload = [
	    		'id' => $uid,
	    		'username' => $username,
	    		'password' => password_hash($password ?: 'password', PASSWORD_DEFAULT),
	    		'role_id' => $this->User_model->get_role_id_by_name('guru'),
	    		'name' => $this->input->post('name', TRUE),
	    		'email' => $email
	    	];
	    	$this->User_model->insert($user_payload);
	    	$teacher_payload = [
	    		'id' => generate_ulid(),
	    		'user_id' => $uid,
	    		'school_id' => $school_id
	    	];
	    	$this->Guru_model->insert($teacher_payload);
	    	echo json_encode(['status'=>'success','message'=>'Guru ditambahkan', 'csrf_hash' => $this->security->get_csrf_hash()]);
	    	return;
	    }
	  }

	  public function teacher_delete()
	  {
	  	$id = $this->input->post('id', TRUE);
	  	$teacher = $this->Guru_model->get($id);
	  	if (!$teacher) {
	  		echo json_encode([
	  			'status' => 'error',
	  			'message' => 'Guru tidak ditemukan',
            'csrf_hash' => $this->security->get_csrf_hash() // <-- TAMBAHKAN INI
          ]);
	  		return;
	  	}

	  	$this->User_model->delete($teacher->user_id);
	  	echo json_encode([
	  		'status' => 'success',
	  		'message' => 'Guru dihapus',
        'csrf_hash' => $this->security->get_csrf_hash() // <-- TAMBAHKAN INI
      ]);
	  }

	// ========== Murid =============
	  /**
     * Menampilkan halaman 'Kelola Murid'.
     * Data tabel akan dimuat via AJAX.
     */
    public function students()
    {
        // $data['students'] tidak diperlukan lagi, data dimuat oleh getStudentList()
        $data['user'] = $this->session->userdata();
        $data['title'] = 'Manajemen Murid';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/students/index', $data); // View baru/sederhana
        $this->load->view('templates/footer');
    }

    /**
     * REFAKTOR: Method student_save()
     * - Sekarang hanya beroperasi di tabel 'users'.
     * - 'id' sekarang merujuk langsung ke 'users.id'.
     * - Menambahkan role_id 'siswa' saat CREATE.
     * - Menambahkan pengecekan role_id saat UPDATE.
     */
    public function student_save()
    {
        $this->load->library('form_validation');
        $id = $this->input->post('id', TRUE); // Ini adalah users.id
        
        $this->form_validation->set_rules('name','Nama','required|trim');
        
        // Aturan validasi username/email
        if (!$id) {
            // --- Mode CREATE ---
            $this->form_validation->set_rules('username','Username','required|trim|is_unique[users.username]', [
                'is_unique' => 'Username ini sudah digunakan.'
            ]);
            $this->form_validation->set_rules('email','Email','trim|valid_email|is_unique[users.email]', [
                'is_unique' => 'Email ini sudah digunakan.'
            ]);
        } else {
            // --- Mode UPDATE ---
            $user = $this->User_model->get($id);
            if (!$user) {
                echo json_encode(['status'=>'error','message'=>'User tidak ditemukan', 'csrf_hash' => $this->security->get_csrf_hash()]);
                return;
            }
            
            // Validasi email HANYA jika diubah
            if ($this->input->post('email') != $user->email) {
                 $this->form_validation->set_rules('email','Email','trim|valid_email|is_unique[users.email]', [
                    'is_unique' => 'Email ini sudah digunakan.'
                ]);
            }
        }

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'status'=>'error',
                'message'=>validation_errors(),
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
            return;
        }

        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        // class_id DIHAPUS

        // Ambil Role ID 'siswa'
        $role_id_siswa = $this->User_model->get_role_id_by_name('siswa'); 
        if (!$role_id_siswa) {
            echo json_encode(['status'=>'error','message'=>'Role "siswa" tidak ditemukan di database.', 'csrf_hash' => $this->security->get_csrf_hash()]);
            return;
        }

        if ($id) {
            // --- LOGIKA UPDATE ---
            $user = $this->User_model->get($id);
            
            // Pengecekan keamanan: pastikan user ada dan role-nya 'siswa'
            if (!$user || $user->role_id != $role_id_siswa) {
                 echo json_encode(['status'=>'error','message'=>'Akses ditolak atau siswa tidak ditemukan', 'csrf_hash' => $this->security->get_csrf_hash()]);
                return;
            }
            
            $user_payload = ['name' => $name, 'email' => $email];
            $this->User_model->update($id, $user_payload);
            $msg = 'Siswa diperbarui';

        } else {
            // --- LOGIKA CREATE ---
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user_payload = [
                'id' => generate_ulid(),
                'username' => $username,
                'password' => password_hash($password ?: 'password', PASSWORD_DEFAULT),
                'role_id' => $role_id_siswa, // <-- PENTING
                'name' => $name,
                'email' => $email
            ];
            $this->User_model->insert($user_payload);
            $msg = 'Siswa ditambahkan';
        }
        
        echo json_encode([
            'status'=>'success',
            'message'=> $msg,
            'csrf_hash' => $this->security->get_csrf_hash()
        ]);
    }

    /**
     * REFAKTOR: Method student_delete()
     * - 'id' adalah users.id.
     * - Menambahkan pengecekan role_id sebelum delete.
     */
    public function student_delete()
    {
        $id = $this->input->post('id', TRUE); // users.id
        $user = $this->User_model->get($id);
        $role_id_siswa = $this->User_model->get_role_id_by_name('siswa');
        
        // Pengecekan keamanan: pastikan user ada dan role-nya 'siswa'
        if (!$user || $user->role_id != $role_id_siswa) {
            echo json_encode([
                'status'=>'error',
                'message'=>'Siswa tidak ditemukan atau akses ditolak',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
            return;
        }
        
        $this->User_model->delete($id); // Hapus user
        
        echo json_encode([
            'status'=>'success',
            'message'=>'Siswa dihapus',
            'csrf_hash' => $this->security->get_csrf_hash()
        ]);
    }
    
    /**
     * REFAKTOR: Endpoint untuk 'fetch' data
     * - Mengambil data dari User_model berdasarkan role 'siswa'.
     */
    public function getStudentList()
    {
        // Gunakan method baru di User_model
        $data = $this->User_model->get_by_role_name('siswa');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

	}

	/* End of file Dashboard.php */
/* Location: ./application/controllers/Admin/Dashboard.php */