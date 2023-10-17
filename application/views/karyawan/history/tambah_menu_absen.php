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

        .sidebar .nav-links li a .link-name {
            font-size: 18px;
            font-weight: 400;
            color: #6699ff;
            transition: all 0.4s ease;
        }

        .sidebar.close .nav-links li a .link-name {
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
            opacity: 0.6;
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

        .sidebar .nav-links li .sub-menu .link-name {
            display: none;
        }

        .sidebar.close .nav-links li .sub-menu .link-name {
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
            height: 100vh;
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

        @media (max-width: 400px) {
            .sidebar.close .nav-links li .sub-menu {
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



        .container {
            text-align: center;
            margin-top: 50px;
        }

        .card {
            background-color: #6699ff;
            border-radius: 8px;
            padding: 20px;
            margin: 15px auto;
            max-width: 1000px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: left;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .absen-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            height: 200px;
            margin-bottom: 20px;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            resize: none;
        }

        .absen-button {
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid white;
            background-color: transparent;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            margin-right: 850px;
        }

        .absen-button:hover {
            background-color: white;
            color: #6699ff;
            border-color: white;
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
                <a href="<?php echo base_url('karyawan') ?>">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span class="link-name">Dashboard</span>
                </a>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class="fa-solid fa-list"></i>
                        <span class="link-name">Absen Menu</span>
                    </a>
                    <i class="fa-solid fa-angle-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link-name" href="">Kategori</a></li>
                    <li><a href="<?php echo base_url('karyawan/tambah_menu_absen') ?>">Absen Karyawan</a></li>
                    <li><a href="<?php echo base_url('karyawan/izin') ?>">Absen Izin</a></li>
                    <li><a href="<?php echo base_url('karyawan/history') ?>">Histori</a></li>
                </ul>
            </li>

            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <?php foreach ($akun as $user): ?>
                            <div class="profile-content">
                                <a href="<?php echo base_url('karyawan/profile') ?>">
                                    <img src="<?php echo base_url('images/karyawan/' . $user->image) ?>" alt="profileImg">
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>

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
            <span class="text">Absen Menu</span>
        </div>

        <div class="container">
            <div class="card">
                <form action="<?php echo base_url('karyawan/aksi_tambah_menu_absen'); ?>" enctype="multipart/form-data"
                    method="post">
                    <h1>Absensi</h1>
                    <textarea class="absen-box" id="kegiatan" name="kegiatan" rows="5"
                        placeholder="Masukkan absensi di sini..." required></textarea><br>
                    <button type="submit" name="submit" class="absen-button">Absen</button>
                </form>
            </div>
        </div>
    </section>


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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>