<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

function sendVerificationEmail($toEmail, $verificationCode)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = "smtp.example.com"; // Ganti dengan server SMTP yang Anda gunakan (misalnya Gmail: smtp.gmail.com)
        $mail->SMTPAuth = true;
        $mail->Username = "annisaikrimatus@gmail.com"; // Ganti dengan email Anda
        $mail->Password = "pjfm vftt rete vbig"; // Ganti dengan password email Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom("youremail@example.com", "Admin");
        $mail->addAddress($toEmail); // Email penerima

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Verifikasi Lupa Password";
        $mail->Body = "Klik link berikut untuk mengatur ulang password Anda: <a href='http://yourdomain.com/reset_password.php?code=$verificationCode'>Reset Password</a>";
        $mail->AltBody =
            "Klik link berikut untuk mengatur ulang password Anda: http://yourdomain.com/reset_password.php?code=" .
            $verificationCode;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
