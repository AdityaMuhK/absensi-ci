<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Side Navigation Bar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        @media (max-width: 400px) {
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

        .card {
            border: 1px solid #6699ff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 70px;
            margin: 20px;
            max-width: 1200px;
            text-align: center;
            background-color: #fff;
        }

        .profile-image {
            position: relative;
            display: inline-block;
        }

        .profile-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid #6699ff;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .edit-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #6699ff;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
        }

        .card h5,
        .card p {
            margin: 0;
            font-size: 1em;
            color: #555;
        }

        @media (max-width: 767px) {
            .card {
                max-width: 100%;
            }

            .card img {
                width: 80px;
                height: 80px;
            }

            .card p {
                font-size: 10px;
            }
        }


        .profile-form {
            margin-top: 20px;
            text-align: left;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-group {
            position: relative;
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding-right: 40px;
        }

        .form-group .input-group-text {
            position: relative;
            top: 0;
            transform: none;
            cursor: pointer;
        }

        .form-group button {
            font-weight: bold;
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
            align-self: flex-start;
        }


        .form-group.position-relative {
            position: relative;
        }

        .form-group.position-relative input {
            padding-right: 40px;
        }

        .form-group.position-relative .input-group-text {
            position: absolute;
            right: 10px;
            top: 55%;
            transform: translateY(-50%);
            cursor: pointer;
        }


        @media (max-width: 767px) {
            .profile-form {
                max-width: 100%;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input {
                padding: 8px;
            }

            .form-group button {
                font-size: 14px;
            }

            /* Opsi tambahan: menyesuaikan teks tombol */
            button[type="submit"] span {
                margin-left: 3px;
            }
        }

        button[type="submit"]:hover {
            background-color: #343a40;
        }

        button[type="submit"]:focus {
            outline: none;
        }

        /* Opsi tambahan: menyesuaikan teks tombol */
        button[type="submit"] span {
            vertical-align: middle;
            margin-left: 5px;
        }

        /* Style untuk modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 3;
        }

        .modal-content {
            background-color: #fff;
            margin: 15%;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            position: relative;
        }

        .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            cursor: pointer;
        }

        .close:hover {
            color: #f00;
        }

        /* input file */
        input[type="file"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 10px;
        }

        /* tombol Simpan dan menambahkan ikon */
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        button[type="submit"] i {
            margin-right: 5px;
        }

        /* CSS untuk modal foto profil*/
        .modalimage {
            display: none;
            position: fixed;
            z-index: 1;
            left: 20%;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
            padding-top: 60px;
        }

        .modalimage-content {
            margin: 5% auto;
            display: block;
            max-width: 700px;
        }

        .closes {
            color: #fff;
            font-size: 35px;
            font-weight: bold;
            position: absolute;
            top: 15px;
            right: 35px;
        }

        .modal-image {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: auto;
        }

        .profile-image img {
            cursor: pointer;
        }

        .logout-button {
            background-color: #ff5050;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #ff6666;
        }

        .fa-arrow-right-from-bracket {
            margin-left: 5px;
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
    </style>
</head>

<body>
    <?php foreach ($akun as $user): ?>
        <div class="sidebar">
            <div class="logo-details">
                <i class="fa-solid fa-cubes"></i>
                <span class="logo_name">Karyawan</span>
            </div>
            <ul class="nav-links">
                <li>
                    <a class="select_hover" href="<?php echo base_url('karyawan') ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="link-name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="select_hover" href="<?php echo base_url('karyawan/tambah_menu_absen') ?>">
                        <i class="fas fa-user-clock"></i>
                        <span class="link-name">Absen Karyawan</span>
                    </a>
                </li>
                <li>
                    <a class="select_hover" href="<?php echo base_url('karyawan/izin') ?>">
                        <i class="fas fa-file-signature"></i>
                        <span class="link-name">Absen Izin</span>
                    </a>
                </li>
                <li>
                    <a class="select_hover" href="<?php echo base_url('karyawan/history') ?>">
                        <i class="fas fa-history"></i>
                        <span class="link-name">Histori</span>
                    </a>
                </li>
                <p class="jam">
                    <span id="tanggal">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?php echo date('d-m-Y'); ?>
                    </span>
                    <br>
                    <i class="fa-regular fa-clock"></i><span id="jam"></span>
                </p>
                <li>
                    <div class="profile-details">
                        <div class="profile-content">
                            <a href="<?php echo base_url('karyawan/profile') ?>">
                                <img src="<?php echo base_url('images/' . $user->image) ?>" alt="profileImg">
                            </a>
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
                <span class="text">Profile</span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-image">
                        <img src="<?php echo base_url('images/' . $user->image) ?>" alt="profileImg" class="rounded-circle">

                        <input name="id" type="hidden" value="<?php echo $user->id ?>">
                        <button for="image_upload" class="edit-button" data-bs-toggle="modal"
                            data-bs-target="#editImageModal"><i class="fa-solid fa-pen"></i></button>
                        <input type="file" id="image" name="image" accept="image/*" style="display:none;">
                    </div>
                    <h5 class="card-title">
                        <?php echo $user->username ?>
                    </h5>
                    <p class="p">
                        <?php echo $user->nama_depan . ' ' . $user->nama_belakang ?>
                    </p>
                </div>

                <form action="<?php echo base_url('karyawan/edit_profile'); ?>" class="profile-form"
                    enctype="multipart/form-data" method="post">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $user->email ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $user->username ?>">
                    </div>
                    <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <input type="text" id="nama_depan" name="nama_depan" value="<?php echo $user->nama_depan ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" id="nama_belakang" name="nama_belakang"
                            value="<?php echo $user->nama_belakang ?>">
                    </div>
                    <div class="form-group position-relative">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password"
                            pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                        <span class="input-group-text" onclick="togglePassword('password')"><i id="icon-password"
                                class="fas fa-eye"></i></span>
                        <br>
                        <small id="password-error-message" style="color: red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Kata Sandi Baru</label>
                        <input type="password" id="password_baru" name="password_baru"
                            pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                        <br>
                        <small id="password-error-message-new" style="color: red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="konfirmasi_password">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="konfirmasi_password" name="konfirmasi_password"
                            pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                        <br>
                        <small id="password-error-message-confirm" style="color: red;"></small>

                    </div>
                    <button class="save" type="submit"><i class="fa-solid fa-save"></i><span>Simpan
                            Perubahan</span></button>
                    <a class="logout-button" onclick="confirmLogout()">
                        Logout
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>

                </form>

            </div>
            </div>
            <!-- Modal -->
            <div class="modal" id="imageModal">
                <div class="modal-content">
                    <span class="close" id="closeModal">&times;</span>
                    <form action="<?php echo base_url('karyawan/edit_image'); ?>" method="post"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                        <label for="image">Pilih gambar:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Modal Image-->
            <div class="modalimage" id="imageModall">
                <div class="modal-content">
                    <span class="closes" id="closeModall">&times;</span>
                    <img src="<?php echo base_url('images/' . $user->image) ?>" alt="profileImg" class="modal-image">
                </div>
            </div>

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
            function togglePassword(inputId) {
                var x = document.getElementById(inputId);
                var icon = document.getElementById("icon-" + inputId);

                if (x.type === "password") {
                    x.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    x.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const passwordInput = document.getElementById('password');
                passwordInput.addEventListener('input', function () {
                    const password = this.value;
                    const errorMessage = document.getElementById('password-error-message');
                    if (!password.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/)) {
                        errorMessage.innerText = 'Password minimal 8 karakter';
                    } else {
                        errorMessage.innerText = '';
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function () {
                const passwordInput = document.getElementById('password_baru');
                passwordInput.addEventListener('input', function () {
                    const password = this.value;
                    const errorMessage = document.getElementById('password-error-message-new');
                    if (!password.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/)) {
                        errorMessage.innerText = 'Password minimal 8 karakter';
                    } else {
                        errorMessage.innerText = '';
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function () {
                const passwordInput = document.getElementById('konfirmasi_password');
                passwordInput.addEventListener('input', function () {
                    const password = this.value;
                    const errorMessage = document.getElementById('password-error-message-confirm');
                    if (!password.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/)) {
                        errorMessage.innerText = 'Password minimal 8 karakter';
                    } else {
                        errorMessage.innerText = '';
                    }
                });
            });
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
        <?php if ($this->session->flashdata('kesalahan_password')) { ?>
            <script>
                Swal.fire({
                    title: "Error!",
                    text: "<?php echo $this->session->flashdata('kesalahan_password'); ?>",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('gagal_update')) { ?>
            <script>
                Swal.fire({
                    title: "Error!",
                    text: "<?php echo $this->session->flashdata('gagal_update'); ?>",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('error_profile')) { ?>
            <script>
                Swal.fire({
                    title: "Error!",
                    text: "<?php echo $this->session->flashdata('error_profile'); ?>",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('berhasil_ubah_foto')) { ?>
            <script>
                Swal.fire({
                    title: "Berhasil",
                    text: "<?php echo $this->session->flashdata('berhasil_ubah_foto'); ?>",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('ubah_password')) { ?>
            <script>
                Swal.fire({
                    title: "Success!",
                    text: "<?php echo $this->session->flashdata('ubah_password'); ?>",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('update_user')) { ?>
            <script>
                Swal.fire({
                    title: "Success!",
                    text: "<?php echo $this->session->flashdata('update_user'); ?>",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php } ?>
        <script>
            // Membuka modal saat tombol edit diklik
            document.querySelector('.edit-button').addEventListener('click', () => {
                document.querySelector('.modal').style.display = 'block';
            });

            // Menutup modal saat tombol close pada modal diklik
            document.querySelector('#closeModal').addEventListener('click', () => {
                document.querySelector('.modal').style.display = 'none';
            });

            // Menutup modal jika area luar modal diklik
            window.addEventListener('click', (e) => {
                if (e.target == document.querySelector('.modal')) {
                    document.querySelector('.modal').style.display = 'none';
                }
            });

        </script>
        <script>
            // Script untuk membuka modal ketika gambar diklik
            document.querySelectorAll('.trigger-modall').forEach(item => {
                item.addEventListener('click', event => {
                    document.getElementById('imageModall').style.display = "block";
                });
            });

            // Script untuk menutup modal
            document.getElementById('closeModall').addEventListener('click', function () {
                document.getElementById('imageModall').style.display = "none";
            });

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <?php endforeach ?>
</body>

</html>