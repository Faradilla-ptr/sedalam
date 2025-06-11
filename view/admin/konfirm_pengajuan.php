<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "web_donor"; // Ganti sesuai database kamu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST["status"])) {
    $status = $_POST["status"];
    $id_pengajuan = $_GET["id"];

    // Update status pengajuan
    $update_sql = "UPDATE pengajuan SET konfirmasi = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $id_pengajuan);
    $stmt->execute();

    // Ambil email pendonor
    $email_query = "SELECT email FROM pengajuan WHERE id = ?";
    $stmt = $conn->prepare($email_query);
    $stmt->bind_param("i", $id_pengajuan);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();

    // Kirim email
    $subject =
        $status == "sukses"
            ? "Pengajuan Donor Diterima"
            : "Pengajuan Donor Ditolak";
    $message =
        $status == "sukses"
            ? "Selamat! Pengajuan Anda diterima."
            : "Maaf, pengajuan Anda ditolak.";
    $headers = "From: no-reply@webdonor.com";

    mail($email, $subject, $message, $headers);

    header("Location: manage_admin.php");
    exit();
}
?>
</body>
</html>