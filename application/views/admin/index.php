<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Tambahkan file CSS kustom jika diperlukan -->
    <link rel="stylesheet" href="path_to_custom_css/custom.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Nama Aplikasi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="confirmLogout()">Keluar</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4">
                <!-- Widget 1 -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Widget 1</h5>
                        <p class="card-text">Konten widget 1</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Widget 2 -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Widget 2</h5>
                        <p class="card-text">Konten widget 2</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Widget 3 -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Widget 3</h5>
                        <p class="card-text">Konten widget 3</p>
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
                    window.location.href = "<?php echo base_url('/auth/register') ?>";
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Tambahkan file JavaScript kustom jika diperlukan -->
    <script src="path_to_custom_js/custom.js"></script>
</body>

</html>