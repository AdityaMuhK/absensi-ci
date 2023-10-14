<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_data($table)
    {
        return $this->db->get($table);
    }

    public function get_by_id($table, $field, $id)
    {
        return $this->db->get_where($table, array($field => $id))->row();
    }

    public function update($table, $data, $where)
    {
        $data = $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function getAbsensiById($absen_id)
    {
        return $this->db->get_where('absensi', array('id' => $absen_id))->row();
    }

    public function addAbsensi($data)
    {
        $data['date'] = date('Y-m-d');
        $data['jam_masuk'] = date('H:i:s');
        $data['status'] = 'NOT';

        $this->db->insert('absensi', $data);

        return $this->db->insert_id();
    }

    public function setAbsensiPulang($absen_id)
    {
        $data = array(
            'jam_pulang' => date('H:i:s'),
            'status' => 'DONE'
        );

        $this->db->where('id', $absen_id);
        $this->db->update('absensi', $data);
    }

    public function addIzin($data)
    {

        $data = array(
            'id_karyawan' => $data['id_karyawan'],
            'keterangan_izin' => $data['keterangan'],
            'date' => date('Y-m-d'),
            'kegiatan' => '-',
            'jam_masuk' => '-',
            'jam_pulang' => '-',
            'status' => 'DONE'
        );

        $this->db->insert('absensi', $data);
    }

    public function hapusAbsensi($absen_id)
    {
        $this->db->where('id', $absen_id);
        $this->db->delete('absensi');
    }

    public function updateAbsensi($absen_id, $data)
    {
        $this->db->where('id', $absen_id);
        $this->db->update('absensi', $data);
    }

    public function batalPulang($absen_id)
    {
        $data = array(
            'jam_pulang' => null,
            'status' => 'NOT'
        );

        $this->db->where('id', $absen_id);
        $this->db->update('absensi', $data);
    }


}