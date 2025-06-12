<?php
session_start();
include "db.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../../vendor/autoload.php"; // pastikan PHPMailer sudah terpasang

// Fungsi untuk menghasilkan kode unik
function generateUniqueCode($length = 6)
{
    return substr(
        str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"),
        0,
        $length
    );
}

$error = "";
$success = "";

// Handle registrasi
if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["username"]) &&
    isset($_POST["nama"]) &&
    isset($_POST["email"])
) {
    // Ambil data dari form
    $username = trim($_POST["username"]);
    $nama = $_POST["nama"];
    $nik = $_POST["nik"];
    $email = $_POST["email"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $gender = $_POST["gender"];
    $alamat = $_POST["alamat"];
    $telepon = $_POST["telepon"];
    $golongan_darah = $_POST["golongan_darah"];

    // Validasi password
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*_)[A-Za-z\d_]{8,}$/';
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } elseif (!preg_match($pattern, $password)) {
        $error =
            "Password harus minimal 8 karakter dan mengandung huruf, angka, dan underscore (_).";
    } else {
        // Cek apakah username atau email sudah ada
        $check_query = "SELECT * FROM akun WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username atau email sudah terdaftar!";
        } else {
            // Generate kode unik
            $kode_unik = generateUniqueCode();

            // Enkripsi password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            // Proses upload foto saat registrasi
            $target_file = "";
            $error = "";

            /// Bagian untuk menangani upload foto profil saat registrasi
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                // Pastikan direktori upload ada
                $target_dir = "profil/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                // Ambil ID pengguna terakhir yang baru saja diinsert
                $last_id = $conn->insert_id; // Menggunakan insert_id untuk mendapatkan ID terakhir setelah query INSERT

                if (!$last_id) {
                    // Jika tidak ada insert_id (misalnya karena koneksi baru), ambil ID terakhir dari database
                    $query = "SELECT MAX(id) as last_id FROM akun";
                    $result = $conn->query($query);
                    if ($result && ($row = $result->fetch_assoc())) {
                        $last_id = $row["last_id"];
                    }
                }

                // Ambil ekstensi file
                $file_extension = pathinfo(
                    $_FILES["foto"]["name"],
                    PATHINFO_EXTENSION
                );

                // Daftar ekstensi yang diperbolehkan
                $allowed_extensions = ["jpg", "jpeg", "png", "gif", "bmp"];

                // Cek apakah ekstensi file diizinkan
                if (
                    !in_array(strtolower($file_extension), $allowed_extensions)
                ) {
                    $error =
                        "Hanya file gambar dengan ekstensi JPG, JPEG, PNG, GIF, atau BMP yang diizinkan.";
                } else {
                    // Buat nama file baru dengan format profil_[id].[extension]
                    $new_filename =
                        "profil_" . $last_id . "." . $file_extension;
                    $target_file = $target_dir . $new_filename;

                    // Cek dan hapus file lama jika ada (untuk menghindari file sampah)
                    $old_files = glob(
                        $target_dir . "profil_" . $last_id . ".*"
                    );
                    foreach ($old_files as $old_file) {
                        if (is_file($old_file)) {
                            unlink($old_file);
                        }
                    }
                }
            }
            if (empty($error)) {
                // Simpan data pengguna di database
                $query = "INSERT INTO akun (username, nama, nik, email, tanggal_lahir, password, gender, alamat, telepon, foto, golongan_darah,kode_unik) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param(
                    "ssssssssssss",
                    $username,
                    $nama,
                    $nik,
                    $email,
                    $tanggal_lahir,
                    $password_hash,
                    $gender,
                    $alamat,
                    $telepon,
                    $target_file,
                    $golongan_darah,
                    $kode_unik
                );

                if ($stmt->execute()) {
                    // Kirim kode unik ke email pengguna
                    $mail = new PHPMailer(true);

                    try {
                        // Pengaturan mailer
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = "faradilla.anastasyaptr@gmail.com";
                        $mail->Password = "fmup yyoi gntj bush";
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        $mail->SMTPOptions = [
                            "ssl" => [
                                "verify_peer" => false,
                                "verify_peer_name" => false,
                                "allow_self_signed" => true,
                            ],
                        ];

                        // Pengaturan email
                        $mail->setFrom(
                            "faradilla.anastasyaptr@gmail.com",
                            "Sedalam"
                        );
                        $mail->addAddress($email, $nama); // Alamat email penerima
                        $mail->isHTML(true);
                        $mail->Subject = "Kode Unik Registrasi Anda";

                        // Konten email dengan HTML untuk tampilan lebih baik
                        $mail->Body =
                            '
                        <html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; line-height: 1.6; }
                                .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                                .header { background: #4D290E; color: white; padding: 10px; text-align: center; border-radius: 5px 5px 0 0; }
                                .content { padding: 20px; }
                                .code { font-size: 24px; font-weight: bold; text-align: center; margin: 20px 0; padding: 10px; background: #f0f0f0; border-radius: 5px; }
                                .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="header">
                                    <h2>Selamat Datang di Sedalam</h2>
                                </div>
                                <div class="content">
                                    <p>Hai <b>' .
                            $nama .
                            '</b>,</p>
                                    <p>Terima kasih telah mendaftar di Sedalam. Pendaftaran Anda telah berhasil!</p>
                                    <p>Berikut adalah kode unik Anda untuk pemulihan password jika suatu saat diperlukan:</p>
                                    <div class="code">' .
                            $kode_unik .
                            '</div>
                                    <p>Harap simpan kode ini dengan aman. Jangan berikan kepada siapapun.</p>
                                    <p>Salam,<br>Tim Sedalam</p>
                                </div>
                                <div class="footer">
                                    Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                                </div>
                            </div>
                        </body>
                        </html>';

                        // Set versi plaintext untuk email client yang tidak support HTML
                        $mail->AltBody = "Halo $nama,\n\nTerima kasih telah mendaftar di Sedalam. Berikut adalah kode unik Anda untuk pemulihan password: $kode_unik\n\nHarap simpan kode ini dengan aman.\n\nSalam,\nTim Sedalam";

                        $mail->send();
                        $success =
                            "Akun berhasil dibuat. Kode unik telah dikirim ke email Anda. Silakan login untuk melanjutkan.";

                        // PENTING: TIDAK redirect langsung ke akun.php setelah registrasi
                        // User harus login dulu
                    } catch (Exception $e) {
                        $error = "Pesan gagal dikirim. Error: {$mail->ErrorInfo}";
                    }
                } else {
                    $error =
                        "Registrasi gagal. Coba lagi. Error: " . $stmt->error;
                }
            }
        }
    }
}

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_submit"])) {
    // Memastikan form login yang disubmit dengan cek keberadaan field login_submit
    $userInput = $_POST["login_username"]; // Field input login khusus
    $password = $_POST["login_password"]; // Field password login khusus
    $_SESSION["login_user"] = $username_yang_login;
    // Query untuk cek user berdasarkan username atau email
    $query = "SELECT * FROM akun WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $userInput, $userInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user["password"])) {
            // Set session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["nama"] = $user["nama"];

            $_SESSION["login_success"] = true;
            header("Location: akun.php");
            exit();
        } else {
            $login_error = "Password salah!";
        }
    } else {
        $login_error = "Username atau email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sedalam</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.js"></script>

  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  * {
  box-sizing: border-box;
}
body, html {
  margin: 0;
  padding: 0;
  font-family: 'Quicksand', sans-serif;
  background-color: #F9f9f9;
  color: #333;
}
.body1 {
  display: flex;
  background-color: #F9f9f9;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  overflow: hidden;
  height: 100vh;
}
@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@600&display=swap');
h1 {
  font-weight: 700;
  font-family: 'Fredoka', sans-serif;
  letter-spacing: -1.5px;
  margin: 0;
  margin-bottom: 15px;
}
@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@600&display=swap');

.title1,.title2 {
  font-family: 'Fredoka', sans-serif;
  font-size: 5rem;
  background: linear-gradient(90deg, rgb(243, 132, 132), rgb(255, 255, 255), rgb(235, 122, 122));
  background-size: 200% auto;
  color: transparent;
  background-clip: text;
  -webkit-background-clip: text;
  animation: gradientMove 6s ease infinite;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2); 
}


