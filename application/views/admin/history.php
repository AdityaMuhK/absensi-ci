<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            height: 650px;
            background: linear-gradient(to bottom, #6600ff 0%, #ffffff 100%);
        }

        .navbar-custom {
            background-color: #8a2be2;
            /* Kode warna ungu */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-custom border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url('admin/history'); ?>">History</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="<?php echo base_url('admin/index'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin/menu_absen'); ?>">Menu Absen</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" type="button" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- absensi karyawan -->
        <div class="container mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-0">ABSENSI KARYAWAN</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Karyawan</th>
                                    <th scope="col">Kegiatan</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Jam Masuk</th>
                                    <th scope="col">Jam Pulang</th>
                                    <th scope="col">Keterangan Izin</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Isi data karyawan di sini, misalnya dengan menggunakan PHP -->
                                <?php
                                // Contoh data karyawan
                                $karyawan = [
                                    ["John Doe", "Meeting", "2023-10-10", "08:00", "17:00", "", "Hadir"],
                                    ["Jane Doe", "Presentation", "2023-10-11", "09:00", "18:00", "Cuti", "Hadir"],
                                ];
                                $no = 1;
                                foreach ($karyawan as $row) {
                                    echo "<tr>";
                                    echo "<th scope='row'>$no</th>";
                                    echo "<td>{$row[0]}</td>";
                                    echo "<td>{$row[1]}</td>";
                                    echo "<td>{$row[2]}</td>";
                                    echo "<td>{$row[3]}</td>";
                                    echo "<td>{$row[4]}</td>";
                                    echo "<td>{$row[5]}</td>";
                                    echo "<td>{$row[6]}</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- LOGOUT -->
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin mau LogOut?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url('/auth/register_karyawan') ?>";
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>