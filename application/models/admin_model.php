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
        $this->db->join('akun', 'absensi.id_karyawan = akun.id', 'left');
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
    public function ubah_data($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
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
    public function get_all_karyawan()
    {
        $this->db->select('absensi.*, akun.nama_depan, akun.nama_belakang');
        $this->db->from('absensi');
        $this->db->join('akun', 'absensi.id_karyawan = akun.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    //start get data perhari
    public function getHarianData($tanggal)
    {
        $this->db->select('absensi.*, akun.nama_depan, akun.nama_belakang');
        $this->db->from('absensi');
        $this->db->join('akun', 'absensi.id_karyawan = akun.id', 'left');
        $this->db->where('date', $tanggal);
        $query = $this->db->get();
        return $query->result();
    }
    // start get data per minggu
    public function getMingguanData($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('absensi.*, akun.nama_depan, akun.nama_belakang');
        $this->db->from('absensi');
        $this->db->join('akun', 'absensi.id_karyawan = akun.id', 'left');
        $this->db->where("WEEK(date, 3) BETWEEN $tanggal_awal AND $tanggal_akhir");
        $query = $this->db->get();
        return $query->result();
    }

    //start get data per bulan
    public function getBulananData($bulan)
    {
        $this->db->select("absensi.*, akun.nama_depan, akun.nama_belakang");
        $this->db->from("absensi");
        $this->db->join("akun", "absensi.id_karyawan = akun.id", "left");
        $this->db->where("DATE_FORMAT(date, '%m') = ", $bulan); // Perbaikan di sini
        $query = $this->db->get();
        return $query->result();
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
    public function image_akun()
    {
        $id_karyawan = $this->session->akundata('id');
        $this->db->select('image');
        $this->db->from('akun');
        $this->db->where('id_karyawan');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->image;
        } else {
            return false;
        }
    }

    public function get_admin_image_by_id($id)
    {
        $this->db->select('image');
        $this->db->from('akun');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->image;
        } else {
            return false;
        }
    }
    public function update_image($akun_id, $new_image)
    {
        $data = array(
            'image' => $new_image
        );

        $this->db->where('id', $akun_id); // Sesuaikan dengan kolom dan nama tabel yang sesuai
        $this->db->update('akun', $data); // Sesuaikan dengan nama tabel Anda

        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang diupdate
    }

    public function get_current_image($akun_id)
    {
        $this->db->select('image');
        $this->db->from('akun'); // Gantilah 'akun_table' dengan nama tabel Anda
        $this->db->where('id', $akun_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->image;
        }

        return null; // Kembalikan null jika data tidak ditemukan
    }

}