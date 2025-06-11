<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . "/../../vendor/autoload.php"; // PHPMailer autoload

$step = $_SESSION["reset_step"] ?? 1;
$error = $success = "";

function kirimOtp($conn, $email)
{
    $otp = rand(100000, 999999);
    $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        return "Email tidak ditemukan di database.";
    }

    $update = $conn->prepare(
        "UPDATE users SET otp = ?, otp_expiry = ? WHERE email = ?"
    );
    $update->bind_param("sss", $otp, $expiry, $email);
    if (!$update->execute()) {
        return "Gagal memperbarui OTP: " . $conn->error;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "annisaikrimatus@gmail.com"; // GANTI
        $mail->Password = "pjfm vftt rete vbig"; // GANTI: App Password
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("annisaikrimatus@gmail.com", "Reset Password");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Kode OTP Reset Password";
        $mail->Body = "Kode OTP Anda adalah: <b>$otp</b><br>Kode berlaku selama 10 menit.";

        $mail->send();
        return "OTP telah dikirim ke email Anda.";
    } catch (Exception $e) {
        return "Gagal mengirim email: " . $mail->ErrorInfo;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["ubah_email"])) {
        $_SESSION["reset_step"] = 1;
        unset($_SESSION["reset_email"]);
        $step = 1;
    } elseif ($step == 1 && isset($_POST["email"])) {
        $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $error = "Format email tidak valid.";
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION["reset_email"] = $email;
                $_SESSION["reset_step"] = 2;
                $step = 2;
                $success = kirimOtp($conn, $email);
            } else {
                $error = "Email tidak ditemukan!";
            }
        }
    } elseif ($step == 2 && isset($_POST["otp"])) {
        $otp = trim($_POST["otp"]);
        $email = $_SESSION["reset_email"] ?? "";

        $stmt = $conn->prepare(
            "SELECT otp, otp_expiry FROM users WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            $error = "Email tidak ditemukan.";
        } elseif ($data["otp"] != $otp) {
            $error = "Kode OTP salah.";
        } elseif (strtotime($data["otp_expiry"]) < time()) {
            $error = "Kode OTP sudah kadaluarsa.";
        } else {
            $_SESSION["reset_step"] = 3;
            $step = 3;
            $success = "OTP benar. Silakan ganti password.";
        }
    } elseif ($step == 2 && isset($_POST["resend_otp"])) {
        $email = $_SESSION["reset_email"] ?? "";
        if ($email) {
            $success = kirimOtp($conn, $email);
        } else {
            $error = "Email tidak tersedia dalam sesi.";
        }
    } elseif ($step == 3 && isset($_POST["password"])) {
        $email = $_SESSION["reset_email"] ?? "";
        $password_plain = $_POST["password"];
        if (strlen($password_plain) < 6) {
            $error = "Password minimal 6 karakter.";
        } else {
            $password = password_hash($password_plain, PASSWORD_DEFAULT);
            $stmt = $conn->prepare(
                "UPDATE users SET password = ?, otp = NULL, otp_expiry = NULL WHERE email = ?"
            );
            $stmt->bind_param("ss", $password, $email);
            if ($stmt->execute()) {
                $success = "Password berhasil diperbarui. Silakan login.";
                $_SESSION = [];
                session_destroy();
            } else {
                $error = "Gagal mengganti password.";
            }
        }
    }
}
?>

<!-- Ganti bagian <head> dan <style> Anda dengan ini -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #ffffff;
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    form {
  background: #fff;
  padding: 40px 35px; /* tambah padding */
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  width: 100%;
  max-width: 600px; /* dari 360px ke 480px */
  text-align: center;
  animation: fadeIn 0.8s ease-in-out;
}


    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      margin-bottom: 15px;
      color:rgb(0, 0, 0);
    }

    input {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 15px;
  transition: 0.3s;
  box-sizing: border-box; /* ⬅️ ini yang penting */
}
  input:focus {
      border-color:rgb(243, 58, 58);
      outline: none;
      box-shadow: 0 0 5px rgb(243, 58, 58);
    }

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

    .resend {
      background-color: #ccc;
      color: #333;
    }

    .msg {
      margin-top: 10px;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
      text-align: left;
    }

    .msg.success {
      background-color: #e6f9e6;
      color: #2b7a2b;
      border: 1px solid #b6e2b6;
    }

    .msg.error {
      background-color: #ffe6e6;
      color: #b30000;
      border: 1px solid #ffb3b3;
    }

    p {
      margin: 0;
      color: #555;
      font-size: 14px;
      margin-bottom: 8px;
    }

    .icon-input {
      position: relative;
    }

    .icon-input i {
      position: absolute;
      top: 14px;
      left: 12px;
      color: #888;
    }

    .icon-input input {
      padding-left: 35px;
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
  </style>
</head>
<body>
<a href="../../login_admin.php" class="logo-home" title="Kembali ke Beranda">
  <i class="fas fa-home"></i>
</a>
  <form method="POST">
    <h2><i class="fas fa-unlock-alt"></i> Reset Password</h2>

    <?php if (!empty($error)): ?>
      <div class="msg error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="msg success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($step == 1): ?>
      <div class="icon-input">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Masukkan Email" required>
      </div>
      <button type="submit">Kirim OTP</button>

    <?php elseif ($step == 2): ?>
      <p><i class="fas fa-envelope-open-text"></i> Email: <strong><?= $_SESSION[
          "reset_email"
      ] ?></strong></p>
      <div class="icon-input">
        <i class="fas fa-key"></i>
        <input type="text" name="otp" placeholder="Masukkan OTP" required>
      </div>
      <button type="submit">Verifikasi OTP</button>
      <button type="submit" name="resend_otp" class="resend">Kirim Ulang OTP</button>
      <button type="submit" name="ubah_email" class="resend">Ubah Email</button>

    <?php elseif ($step == 3): ?>
      <div class="icon-input">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password Baru" required>
      </div>
      <button type="submit">Ganti Password</button>
    <?php endif; ?>
  </form>
</body>
</html>
