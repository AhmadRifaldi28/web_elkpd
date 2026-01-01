<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {

	protected $table = 'teachers';

	public function insert($d){ return $this->db->insert($this->table,$d); }
	public function update($id,$d){ return $this->db->where('id',$id)->update($this->table,$d); }
	public function get($id){ return $this->db->where('id',$id)->get($this->table)->row(); }
	public function get_all_with_user_and_school(){
    // $this->db->select('t.*, u.username, u.name AS user_name, s.name AS school_name');
    // SESUDAH (Ubah 'user_name' menjadi 'name' dan tambahkan 'u.email')
		$this->db->select('t.*, u.username, u.name, u.email, s.name AS school_name');
		$this->db->from('teachers t');
		$this->db->join('users u','u.id = t.user_id','left');
		$this->db->join('schools s','s.id = t.school_id','left');
		return $this->db->get()->result();
	}

  /**
   * Mengambil semua sekolah yang terhubung dengan seorang guru.
   * @param string $user_id ID guru (dari session)
   * @return array Array objek hasil query
   */
  public function get_sekolah_by_guru($user_id)
  {
    $this->db->select('s.id, s.name, s.address'); // Menggunakan 'name' sesuai skema tabel schools
    $this->db->from('schools as s');
    $this->db->join('teachers as t', 's.id = t.school_id');
    $this->db->where('t.user_id', $user_id);
    
    return $this->db->get()->result();
  }

  /**
   * Mengambil detail satu sekolah berdasarkan ID.
   * @param string $school_id ID sekolah
   * @return object Objek hasil query (satu baris)
   */
  public function get_school_by_id($school_id)
  {
  	$this->db->where('id', $school_id);
  	return $this->db->get('schools')->row();
  }

  /**
   * Mengambil semua kelas yang dibuat oleh guru di sekolah tertentu.
   * * CATATAN: Query ini mengasumsikan:
   * 1. Kolom `classes.user_id` berisi `user_id` guru (sesuai skema `classes`).
   * 2. Tabel `classes` memiliki kolom `school_id` (wajib untuk fungsionalitas ini).
   *
   * @param string $user_id ID guru (dari session)
   * @param string $school_id ID sekolah
   * @return array Array objek hasil query
   */
  public function get_kelas_by_guru_dan_sekolah($user_id, $school_id)
  {
      // Menggunakan 'user_id' sesuai skema tabel 'classes'
  	$this->db->where('user_id', $user_id); 

      // Asumsi kolom 'school_id' ada di tabel 'classes'
  	$this->db->where('school_id', $school_id); 

  	return $this->db->get('classes')->result();
  }

  /**
   * Mengambil satu kelas spesifik,
   * memastikan kelas itu milik guru yang login.
   */
  public function get_class_by_id($class_id, $user_id)
  {
  	return $this->db->get_where('classes', [
  		'id' => $class_id, 
  		'user_id' => $user_id
  	])->row();
  }

  /**
   * [READ] Mengambil detail kelas, HANYA jika dimiliki oleh guru yg login.
   * Ini adalah fungsi keamanan penting.
   * @param string $kelas_id ID kelas
   * @param string $user_id ID guru (dari session)
   * @return object|null
   */
  public function get_kelas_by_id_dan_guru($kelas_id, $user_id)
  {
  	$this->db->where('id', $kelas_id);
  	$this->db->where('user_id', $user_id);
  	return $this->db->get('classes')->row();
  }

  /**
   * Menambahkan kelas baru ke database.
   */
  public function insert_class($payload)
  {
    // 'user_id', 'school_id', 'name', 'code', 'id'
    // semuanya sudah ada di dalam $payload
  	return $this->db->insert('classes', $payload);
  }

  /**
   * Memperbarui kelas yang ada.
   * HANYA memperbarui jika ID dan user_id cocok.
   */
  public function update_class($class_id, $user_id, $payload)
  {
  	$this->db->where('id', $class_id);
    $this->db->where('user_id', $user_id); // Keamanan: Hanya pemilik yang bisa update
    return $this->db->update('classes', $payload);
  }

  /**
   * Menghapus kelas.
   * HANYA menghapus jika ID dan user_id cocok.
   */
  public function delete_class($class_id, $user_id)
  {
		$this->db->where('id', $class_id);
	  $this->db->where('user_id', $user_id); // Keamanan: Hanya pemilik yang bisa hapus
	  return $this->db->delete('classes');
  }

  /**
   * Mengambil detail satu kelas spesifik.
   * Memastikan kelas itu milik guru yang login.
   */
  public function get_class_details($class_id, $user_id)
  {
      // Ambil info kelas
  	$class = $this->db->get_where('classes', [
  		'id' => $class_id, 
  		'user_id' => $user_id
  	])->row();

  	if (!$class) return null;

      // Hitung jumlah siswa di kelas
  	$this->db->where('class_id', $class_id);
  	$class->student_count = $this->db->count_all_results('students');

  	return $class;
  }

  /**
   * [AJAX LOAD] Mengambil daftar siswa yang ada DI DALAM kelas tertentu.
   * Bergabung dengan tabel users untuk mendapatkan nama, username, dll.
   */
  public function get_students_in_class($class_id)
  {
    $this->db->select('s.id, u.name, u.username, u.email'); // 's.id' adalah 'students.id'
    $this->db->from('students s');
    $this->db->join('users u', 'u.id = s.user_id');
    $this->db->where('s.class_id', $class_id);
    return $this->db->get()->result();
  }

  /**
   * [MODAL DROPDOWN] Mengambil daftar siswa yang BELUM MEMILIKI KELAS.
   * Ini untuk mengisi <select> di modal "Tambah Siswa".
   * Asumsi: Siswa yang 'tersedia' adalah yang 'class_id'-nya NULL
   */
  public function get_available_students()
  {
    $this->db->select('s.id, u.name, u.username'); // 's.id' adalah 'students.id'
    $this->db->from('students s');
    $this->db->join('users u', 'u.id = s.user_id');
    $this->db->where('s.class_id IS NULL');
    // Anda mungkin ingin memfilter berdasarkan sekolah di sini jika ada relasinya
    return $this->db->get()->result();
  }

  /**
   * [AJAX SAVE] Menambahkan siswa ke kelas (meng-UPDATE students.class_id).
   * @param string $student_id ID dari tabel 'students'
   * @param string $class_id ID dari tabel 'classes'
   */
  public function add_student_to_class($user_id, $class_id)
    {
        // 1. Cek sekali lagi apakah user ini sudah ada di tabel students
        $existing = $this->db->get_where('students', ['user_id' => $user_id])->row();

        // 2. Jika BELUM ADA, maka INSERT
        if ($existing === NULL) {
            $payload = [
                'id' => generate_ulid(), // Helper ULID Anda
                'user_id' => $user_id,
                'class_id' => $class_id
            ];
            return $this->db->insert('students', $payload);
        }

        // 3. Jika SUDAH ADA (mungkin di kelas lain), gagalkan.
        // Atau jika 'class_id' nya NULL (kasus update), Anda bisa tangani di sini.
        // Tapi berdasarkan permintaan Anda, kita fokus pada INSERT.
        return false; // Gagal karena user sudah ada
    }

    /**
     * [REVISI TOTAL] - Mengeluarkan siswa dari kelas (DELETE dari students).
     *
     * Ini akan menghapus baris dari 'students',
     * membuat user 'tersedia' lagi di dropdown.
     *
     * @param string $student_id ID dari baris di tabel 'students' (BUKAN user_id)
     * @param string $user_id_guru ID guru (untuk keamanan, opsional)
     * @return bool
     */
    /*public function remove_student_from_class($student_id, $user_id_guru = null)
    {
        $this->db->where('id', $student_id);
        return $this->db->delete('students');
    }*/

  /**
   * [AJAX DELETE] Mengeluarkan siswa dari kelas (set class_id = NULL).
   * @param string $student_id ID dari tabel 'students'
   * @param string $class_id ID kelas (untuk keamanan, pastikan kita hapus dari kelas yg benar)
   */
  public function remove_student_from_class($student_id, $class_id)
  {
  	$this->db->where('id', $student_id);
    $this->db->where('class_id', $class_id); // Keamanan
    return $this->db->delete('students');
    // return $this->db->update('students', ['class_id' => NULL]);
  }

}

/* End of file Guru_model.php */
/* Location: ./application/models/Guru_model.php */