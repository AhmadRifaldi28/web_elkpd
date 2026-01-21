<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_search_results')) {
    function get_search_results($keyword)
    {
        $CI = &get_instance();
        $CI->load->model('Search_model', 'search_model');

        // Ambil Session
        $role = $CI->session->userdata('role');       // 'Guru' atau 'Siswa'
        $user_id = $CI->session->userdata('user_id');

        if (empty($keyword)) {
            return [];
        }

        // Logika Percabangan Role
        if ($role === 'Guru') {
            return $CI->search_model->search_guru($keyword, $user_id);
        } elseif ($role === 'Siswa') {
            return $CI->search_model->search_siswa($keyword, $user_id);
        } else {
            return []; // Admin atau Role lain
        }
    }
}