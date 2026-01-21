<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Helper Search yang kita buat tadi
        $this->load->helper(['search', 'url']); 
        
        // Cek Login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $keyword = $this->input->get('query', TRUE);
        
        // Panggil fungsi Helper
        $data['results'] = get_search_results($keyword);
        $data['keyword'] = $keyword;
        $data['title']   = 'Hasil Pencarian';
        
        // Data User untuk Header (sesuaikan dengan logic controller lain)
        // $data['user'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['user'] = $this->session->userdata();

        // Load View
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data); // Sesuaikan jika ada sidebar
        $this->load->view('search_results', $data);    // View khusus hasil search
        $this->load->view('templates/footer');
    }
}