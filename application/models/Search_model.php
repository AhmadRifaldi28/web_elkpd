<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search_model extends CI_Model
{
    // === PENCARIAN UNTUK GURU ===
    // Mencari Kelas dan Siswa
    public function search_guru($keyword, $user_id)
{
    $results = [];

    // 1. Ambil ID Guru dari tabel teachers (jika diperlukan untuk validasi school_id)
    $teacher = $this->db->get_where('teachers', ['user_id' => $user_id])->row();
    if (!$teacher) return [];

    // ==========================================
    // 1. CARI KELAS (FIXED)
    // ==========================================
    $this->db->select('*');
    $this->db->from('classes');
    
    // Mulai pengelompokan logika OR (Kurung Buka)
    $this->db->group_start(); 
        $this->db->like('name', $keyword);
        $this->db->or_like('code', $keyword);
    $this->db->group_end(); 
    // Selesai pengelompokan logika OR (Kurung Tutup)

    // Filter Wajib (AND) - Sekarang berlaku untuk kedua kondisi di atas
    $this->db->where('user_id', $user_id); 
    // $this->db->where('school_id', $teacher->school_id); // Opsional: jika user_id sudah unik per guru, ini mungkin redundan tapi aman dipakai
    
    $classes = $this->db->get()->result_array();

    foreach ($classes as $c) {
        $results[] = [
            'title' => 'Kelas: ' . $c['name'],
            'desc'  => 'Kode: ' . $c['code'],
            'type'  => 'Kelas',
            'url'   => base_url('guru/dashboard/class_detail/' . $c['id'])
        ];
    }

    // ==========================================
    // 2. CARI SISWA
    // ==========================================
    // Note: Pastikan join user_id sesuai kolom PK di tabel users (misal: u.user_id atau u.id)
    $this->db->select('u.name, u.email, s.id as student_id');
    $this->db->from('students s');
    $this->db->join('users u', 's.user_id = u.id'); // Sesuaikan u.user_id jika PK tabel users adalah user_id
    
    // Filter siswa hanya yang ada di kelas milik guru ini (Opsional tapi direkomendasikan)
    // $this->db->join('classes c', 's.class_id = c.id');
    // $this->db->where('c.user_id', $user_id);

    $this->db->like('u.name', $keyword);
    $students = $this->db->get()->result_array();

    foreach ($students as $s) {
        $results[] = [
            'title' => 'Siswa: ' . $s['name'],
            'desc'  => $s['email'],
            'type'  => 'Siswa',
            'url'   => '#' // Link detail siswa
        ];
    }

    // ==========================================
    // 3. CARI MATERI (NEW)
    // ==========================================
    // Mencari materi (pbl_orientasi) yang terhubung dengan kelas milik guru ini
    $this->db->select('m.id, m.title, m.reflection, m.class_id');
    $this->db->from('pbl_orientasi m');
    $this->db->join('classes c', 'm.class_id = c.id'); // Hubungkan materi ke kelas
    
    $this->db->like('m.title', $keyword);
    $this->db->where('c.user_id', $user_id); // Pastikan materi berada di kelas milik guru yang login
    
    $materials = $this->db->get()->result_array();

    foreach ($materials as $m) {
        $results[] = [
            'title' => 'Materi: ' . $m['title'],
            'desc'  => substr(strip_tags($m['reflection']), 0, 50) . '...',
            'type'  => 'Materi',
            'url'   => base_url('guru/pbl/index/' . $m['class_id']) // Sesuaikan URL detail materi untuk guru
        ];
    }

    return $results;
}

    // === PENCARIAN UNTUK SISWA ===
    // Mencari Materi (PBL Orientasi)
    public function search_siswa($keyword, $user_id)
    {
        $results = [];

        // Cari Materi di pbl_orientasi
        $this->db->like('title', $keyword);
        // (Opsional: Filter berdasarkan class_id siswa jika perlu)
        $materials = $this->db->get('pbl_orientasi')->result_array();

        foreach ($materials as $m) {
            $results[] = [
                'title' => 'Materi: ' . $m['title'],
                'desc'  => substr(strip_tags($m['reflection']), 0, 50) . '...',
                'type'  => 'Materi',
                'url'   => base_url('siswa/pbl/index/' . $m['class_id'])
            ];
        }

        return $results;
    }
}