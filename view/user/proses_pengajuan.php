<?php
$servername = "localhost";
$username = "root";  // Sesuaikan dengan user MySQL kamu
$password = "";       // Kosongkan jika tidak ada password
$dbname = "sedalam";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$email = $_POST['email'];
$hp = $_POST['hp'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$lokasi = $_POST['lokasi'];
$sehat = $_POST['sehat'];
$obat = $_POST['obat'];
$otp = $_POST['otp'];
$konfirmasi = isset($_POST['konfirmasi']) ? 1 : 0;

// Handle upload file jika ada
$target_file = NULL;
if (!empty($_FILES['dokumen']['name'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["dokumen"]["name"]);
    move_uploaded_file($_FILES["dokumen"]["tmp_name"], $target_file);
}

// Simpan data ke database
$sql = "INSERT INTO pengajuan (nama, nik, email, hp, tanggal, waktu, lokasi, sehat, obat, dokumen, otp, konfirmasi)
        VALUES ('$nama', '$nik', '$email', '$hp', '$tanggal', '$waktu', '$lokasi', '$sehat', '$obat', '$target_file', '$otp', '$konfirmasi')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Pengajuan berhasil dikirim!'); window.location.href='pengajuan_donor.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
