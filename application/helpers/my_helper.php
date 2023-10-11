<?php

if (!function_exists('getLoggedInUserName')) {
    function getLoggedInUserName()
    {
        $CI =& get_instance();
        return $CI->session->userdata('nama_depan') . ' ' . $CI->session->userdata('nama_belakang');
    }
}

?>