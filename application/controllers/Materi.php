<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Materi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Materi_model');
        $this->load->library(['form_validation', 'upload']);
    }

    public function index()
    {
        $q = $this->input->get('q'); // Ambil kata kunci dari input form

        if (!empty($q)) {
            $this->db->like('judul', $q);
            $this->db->or_like('deskripsi', $q);
        }

        $data['materi'] = $this->db->get('materi')->result();
        $this->load->view('layouts/header', $data);
        $this->load->view('materi/index', $data);
    }

    public function detail($id)
    {
        $data['materi'] = $this->Materi_model->get_by_id($id);
        $data['title'] = 'Detail Materi';
        $this->load->view('templates/header', $data);
        $this->load->view('materi/detail', $data);
    }
    public function create()
    {
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layouts/header');
            $this->load->view('materi/form');
            return;
        }

        $file_path = null;
        if (!empty($_FILES['file']['name'])) {
            $config['upload_path'] = './uploads/materi/';
            $config['allowed_types'] = 'pdf|doc|docx|zip|jpg|png|mp4|webm';
            $config['max_size'] = 10240;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $data = $this->upload->data();
                $file_path = 'uploads/materi/' . $data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('materi/create');
            }
        }

        $ins = [
            'judul' => $this->input->post('judul', true),
            'deskripsi' => $this->input->post('deskripsi'),
            'file_path' => $file_path,
            'created_by' => $this->session->userdata('user_id')
        ];
        $this->Materi_model->insert($ins);
        $this->session->set_flashdata('success', 'Materi dibuat');
        redirect('materi');
    }

    public function edit($id)
    {
        $data['materi'] = $this->Materi_model->get($id);
        if (!$data['materi']) show_404();

        $this->form_validation->set_rules('judul', 'Judul', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('materi/form', $data);
            return;
        }

        $update = [
            'judul' => $this->input->post('judul', true),
            'deskripsi' => $this->input->post('deskripsi')
        ];
        // file handling optional (similar to create)
        $this->Materi_model->update($id, $update);
        $this->session->set_flashdata('success', 'Materi diupdate');
        redirect('materi');
    }

    public function simpan()
    {
        $config['upload_path']   = './uploads/materi/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|mp4|mov|avi';
        $config['max_size']      = 100000; // 100MB
        $config['encrypt_name']  = TRUE;

        // Buat folder kalau belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($config);

        $file_path = null;
        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $file_path = 'uploads/materi/' . $uploadData['file_name'];
            } else {
                echo "<pre>";
                print_r($this->upload->display_errors());
                echo "</pre>";
                return;
            }
        }

        $data = [
            'judul'      => $this->input->post('judul'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'file_path'  => $file_path,
            'created_by' => 1, // bisa diganti dengan session user_id guru
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Materi_model->insert($data);
        redirect('materi');
    }

    public function update($id)
    {
        $materi = $this->Materi_model->get($id);
        if (!$materi) show_404();

        $config['upload_path']   = './uploads/materi/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|mp4|mov|avi';
        $config['max_size']      = 100000; // 100MB
        $config['encrypt_name']  = TRUE;

        // Pastikan folder ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($config);

        $file_path = $materi->file_path; // default: file lama
        if (!empty($_FILES['file']['name'])) {
            // Hapus file lama jika ada
            if (!empty($materi->file_path) && file_exists($materi->file_path)) {
                unlink($materi->file_path);
            }

            // Upload file baru
            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $file_path = 'uploads/materi/' . $uploadData['file_name'];
            } else {
                echo "<pre>";
                print_r($this->upload->display_errors());
                echo "</pre>";
                return;
            }
        }

        $data = [
            'judul'      => $this->input->post('judul'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'file_path'  => $file_path,
        ];

        $this->Materi_model->update($id, $data);
        redirect('materi/view/' . $id);
    }

    public function delete($id)
    {
        $this->Materi_model->delete($id);
        $this->session->set_flashdata('success', 'Materi dihapus');
        redirect('materi');
    }

    public function view($id)
    {
        $data['materi'] = $this->Materi_model->get($id);
        if (!$data['materi']) show_404();
        $this->load->view('layouts/header', $data);
        $this->load->view('materi/view', $data);
    }
}
