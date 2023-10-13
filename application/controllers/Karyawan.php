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
    public function upload_img($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/';
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
    public function index()
    {
        $data['admin_data'] = $this->m_model->get_data('admin')->result();
        $this->load->view('karyawan/index', $data);
    }
    public function tambah_absensi()
    {
        $this->m_model->get_data()->result();
        $this->load->view('karyawan/menu_absen');
    }
    public function aksi_tambah_absensi()
    {
        $data = [
            'kegiatan' => $this->input->post('kegiatan'),
            'tanggal' => date('Y-m-d'),
            // Tanggal saat ini
            'jam_masuk' => date('H:i:s'),
            // Jam masuk saat ini
        ];

        $this->m_model->tambah_data('absensi', $data);
        redirect(base_url('karyawan/index'));
    }

    public function history()
    {
        $id_karyawan = $this->session->userdata('id');
        $data['absensi'] = $this->m_model->get_absensi_by_karyawan($id_karyawan);
        $this->load->view('karyawan/history', $data);
    }

    public function tambah_menu_absen()
    {
        $this->load->view('karyawan/history/tambah_menu_absen');
    }
    public function update_menu_absen($id)
    {
        $data['absensi'] = $this->m_model->get_by_id('absensi', 'id', $id)->result();
        $this->load->view('karyawan/history/update_menu_absen', $data);
    }

    public function aksi_tambah_menu_absen()
    {
        $id_karyawan = $this->session->userdata('id');
        $tanggal_sekarang = date('Y-m-d'); // Mendapatkan tanggal hari ini

        // Cek apakah sudah melakukan absen hari ini
        $is_already_absent = $this->m_model->cek_absen($id_karyawan, $tanggal_sekarang);

        // Cek apakah sudah melakukan izin hari ini
        $is_already_izin = $this->m_model->cek_izin($id_karyawan, $tanggal_sekarang);

        if ($is_already_absent) {
            $this->session->set_flashdata('gagal_absen', 'Anda sudah melakukan absen hari ini.');
        } elseif ($is_already_izin) {
            $this->session->set_flashdata('gagal_absen', 'Anda sudah mengajukan izin hari ini.');
        } else {
            $data = [
                'id_karyawan' => $id_karyawan,
                'kegiatan' => $this->input->post('kegiatan'),
                'status' => 'false',
                'keterangan_izin' => 'masuk',
                'jam_pulang' => '00:00:00',
                // Mengosongkan jam_pulang
                'date' => $tanggal_sekarang,
                // Menyimpan tanggal absen
            ];
            $this->m_model->tambah_data('absensi', $data);
            $this->session->set_flashdata('berhasil_absen', 'Berhasil Absen.');
        }

        redirect(base_url('karyawan/history'));
    }

    public function aksi_update_menu_absen()
    {
        $id_karyawan = $this->session->userdata('id');
        $data = [
            'kegiatan' => $this->input->post('kegiatan'),
        ];
        $eksekusi = $this->m_model->update_data
        ('absensi', $data, array('id' => $this->input->post('id')));
        if ($eksekusi) {
            $this->session->set_flashdata('berhasil_update', 'Berhasil mengubah kegiatan');
            redirect(base_url('karyawan/history'));
        } else {
            redirect(base_url('karyawan/history/update_menu_absen/' . $this->input->post('id')));
        }
    }

    public function izin()
    {
        $this->load->view('karyawan/izin');
    }
    public function profile()
    {
        $data['akun'] = $this->m_model->get_by_id('admin', 'id', $this->session->userdata('id'))->result();
        $this->load->view('karyawan/profile', $data);
    }

    public function edit_profile()
    {
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $nama_depan = $this->input->post('nama_depan');
        $nama_belakang = $this->input->post('nama_belakang');

        $data = array(
            'email' => $email,
            'username' => $username,
            'nama_depan' => $nama_depan,
            'nama_belakang' => $nama_belakang,
        );

        if (!empty($password_baru)) {
            if ($password_baru === $konfirmasi_password) {
                $data['password'] = md5($password_baru);
            } else {
                $this->session->set_flashdata('message', 'Password baru dan Konfirmasi password tidak sama');
                redirect(base_url('karyawan/profile'));
            }
        }



        $this->session->set_userdata($data);
        $update_result = $this->m_model->update_data('admin', $data, array('id' => $this->session->userdata('id')));

        if ($update_result) {
            redirect(base_url('karyawan/profile'));
        } else {
            redirect(base_url('karyawan/profile'));
        }
    }

    public function edit_foto()
    {
        $config['upload_path'] = './assets/images/'; // Lokasi penyimpanan gambar di server
        $config['allowed_types'] = 'jpg|jpeg|png'; // Tipe file yang diizinkan
        $config['max_size'] = 5120; // Maksimum ukuran file (dalam KB)

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('userfile')) {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            // Update nama file gambar baru ke dalam database untuk user yang sesuai
            $user_id = $this->session->userdata('id'); // Ganti ini dengan cara Anda menyimpan ID user yang sedang login
            $current_image = $this->m_model->get_current_image($user_id); // Dapatkan nama gambar saat ini

            if ($current_image !== 'User.png') {
                // Hapus gambar saat ini jika bukan 'User.png'
                unlink('./assets/images/' . $current_image);
            }

            $this->m_model->update_image($user_id, $file_name); // Gantilah 'm_model' dengan model Anda

            // Redirect atau tampilkan pesan keberhasilan
            redirect('karyawan/profile'); // Gantilah dengan halaman yang sesuai
        } else {
            $error = array('error' => $this->upload->display_errors());
            // Tangani kesalahan unggah gambar
        }
    }
}
?>