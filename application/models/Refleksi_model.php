<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refleksi_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

  /**
   * Mengambil rekap nilai siswa + data refleksi jika ada
   * 
   */
  public function getAllStudentScores($class_id, $only_locked = false)
  {
        $this->db->select('
            u.id as user_id, 
            u.name as student_name, 
            u.image,
            
            -- Nilai Tahap 2: Quiz (AVG)
            COALESCE((SELECT AVG(score) FROM pbl_quiz_results WHERE user_id = u.id), 0) as quiz_score,
            
            -- Nilai Tahap 2: TTS (AVG)
            COALESCE((SELECT AVG(score) FROM pbl_tts_results WHERE user_id = u.id), 0) as tts_score,

            -- Nilai Tahap 3: Observasi (AVG)
            COALESCE((SELECT AVG(score) FROM pbl_observation_results WHERE user_id = u.id), 0) as obs_score,

            -- Nilai Tahap 4: Esai (AVG - jaga-jaga jika ada lebih dari 1 esai)
            COALESCE((SELECT AVG(grade) FROM pbl_essay_submissions WHERE user_id = u.id), 0) as essay_score,

            -- Data Refleksi (Tahap 5) - Menggunakan MAX() untuk menghindari ONLY_FULL_GROUP_BY
            MAX(r.id) as reflection_id,
            MAX(r.teacher_reflection) as teacher_reflection,
            MAX(r.student_feedback) as student_feedback,
            MAX(r.created_at) as reflection_date,
            -- AMBIL STATUS LOCKED (Default 0 jika null)
            COALESCE(MAX(r.is_locked), 0) as is_locked
        ');

        $this->db->from('students s'); 
        $this->db->join('users u', 'u.id = s.user_id'); 
        
        // Join ke tabel refleksi
        $this->db->join('pbl_reflections r', 'r.user_id = u.id AND r.class_id = s.class_id', 'left');

        $this->db->where('s.class_id', $class_id);

        // FILTER KHUSUS DATA YANG SUDAH DILOCK
        if ($only_locked) {
            $this->db->where('r.is_locked', 1);
        }
        
        $this->db->group_by('u.id'); 

        return $this->db->get()->result();
  }

  // Ambil Data Sekolah berdasarkan Class ID
  public function getSchoolByClassId($class_id)
  {
    $this->db->select('s.*');
    $this->db->from('classes c');
    $this->db->join('schools s', 's.id = c.school_id');
    $this->db->where('c.id', $class_id);
    return $this->db->get()->row();
  }

  // Ambil Info Kelas
  public function getClassInfo($class_id)
  {
    return $this->db->get_where('classes', ['id' => $class_id])->row();
  }

  // FUNGSI BARU: Update Status Lock
    public function set_lock_status($class_id, $user_id, $status)
    {
        // Cek apakah data refleksi sudah ada?
        $exists = $this->db->get_where('pbl_reflections', [
            'class_id' => $class_id,
            'user_id'  => $user_id
        ])->row();

        if ($exists) {
            // Update status
            $this->db->where('id', $exists->id);
            return $this->db->update('pbl_reflections', ['is_locked' => $status]);
        } else {
            // Jika belum ada data refleksi, tidak bisa dikunci (karena belum ada nilai/feedback)
            return false;
        }
    }
    
    // FUNGSI BARU: Cek akses siswa
    public function check_student_access($class_id, $user_id)
    {
        $row = $this->db->get_where('pbl_reflections', [
            'class_id' => $class_id,
            'user_id'  => $user_id,
            'is_locked' => 1 // Hanya boleh akses jika 1
        ])->row();

        return $row ? true : false;
    }

  public function getFinalRecapByClass($class_id)
{
    $this->db->select("
        u.id AS user_id,
        u.name AS student_name,
        u.image,

        -- Rata-rata nilai per komponen
        ROUND(
            (SELECT AVG(score)
             FROM pbl_quiz_results
             WHERE user_id = u.id), 2
        ) AS quiz_avg,

        ROUND(
            (SELECT AVG(score)
             FROM pbl_tts_results
             WHERE user_id = u.id), 2
        ) AS tts_avg,

        ROUND(
            (SELECT AVG(score)
             FROM pbl_observation_results
             WHERE user_id = u.id), 2
        ) AS obs_avg,

        ROUND(
            (SELECT AVG(grade)
             FROM pbl_essay_submissions
             WHERE user_id = u.id), 2
        ) AS essay_avg,

        -- Snapshot nilai akhir (jika sudah dikunci)
        MAX(r.final_score) AS final_score,
        MAX(r.is_locked) AS is_locked,

        -- Status refleksi
        MAX(
            CASE 
                WHEN r.teacher_reflection IS NOT NULL 
                  OR r.student_reflection IS NOT NULL
                THEN 1 ELSE 0 
            END
        ) AS has_reflection
    ");

    $this->db->from('students s');
    $this->db->join('users u', 'u.id = s.user_id');
    $this->db->join(
        'pbl_reflection r',
        'r.user_id = u.id AND r.class_id = s.class_id',
        'left'
    );

    $this->db->where('s.class_id', $class_id);
    $this->db->group_by('u.id');

    return $this->db->get()->result();
}

/* Tambahkan function ini di dalam Refleksi_model.php */

public function getSingleStudentScore($class_id, $user_id)
{
    $this->db->select('
        u.id as user_id, 
        u.name as student_name, 
        u.image,
        
        -- Nilai Tahap 2: Quiz (AVG)
        COALESCE((SELECT AVG(score) FROM pbl_quiz_results WHERE user_id = u.id), 0) as quiz_score,
        
        -- Nilai Tahap 2: TTS (AVG)
        COALESCE((SELECT AVG(score) FROM pbl_tts_results WHERE user_id = u.id), 0) as tts_score,

        -- Nilai Tahap 3: Observasi (AVG)
        COALESCE((SELECT AVG(score) FROM pbl_observation_results WHERE user_id = u.id), 0) as obs_score,

        -- Nilai Tahap 4: Esai (AVG)
        COALESCE((SELECT AVG(grade) FROM pbl_essay_submissions WHERE user_id = u.id), 0) as essay_score,

        -- Data Refleksi
        MAX(r.id) as reflection_id,
        MAX(r.teacher_reflection) as teacher_reflection,
        MAX(r.student_feedback) as student_feedback,
        MAX(r.created_at) as reflection_date,
        COALESCE(MAX(r.is_locked), 0) as is_locked
    ');

    $this->db->from('students s'); 
    $this->db->join('users u', 'u.id = s.user_id'); 
    $this->db->join('pbl_reflections r', 'r.user_id = u.id AND r.class_id = s.class_id', 'left');

    $this->db->where('s.class_id', $class_id);
    
    // --- FILTER TAMBAHAN KHUSUS 1 SISWA ---
    $this->db->where('u.id', $user_id); 
    // --------------------------------------

    $this->db->group_by('u.id'); 

    // Tetap gunakan result() agar outputnya array [{...}] 
    // sehingga JS .map() tetap jalan lancar.
    return $this->db->get()->result(); 
}

public function getReflectionRecapByClass($class_id)
{
    $this->db->select("
        u.id AS user_id,
        u.name AS student_name,

        -- WAJIB pakai MAX() agar lolos ONLY_FULL_GROUP_BY
        MAX(r.teacher_reflection) AS teacher_reflection,
        MAX(r.teacher_feedback)   AS teacher_feedback,
        MAX(r.is_locked)          AS is_locked
    ");

    $this->db->from('students s');
    $this->db->join('users u', 'u.id = s.user_id');

    // PENTING: tetap pakai pbl_reflection (tunggal)
    $this->db->join(
        'pbl_reflection r',
        'r.user_id = u.id AND r.class_id = s.class_id',
        'left'
    );

    $this->db->where('s.class_id', $class_id);

    // Group hanya per siswa
    $this->db->group_by('u.id');

    return $this->db->get()->result();
}


public function isLocked($class_id, $user_id)
{
    $row = $this->db->get_where('pbl_reflection', [
        'class_id' => $class_id,
        'user_id'  => $user_id
    ])->row();

    return $row && (int)$row->is_locked === 1;
}



  public function save_reflection($data)
  {
    // Cek apakah data sudah ada
  	$exists = $this->db->get_where('pbl_reflections', [
  		'class_id' => $data['class_id'],
  		'user_id'  => $data['user_id'],
  	])->row();

  	if ($exists) {
        // Update jika sudah ada
  		$this->db->where('id', $exists->id);
  		return $this->db->update('pbl_reflections', [
  			'teacher_reflection' => $data['teacher_reflection'],
  			'student_feedback'   => $data['student_feedback'],
        'is_locked'          => $data['is_locked'] // Update status kunci
  		]);
  	} else {
      // Insert baru jika belum ada
  		if (empty($data['id'])) {
  			$data['id'] = generate_ulid(); 
  		}

  		return $this->db->insert('pbl_reflections', $data);
  	}
  }

  public function get_class_reflection($class_id)
  {
    return $this->db
      ->where('class_id', $class_id)
      ->get('pbl_class_reflections')
      ->result();
  }

  public function save_class_reflection($data)
  {
    $existing = $this->db->get_where('pbl_class_reflections', [
        'class_id' => $data['class_id']
    ])->row();

    if ($existing) {
      $this->db->where('id', $existing->id);
      return $this->db->update('pbl_class_reflections', [
        'strengths' => $data['strengths'],
        'obstacles' => $data['obstacles'],
        'competency_achievement' => $data['competency_achievement']
      ]);
    }

    $data['id'] = generate_ulid();
    return $this->db->insert('pbl_class_reflections', $data);
  }

}

/* End of file Refleksi_model.php */
/* Location: ./application/models/Refleksi_model.php */