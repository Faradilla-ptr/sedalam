<?php
session_start();
include "db.php";

if (isset($_GET["code"])) {
    $code = $_GET["code"];

    // Cek kode verifikasi di database
    $query = "SELECT * FROM akun WHERE verification_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Tampilkan form reset password
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirm_password"];

            if ($password === $confirmPassword) {
                // Update password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $query =
                    "UPDATE akun SET password = ?, verification_code = NULL WHERE verification_code = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $hashedPassword, $code);
                $stmt->execute();

                echo "<script>alert('Password berhasil diubah!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Password tidak cocok!');</script>";
            }
        }

        echo '
        <form method="POST">
            <h2>Reset Password</h2>
            <input type="password" name="password" placeholder="Password Baru" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit">Reset Password</button>
        </form>
        ';
    } else {
        echo "<script>alert('Kode verifikasi tidak valid!'); window.location.href='lupa_password.php';</script>";
    }
}
?>
