<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $data['get_karyawan'] = $this->m_model->get_data('akun')->result();
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        $this->load->view('admin/index', $data);
    }
    public function rekap_harian()
    {
        $date = $this->input->get('tanggal'); // Ambil date dari parameter GET
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        $data['rekap_harian'] = $this->admin_model->getRekapHarian($date);
        $this->load->view('admin/rekap_harian', $data);
    }
    public function rekap_mingguan()
    {
        $date = $this->input->get('tanggal'); // Ambil date dari parameter GET
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        $data['rekap_mingguan'] = $this->admin_model->getAbsensiLast7Days($date);
        $this->load->view('admin/rekap_mingguan', $data);
    }

    public function rekap_bulanan()
    {
        $bulan = $this->input->get('bulan'); // Ambil nilai bulan dari form
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();

        if ($bulan) {
            $data['rekap_bulanan'] = $this->admin_model->getRekapBulan($bulan);
        } else {
            $data['rekap_bulanan'] = array(); // Inisialisasi data kosong jika tidak ada bulan yang dipilih
        }

        $this->load->view('admin/rekap_bulanan', $data);
    }

    public function profile()
    {
        $data['akun'] = $this->m_model->get_by_id('akun', 'id', $this->session->userdata('id'))->result();
        $this->load->view('admin/profile', $data);
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
                redirect(base_url('admin/profile'));
            }
        }

        $this->session->set_userdata($data);
        $update_result = $this->m_model->update_data('akun', $data, array('id' => $this->session->userdata('id')));

        if ($update_result) {
            $this->session->set_flashdata('update_akun', 'Data berhasil diperbarui');
            redirect(base_url('admin/profile'));
        } else {
            $this->session->set_flashdata('gagal_update', 'Gagal memperbarui data');
            redirect(base_url('admin/profile'));
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
            $upload_path = './images/' . $file_name;
            $this->session->set_flashdata('berhasil_ubah_foto', 'Foto berhasil diperbarui.');
            if (move_uploaded_file($image_temp, $upload_path)) {
                // Hapus image lama jika ada
                $old_file = $this->admin_model->get_admin_image_by_id($this->input->post('id'));
                if ($old_file && file_exists('./images/' . $old_file)) {
                    unlink('./images/' . $old_file);
                }

                $data = [
                    'image' => $file_name
                ];
            } else {
                // Gagal mengunggah image baru
                redirect(base_url('admin/ubah_image/' . $this->input->post('id')));
            }
        } else {
            // Jika tidak ada image yang diunggah
            $data = [
                'image' => 'User.png'
            ];
        }

        // Eksekusi dengan model ubah_data
        $eksekusi = $this->admin_model->ubah_data('akun', $data, array('id' => $this->input->post('id')));

        if ($eksekusi) {
            redirect(base_url('admin/profile'));
        } else {
            redirect(base_url('admin/ubah_image/' . $this->input->post('id')));
        }
    }
    //start export data karyawan
    public function export()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "ID");
        $sheet->setCellValue('B3', "USERNAME");
        $sheet->setCellValue('C3', "NAMA DEPAN");
        $sheet->setCellValue('D3', "NAMA BELAKANG");
        $sheet->setCellValue('E3', "IMAGE");
        $sheet->setCellValue('F3', "EMAIL");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);

        $karyawan = $this->m_model->get_data('akun')->result();

        $no = 1;
        $numrow = 4;
        foreach ($karyawan as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->username);
            $sheet->setCellValue('C' . $numrow, $data->nama_depan);
            $sheet->setCellValue('D' . $numrow, $data->nama_belakang);
            $sheet->setCellValue('E' . $numrow, $data->image);
            $sheet->setCellValue('F' . $numrow, $data->email);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");
        header('Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data_karyawan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }
    //end export data karyawan

    //start export semua data absensi
    public function export_absensi_all()
    {
        // $tanggal = date('Y-m-d');
        $tanggal = $this->input->post('tanggal');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($tanggal)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', "ID");
            $sheet->setCellValue('B3', "NAMA KARYAWAN");
            $sheet->setCellValue('C3', "KEGIATAN");
            $sheet->setCellValue('D3', "TANGGAL MASUK");
            $sheet->setCellValue('E3', "JAM MASUK");
            $sheet->setCellValue('F3', "JAM PULANG");
            $sheet->setCellValue('G3', "KETERANGAN IZIN");
            $sheet->setCellValue('H3', "STATUS");

            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);

            $karyawan = $this->admin_model->get_all_karyawan();

            $no = 1;
            $numrow = 4;
            foreach ($karyawan as $data) {
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $data->nama_depan . ' ' . $data->nama_belakang);
                $sheet->setCellValue('C' . $numrow, $data->kegiatan);
                $sheet->setCellValue('D' . $numrow, $data->date);
                $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $data->keterangan_izin);
                $sheet->setCellValue('H' . $numrow, $data->status);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);

                $no++;
                $numrow++;
            }

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);

            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");
            header('Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="semua_data_absensi.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }

    }
    //end export semua data absensi
    //start export data absen perhari
    public function export_absensi()
    {
        $tanggal = date('Y-m-d');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($tanggal)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', "ID");
            $sheet->setCellValue('B3', "NAMA KARYAWAN");
            $sheet->setCellValue('C3', "KEGIATAN");
            $sheet->setCellValue('D3', "TANGGAL MASUK");
            $sheet->setCellValue('E3', "JAM MASUK");
            $sheet->setCellValue('F3', "JAM PULANG");
            $sheet->setCellValue('G3', "KETERANGAN IZIN");
            $sheet->setCellValue('H3', "STATUS");

            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);

            $karyawan = $this->admin_model->getHarianData($tanggal);

            $no = 1;
            $numrow = 4;
            foreach ($karyawan as $data) {
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $data->nama_depan . ' ' . $data->nama_belakang);
                $sheet->setCellValue('C' . $numrow, $data->kegiatan);
                $sheet->setCellValue('D' . $numrow, $data->date);
                $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $data->keterangan_izin);
                $sheet->setCellValue('H' . $numrow, $data->status);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);

                $no++;
                $numrow++;
            }

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);

            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");
            header('Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="absensi_perhari.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }

    }
    //end export data absen perhari
    //start export data absen mingguan
    public function export_absensi_mingguan()
    {
        $tanggal_akhir = date('Y-m-d');
        $tanggal_awal = date('Y-m-d', strtotime('-7 days', strtotime($tanggal_akhir)));
        $tanggal_awal = date('W', strtotime($tanggal_awal));
        $tanggal_akhir = date('W', strtotime($tanggal_akhir));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($tanggal_awal && $tanggal_akhir)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', "ID");
            $sheet->setCellValue('B3', "NAMA KARYAWAN");
            $sheet->setCellValue('C3', "KEGIATAN");
            $sheet->setCellValue('D3', "TANGGAL MASUK");
            $sheet->setCellValue('E3', "JAM MASUK");
            $sheet->setCellValue('F3', "JAM PULANG");
            $sheet->setCellValue('G3', "KETERANGAN IZIN");
            $sheet->setCellValue('H3', "STATUS");

            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);

            $karyawan = $this->admin_model->getMingguanData($tanggal_awal, $tanggal_akhir);

            $no = 1;
            $numrow = 4;
            foreach ($karyawan as $data) {
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $data->nama_depan . ' ' . $data->nama_belakang);
                $sheet->setCellValue('C' . $numrow, $data->kegiatan);
                $sheet->setCellValue('D' . $numrow, $data->date);
                $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $data->keterangan_izin);
                $sheet->setCellValue('H' . $numrow, $data->status);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);

                $no++;
                $numrow++;
            }

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);

            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");
            header('Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="data_absensi_perminggu.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }

    }
    //end export data absen mingguan

    //start export data absen bulanan
    public function export_absensi_bulanan()
    {
        $bulan = $this->input->post('bulan');
        $absensi = $this->admin_model->getBulananData($bulan);
        // $bulan = date('Y-m');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($bulan) && !empty($absensi)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

            $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', "ID");
            $sheet->setCellValue('B3', "NAMA KARYAWAN");
            $sheet->setCellValue('C3', "KEGIATAN");
            $sheet->setCellValue('D3', "TANGGAL MASUK");
            $sheet->setCellValue('E3', "JAM MASUK");
            $sheet->setCellValue('F3', "JAM PULANG");
            $sheet->setCellValue('G3', "KETERANGAN IZIN");
            $sheet->setCellValue('H3', "STATUS");

            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);

            $karyawan = $this->admin_model->getBulananData($bulan);

            $no = 1;
            $numrow = 4;
            foreach ($karyawan as $data) {
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $data->nama_depan . ' ' . $data->nama_belakang);
                $sheet->setCellValue('C' . $numrow, $data->kegiatan);
                $sheet->setCellValue('D' . $numrow, $data->date);
                $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $data->keterangan_izin);
                $sheet->setCellValue('H' . $numrow, $data->status);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);

                $no++;
                $numrow++;
            }

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);

            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");
            header('Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="absensi_perbulan.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        } else {
            $this->session->set_flashdata('error_export_perbulan', 'Data tidak ada untuk di export');
            redirect(base_url('admin/rekap_bulanan'));
        }

    }
    //end export data absen bulanan
}
?>