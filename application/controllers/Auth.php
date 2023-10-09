<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->database();
    }

    // LOGIN
    public function index()
    {
        $this->load->view('auth/login');
    }
    public function aksi_login()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $data = ['email' => $email,];
        $query = $this->m_model->getwhere('admin', $data);
        $result = $query->row_array();

        if (!empty($result) && md5($password) === $result['password']) {
            $data = [
                'logged_in' => TRUE,
                'email' => $result['email'],
                'username' => $result['username'],
                'id' => $result['id'],
            ];
            $this->session->set_userdata($data);

            redirect(base_url() . "admin");
        } else {
            redirect(base_url() . "auth");
        }
    }


    // REGISTER
    public function register()
    {
        $this->load->view('auth/register');
    }

    public function aksi_register()
    {
        $email = $this->input->post('email', true);
        $username = $this->input->post('username', true);
        $password = md5($this->input->post('password', true));
        $nama_depan = $this->input->post('nama_depan', true);
        $nama_belakang = $this->input->post('nama_belakang', true);
        $role = $this->input->post('role', true);

        // Jika ada gambar diunggah
        if ($_FILES['image']['name']) {
            $config['upload_path'] = './path_to_upload_directory/'; // Ganti dengan lokasi direktori upload Anda
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048; // Ukuran file maksimum (dalam KB)

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $image_data = $this->upload->data();
                $image = $image_data['file_name'];
            } else {
                $image = 'User.png'; // Jika gagal mengunggah, menggunakan gambar default
            }
        } else {
            $image = 'User.png'; // Jika tidak ada gambar diunggah, menggunakan gambar default
        }

        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => $role,
            'nama_depan' => $nama_depan,
            'nama_belakang' => $nama_belakang,
            'image' => $image
        ];

        $table = 'admin';

        $this->db->insert($table, $data);

        if ($this->db->affected_rows() > 0) {
            // Registrasi berhasil
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'email' => $email,
                'username' => $username,
                'role' => $role,
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'image' => $image
            ]);
            redirect(base_url() . "auth");
        } else {
            // Registrasi gagal
            redirect(base_url() . "auth/register");
        }
    }


    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('/'));
    }

}
?>