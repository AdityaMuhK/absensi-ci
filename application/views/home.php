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
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Nunito", sans-serif;
        }

        body {
            height: 100%;
        }

        .text-animation {
            background: #000;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-wrapper {
            position: relative;
        }

        .text-wrapper h2 {
            z-index: 4;
            color: #fff;
            font-size: 5vw;
            white-space: nowrap;
            position: absolute;
            transform: translate(-50%, -62%);
        }

        .text-wrapper h2:nth-child(1) {
            color: transparent;
            -webkit-text-stroke: 2px #fff;
        }

        .text-wrapper h2:nth-child(2) {
            color: #6699ff;
            animation: wave 4s ease-in-out infinite;
        }

        @keyframes wave {

            /* start point */
            0%,
            100% {
                clip-path: polygon(0% 46%,
                        17% 45%,
                        34% 50%,
                        56% 61%,
                        69% 62%,
                        86% 60%,
                        100% 51%,
                        100% 100%,
                        0% 100%);
            }

            /* Mid point */
            50% {
                clip-path: polygon(0% 59%,
                        16% 64%,
                        33% 65%,
                        52% 61%,
                        70% 52%,
                        85% 47%,
                        100% 48%,
                        100% 100%,
                        0% 100%);
            }
        }

        /* ********************* Image Waves ************************ */
        .waveDiv {
            position: absolute;
            overflow: hidden;
            margin: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .wave-content-wrapper {
            height: 100%;
            width: 100%;
            position: absolute;
            overflow: hidden;
            bottom: -1px;
            background-image: linear-gradient(to top, #6699ff 30%, #ffffff 90%);
        }

        .first-wave {
            z-index: 3;
            opacity: 0.5;
        }

        .second-wave {
            z-index: 2;
            opacity: 0.75;
        }

        .third-wave {
            z-index: 1;
        }

        .wave-image {
            width: 200%;
            height: 100%;
            position: absolute;
            left: 0;
            background-repeat: repeat no-repeat;
            background-position: 0 bottom;
            transform-origin: center bottom;
        }

        .first-image {
            background-size: 50% 100px;
        }

        .animation-wave .first-image {
            animation: move-wave 3s;
            -webkit-animation: move-wave 3s;
            -webkit-animation-delay: 2s;
            animation-delay: 2s;
        }

        .second-image {
            background-size: 50% 120px;
        }

        .animation-wave .second-image {
            animation: waves 10s linear infinite;
        }

        .third-image {
            background-size: 50% 140px;
        }

        .animation-wave .third-image {
            animation: waves 15s linear infinite;
        }

        @keyframes waves {
            0% {
                transform: translateX(0) scaleY(1);
            }

            50% {
                transform: translateX(-25%) scaleY(0.55);
            }

            100% {
                transform: translateX(-50%) scaleY(1);
            }
        }

        /* Add this CSS to your existing stylesheet */
        .button-wrapper {
            text-align: center;
            position: absolute;
            margin-top: 5%;
        }


        .button-wrapper .login-button {
            z-index: 4;
            color: #fff;
            font-size: 30px;
            white-space: nowrap;
            position: absolute;
            transform: translate(-50%, -62%);
        }

        .login-button a{
            background-color: #6699ff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .login-button:hover {
            background-color: #4477cc;
        }

        /* Animation for the button */
        .login-button {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {

            .button-wrapper {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <section>
        <div class="container">
            <div class="text-animation">
                <div class="text-wrapper">
                    <h2>Selamat Datang Di Mini Project Absensi</h2>
                    <h2>Selamat Datang Di Mini Project Absensi</h2>
                </div>
                <div class="button-wrapper">
                    <div class="login-button">
                        <a href="<?php echo base_url('auth') ?>">Login <i class="fa-solid fa-right-to-bracket"></i></a>
                    </div>
                </div>
            </div>

            <div class="waveDiv animation-wave">
                <div class="wave-content-wrapper first-wave">
                    <div class="wave-image first-image"
                        style="background-image: url('https://www.yudiz.com/codepen/wave-animation/first-wave.png')">
                    </div>
                </div>
                <div class="wave-content-wrapper second-wave">
                    <div class="wave-image second-image"
                        style="background-image: url('https://www.yudiz.com/codepen/wave-animation/second-wave.png')">
                    </div>
                </div>
                <div class="wave-content-wrapper third-wave">
                    <div class="wave-image third-image"
                        style="background-image: url('https://www.yudiz.com/codepen/wave-animation/third-wave.png')">
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>