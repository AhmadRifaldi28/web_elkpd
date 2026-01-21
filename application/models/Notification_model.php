<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    // Ambil Notifikasi untuk GURU (Siswa mengumpulkan tugas, Grade = NULL)
	public function get_notifs_guru($user_id)
	{
        // 1. Cari ID Teacher berdasarkan user_id yang login
		$teacher = $this->db->get_where('teachers', ['user_id' => $user_id])->row();
		if (!$teacher) return [];

		$this->db->select('sub.id, essay_id, sub.created_at, u.name as student_name, essay.title as task_title');
		$this->db->from('pbl_essay_submissions sub');

        // Join ke User untuk ambil nama siswa
		$this->db->join('users u', 'sub.user_id = u.id');

        // Join ke Soal untuk ambil judul & class_id
		$this->db->join('pbl_solution_essays essay', 'sub.essay_id = essay.id');

        // Join ke Kelas untuk filter berdasarkan Guru
		$this->db->join('classes c', 'essay.class_id = c.id');

        // Filter: Hanya kelas milik guru ini
        // PASTIKAN tabel 'classes' memiliki kolom 'teacher_id'
		$this->db->where('c.user_id', $teacher->user_id);

        // Filter: Hanya yang BELUM dinilai
		$this->db->where('sub.grade IS NULL', null, false);

		$this->db->order_by('sub.created_at', 'DESC');
        $this->db->limit(5); // Batasi 5 notifikasi
        
        return $this->db->get()->result_array();
      }

    // Ambil Notifikasi untuk SISWA (Tugas sudah dinilai, Grade != NULL)
      public function get_notifs_siswa($user_id)
      {
      	$this->db->select('sub.id, essay_id, sub.updated_at, sub.grade, essay.title as task_title');
      	$this->db->from('pbl_essay_submissions sub');
      	$this->db->join('pbl_solution_essays essay', 'sub.essay_id = essay.id');

        // Filter: Hanya punya siswa yang login
      	$this->db->where('sub.user_id', $user_id);

        // Filter: Hanya yang SUDAH dinilai
      	$this->db->where('sub.grade IS NOT NULL', null, false);

        $this->db->order_by('sub.updated_at', 'DESC'); // Urutkan dari yang baru dinilai
        $this->db->limit(5);
        
        return $this->db->get()->result_array();
      }
    }