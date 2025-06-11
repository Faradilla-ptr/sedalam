<?php
require_once "vendor/autoload.php"; // Pastikan sudah menginstal Twilio SDK melalui Composer

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil nomor WhatsApp yang diinputkan
    $nomorHP = $_POST["hp"];

    // Validasi format nomor HP (pastikan diawali dengan 62)
    if (preg_match("/^0/", $nomorHP)) {
        $nomorHP = "62" . substr($nomorHP, 1);
    }

    // Validasi jika nomor HP kosong
    if (empty($nomorHP)) {
        echo "error";
        exit();
    }

    // Buat OTP 6 digit acak
    $otp = mt_rand(100000, 999999);

    // Konfigurasi Twilio (gunakan kredensial dari Twilio)
    $sid = "AC280b7262065039baa9ed6ea3b19d4545"; // Ganti dengan SID Twilio Anda
    $authToken = "d51915ef88f32d5f3d3874e80f28310f"; // Ganti dengan Auth Token Twilio Anda
    $twilioPhoneNumber = "+6282145483984"; // Nomor WhatsApp Twilio yang digunakan

    // Buat client Twilio
    $client = new Client($sid, $authToken);

    try {
        // Kirim pesan OTP via WhatsApp
        $message = $client->messages->create(
            "whatsapp:" . $nomorHP, // Nomor WhatsApp penerima
            [
                "from" => "whatsapp:" . $twilioPhoneNumber, // Nomor WhatsApp Twilio yang digunakan
                "body" => "Halo, berikut adalah kode OTP Anda: $otp. Jangan berikan kode ini kepada siapapun!",
            ]
        );

        // Simpan OTP ke sesi atau database (misalnya ke sesi)
        session_start();
        $_SESSION["otp"] = $otp;

        // Beri respons sukses
        echo "success";
    } catch (Exception $e) {
        // Tampilkan pesan error
        echo "error";
    }
}
?>
