<?php
require_once 'vendor/autoload.php'; // Pastikan sudah menginstal Twilio SDK melalui Composer

use Twilio\Rest\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nomor WhatsApp yang diinputkan
    $nomorHP = $_POST['hp'];
    
    // Validasi format nomor HP (pastikan diawali dengan 62)
    if (preg_match('/^0/', $nomorHP)) {
        $nomorHP = '62' . substr($nomorHP, 1);
    }

    // Validasi jika nomor HP kosong
    if (empty($nomorHP)) {
        echo "error";
        exit;
    }

    // Buat OTP 6 digit acak
    $otp = mt_rand(100000, 999999);

    // Konfigurasi Twilio (gunakan kredensial dari Twilio)
    $sid = 'hi'; // Ganti dengan SID Twilio Anda
    $authToken = 'hi'; // Ganti dengan Auth Token Twilio Anda
    $twilioPhoneNumber = '+hi'; // Nomor WhatsApp Twilio yang digunakan

    // Buat client Twilio
    $client = new Client($sid, $authToken);

    try {
        // Kirim pesan OTP via WhatsApp
        $message = $client->messages->create(
            'whatsapp:' . $nomorHP, // Nomor WhatsApp penerima
            [
                'from' => 'whatsapp:' . $twilioPhoneNumber, // Nomor WhatsApp Twilio yang digunakan
                'body' => "Halo, berikut adalah kode OTP Anda: $otp. Jangan berikan kode ini kepada siapapun!",
            ]
        );

        // Simpan OTP ke sesi atau database (misalnya ke sesi)
        session_start();
        $_SESSION['otp'] = $otp;

        // Beri respons sukses
        echo "success";
    } catch (Exception $e) {
        // Tampilkan pesan error
        echo "error";
    }
}
?>
