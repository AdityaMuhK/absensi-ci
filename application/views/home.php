<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $title ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            background-image: url('https://i.pinimg.com/originals/36/a0/41/36a04197a7be4e694d9f35389287841c.gif');
            background-size: cover;
            /* Menyesuaikan gambar latar belakang dengan ukuran layar */
            background-position: center;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
        }


        .content {
            position: relative;
            bottom: 150px;
            margin-left: 100px;
        }

        .content h2 {
            color: #fff;
            font-size: 3em;
            position: absolute;
            transform: translate(-50%, -50%);
            white-space: nowrap;
            /* Tambahkan baris ini */
        }

        .content h2:nth-child(1) {
            color: transparent;
            -webkit-text-stroke: 2px #66a3ff;
        }

        .content h2:nth-child(2) {
            color: #fff;
            animation: animate 4s ease-in-out infinite;
        }

        @keyframes animate {

            0%,
            100% {
                clip-path: polygon(0% 45%,
                        16% 44%,
                        33% 50%,
                        54% 60%,
                        70% 61%,
                        84% 59%,
                        100% 52%,
                        100% 100%,
                        0% 100%);
            }

            50% {
                clip-path: polygon(0% 60%,
                        15% 65%,
                        34% 66%,
                        51% 62%,
                        67% 50%,
                        84% 45%,
                        100% 46%,
                        100% 100%,
                        0% 100%);
            }
        }

        .login-button {
            display: inline-block;
            margin: 20px;
            font-size: 1.2em;
            position: relative;
            cursor: pointer;
        }

        .login-button a {
            display: block;
            padding: 10px 20px;
            background-color: #6699ff;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .login-button a:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .login-button a:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #66a3ff;
            z-index: -1;
            border-radius: 4px;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s;
        }

        .login-button a:hover:before {
            transform: scaleX(1);
            transform-origin: left;
        }

        @media (max-width: 768px) {
            .login-button {
                text-align: center;
                /* Mengatur tombol login ke tengah */
            }

            .content {
                position: relative;
                text-align: center;
                /* Mengatur teks di tengah saat tampilan kecil */
                bottom: 0;
                /* Kembalikan posisi ke bawah tombol login */
                margin-left: 0;
                /* Menghilangkan margin kiri */
            }
        }
       </style>
</head>

<body>
    <div class="content">
        <h2 style="text-align: center;">Selamat Datang Di Mini Project Absensi Saya</h2>
        <h2 style="text-align: center;">Selamat Datang Di Mini Project Absensi Saya</h2>
    </div>

    <div class="login-button">
        <a href="<?php echo base_url('auth') ?>">Login <i class="fa-solid fa-right-to-bracket"></i></a>
    </div>
</body>

</html>