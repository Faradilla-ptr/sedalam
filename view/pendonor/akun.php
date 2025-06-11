<?php
session_start();
include "db.php"; // Sesuaikan dengan lokasi file db.php

// Cek apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login_user.php");
    exit();
}

// Ambil data user dari database
$id_user = $_SESSION["user_id"];
$query = "SELECT * FROM akun WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akun Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.js"></script>
    
    <style>
        body {
            background-color: #f8f9fa; /* Biru muda untuk background */
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 15px;
            overflow-y: auto;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .card {
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: white;
            
        }
        .btn-warning, .btn-secondary {
  position: relative;
  border-radius: 25px;
  border: none;
  background: linear-gradient(135deg, rgb(224, 87, 101), #a71d2a);
  color: #ffffff;
  font-size: 15px;
  font-weight: 700;
  margin: 10px;
  padding: 12px 80px;
  letter-spacing: 1px;
  text-transform: capitalize;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(167, 29, 42, 0.4);
  cursor: pointer;
}

.btn-warning:hover, .btn-secondary:hover {
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}

.profil-img {
    width: 400px;         /* 5 bagian */
    height: 400px;        /* 6 bagian */
    object-fit: cover;    /* agar gambar memenuhi kotak tanpa distorsi */
    border-radius: 8px;
    border: 1px solid #ccc;
}
        .table th, .table td {
            vertical-align: middle;
        }
        .custom-header {
            background: linear-gradient(135deg,rgb(224, 87, 101), #a71d2a);
}

.text-profil {
    color: #ffffff;
    font-weight: bold;
}

    </style>
</head>
<body>
<?php include "sidebar.php"; ?>

<div class="content">
    <?php // Tampilkan pesan sukses jika ada

if (isset($_SESSION["success_message"])) {
        echo '<script>
            Swal.fire({
                title: "Berhasil!",
                text: "' .
            $_SESSION["success_message"] .
            '",
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        </script>';
        unset($_SESSION["success_message"]);
    } ?>

    <div class="card shadow">
    <div class="card-header custom-header">
    <h4 class="mb-0 text-profil"><i class="bi bi-person-circle"></i> Profil Akun</h4>
</div>

        <div class="card-body row">
            <div class="col-md-4 text-center">
            <?php
            $foto_url_dir = "profil/";
            $foto_basename = "profil_" . $user["id"];
            $foto_extensions = ["jpg", "jpeg", "png", "gif", "bmp"];

            $foto_url = "";

            // Cek file berdasarkan direktori dan nama file
            foreach ($foto_extensions as $ext) {
                $path =
                    __DIR__ . "/" . $foto_url_dir . $foto_basename . "." . $ext;
                if (file_exists($path)) {
                    $foto_url = $foto_url_dir . $foto_basename . "." . $ext;
                    break;
                }
            }

            // Jika tidak ada, gunakan default
            if (!$foto_url) {
                $foto_url = "../assets/img/default_profile.jpg";
            }

            // Tambahkan timestamp agar tidak cache
            $timestamp = time();

            echo '<img src="' .
                $foto_url .
                "?v=" .
                $timestamp .
                '" class="img-thumbnail mb-3 profil-img">';
            ?>


            </div>

            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <th></i> Username</th>
                        <td>: <?= htmlspecialchars($user["username"]) ?></td>
                    </tr>
                    <tr>
                        <th></i> Nama</th>
                        <td>: <?= htmlspecialchars($user["nama"]) ?></td>
                    </tr>
                    <tr>
                        <th></i> NIK</th>
                        <td>: <?= htmlspecialchars($user["nik"]) ?></td>
                    </tr>
                    <tr>
                        <th></i> Golongan Darah</th>
                        <td>: <?= htmlspecialchars(
                            $user["golongan_darah"]
                        ) ?></td>
                    </tr>
                    <tr>
                        <th></i> Email</th>
                        <td>: <?= htmlspecialchars($user["email"]) ?></td>
                    </tr>
                    <tr>
                        <th></i> Tanggal Lahir</th>
                        <td>: <?= htmlspecialchars(
                            $user["tanggal_lahir"]
                        ) ?></td>
                    </tr>
                    <tr>
                        <th></i> Gender</th>
                        <td>: <?= htmlspecialchars($user["gender"]) ?></td>
                    </tr>
                    <tr>
                        <th></i> Telepon</th>
                        <td>: <?= htmlspecialchars($user["telepon"]) ?></td>
                    </tr>
                    <tr>
                        <th></i> Alamat</th>
                        <td>: <?= htmlspecialchars($user["alamat"]) ?></td>
                    </tr>
                </table>

                <a href="edit_profil.php" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit Profil
                </a>
                <a href="ubah_pw.php" class="btn btn-secondary">
                    <i class="bi bi-lock"></i> Ganti Password
                </a>
            </div>
        </div>
    </div>
</div>

<script>
window.onload = function() {
    <?php if (
        isset($_SESSION["login_success"]) &&
        $_SESSION["login_success"] == true
    ) { ?>
        Swal.fire({
            title: 'Selamat Datang!',
            text: 'Login kamu berhasil! 🎉',
            icon: 'success',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
        });

        <?php unset($_SESSION["login_success"]); ?>
    <?php } ?>
}
</script>

</body>
</html>