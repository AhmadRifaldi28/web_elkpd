<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_tahap5_model extends CI_Model
{
  private $table_results = 'pbl_final_results';
  private $table_users = 'users'; 
  private $table_students = 'students'; // Tabel penghubung siswa ke kelas

  /**
   * GURU: Mengambil semua siswa di kelas beserta status nilai akhirnya
   */
  public function get_students_with_grades($class_id)
  {
    // 1. Select kolom yang dibutuhkan
    $this->db->select('u.id as user_id, u.name as student_name, u.image,
       r.id as result_id, r.final_score, r.feedback, r.status');
    
    // 2. Mulai dari tabel Users (u)
    $this->db->from($this->table_users . ' as u');

    // 3. Join ke tabel Students (s) untuk memfilter siswa di kelas ini
    //    (students.user_id = users.id)
    $this->db->join($this->table_students . ' as s', 's.user_id = u.id');
    
    // 4. Left Join ke tabel Nilai (r) 
    //    (agar siswa yang belum dinilai tetap muncul di list)
    $this->db->join($this->table_results . ' as r', 
      'r.user_id = u.id AND r.class_id = ' . $this->db->escape($class_id), 
        'left');

    // 5. Filter Kondisi
    $this->db->where('s.class_id', $class_id); // Filter berdasarkan kelas
    $this->db->where('u.role_id', '2');        // Filter hanya role siswa (sesuai DB Anda '2' biasanya siswa)
    
    $this->db->order_by('u.name', 'ASC');
    
    return $this->db->get()->result();
  }

  /**
   * GURU: Simpan/Update Nilai (Upsert Logic)
   */
  public function save_grade($data)
  {
    // Cek apakah data nilai sudah ada untuk siswa ini di kelas ini
    $exists = $this->db->where('class_id', $data['class_id'])
    ->where('user_id', $data['user_id'])
    ->get($this->table_results)
    ->row();

    if ($exists) {
      // Update jika sudah ada
      $this->db->where('id', $exists->id);
      return $this->db->update($this->table_results, $data);
    } else {
      // Insert jika belum ada
      // Pastikan helper string/ulid dimuat di controller
      $data['id'] = generate_ulid(); 
      return $this->db->insert($this->table_results, $data);
    }
  }

  /**
   * SISWA: Ambil nilai akhir diri sendiri
   */
  public function get_my_result($class_id, $user_id)
  {
    return $this->db->where('class_id', $class_id)
      ->where('user_id', $user_id)
      ->get($this->table_results)
      ->row();
  }
}

/* End of file Pbl_tahap5_model.php */
/* Location: ./application/models/Pbl_tahap5_model.php */