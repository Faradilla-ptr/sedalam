<?php
// Kirim Email via PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../../vendor/autoload.php";

// Koneksi database
$conn = new mysqli("localhost", "root", "", "web_donor");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    // Ambil data dari database
    $stmt = $conn->prepare(
        "SELECT email, konfirmasi FROM pengajuan WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email, $konfirmasi);
    $stmt->fetch();
    $stmt->close();

    if ($email) {
        // Persiapan isi email berdasarkan status konfirmasi
        $body = "";
        if ($konfirmasi == "sukses") {
            $body =
                "Halo! Pengajuan donor darah Anda telah <b>DITERIMA</b>. Terima kasih atas partisipasi Anda.";
        } elseif ($konfirmasi == "gagal") {
            $body =
                "Maaf, pengajuan donor darah Anda <b>TIDAK DAPAT DIPROSES</b>. Silakan coba lagi di lain waktu.";
        } else {
            $body = "Status pengajuan Anda: <b>$konfirmasi</b>. Silakan hubungi admin untuk informasi lebih lanjut.";
        }

        $body = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f2f9ff; margin: 0; padding: 20px; }
                .container { max-width: 600px; background: #ffffff; margin: auto; border-radius: 8px; overflow: hidden; border: 1px solid #cce5ff; }
                .header { background: #007BFF; color: white; padding: 20px; text-align: center; }
                .content { padding: 30px; color: #333; }
                .footer { background: #e9f5ff; text-align: center; padding: 15px; font-size: 12px; color: #555; }
                .status { font-size: 18px; margin: 20px 0; font-weight: bold; color: #007BFF; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Konfirmasi Pengajuan Donor</h2>
                </div>
                <div class="content">
                    <p>Halo,</p>';

        if ($konfirmasi == "sukses") {
            $body .= '
                    <p class="status">Pengajuan donor darah Anda telah <strong>DITERIMA</strong>.</p>
                    <p>Terima kasih atas kepedulian dan kontribusi Anda. Kami akan segera menghubungi Anda untuk tahap selanjutnya.</p>';
        } elseif ($konfirmasi == "gagal") {
            $body .= '
                    <p class="status">Pengajuan donor darah Anda <strong>TIDAK DAPAT DIPROSES</strong>.</p>
                    <p>Mohon maaf atas ketidaknyamanan ini. Anda dapat mencoba kembali di lain waktu atau menghubungi admin untuk bantuan lebih lanjut.</p>';
        } else {
            $body .=
                '
                    <p class="status">Status pengajuan Anda: <strong>' .
                htmlspecialchars($konfirmasi) .
                '</strong></p>
                    <p>Silakan hubungi admin untuk informasi lebih lanjut mengenai status ini.</p>';
        }

        $body .= '
                    <p>Salam hangat,<br><strong>Tim Sedalam</strong></p>
                </div>
                <div class="footer">
                    Email ini dikirim secara otomatis. Mohon untuk tidak membalas.
                </div>
            </div>
        </body>
        </html>';

        // Kirim email pakai PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP Gmail
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "faradilla.anastasyaptr@gmail.com"; // Email pengirim
            $mail->Password = "giwg gqyv vyte nvao"; // Gunakan App Password, bukan password biasa
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email dari dan ke
            $mail->setFrom("sedalam@gmail.com", "Admin Web Donor");
            $mail->addAddress($email); // Email tujuan

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            echo "<script>alert('Email berhasil dikirim!'); window.location.href='manage_admin.php';</script>";
        } catch (Exception $e) {
            echo "Gagal kirim email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>
