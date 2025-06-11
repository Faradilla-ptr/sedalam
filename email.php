<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php"; // Pastikan PHPMailer sudah diinstall

function getMailer()
{
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = "smtp.example.com"; // Ganti sesuai penyedia emailmu
        $mail->SMTPAuth = true;
        $mail->Username = "faradilla.anastasyaptr@gmail.com"; // Email pengirim
        $mail->Password = "giwg gqyv vyte nvao"; // Password email pengirim
        $mail->SMTPSecure = "tls"; // Atau 'ssl'
        $mail->Port = 587; // Sesuaikan dengan penyedia

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Bisa kamu log kalau mau debug
        return false;
    }
}
?>
