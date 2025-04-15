<?php
include 'db.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nama, $email, $password, $role);

    if ($stmt->execute()) {
        $success = "Registrasi berhasil! Silakan login.";
    } else {
        $error = "Registrasi gagal!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <!-- Notifikasi Pop-up -->
    <?php if (isset($error)): ?>
        <div class="popup error">
            <p><?php echo $error; ?></p>
            <span class="close-btn" onclick="closePopup()">×</span>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="popup success">
            <p><?php echo $success; ?></p>
            <span class="close-btn" onclick="closePopup()">×</span>
        </div>
    <?php endif; ?>

    <form method="post" class="form-container">
    <div class="input-group">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
    </div>
    <div class="input-group">
        <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <div class="input-group">
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin PMI</option>
        </select>
    </div>
    <button type="submit">Register</button>
</form>

    
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

<script>
    function closePopup() {
        document.querySelector(".popup").style.display = "none";
    }
</script>

</body>
</html>
