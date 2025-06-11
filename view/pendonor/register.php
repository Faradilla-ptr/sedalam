<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $gender = $_POST["gender"];
    $telepon = $_POST["telepon"];
    $alamat = $_POST["alamat"];

    $foto = null;
    if ($_FILES["foto"]["name"]) {
        $foto = "uploads/" . time() . "_" . $_FILES["foto"]["name"];
        move_uploaded_file($_FILES["foto"]["tmp_name"], $foto);
    }

    $stmt = $conn->prepare(
        "INSERT INTO akun (username, nama, email, tanggal_lahir, password, gender, telepon, alamat, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sssssssss",
        $username,
        $nama,
        $email,
        $tanggal_lahir,
        $password,
        $gender,
        $telepon,
        $alamat,
        $foto
    );

    if ($stmt->execute()) {
        header("Location: login_user.php");
        exit();
    } else {
        echo "Gagal mendaftar: " . $conn->error;
    }
}
?>

<!-- HTML -->
<form method="post" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="date" name="tanggal_lahir" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="gender" required>
        <option value="">Pilih Gender</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select><br>
    <input type="text" name="telepon" placeholder="No Telepon" required><br>
    <textarea name="alamat" placeholder="Alamat" required></textarea><br>
    <input type="file" name="foto" accept="image/*"><br>
    <button type="submit">Daftar</button>
</form>
