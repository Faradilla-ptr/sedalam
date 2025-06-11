<?php
session_start();
include "db.php"; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $plain_pwd = $_POST["password"];
    $role = "admin";

    // Regex password: min 8 karakter dengan huruf, angka, underscore
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*_)[A-Za-z\d_]{8,}$/';

    if (!preg_match($pattern, $plain_pwd)) {
        $_SESSION["alert"] = [
            "icon" => "error",
            "title" => "Password Tidak Valid",
            "text" =>
                "Gunakan minimal 8 karakter dengan huruf, angka, dan underscore (_).",
        ];
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    // Cek apakah email sudah terdaftar
    $check_sql = "SELECT id FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["alert"] = [
            "icon" => "error",
            "title" => "Email Sudah Terdaftar",
            "text" => "Silakan gunakan email lain.",
        ];
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    // Jika lolos, hash password dan simpan
    $password = password_hash($plain_pwd, PASSWORD_BCRYPT);
    $insert_sql =
        "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($insert_sql);
    $stmt_insert->bind_param("ssss", $nama, $email, $password, $role);

    if ($stmt_insert->execute()) {
        $_SESSION["register_success"] = true;
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    } else {
        $_SESSION["alert"] = [
            "icon" => "error",
            "title" => "Registrasi Gagal!",
            "text" => "Terjadi kesalahan saat menyimpan data.",
        ];
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Register Sedalam</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
     * { box-sizing: border-box; }
        .body1 { display: flex; background-color: #F9f9f9; justify-content: center; align-items: center; flex-direction: column; font-family: "Poppins", sans-serif; overflow: hidden; height: 100vh; }
        h1 { font-weight: 700; letter-spacing: -1.5px; margin: 0; margin-bottom: 15px; }
        h1.title1 { font-size: 70px; line-height: 60px; margin: 0; text-shadow: 0 0 10px rgba(16, 64, 74, 0.5); }
        p { font-size: 14px; font-weight: 100; line-height: 20px; letter-spacing: 0.5px; margin: 20px 0 30px; text-shadow: 0 0 10px rgba(16, 64, 74, 0.5); }
        span { font-size: 14px; margin-top: 25px; }
        a { color: #333; font-size: 14px; text-decoration: none; margin: 15px 0; transition: 0.3s ease-in-out; }
        a:hover { color: #FFE7CA; }
        .content { display: flex; width: 100%; height: 50px; align-items: center; justify-content: space-around; }
        button {
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

button:hover {
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}
        button:active { transform: scale(0.95); }
        button:focus { outline: none; }
        form { background-color: #fff; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 50px; height: 100%; text-align: center; }
        input, select { background-color: #eee; border-radius: 10px; border: none; padding: 12px 15px; margin: 8px 0; width: 100%; }
        .container { background-color: #fff; border-radius: 25px; box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22); position: relative; overflow: hidden; width: 768px; max-width: 100%; min-height: 500px; }
        .form-container { position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; }
        .register-container { left: 0; width: 100%; z-index: 2; }
        .overlay-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100; }
        body, html { margin: 0; padding: 0; font-family: 'Arial', sans-serif; background-color: #f5e6d3; }
        .password-wrapper {
      position: relative;
      width: 100%;
    }
    .password-wrapper input {
      width: 100%;
      padding-right: 40px; /* ruang untuk ikon */
    }
    .password-wrapper .toggle-pw {
      position: absolute;
      top: 50%;
      right: 12px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #555;
    }
    .login-back {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 28px;
      color: #fff;
      text-decoration: none;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      padding: 10px 12px;
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      z-index: 999;
      border: 1px solid rgba(0, 0, 0, 0.3);
    }

    .login-back:hover {
      background: rgb(222, 59, 59);
      transform: scale(1.1);
      color: #fff;
    }
.judul-register {
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
    font-size: 36px;
    color: #333333;
    text-align: center;
    margin-bottom: 20px;
    letter-spacing: 3px;
}
    </style>
</head>
<body>
<a href="login_admin.php" class="login-back">
  <i class="fas fa-user-circle"></i> 
</a>


    <div class="body1">
        <div class="container" id="container">
            <div class="form-container register-container">
                <form method="post" action="">
                    <h1 class="judul-register">Registrasi</h1>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <div class="password-wrapper">
      <input type="password" name="password"
        id="password"
        placeholder="Password"
        required
      />
      <i class="fas fa-eye toggle-pw" id="togglePw"></i>
    </div>
                    <input type="hidden" name="role" value="admin" />
                    <button type="submit">Daftar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePw');

    toggleIcon.addEventListener('click', () => {
      const isPassword = passwordInput.getAttribute('type') === 'password';
      passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
      toggleIcon.classList.toggle('fa-eye');
      toggleIcon.classList.toggle('fa-eye-slash');
    });
  </script>
<script>
        // Konfirmasi submit
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah data Anda sudah sesuai?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Periksa Lagi',
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });

        // Menampilkan alert dari session
        <?php if (isset($_SESSION["alert"])): ?>
            Swal.fire({
                icon: '<?= $_SESSION["alert"]["icon"] ?>',
                title: '<?= $_SESSION["alert"]["title"] ?>',
                text: '<?= $_SESSION["alert"]["text"] ?>'
            });
            <?php unset($_SESSION["alert"]); ?>
        <?php endif; ?>

        // Registrasi sukses
        <?php if (
            isset($_SESSION["register_success"]) &&
            $_SESSION["register_success"]
        ): ?>
            Swal.fire({
                icon: 'success',
                title: 'Akun berhasil dibuat!',
                text: 'Anda akan diarahkan ke halaman login...',
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = 'login_admin.php';
            });
            <?php unset($_SESSION["register_success"]); ?>
        <?php endif; ?>
    </script>
</body>
</html>