@keyframes gradientMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

p.typing-effect {
  white-space: nowrap;
  overflow: hidden;
  border-right: 3px solid #800000;
  width: 0;
  animation: typing 4s steps(40, end) forwards, blink 0.75s step-end infinite;
}

@keyframes typing {
  from { width: 0; }
  to { width: 100%; }
}

@keyframes blink {
  0%, 100% { border-color: transparent; }
  50% { border-color: #800000; }
}

span {
  font-size: 15px;
  margin-top: 25px;
  color: #6a040f;
  font-weight: 500;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
}
span:hover {
  transform: scale(1.05);
}

a {
  color: #6a040f;
  font-size: 14px;
  text-decoration: none;
  margin: 15px 0;
  transition: 0.3s;
}
a:hover {
  color: #e63946;
}

.content {
  display: flex;
  width: 100%;
  height: 50px;
  align-items: center;
  justify-content: space-around;
}

.content .checkbox {
  display: flex;
  align-items: center;
  justify-content: center;
}

.content input {
  accent-color: #333;
  width: 12px;
  height: 12px;
}

.content label {
  font-size: 14px;
  user-select: none;
  padding-left: 5px;
}

button {
  border-radius: 25px;
  border: none;
  background-image: linear-gradient(to right, #800000, #e63946);
  color: white;
  font-size: 16px;
  font-weight: 600;
  margin: 10px;
  padding: 12px 80px;
  letter-spacing: 1px;
  text-transform: capitalize;
  box-shadow: 0 4px 15px rgba(230, 57, 70, 0.4);
  transition: all 0.3s ease-in-out;
}
button:hover {
  transform: scale(1.03);
  box-shadow: 0 6px 20px rgba(230, 57, 70, 0.6);
}
button:active {
  transform: scale(0.95);
}

button:focus {
  outline: none;
}

button.ghost {
  background-color: rgba(225, 225, 225, 0.2);
  border: 2px solid #fff;
  color: #FFE7CA;
}

button.ghost i{
  position: absolute;
  opacity: 0;
  transition: 0.3s ease-in-out;
}

button.ghost i.register{
  right: 70px;
}

button.ghost i.login{
  left: 70px;
}

button.ghost:hover i.register{
  right: 40px;
  opacity: 1;
}

button.ghost:hover i.login{
  left: 40px;
  opacity: 1;
}

form {
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 50px;
  height: 100%;
  text-align: center;
}

input {
  background-color: #eee;
  border-radius: 10px;
  border: none;
  padding: 12px 15px;
  margin: 6px 0;
  width: 100%;
}

.container {
  background-color: #fff;
  border-radius: 25px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  position: relative;
  overflow: hidden;
  width: 1200px; /* ditingkatkan dari 768px */
  max-width: 100%;
  min-height: 750px; /* diperbesar */
}

.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  width: 50%;
  transition: all 0.6s ease-in-out;
  padding: 30px;
  overflow-y: auto; 
  max-height: 100%;/* ini penting agar bisa scroll jika form tinggi */
  box-sizing: border-box;
}


.login-container {
  left: 0;
  width: 50%;
  z-index: 2;
}

.container.right-panel-active .login-container {
  transform: translateX(100%);
}

.register-container {
  left: 0;
  width: 50%;
  opacity: 0;
  z-index: 1;
}

.container.right-panel-active .register-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: show 0.6s;
}

