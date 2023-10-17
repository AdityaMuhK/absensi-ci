<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('karyawan_model');
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('upload');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'karyawan') {
            redirect(base_url() . 'auth');
        }
    }
    public function upload_img($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/karyawan/';
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
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        if ($this->session->userdata('role') === 'karyawan') {
            $data['absensi'] = $this->karyawan_model->get_data('absensi')->num_rows();
            $data['absensi_data'] = $this->karyawan_model->get_data('absensi')->result();
            $this->load->view('karyawan/index', $data);
        } else {
            redirect('auth');
        }
    }
    public function aksi_tambah_absensi()
    {
        $data = [
            'kegiatan' => $this->input->post('kegiatan'),
            'date' => date('Y-m-d'),
            // Tanggal saat ini
            'jam_masuk' => date('H:i:s'),
            // Jam masuk saat ini
        ];

        $this->m_model->tambah_data('absensi', $data);
        redirect(base_url('karyawan/index'));
    }

    public function history()
    {
        if ($this->session->userdata('role') === 'karyawan') {
            // Set zona waktu ke 'Asia/Jakarta'
            date_default_timezone_set('Asia/Jakarta');

            $data['absensi'] = $this->karyawan_model->get_data('absensi')->result();
            $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();

            $this->load->view('karyawan/history', $data);
        } else {
            redirect('auth');
        }
    }

    public function tambah_menu_absen()
    {
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();

        $this->load->view('karyawan/history/tambah_menu_absen', $data);
    }
    // public function update_menu_absen()
    // {
    //     $this->load->view('karyawan/history/update_menu_absen');
    // }

    public function aksi_tambah_menu_absen()
    {
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        if ($this->session->userdata('role') === 'karyawan') {
            $user_id = $this->session->userdata('id'); // Ambil id pengguna yang sedang login
            $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('karyawan/histori/update_menu_absen', $data);
            } else {
                date_default_timezone_set('Asia/Jakarta');
                $jam_masuk = date('H:i:s');

                $data = array(
                    'id_karyawan' => $user_id,
                    // Tetapkan id_karyawan berdasarkan pengguna yang sedang login
                    'kegiatan' => $this->input->post('kegiatan'),
                    'date' => date('Y-m-d'),
                    'jam_masuk' => $jam_masuk,
                    'status' => 'belum done',
                    'keterangan_izin' => '-'
                );

                // Menambahkan absensi dan mendapatkan ID data yang baru ditambahkan
                $new_absensi_id = $this->karyawan_model->addAbsensi($data);

                // Redirect ke halaman history_absen dengan membawa ID baru
                redirect('karyawan/history/' . $new_absensi_id);
            }
        } else {
            redirect('other_page');
        }
    }

    public function update_menu_absen($absen_id)
    {
        if ($this->session->userdata('role') === 'karyawan') {
            // Mengambil data absensi berdasarkan ID yang diberikan
            $absensi = $this->karyawan_model->getAbsensiById($absen_id);

            // Periksa apakah data absensi ditemukan
            if ($absensi) {
                // Mengecek apakah pengguna mengirimkan formulir perubahan
                if ($this->input->post()) {
                    // Lakukan validasi terhadap input
                    $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
                    $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required');

                    if ($this->form_validation->run() === TRUE) {
                        // Dapatkan data input pengguna
                        $kegiatan = $this->input->post('kegiatan');
                        $jam_masuk = $this->input->post('jam_masuk');

                        // Lakukan pembaruan data absensi
                        $data = array(
                            'kegiatan' => $kegiatan,
                            'jam_masuk' => $jam_masuk
                        );

                        $this->karyawan_model->updateAbsensi($absen_id, $data);

                        // Set pesan sukses
                        $this->session->set_flashdata('success', 'Data absensi berhasil diubah.');

                        // Redirect kembali ke halaman riwayat absen
                        redirect('karyawan/history');
                    }
                }

                $data['absensi'] = $absensi;
                $data['absen_id'] = $absen_id;
                $this->load->view('karyawan/history/update_menu_absen', $data);

            } else {
                // Data absensi tidak ditemukan, tampilkan pesan error
                show_error('Data absensi tidak ditemukan.', 404, 'Data Tidak Ditemukan');
            }
        } else {
            // Pengguna bukan karyawan, redirect ke halaman lain
            redirect('auth');
        }
    }
    public function pulang($absen_id)
    {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->karyawan_model->setAbsensiPulang($absen_id);
            redirect('karyawan/history');
        } else {
            redirect('auth');
        }
    }
    public function batal_pulang($absen_id)
    {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->karyawan_model->batalPulang($absen_id);

            // Set pesan sukses
            $this->session->set_flashdata('success', 'Batal Pulang berhasil.');

            // Redirect kembali ke halaman riwayat absen
            redirect('karyawan/history');
        } else {
            redirect('auth');
        }
    }
    public function izin()
    {
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        $this->load->view('karyawan/izin', $data);
    }

    public function tambah_izin()
    {
        if ($this->session->userdata('role') === 'karyawan') {
            $user_id = $this->session->userdata('id');
            $this->form_validation->set_rules('keterangan', 'Keterangan Izin', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('karyawan/izin');
            } else {
                $data = array(
                    'id_karyawan' => $user_id,
                    'keterangan' => $this->input->post('keterangan'),
                    // Mengambil data dari form input
                );

                // Memanggil fungsi untuk menambahkan izin
                $this->karyawan_model->addIzin($data);

                // Redirect ke halaman history_absen
                redirect('karyawan/history');
            }
        } else {
            redirect('auth');
        }
    }
    public function profile()
    {
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
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
                $this->session->set_flashdata('ubah_password', 'Berhasil mengubah password');
            } else {
                $this->session->set_flashdata('kesalahan_password', 'Password baru dan Konfirmasi password tidak sama');
                redirect(base_url('karyawan/profile'));
            }
        }

        $this->session->set_userdata($data);
        $update_result = $this->m_model->update_data('akun', $data, array('id' => $this->session->userdata('id')));

        if ($update_result) {
            $this->session->set_flashdata('update_akun', 'Data berhasil diperbarui');
            redirect(base_url('karyawan/profile'));
        } else {
            $this->session->set_flashdata('gagal_update', 'Gagal memperbarui data');
            redirect(base_url('karyawan/profile'));
        }
    }

    public function edit_image()
    {
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];

        // Jika ada image yang diunggah
        if ($image) {
            $kode = round(microtime(true) * 1000);
            $file_name = $kode . '_' . $image;
            $upload_path = './images/karyawan/' . $file_name;
            $this->session->set_flashdata('berhasil_ubah_foto', 'Foto berhasil diperbarui.');
            if (move_uploaded_file($image_temp, $upload_path)) {
                // Hapus image lama jika ada
                $old_file = $this->karyawan_model->get_karyawan_image_by_id($this->input->post('id'));
                if ($old_file && file_exists('./images/karyawan/' . $old_file)) {
                    unlink('./images/karyawan/' . $old_file);
                }

                $data = [
                    'image' => $file_name
                ];
            } else {
                // Gagal mengunggah image baru
                redirect(base_url('karyawan/ubah_image/' . $this->input->post('id')));
            }
        } else {
            // Jika tidak ada image yang diunggah
            $data = [
                'image' => 'User.png'
            ];
        }

        // Eksekusi dengan model ubah_data
        $eksekusi = $this->karyawan_model->ubah_data('akun', $data, array('id' => $this->input->post('id')));

        if ($eksekusi) {
            redirect(base_url('karyawan/profile'));
        } else {
            redirect(base_url('karyawan/ubah_image/' . $this->input->post('id')));
        }
    }

    public function hapus($absen_id)
    {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->karyawan_model->hapusAbsensi($absen_id);
            redirect('karyawan/history');
        } else {
            redirect('auth');
        }
    }
}
?>