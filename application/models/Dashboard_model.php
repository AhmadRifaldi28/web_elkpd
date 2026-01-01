<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

	public function count_all($table)
	{
		return $this->db->count_all($table);
	}

	public function teachers_per_school()
	{
		return $this->db->query("
			SELECT s.name AS label, COUNT(t.id) AS total
			FROM schools s
			LEFT JOIN teachers t ON t.school_id = s.id
			GROUP BY s.id
			")->result();
	}

	public function students_per_school()
	{
		return $this->db->query("
			SELECT s.name AS label, COUNT(st.id) AS total
			FROM schools s
			LEFT JOIN classes c ON c.school_id = s.id
			LEFT JOIN students st ON st.class_id = c.id
			GROUP BY s.id
			")->result();
	}

	public function students_per_class()
	{
		return $this->db->query("
			SELECT c.name AS label, COUNT(s.id) AS total
			FROM classes c
			LEFT JOIN students s ON s.class_id = c.id
			GROUP BY c.id
			")->result();
	}

	public function unregistered_teachers()
	{
		return $this->db->query("
			SELECT COUNT(u.id) AS total
			FROM users u
			JOIN roles r ON r.id = u.role_id
			LEFT JOIN teachers t ON t.user_id = u.id
			WHERE r.role = 'Guru'
			AND t.id IS NULL
			")->row()->total;
	}

	public function unregistered_students()
	{
		return $this->db->query("
			SELECT COUNT(u.id) AS total
			FROM users u
			JOIN roles r ON r.id = u.role_id
			LEFT JOIN students s ON s.user_id = u.id
			WHERE r.role = 'Siswa'
			AND s.id IS NULL
			")->row()->total;
	}
}