@keyframes show {
  0%,
  49.99% {
    opacity: 0;
    z-index: 1;
  }

  50%,
  100% {
    opacity: 1;
    z-index: 5;
  }
}

.overlay-container {
  
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}

.container.right-panel-active .overlay-container {
  transform: translate(-100%);
}

.overlay {
  background-image: url('../../assets/blood.jpg');
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 0 0;
  color: #FFE7CA;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.overlay::before {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: linear-gradient(
    to top,
    rgba(46, 94, 109, 0.4) 40%,
    rgba(46, 94, 109, 0)
  );
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
}

.overlay-panel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;

}

.overlay-left {
  transform: translateX(-20%);
  
}

.container.right-panel-active .overlay-left {
  transform: translateX(0);
}

.overlay-right {
  right: 0;
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}

.social-container {
  margin: 20px 0;
}

.social-container a {
  border: 1px solid #dddddd;
  border-radius: 50%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 0 5px;
  height: 40px;
  width: 40px;
  transition: 0.3s ease-in-out;
}

.social-container a:hover {
  border: 1px solid #FFE7CA;
}

.image {
  width: 10%; 
  height: auto; 
  margin: 0;
  padding: 0;
}

.body2 {
  background: url('../../assets/blood.jpg'); /* Gunakan path absolut */
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
}

body, html {
  margin: 0;
  padding: 0;
  font-family: 'Arial', sans-serif;
  background-color: #f5e6d3;
}

.navbar {
    background-color: #4b2e2e;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logo{
    height: auto;
    width: 50%;

}

