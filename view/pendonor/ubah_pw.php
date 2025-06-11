<?php

session_start();
include "db.php";
// Koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari session
$user_id = $_SESSION["user_id"];

// Cek jika form ubah password disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Ambil data user dari database
    $query = "SELECT * FROM akun WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifikasi password lama
    if (password_verify($current_password, $user["password"])) {
        if ($new_password === $confirm_password) {
            // Enkripsi password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password di database
            $update_query = "UPDATE akun SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $hashed_password, $user_id);

            if ($update_stmt->execute()) {
                $success_message = "Password berhasil diubah!";
            } else {
                $error_message = "Terjadi kesalahan, coba lagi nanti!";
            }
        } else {
            $error_message =
                "Password baru dan konfirmasi password tidak cocok!";
        }
    } else {
        $error_message = "Password lama salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
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
            padding: 30px 20px 20px 20px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .position-relative {
            position: relative;
        }
        .custom-header {
            background: linear-gradient(135deg,rgb(224, 87, 101), #a71d2a);
}
.btn-custom  {
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

.btn-custom:hover{
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}

    </style>
</head>
<body class="bg-light">

<?php include "sidebar.php"; ?>

<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                        <div class="card-header custom-header">
                <h4 class="text-center text-white">Ubah Password</h4>
            </div>


                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= $error_message ?></div>
                    <?php endif; ?>
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success"><?= $success_message ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3 position-relative">
                            <label for="current_password" class="form-label">Password Lama</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                            <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('current_password', this)"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                            <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('new_password', this)"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('confirm_password', this)"></i>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Ubah Password</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="akun.php">Kembali ke Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(id, icon) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }
</script>

</body>
</html>
