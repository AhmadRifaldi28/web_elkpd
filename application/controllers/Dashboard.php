<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->helper('url');
        $this->load->model('Materi_model');
        // Pastikan sudah login
        /*if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }*/
        is_logged_in();
    }
    // ==========================
    // 🔹 Dashboard Umum
    // ==========================
    public function index()
    {
        $role = $this->session->userdata('role_id');

        if ($role == 1) {
            redirect('guru');
        } elseif ($role == 2) {
            redirect('dashboard/siswa');
        } else {
            show_error('Role tidak dikenali. Hubungi administrator.');
        }
    }

    // ==========================
    // 🔹 Dashboard Guru
    // ==========================
    public function guru()
    {
        // Middleware: hanya untuk guru
        if ($this->session->userdata('role_id') != 1) {
            show_error('Akses ditolak: Halaman ini hanya untuk guru.', 403);
        }

        $data['title'] = 'Dashboard Guru';
        $data['user'] = $this->session->userdata();

        // View khusus guru
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/guru', $data);
        $this->load->view('templates/footer');
    }

    // ==========================
    // 🔹 Dashboard Siswa
    // ==========================
    public function siswa()
    {
        // Middleware: hanya untuk siswa
        if ($this->session->userdata('role_id') != 'siswa') {
            show_error('Akses ditolak: Halaman ini hanya untuk siswa.', 403);
        }

        $data['title'] = 'Dashboard Siswa';
        $data['user'] = $this->session->userdata();

        // View khusus siswa
        $this->load->view('layouts/header', $data);
        $this->load->view('dashboard/siswa', $data);
        $this->load->view('layouts/footer');
    }
}
