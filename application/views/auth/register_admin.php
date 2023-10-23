<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /*Start Global Style*/
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #e9ebee;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: sans-serif;
            background: linear-gradient(to top left, #6699ff 23%, #ffffff 100%);
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            height: 100%
        }

        .login,
        .register {
            width: 50%
        }

        /*Start Login Style*/
        .login {
            float: left;
            background-color: #fafafa;
            height: 100%;
            border-radius: 10px 0 0 10px;
            text-align: center;
            padding-top: 20px;
        }

        .login h1 {
            margin-bottom: 40px;
            font-size: 2.5em;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #6699ff;
            outline: none;
        }


        .login span {
            float: left
        }

        .login a {
            float: right;
            text-decoration: none;
            color: #000;
            transition: 0.3s all ease-in-out;
        }

        .login a:hover {
            color: #6699ff;
            font-weight: bold
        }

        .login button {
            width: 100%;
            margin: 30px 0;
            padding: 10px;
            border: none;
            background-color: #6699ff;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: 0.3s all ease-in-out;
        }

        .login button:hover {
            width: 97%;
            font-size: 22px;
            border-radius: 5px;

        }

        .login hr {
            width: 30%;
            display: inline-block
        }

        .login p {
            display: inline-block;
            margin: 0px 10px 30px;
        }

        .login ul {
            list-style: none;
            margin-bottom: 40px;
        }

        .login ul li {
            display: inline-block;
            margin-right: 30px;
            cursor: pointer;
        }

        .login ul li:hover {
            opacity: 0.6
        }

        .login ul li:last-child {
            margin-right: 0
        }

        .login .copyright {
            display: inline-block;
            float: none;
        }

        /*Start Register Style*/
        .register {
            float: right;
            background: linear-gradient(to top left, #6699ff 23%, #ffffff 100%);
            height: 100%;
            color: #fff;
            border-radius: 0 10px 10px 0;
            text-align: center;
            padding: 100px 0;
        }

        .register h2 {
            margin: 30px 0;
            font-size: 50px;
            letter-spacing: 3px
        }

        .register p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .register a {
            background-color: transparent;
            border: 1px solid #FFF;
            border-radius: 20px;
            padding: 10px 20px;
            color: #fff;
            font-size: 20px;
            text-transform: uppercase;
            transition: 0.2s all ease-in-out;
            text-decoration: none;
        }

        .register a:hover {
            color: #6699ff;
            background-color: #fff;
            cursor: pointer;
        }

        /* Ganti CSS input agar ikon eye dan eye slash bisa didalam input */
        .input-container {
            position: relative;
            width: 100%;
        }

        .input-container input {
            padding-left: 10px;
            padding-right: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-container input:focus {
            border-color: #6699ff;
            outline: none;
        }

        /* Ganti CSS untuk ikon mata dan mata tertutup */
        .show_hide {
            position: absolute;
            top: 40%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #eye {
            display: none;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 100%;
            }

            .login,
            .register {
                width: 100%;
                border-radius: 10px;
            }

            .register {
                margin-top: 20px;
            }


            .login,
            .register,
            .container {
                height: auto;
            }

            .login input,
            .register input,
            .login button,
            .register a {
                width: 90%;
            }

            .register a {
                font-size: 10px;
            }

            .register h2 {
                font-size: 2em;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="login">
            <div class="container">
                <h1>REGISTER</h1>
                <form action="<?php echo base_url('auth/aksi_register_admin'); ?>" method="post">
                    <input id="username" name="username" type="text" placeholder="Username">
                    <input id="nama_depan" name="nama_depan" type="text" placeholder="Nama Depan"><br>
                    <input id="nama_belakang" name="nama_belakang" type="text" placeholder="Nama Belakang"><br>
                    <input id="email" name="email" type="email" placeholder="Email" onblur="validateEmail()">
                    <span id="emailError" style="color: red; display: none;">Email harus berakhiran @gmail.com</span>
                    <div class="input-container">
                        <input id="password" name="password" type="password" placeholder="Password"
                            pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" required>
                        <span class="show_hide" id="show_hide_password">
                            <i class="fas fa-eye-slash" id="eye-slash"></i>
                            <i class="fas fa-eye" id="eye"></i>
                        </span>
                    </div>
                    <br>
                    <small id="password-error-message" style="color: red;"></small>
                    <button type="submit">Sign In</button>
                    <hr>
                    <hr>

                </form>
            </div>
        </div>
        <div class="register">
            <div class="container">
                <i class="fa-solid fa-user-pen fa-5x"></i>
                <h2>Halo,Kak!</h2>
                <p>Jika Sudah Punya Akun Sebagai Karyawan Langsung Login Aja</p>
                <a type="button" href="<?php echo base_url('auth') ?>">Login <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <script>

        // agar mengisi password minimal 8 karakter huruf dan angka
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            passwordInput.addEventListener('input', function () {
                const password = this.value;
                const errorMessage = document.getElementById('password-error-message');
                if (!password.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/)) {
                    errorMessage.innerText = 'Password harus terdiri dari 8 karakter yang terdiri dari huruf dan angka';
                } else {
                    errorMessage.innerText = '';
                }
            });
        });

        // ikon mata untuk memperlihatkan password
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const showHideButton = document.getElementById('show_hide_password');
            const eyeSlashIcon = document.getElementById('eye-slash');
            const eyeIcon = document.getElementById('eye');

            showHideButton.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeSlashIcon.style.display = 'inline-block';
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.style.display = 'inline-block';
                    eyeSlashIcon.style.display = 'none';
                }
            });
        });
        // validasi email
        function validateEmail() {
            var emailInput = document.getElementById('email');
            var email = emailInput.value;

            var emailError = document.getElementById('emailError');

            if (!email.endsWith('@gmail.com')) {
                emailError.style.display = 'inline';
                return false;
            } else {
                emailError.style.display = 'none';
                return true;
            }
        }
    </script>
</body>

</html>