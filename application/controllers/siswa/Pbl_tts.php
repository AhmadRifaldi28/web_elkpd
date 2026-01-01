<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_tts extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        // is_logged_in();
		$this->load->model('Pbl_tts_model');
		$this->load->helper(['security', 'string']);
	}

	public function detail($tts_id = null)
  {
    if (!$tts_id) redirect('siswa/pbl');

    $tts = $this->Pbl_tts_model->get_tts_by_id($tts_id);
    if (!$tts) show_404();

    $user_id = $this->session->userdata('user_id');
    $result = $this->Pbl_tts_model->check_submission($tts_id, $user_id);

    // Grid Size Logic
    $gridSize = (int)($tts->grid_data ?: 15);
    if ($gridSize < 5) $gridSize = 5;
    $tts->grid_size = $gridSize;

    $data = [
        'title' => 'TTS: ' . $tts->title,
        'tts' => $tts,
        'result' => $result,
        'is_done' => ($result) ? true : false, // Flag penting untuk JS
        'class_id' => $tts->class_id,
        'user' => $this->session->userdata(),
        'url_name' => 'siswa'
    ];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('siswa/pbl_tts_detail', $data);
    $this->load->view('templates/footer');
  }

    // AJAX: Get Soal & Grid Config (Tanpa Jawaban)
	public function get_game_data($tts_id)
	{
		$data = $this->Pbl_tts_model->get_questions_for_student($tts_id);
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	// AJAX: Get Review (Mode Lihat Nilai & Emote)
  public function get_review_data($tts_id)
  {
    $user_id = $this->session->userdata('user_id');
    $data = $this->Pbl_tts_model->get_tts_review($tts_id, $user_id);
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
  }

    // AJAX: Submit Jawaban
	public function submit_tts()
	{
		$tts_id = $this->input->post('tts_id');
    $answers = $this->input->post('answers'); // Array [question_id => "JAWABAN"]
    $user_id = $this->session->userdata('user_id');

    if (!$tts_id) {
    	echo json_encode(['status' => 'error', 'message' => 'Data tidak valid.']);
    	return;
    }

    if ($this->Pbl_tts_model->check_submission($tts_id, $user_id)) {
    	echo json_encode(['status' => 'error', 'message' => 'Anda sudah mengerjakan TTS ini.']);
    	return;
    }

    $result = $this->Pbl_tts_model->submit_answers($tts_id, $user_id, $answers);

    echo json_encode([
    	'status' => 'success',
    	'message' => 'TTS berhasil dikirim. Nilai: ' . $result['score'],
    	'score' => $result['score'],
    	'csrf_hash' => $this->security->get_csrf_hash()
    ]);
  }
  public function panduan_tahap2_tts()
  {
    $data['title'] = 'Panduan Tahap 2 – Teka-Teki Silang';
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'siswa';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);

    $this->load->view('templates/header', $data);
    $this->load->view('guru/panduan/tahap2_tts', $data);
    $this->load->view('templates/footer');
  }
}

/* End of file Pbl_tts.php */
/* Location: ./application/controllers/Siswa/Pbl_tts.php */