<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('TtsModel');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // ===============================
    // 📘 FUNGSI INDEX – LIHAT SEMUA NILAI SISWA
    // ===============================
    public function index()
    {
        $data['title'] = 'Ruang Nilai TTS Seluruh Siswa';

        // Ambil semua nilai dari tabel tts_answers JOIN dengan tts dan user
        $data['rekap_nilai'] = $this->TtsModel->get_all_nilai();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/tts/nilai_index', $data);
        $this->load->view('templates/footer');
    }

    // ===============================
    // 📘 FUNGSI NILAI PER TTS
    // ===============================
    public function nilai($tts_id)
    {
        $data['title'] = 'Ruang Nilai TTS';

        $data['tts'] = $this->TtsModel->get($tts_id);
        $data['hasil_siswa'] = $this->TtsModel->get_all_nilai_siswa($tts_id);
        var_dump($data['hasil_siswa']);
        die();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/tts/nilai_siswa', $data);
        $this->load->view('templates/footer');
    }

    public function panduan_tahap2_tts()
    {
    $data['title'] = 'Panduan Tahap 2 – Tes TTS';
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);
    
    $this->load->view('templates/header', $data);
    $this->load->view('guru/panduan/tahap2_tts', $data);
    $this->load->view('templates/footer');
    }
}