.navbar .logo span {
    color: #FFFFFF;
    font-size: 20px;
    font-family: 'Brush Script MT', cursive;
}
.navbar .nav-links {
    display: flex;
    gap: 20px;
}
.navbar .nav-links a {
    color: #FFFFFF;
    text-decoration: none;
    font-size: 16px;
}
.navbar .icons {
    display: flex;
    gap: 15px;
    color: white;
}
.navbar .icons i {
    color: #FFFFFF;
    font-size: 20px;
}

.logo-form {
    max-width: 300px;
    height: auto;
    
}
.password-wrapper {
  position: relative;
  width: 100%;
}

.password-wrapper input {
  width: 100%;
  padding-right: 40px;
}

.password-wrapper i {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  cursor: pointer;
  color: #666;
}

.gender-alamat-wrapper {
  display: flex;
  gap: 10px;
  width: 100%;
}

.gender-alamat-wrapper select,
.gender-alamat-wrapper textarea {
  flex: 1;
  border-radius: 10px;
  border: none;
  padding: 12px 15px;
  background-color: #eee;
  margin: 8px 0;
}
.gender-alamat-wrapper textarea {
  resize: vertical;
  min-height: 45px;
}

.golongan-darah-wrapper {
  display: flex;
  gap: 10px;
  width: 100%;
}

.golongan-darah-wrapper select {
  flex: 1;
  border-radius: 10px;
  border: none;
  padding: 12px 15px;
  background-color: #eee;
  margin: 8px 0;
}
.judul-login {
  font-size: 60px;
  font-weight: 700;
  font-family: 'Segoe UI', sans-serif;
  color:rgb(0, 0, 0); /* Warna tegas dan profesional */
  margin-bottom: 20px;
  margin-top: 30px;
  text-align: center;
  letter-spacing: 3px;
  border-bottom: 2px solid #3e6e85;
  display: inline-block;
  padding-bottom: 5px;
}




/* Wrapper input HP */
.phone-input-wrapper {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
  width: 100%; /* Penting untuk menyamakan lebar */
}

/* Kotak kecil +62 */
.kode-negara {
  width: 70px;
  height: 45px;
  border-radius: 10px;
  background-color: #eee;
  border: none;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  font-size: 14px;
  color: #333;
  flex-shrink: 0; /* Biar tidak mengecil */
}

/* Input nomor HP */
.phone-input-wrapper input[type="text"] {
  background-color: #eee;
  border-radius: 10px;
  border: none;
  padding: 12px 15px;
  font-size: 14px;
  width: 100%;
}

