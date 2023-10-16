<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('m_model');
        $this->load->helper('admin_helper');
        $this->load->library('upload');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'admin') {
            redirect(base_url() . 'auth');
        }
    }
    public function upload_img($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/siswa/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['fle_name'] = $kode;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($value)) {
            return [false, ''];
        } else {
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            return [true, $nama];
        }
    }
    // admin
    public function index()
    {
        $data['admin_data'] = $this->admin_model->get_data('absensi')->result();
        $this->load->view('admin/index', $data);
    }
    public function rekap_harian()
    {
        $date = $this->input->get('tanggal'); // Ambil date dari parameter GET
        $data['rekap_harian'] = $this->admin_model->getRekapHarian($date);
        $this->load->view('admin/rekap_harian', $data);
    }
    public function rekap_mingguan()
    {
        $date = $this->input->get('tanggal'); // Ambil date dari parameter GET
        $data['rekap_mingguan'] = $this->admin_model->getAbsensiLast7Days($date);
        $this->load->view('admin/rekap_mingguan', $data);
    }

    public function rekap_bulanan()
{
    $bulan = $this->input->get('bulan'); // Ambil nilai bulan dari form

    if ($bulan) {
        $data['rekap_bulanan'] = $this->admin_model->getRekapBulan($bulan);
    } else {
        $data['rekap_bulanan'] = array(); // Inisialisasi data kosong jika tidak ada bulan yang dipilih
    }

    $this->load->view('admin/rekap_bulanan', $data);
}

}
?>