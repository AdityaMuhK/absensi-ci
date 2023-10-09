<!-- SISWA -->
<?php
function tampil_full_kelas_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('kelas');
    foreach ($result->result() as $c) {
        $stmt = $c->tingkat_kelas . ' ' . $c->jurusan_kelas;
        return $stmt;
    }
}
?>
<!-- GURU -->
<?php
function tampil_full_mapel_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('mapel');
    foreach ($result->result() as $c) {
        $stmt = $c->nama_mapel;
        return $stmt;
    }
}

?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_siswa_by_id')) {
    function get_siswa_by_id($id_siswa)
    {
        $ci =& get_instance();
        $ci->load->database();

        $ci->db->where('id_siswa', $id_siswa);
        return $ci->db->get('siswa')->row();
    }
}
?>