.judul-register {
  font-size: 30px;
  font-weight: 700;
  font-family: 'Segoe UI', sans-serif;
  color:rgb(0, 0, 0); /* Warna tegas dan profesional */
  margin-bottom: 20px;
  margin-top: 30px;
  margin-bottom: 10px;
  text-align: center;
  letter-spacing: 3px;
  border-bottom: 2px solid #3e6e85;
  display: inline-block;
  padding-bottom: 5px;
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
    .upload-box {
    display: block;
    width: 100%;
    min-height: 45px;
    padding: 12px 15px;
    border: 2px solid #ccc;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    color: #555;
    font-weight: bold;
    transition: background-color 0.2s;
    box-sizing: border-box;
    margin: 6px 0;
    background-color: #eee;
}

.upload-box:hover {
    background-color: #eee;
}

.upload-box input[type="file"] {
    display: none;
}
    .file-name {
        margin-left: 10px;
        font-style: italic;
        color: #000000;
    }
</style>
</head> 

<body>
<a href="/sedalam/view/user/home.php" class="logo-home">🏠</a>

<div class="body1">
  <div class="container" id="container">

  <div class="form-container register-container">
  <form method="post" enctype="multipart/form-data">
    <h1 class="judul-register">Daftar Akun</h1>

    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="nama" placeholder="Nama Lengkap" required>
    <input type="text" name="nik" placeholder="NIK" required> <!-- NIK Input -->
    <input type="email" name="email" placeholder="Email" required>
    <input type="date" name="tanggal_lahir" required>

    <!-- Golongan Darah Input -->
    <div class="golongan-darah-wrapper">
  <select name="golongan_darah" required>
    <option value="">Pilih Golongan Darah</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="AB">AB</option>
    <option value="O">O</option>
  </select>
</div>
    <!-- Password Field dengan Icon Mata -->
    <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <i class="far fa-eye" id="togglePassword"></i>
    </div>

    <!-- Konfirmasi Password Field -->
    <div class="password-wrapper">
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
        <i class="far fa-eye" id="toggleConfirmPassword"></i>
    </div>

    <!-- Gender dan Alamat Sejajar -->
    <div class="gender-alamat-wrapper">
        <select name="gender" required>
            <option value="">Pilih Gender</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <textarea name="alamat" placeholder="Alamat" required></textarea>
    </div>
    <div class="phone-input-wrapper">
  <div class="kode-negara">+62</div>
  <input type="text" name="telepon" placeholder="Nomor HP" required>
</div>
<label class="upload-box" id="file-label">
    Upload Profil
    <input type="file" name="foto" accept="image/*" onchange="showFileName(this)">
</label>
    <button type="submit">Daftar</button>
</form>
</div>
  <div class="form-container login-container">
  <form method="post" action="">
  <h1 class="judul-login">Login</h1>
    <div class="text-center">
      <img src="../../assets/logo_sedalam.png" alt="Logo Sedalam" class="logo-form">
    </div>
    <input type="text" name="login_username" placeholder="Username atau Email" required>
    <div class="password-wrapper">
      <input type="password" id="login_password" name="login_password" placeholder="Password" required>
      <i class="far fa-eye" id="toggleLoginPassword"></i>
    </div>
    <!-- Tambahkan hidden input untuk membedakan form login -->
    <input type="hidden" name="login_submit" value="1">
    <button type="submit">Login</button>
    <a href="lupa_password.php" class="forgot-password-btn">Lupa Password?</a>
  </form>
</div>

    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1 class="title2">Start your <br> donating blood</h1>
          <p>Create your Blood Donation account to make a difference, receive personalized notifications, and track your donation history. Join us in saving lives! 💉❤</p>
          <button class="ghost" id="login">Login
            <i class="lni lni-arrow-left login"></i>
          </button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1 class="title1">Sedalam</h1>
          <p>Welcome to Sedalam! Every donation is a step towards saving a life. Come, donate, and be part of something bigger. 💉✨</p>
          <button class="ghost" id="register">Register
            <i class="lni lni-arrow-right register"></i>
          </button>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
// Tampilkan notifikasi error atau success dengan SweetAlert2
if (!empty($error)) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '$error',
                confirmButtonColor: '#4D290E'
            });
        });
    </script>";
} elseif (!empty($success)) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: '$success',
                confirmButtonColor: '#4D290E'
            });
        });
    </script>";
}

// Tampilkan error login jika ada
if (!empty($login_error)) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '$login_error',
                confirmButtonColor: '#4D290E'
            });
        });
    </script>";
}
?>

<script>
  function validatePhoneNumber() {
  const phoneInput = document.getElementById("telepon").value.trim();
  
  if (phoneInput.startsWith("08")) {
    alert("Nomor telepon harus diawali dengan 628, bukan 08.");
    return false;
  } else if (!phoneInput.startsWith("628")) {
    alert("Nomor telepon tidak valid. Harus diawali dengan 628.");
    return false;
  }
  
  return true; // Valid, lanjutkan submit
}
// Toggle password untuk form registrasi
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function () {
  const type = password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
  this.classList.toggle("fa-eye-slash");
});

// Toggle konfirmasi password
const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
const confirmPassword = document.querySelector("#confirm_password");

toggleConfirmPassword.addEventListener("click", function () {
  const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
  confirmPassword.setAttribute("type", type);
  this.classList.toggle("fa-eye-slash");
});

// Toggle password untuk form login
const toggleLoginPassword = document.querySelector("#toggleLoginPassword");
const loginPassword = document.querySelector("#login_password");

if (toggleLoginPassword) {
  toggleLoginPassword.addEventListener("click", function () {
    const type = loginPassword.getAttribute("type") === "password" ? "text" : "password";
    loginPassword.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash");
  });
}

// Animasi container
const registerButton = document.getElementById("register");
const loginButton = document.getElementById("login");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

loginButton.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
});

// Auto-display register form if there was an error with registration
<?php if (!empty($error) && isset($_POST["username"])) { ?>
    document.addEventListener('DOMContentLoaded', function() {
        container.classList.add("right-panel-active");
    });
<?php } ?>

// Auto-display login form if there was an error with login
<?php if (!empty($login_error)) { ?>
    document.addEventListener('DOMContentLoaded', function() {
        container.classList.remove("right-panel-active");
    });
<?php } ?>
</script>
<script>
function showFileName(input) {
    const fileName = input.files.length > 0 ? input.files[0].name : "Upload Profil";
    document.getElementById('file-label').textContent = fileName;
    // re-append input so it still works
    input.parentNode.appendChild(input);
}
</script>
</body>
</html>