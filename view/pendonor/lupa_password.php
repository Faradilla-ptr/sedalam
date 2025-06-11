<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS di sini (yang sudah kamu tulis sebelumnya) */
        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }
        .logo-home {
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

        .logo-home:hover {
            background: rgb(222, 59, 59);
            transform: scale(1.1);
            color: #fff;
        }
        .reset-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #4A90E2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
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

.btn-primary:hover {
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}

        .form-text {
            color: #777;
            font-size: 14px;
            margin-top: 5px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: #31708f;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slide-in 0.5s forwards;
            z-index: 1000;
        }

        .notification-content {
            display: flex;
            align-items: center;
        }

        .success {
            background-color: #DFF2BF;
            color: #4F8A10;
            border-left: 4px solid #4F8A10;
        }

        .error {
            background-color: #FFBABA;
            color: #D8000C;
            border-left: 4px solid #D8000C;
        }

        .check-icon, .error-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .message {
            font-weight: 500;
        }

        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<a href="login_user.php" class="logo-home">🏠</a>

<?php
// Tampilkan pesan jika ada
if (isset($_SESSION["pesan"])) {
    echo '<div class="alert alert-info">' . $_SESSION["pesan"] . "</div>";
    unset($_SESSION["pesan"]);
}

// Tampilkan form reset password baru jika validasi email dan kode unik berhasil
if (
    isset($_SESSION["reset_email"]) &&
    isset($_SESSION["validasi_berhasil"]) &&
    $_SESSION["validasi_berhasil"] === true
) {
    // Form reset password
    echo '
    <div class="container">
        <div class="reset-form">
            <h2>Reset Password Baru</h2>
            <form method="POST" class="form-reset">
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small class="form-text">Password minimal 8 karakter</small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" name="reset_password" class="btn btn-primary">Perbarui Password</button>
            </form>
        </div>
    </div>
    ';
} else {
    echo '
    <div class="container">
        <div class="reset-form">
            <h2>Lupa Password</h2>
            <form method="POST" class="form-validasi">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email anda" required>
                </div>
                <div class="form-group">
                    <label for="kode_unik">Kode Unik</label>
                    <input type="text" id="kode_unik" name="kode_unik" class="form-control" placeholder="Masukkan kode unik anda" required>
                    <small class="form-text">Kode unik dapat ditemukan di email konfirmasi pendaftaran</small>
                </div>
                <button type="submit" name="validasi" class="btn btn-primary">Validasi</button>
            </form>
        </div>
    </div>
    ';
}

// Validasi email dan kode unik
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["validasi"])) {
    // (kode validasi email & kode unik)
    // (sudah ada di kode awal kamu, tetap dipakai)
}

// Proses reset password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
    // (kode update password)
    // (sudah ada di kode awal kamu, tetap dipakai)
}
?>

</body>
</html>
