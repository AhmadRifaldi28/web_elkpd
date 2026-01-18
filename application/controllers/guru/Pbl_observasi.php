<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_observasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // Pastikan helper login aktif
        $this->load->model('Pbl_observasi_model');
    }

    // Halaman Detail (Menampilkan List Upload Siswa)
    public function detail($slot_id = null)
{
    if (!$slot_id) redirect('guru/pbl');

    $slot = $this->Pbl_observasi_model->get_slot_by_id($slot_id);
    if (!$slot) show_404();

    $data['title'] = 'Detail Observasi: ' . $slot->title;
    $data['slot'] = $slot;
    $data['class_id'] = $slot->class_id;
    
    // --- TAMBAHAN KODE DI SINI ---
    // 1. Ambil data statistik dari Model
    $stats = $this->Pbl_observasi_model->get_slot_statistics($slot_id);
    
    // 2. Masukkan ke array $data agar bisa diakses di View
    $data['stat_total']   = $stats['total'];
    $data['stat_graded']  = $stats['graded'];
    $data['stat_pending'] = $stats['pending'];

    // 3. Hitung Persentase untuk Progress Bar
    // (Cegah pembagian dengan nol jika tidak ada upload)
    if ($stats['total'] > 0) {
        $data['progress_percent'] = round(($stats['graded'] / $stats['total']) * 100);
    } else {
        $data['progress_percent'] = 0;
    }
    // -----------------------------

    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $data['is_admin_or_guru'] = true;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('guru/pbl_observasi_detail', $data);
    $this->load->view('templates/footer');
}

    // --- AJAX METHODS ---

    // Get Data untuk Tabel
    public function get_uploads($slot_id)
    {
        $data = $this->Pbl_observasi_model->get_uploads_by_slot($slot_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // Delete Upload
    public function delete_upload($id = null)
    {
        if ($id) {
            $this->Pbl_observasi_model->delete_upload($id);
            $response = ['status' => 'success', 'message' => 'File observasi berhasil dihapus.'];
        } else {
            $response = ['status' => 'error', 'message' => 'ID tidak valid.'];
        }
        
        // CSRF Hash refresh
        $response['csrf_hash'] = $this->security->get_csrf_hash();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_grades($slot_id)
    {
        $data = $this->Pbl_observasi_model->get_grades_by_slot($slot_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_grade()
    {
        $this->form_validation->set_rules('user_id', 'Siswa', 'required');
        $this->form_validation->set_rules('score', 'Nilai', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('feedback', 'Feedback', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => validation_errors()]));
            return;
        }

        $id = $this->input->post('id'); // ID dari tabel results (jika edit)
        $slot_id = $this->input->post('observation_slot_id');
        $user_id = $this->input->post('user_id');
        
        $payload = [
            'observation_slot_id' => $slot_id,
            'user_id' => $user_id,
            'score' => $this->input->post('score'),
            'feedback' => $this->input->post('feedback')
        ];

        // Cek apakah siswa ini sudah dinilai sebelumnya di slot ini?
        $existing = $this->Pbl_observasi_model->check_grade_exists($slot_id, $user_id);

        if ($id) {
            // Mode Edit via ID
            $this->Pbl_observasi_model->update_grade($id, $payload);
            $msg = 'Nilai diperbarui.';
        } elseif ($existing) {
            // Mode Insert tapi data sudah ada -> Update saja
            $this->Pbl_observasi_model->update_grade($existing->id, $payload);
            $msg = 'Nilai diperbarui (Siswa sudah dinilai sebelumnya).';
        } else {
            // Mode Insert Baru
            $payload['id'] = generate_ulid();
            $this->Pbl_observasi_model->insert_grade($payload);
            $msg = 'Nilai berhasil disimpan.';
        }

        echo json_encode(['status' => 'success', 'message' => $msg, 'csrf_hash' => $this->security->get_csrf_hash()]);
    }

    public function delete_grade()
    {
        $id = $this->input->post('id');
        $this->Pbl_observasi_model->delete_grade($id);
        echo json_encode(['status' => 'success', 'message' => 'Nilai dihapus.', 'csrf_hash' => $this->security->get_csrf_hash()]);
    }
    
    public function panduan_observasi_tahap3($class_id)
    {
    $data['title'] = 'Panduan Observasi – Tahap 3';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);
    
    $this->load->view('templates/header', $data);
    $this->load->view('guru/panduan/tahap3_observasi', $data);
    $this->load->view('templates/footer');
    }
    
    public function panduan_detail_observasi_tahap3($class_id)
    {
    $data['title'] = 'Panduan Detail Observasi – Tahap 3';
    $data['class_id'] = $class_id;
    $data['user'] = $this->session->userdata();
    $data['url_name'] = 'guru';
    $role_id = $this->session->userdata('role_id');    
    $data['is_admin_or_guru'] = $this->User_model->check_is_teacher($role_id);
    
    $this->load->view('templates/header', $data);
    $this->load->view('guru/panduan/tahap3_observasi_detail', $data);
    $this->load->view('templates/footer');
    }
    
}

/* End of file Pbl_observasi.php */
/* Location: ./application/controllers/Guru/Pbl_observasi.php */