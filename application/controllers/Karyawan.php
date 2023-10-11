<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'karyawan') {
			redirect(base_url() . 'auth');
		}
    }
    public function index()
    {
        $data['admin_data'] = $this->m_model->get_data('admin')->result();
        $this->load->view('karyawan/index', $data);
    }
    public function menu_absen()
    {
        $this->load->view('karyawan/menu_absen');
    }
    public function history()
    {
        $this->load->view('karyawan/history');
    }

}
?>