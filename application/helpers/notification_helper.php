<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_dynamic_notifications')) {
    function get_dynamic_notifications()
    {
        $CI = &get_instance();
        $CI->load->model('Notification_model', 'notif_model');

        // Ambil data session
        $role = $CI->session->userdata('role');
        $user_id = $CI->session->userdata('user_id');

        $notifications = [];

        if ($role === 'Guru') {
            // Logika Guru: Notif ada Tugas Masuk
            $raw_data = $CI->notif_model->get_notifs_guru($user_id);
            
            foreach($raw_data as $row) {
                $notifications[] = [
                    'title'   => 'Tugas Masuk',
                    'message' => '<strong>' . html_escape($row['student_name']) . '</strong> mengumpulkan tugas "' . html_escape($row['task_title']) . '"',
                    'time'    => time_elapsed_string($row['created_at']),
                    'icon'    => 'bi-exclamation-circle text-warning', // Icon kuning (warning/perhatian)
                    // Sesuaikan link ini ke halaman detail penilaian guru
                    'link'    => base_url('guru/pbl_esai/detail/' . $row['essay_id']) 
                ];
            }

        } elseif ($role === 'Siswa') {
            // Logika Siswa: Notif Nilai Keluar
            $raw_data = $CI->notif_model->get_notifs_siswa($user_id);

            foreach($raw_data as $row) {
                $notifications[] = [
                    'title'   => 'Tugas Dinilai',
                    'message' => 'Tugas "' . html_escape($row['task_title']) . '" mendapat nilai: <strong>' . $row['grade'] . '</strong>',
                    'time'    => time_elapsed_string($row['updated_at']),
                    'icon'    => 'bi-check-circle text-success', // Icon hijau (selesai)
                    // Sesuaikan link ini ke halaman detail jawaban siswa
                    'link'    => base_url('siswa/pbl_esai/detail/' . $row['essay_id']) 
                ];
            }
        }

        return $notifications;
    }
}

// Helper Waktu (Convert datetime ke "30 min ago")
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }
}