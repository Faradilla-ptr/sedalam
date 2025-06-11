<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Simpan informasi user ke session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_role"] = $user["role"]; // Pastikan kolom role ada di database

            // Arahkan sesuai role
            if ($user["role"] === "admin") {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.html");
            }
            exit();
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo dirname(
        $_SERVER["SCRIPT_NAME"]
    ); ?>/css/style.css">


</head>
<body>

<div class="container">
    <h2>Login</h2>

    <!-- Notifikasi Pop-up -->
    <?php if (isset($error)): ?>
        <div class="popup error">
            <p><?php echo $error; ?></p>
            <span class="close-btn" onclick="closePopup()">×</span>
        </div>
    <?php endif; ?>

    <form method="post" class="form-container">
        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</div>

<script>
    function closePopup() {
        document.querySelector(".popup").style.display = "none";
    }
</script>

</body>
</html>
