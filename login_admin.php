<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST["email"]; // bisa username atau email
    $password = $_POST["password"];

    // Cek apakah input cocok dengan email atau username
    $query =
        "SELECT * FROM users WHERE (email=? OR username=?) AND role='admin'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_role"] = $user["role"];
            $_SESSION["username"] = $user["username"];

            // Mapping admin username ke lokasi
            $admin_locations = [
                "Admin PMI Kab Probolinggo" => "UDD PMI Kabupaten Probolinggo",
                "Admin PMI Kota Probolinggo" => "UDD PMI Kota Probolinggo",
                "Admin PMI Kab Lumajang" => "UDD PMI Kabupaten Lumajang",
                "Admin PMI Kab Jember" => "UDD PMI Kabupaten Jember",
                "Admin PMI Kab Bondowoso" => "UDD PMI Kabupaten Bondowoso",
                "Admin PMI Kab Situbondo" => "UDD PMI Kabupaten Situbondo",
                "Admin PMI Kab Banyuwangi" => "UDD PMI Kabupaten Banyuwangi",
                "Super Admin Pusat" => "ALL", // Super admin dapat melihat semua data
            ];

            // Set lokasi admin berdasarkan username
            if (array_key_exists($user["username"], $admin_locations)) {
                $_SESSION["admin_location"] =
                    $admin_locations[$user["username"]];
                $_SESSION["is_super_admin"] =
                    $user["username"] === "Super Admin Pusat";
                $update_login_time = $conn->prepare(
                    "UPDATE users SET last_login = NOW() WHERE id = ?"
                );
                $update_login_time->bind_param("i", $user["id"]);
                $update_login_time->execute();
                // ✅ Trigger SweetAlert
                $_SESSION["login_success"] = true;

                header("Location: view/admin/dashboard_admin.php");
                exit();
            } else {
                $error = "Username admin tidak dikenali!";
            }
        } else {
            $error = "Email/Username atau password salah!";
        }
    } else {
        $error = "Email/Username atau password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin PMI</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    .body1 {
      display: flex;
      background:#f9f9f9;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      font-family: "Segoe UI", sans-serif;
      overflow: hidden;
      height: 100vh;
      position: relative;
    }

    /* Background Pattern */
    .body1::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: 
        radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 2px),
        radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 2px, transparent 2px);
      background-size: 50px 50px;
      pointer-events: none;
    }

    h1 {
      font-weight: 700;
      letter-spacing: -1.5px;
      margin: 0;
      margin-bottom: 15px;
    }

    h1.title1 {
      font-size: 70px;
      line-height: 60px;
      margin: 0;
      text-shadow: 0 0 10px rgba(16, 64, 74, 0.5);
    }

    p {
      font-size: 14px;
      font-weight: 100;
      line-height: 20px;
      letter-spacing: 0.5px;
      margin: 20px 0 30px;
      text-shadow: 0 0 10px rgba(16, 64, 74, 0.5);
    }

    span {
      font-size: 14px;
      margin-top: 25px;
    }

    a {
      color: #333;
      font-size: 14px;
      text-decoration: none;
      margin: 15px 0;
      transition: 0.3s ease-in-out;
    }

    a:hover {
      color: #667eea;
    }

    .content {
      display: flex;
      width: 100%;
      height: 50px;
      align-items: center;
      justify-content: space-around;
    }

    button {
  position: relative;
  border-radius: 25px;
  border: none;
  background: linear-gradient(135deg, rgb(224, 87, 101), #a71d2a);
  color: #ffffff;
  font-size: 15px;
  font-weight: 700;
  margin: 10px;
  padding: 12px 80px;
  letter-spacing: 1px;
  text-transform: capitalize;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(167, 29, 42, 0.4);
  cursor: pointer;
}

button:hover {
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}


    button:active {
      transform: scale(0.95);
    }

    button:focus {
      outline: none;
    }

    form {
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 50px;
      height: 100%;
      text-align: center;
      border-radius: 25px;
    }

    input {
      background-color: #f8f9fa;
      border-radius: 15px;
      border: 2px solid #e9ecef;
      padding: 12px 15px;
      margin: 8px 0;
      width: 100%;
      transition: all 0.3s ease;
      font-size: 14px;
    }

    input:focus {
      outline: none;
      border-color: #667eea;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(102, 126, 234, 0.1);
    }

    .container {
      background-color: #fff;
      border-radius: 25px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 15px 25px rgba(0, 0, 0, 0.05);
      position: relative;
      overflow: hidden;
      width: 768px;
      max-width: 100%;
      min-height: 500px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      transition: all 0.6s ease-in-out;
    }

    .login-container {
      left: 0;
      width: 100%;
      z-index: 2;
    }

    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .password-wrapper {
      position: relative;
      width: 100%;
    }

    .password-wrapper input {
      width: 100%;
      padding-right: 40px;
    }

    .password-wrapper .toggle-pw {
      position: absolute;
      top: 50%;
      right: 12px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
      transition: color 0.3s ease;
    }

    .password-wrapper .toggle-pw:hover {
      color: #667eea;
    }

    .logo-home {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 28px;
      color: #fff;
      text-decoration: none;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      padding: 10px 12px;
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      z-index: 999;
      border: 1px solid rgba(0, 0, 0, 0.3);
    }

    .logo-home:hover {
      background: rgb(222, 59, 59);
      transform: scale(1.1);
      color: #fff;
    }

    .judul-login {
      font-family: 'Segoe UI', sans-serif;
      font-weight: bold;
      font-size: 36px;
      color: #333333;
      text-align: center;
      margin-bottom: 10px;
      letter-spacing: 2px;
    }

    .subtitle-login {
      font-size: 14px;
      color: #666;
      margin-bottom: 30px;
      font-weight: 300;
    }

    .floating-shapes {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
      pointer-events: none;
    }

    .shape {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      top: 10%;
      left: 10%;
      animation-delay: 0s;
    }

    .shape:nth-child(2) {
      width: 60px;
      height: 60px;
      top: 20%;
      right: 10%;
      animation-delay: 2s;
    }

    .shape:nth-child(3) {
      width: 100px;
      height: 100px;
      bottom: 10%;
      left: 15%;
      animation-delay: 4s;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    @media (max-width: 768px) {
      .container {
        width: 90%;
        margin: 20px;
      }
      
      .admin-list ul {
        columns: 1;
      }
      
      form {
        padding: 0 30px;
      }
    }
  </style>
</head> 
<body>
<div class="floating-shapes">
  <div class="shape"></div>
  <div class="shape"></div>
  <div class="shape"></div>
</div>

<a href="/sedalam/view/user/home.php" class="logo-home" title="Kembali ke Beranda">
  <i class="fas fa-home"></i>
</a>
  <div class="body1">
    <div class="container" id="container">
      <div class="form-container login-container">
        <form method="post" action="">
          <h1 class="judul-login">Login Admin</h1>
          <p class="subtitle-login">Sistem Manajemen PMI Regional</p>

          <input type="text" name="email" placeholder="Username atau Email Admin" required>
          <div class="password-wrapper">
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Password"
              required
            />
            <i class="fas fa-eye toggle-pw" id="togglePw"></i>
          </div>
          <button type="submit">Login Admin</button>
          <a href="view/admin/reset_password.php" class="forgot-password-btn">Lupa Password?</a>
          <p>Belum punya akun? <a href="register.php">Login dulu ya </a></p>

          <?php if (!empty($error)): ?>
            <script>
              Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: '<?= $error ?>',
                confirmButtonColor: '#667eea'
              });
            </script>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
  <script>
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePw');

    toggleIcon.addEventListener('click', () => {
      const isPassword = passwordInput.getAttribute('type') === 'password';
      passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
      toggleIcon.classList.toggle('fa-eye');
      toggleIcon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>