<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Side Navigation Bar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background: #ffff;
            z-index: 100;
            transition: all 0.5s ease;
        }

        .sidebar.close {
            width: 78px;
        }

        .sidebar .logo-details {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .sidebar .logo-details i {
            font-size: 30px;
            color: #6699ff;
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
        }

        .sidebar .logo-details .logo_name {
            font-size: 22px;
            color: #6699ff;
            font-weight: 600;
            transition: 0.3s ease;
            transition-delay: 0.1s;
        }

        .sidebar.close .logo-details .logo_name {
            transition-delay: 0s;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links {
            height: 100%;
            padding: 30px 0 150px 0;
            overflow: auto;
        }

        .sidebar.close .nav-links {
            overflow: visible;
        }

        .sidebar .nav-links::-webkit-scrollbar {
            display: none;
        }

        .sidebar .nav-links li {
            position: relative;
            list-style: none;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li:hover {
            background: #f3f1f6;
        }

        .sidebar .sub-menu li:hover {
            background: none;
            color: #6699ff;
        }

        .sidebar .nav-links li .icon-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar.close .nav-links li .icon-link {
            display: block;
        }

        .sidebar .nav-links li i {
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
            color: #6699ff;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li.showMenu i.arrow {
            transform: rotate(-180deg);
        }

        .sidebar.close .nav-links i.arrow {
            display: none;
        }

        .sidebar .nav-links li a {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-links li a .link_name {
            font-size: 18px;
            font-weight: 400;
            color: #6699ff;
            transition: all 0.4s ease;
        }

        .sidebar.close .nav-links li a .link_name {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li .sub-menu {
            padding: 6px 6px 14px 80px;
            margin-top: 0px;
            background: #fff;
            display: none;
        }

        .sidebar .nav-links li.showMenu .sub-menu {
            display: block;
        }

        .sidebar .nav-links li .sub-menu a {
            color: #6699ff;
            font-size: 15px;
            padding: 5px 0;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li .sub-menu a:hover {
            opacity: 1;
        }

        .sidebar.close .nav-links li .sub-menu {
            position: absolute;
            left: 100%;
            top: -10px;
            margin-top: 0;
            padding: 10px 20px;
            border-radius: 0 6px 6px 0;
            opacity: 0;
            display: block;
            pointer-events: none;
            transition: 0s;
        }

        .sidebar.close .nav-links li:hover .sub-menu {
            top: 0;
            opacity: 1;
            pointer-events: auto;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li .sub-menu .link_name {
            display: none;
        }

        .sidebar.close .nav-links li .sub-menu .link_name {
            font-size: 18px;
            opacity: 1;
            display: block;
        }

        .sidebar .nav-links li .sub-menu.blank {
            opacity: 1;
            pointer-events: auto;
            padding: 3px 20px 6px 16px;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li:hover .sub-menu.blank {
            top: 50%;
            transform: translateY(-50%);
        }

        .sidebar .profile-details {
            position: fixed;
            bottom: 0;
            width: 260px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f3f1f6;
            padding: 12px 0;
            transition: all 0.5s ease;
        }

        .sidebar.close .profile-details {
            background: none;
        }

        .sidebar.close .profile-details {
            width: 78px;
        }

        .sidebar .profile-details .profile-content {
            display: flex;
            align-items: center;
        }

        .sidebar .profile-details img {
            height: 52px;
            width: 52px;
            object-fit: cover;
            border-radius: 16px;
            margin: 0 14px 0 12px;
            background: #1d1b31;
        }

        .sidebar .profile-details .profile_name,
        .sidebar .profile-details .job {
            color: #6699ff;
            font-size: 18px;
            font-weight: 500;
            white-space: nowrap;
            transition: all 5s ease;
        }

        .sidebar.close .profile-details i,
        .sidebar.close .profile-details .profile_name,
        .sidebar.close .profile-details .job {
            display: none;
        }

        .sidebar .profile-details .job {
            font-size: 12px;
        }

        .home-section {
            position: relative;
            background: #e4e9f7;
            height: auto;
            left: 260px;
            width: calc(100% - 260px);
            transition: all 0.5s ease;
        }

        .sidebar.close~.home-section {
            left: 78px;
            width: calc(100% - 78px);
        }

        .home-section .home-content {
            height: 60px;
            display: flex;
            align-items: center;
        }

        .home-section .home-content .fa-bars,
        .home-section .home-content .text {
            color: #6699ff;
            font-size: 35px;
        }

        .home-section .home-content .fa-bars {
            margin: 0 15px;
            cursor: pointer;
        }

        .home-section .home-content .text {
            font-size: 26px;
            font-weight: 600;
        }

        /* Tabel */
        .table-wrap {
            max-width: 1000px;
            margin: 40px auto;
            overflow-x: auto;

        }

        table,
        td,
        th {
            /*   border: 1px solid #ddd; */
            text-align: center;
            font-size: 15px;
            text-transform: capitalize;
        }

        table thead tr {
            background-color: #6699ff;
            color: #fff;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border-radius: 16px 16px 0px 0px;
            overflow: hidden;
        }

        table tbody tr td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            white-space: nowrap;
        }

        table tbody tr:nth-child(odd) {
            background: #b4b4b442;
            color: #000;
            font-weight: 500;
        }

        .box-wrap {
            padding: 0px 16px;
        }

        .edit {
            background-color: #6699ff;
        }

        .pulang {
            background-color: #00ff00;
        }

        .delete {
            background-color: #ff6666;
        }

        .icon-btn {
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .icon-btn:focus {
            outline: none;
        }

        .icon-btn:hover {
            background-color: #555;
        }

        .card-wrap {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin: 0 0 20px 0;
            margin-left: 5px;
            margin-right: 5px;
            max-width: 300px;
            flex-basis: calc(33.33% - 20px);
            position: relative;
        }

        .card .icon {
            font-size: 4em;
            color: #6699ff;
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .card-content {
            text-align: left;
        }

        .card-content h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .card-content .total {
            font-size: 1.5em;
            color: #007bff;
        }

        @media (max-width: 400px) {
            .card {
                max-width: 100%;
                /* Mengisi lebar penuh pada layar kecil */
                flex-basis: 100%;
            }

            .sidebar.close .nav-links li .name-job {
                display: none;
            }

            .sidebar {
                width: 78px;
            }

            .sidebar.close {
                width: 0;
            }

            .home-section {
                left: 78px;
                width: calc(100% - 78px);
                z-index: 100;
            }

            .sidebar.close~.home-section {
                width: 100%;
                left: 0;
            }
        }

        .select_hover {
            transition: background-color 0.3s, padding 0.3s;
            /* Tambahkan transisi untuk efek yang lebih halus */
        }

        .select_hover:hover {
            background-color: #b3d1ff;
            padding: 5px;
            /* Ubah nilai padding pada hover */
            border-radius: 5px;
            /* Tambahkan sudut melengkung */
        }

        .jam {
            transform: translateY(130px);
            text-align: center;
            font-size: 20px;
            color: #6699ff;
        }

        #tanggal {
            border-bottom: 1px solid #6699ff;
            padding-bottom: 5px;
            display: inline-block;
        }

        #jam {
            font-size: 24px;
            font-weight: bold;
            margin-top: 5px;
        }

        @media screen and (max-width: 600px) {

            #tanggal,
            #jam {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="fa-solid fa-cubes"></i>
            <span class="logo_name">Karyawan</span>
        </div>
        <ul class="nav-links">
            <li>
                <a class="select_hover" href="<?php echo base_url('karyawan') ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="select_hover" href="<?php echo base_url('karyawan/tambah_menu_absen') ?>">
                    <i class="fas fa-user-clock"></i>
                    <span class="link_name">Absen Karyawan</span>
                </a>
            </li>
            <li>
                <a class="select_hover" href="<?php echo base_url('karyawan/izin') ?>">
                    <i class="fas fa-file-signature"></i>
                    <span class="link_name">Absen Izin</span>
                </a>
            </li>
            <li>
                <a class="select_hover" href="<?php echo base_url('karyawan/history') ?>">
                    <i class="fas fa-history"></i>
                    <span class="link_name">Histori</span>
                </a>
            </li>
            <p class="jam">
                <span id="tanggal">
                    <?php echo date('d-m-Y'); ?>
                </span>
                <br>
                <span id="jam"></span>
            </p>

            <li>
                <div class="profile-details">
                    <?php foreach ($akun as $user): ?>
                        <div class="profile-content">
                            <a href="<?php echo base_url('karyawan/profile') ?>">
                                <img src="<?php echo base_url('images/' . $user->image) ?>" alt="profileImg">
                            </a>
                        </div>
                    <?php endforeach ?>

                    <div class="name-job">
                        <div class="profile_name">
                            <?php echo $this->session->userdata('username'); ?>
                        </div>
                        <div class="job">
                            <marquee scrolldelay="200">
                                <?php echo $_SESSION['email']; ?>
                            </marquee>
                        </div>
                    </div>
                    <a onclick="confirmLogout()">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class="fa-solid fa-bars"></i>
            <span class="text">Dashboard</span>
        </div>

        <!-- Tabel -->
        <div class="box-wrap">
            <div class="table-wrap">
                <!-- Cards -->
                <div class="card-wrap">
                    <div class="card">
                        <i class="fa-solid fa-user-clock icon"></i>
                        <div class="card-content">
                            <h3>Total Izin</h3>
                            <span class="total">
                                <?php echo $totalIzin; ?>
                            </span>
                        </div>
                    </div>
                    <div class="card">
                        <i class="fa-solid fa-user-check icon"></i>
                        <div class="card-content">
                            <h3>Total Masuk</h3>
                            <span class="total">
                                <?php echo $totalMasuk; ?>
                            </span>
                        </div>
                    </div>
                    <div class="card">
                        <i class="fa-solid fa-users icon"></i>
                        <div class="card-content">
                            <h3>Total Keseluruhan</h3>
                            <span class="total">
                                <?php echo ($totalIzin + $totalMasuk); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Username</th>
                            <th>Kegiatan</th>
                            <th>Date</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($absensi as $row):
                            $no++ ?>
                            <tr class="text-center">
                                <td>
                                    <?php echo $no ?>
                                </td>
                                <td>
                                    <?php echo $username; ?>
                                </td>
                                <td>
                                    <?php echo $row->kegiatan ?>
                                </td>
                                <td>
                                    <?php echo $row->date ?>
                                </td>
                                <td>
                                    <?php echo $row->jam_masuk ?>
                                </td>
                                <td>
                                    <?php echo $row->jam_pulang ?>
                                </td>
                                <td>
                                    <?php echo $row->status ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Tabel End -->
    </section>
    <!-- script tanggal & jam -->
    <script type="text/javascript">
        window.onload = function () {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
    <script>
        const arrows = document.querySelectorAll(".arrow");

        arrows.forEach((arrow) => {
            arrow.addEventListener("click", (e) => {
                const arrowParent = e.target.closest(".arrow").parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        });

        const sidebar = document.querySelector(".sidebar");
        const sidebarBtn = document.querySelector(".fa-bars");

        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });

    </script>
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
                    window.location.href = "<?php echo base_url('auth') ?>";
                }
            });
        }
    </script>
</body>

</html>