<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_data($tabel)
    {
        return $this->db->get($tabel);
    }

    function getwhere($tabel, $data)
    {
        return $this->db->get_where($tabel, $data);
    }
    public function delete($tabel, $field, $id)
    {
        $data = $this->db->delete($tabel, array($field => $id));
        return $data;
    }
    public function tambah_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        return $this->db->insert_id();
    }

    public function get_by_id($tabel, $id_column, $id)
    {
        $data = $this->db->where($id_column, $id)->get($tabel);
        return ($data);
    }
    public function getKaryawan()
    {
        $query = $this->db->get('absensi');
        return $query->result_array();
    }

    public function getRekapHarian($date)
    {
        $this->db->select('absensi.id, absensi.date, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status');
        $this->db->from('absensi');
        $this->db->where('absensi.date', $date); // Menyaring data berdasarkan date
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAbsensiLast7Days($date)
    {
        // Ubah format tanggal yang dipilih menjadi format yang sesuai dengan database Anda
        $date = date('Y-m-d', strtotime($date));

        // Ambil data absensi berdasarkan tanggal
        $this->db->where('date >=', date('Y-m-d', strtotime('-7 days', strtotime($date))));
        $this->db->where('date <=', $date);
        $this->db->select('absensi.id, absensi.date, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status');
        return $this->db->get('absensi')->result();
    }




    public function getRekapBulan($bulan)
    {
        $this->db->from('absensi');
        $this->db->where("DATE_FORMAT(date, '%Y-%m') =", $bulan);
        $db = $this->db->get();
        $result = $db->result();
        return $result;
    }


    public function getRekapHarianByBulan($bulan)
    {
        $this->db->select('absensi.id, absensi.date, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status');
        $this->db->from('absensi');
        $this->db->where('MONTH(absensi.date)', $bulan);
        $query = $this->db->get();
        return $query->result_array();
    }

}