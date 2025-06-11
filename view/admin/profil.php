<?php
session_start();
include "../../db.php";
include "../../admin_filter_helper.php";
if (!isset($_SESSION["admin_location"]) && isset($_SESSION["user_id"])) {
    // Ambil lokasi dari database jika belum ada di session
    $user_query = "SELECT lokasi FROM users WHERE id = ?";
    $user_stmt = $conn->prepare($user_query);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();

    if ($user_data && !empty($user_data["lokasi"])) {
        $_SESSION["admin_location"] = $user_data["lokasi"];
    }
}
// Cek apakah user sudah login sebagai admin
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../../login_admin.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$success_message = "";
$error_message = "";

// Ambil data admin dari database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$admin_data = $result->fetch_assoc();

// Proses update profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_profile"])) {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        // Hapus baris: $lokasi = trim($_POST["lokasi"]);

        // Validasi input
        if (empty($username) || empty($email)) {
            $error_message = "Username dan email tidak boleh kosong!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Format email tidak valid!";
        } else {
            // Cek apakah username atau email sudah digunakan user lain
            $check_query =
                "SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ssi", $username, $email, $user_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $error_message =
                    "Username atau email sudah digunakan oleh admin lain!";
            } else {
                // Update profil (tanpa lokasi)
                $update_query =
                    "UPDATE users SET username = ?, email = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("ssi", $username, $email, $user_id);

                if ($update_stmt->execute()) {
                    $_SESSION["username"] = $username;
                    $success_message = "Profil berhasil diperbarui!";

                    // Refresh data admin
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $admin_data = $result->fetch_assoc();
                } else {
                    $error_message = "Gagal memperbarui profil!";
                }
            }
        }
    }
}

// Proses ganti password
if (isset($_POST["change_password"])) {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if (
        empty($current_password) ||
        empty($new_password) ||
        empty($confirm_password)
    ) {
        $error_message = "Semua field password harus diisi!";
    } elseif (strlen($new_password) < 6) {
        $error_message = "Password baru minimal 6 karakter!";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Konfirmasi password tidak cocok!";
    } elseif (!password_verify($current_password, $admin_data["password"])) {
        $error_message = "Password saat ini salah!";
    } else {
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password_query = "UPDATE users SET password = ? WHERE id = ?";
        $update_password_stmt = $conn->prepare($update_password_query);
        $update_password_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_password_stmt->execute()) {
            $success_message = "Password berhasil diubah!";
        } else {
            $error_message = "Gagal mengubah password!";
        }
    }
}

// Statistik untuk admin

$admin_location = getAdminLocationName();
$is_super_admin = isSuperAdmin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - PMI</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #e05765;
            --secondary-color: #a71d2a;
            --light-bg: #f8f9fa;
            --shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .main-content {
    margin-left: 250px;
    padding: 2rem;
}

        .profile-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 3rem;
            position: relative;
            z-index: 1;
        }

        .profile-info {
            position: relative;
            z-index: 1;
        }

        .admin-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .stats-row {
            background: var(--light-bg);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 1.5rem 0;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .form-section {
            padding: 2rem;
        }

        .form-title {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(224, 87, 101, 0.25);
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(224, 87, 101, 0.4);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(224, 87, 101, 0.5);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .alert-custom {
            border-radius: 15px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 20px 20px 0 0;
        }

        @media (max-width: 768px) {
            .profile-container {
                margin-top: 1rem;
            }
            
            .form-section {
                padding: 1rem;
            }
        }
        .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color:rgb(255, 255, 255);
        color: white;
        padding: 20px;
    }
    h1, h2, h3, .card-header{
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
}
    </style>
</head>
<body>


<?php include "sidebar.php"; ?>
<div class="main-content">

    <div class="container profile-container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="profile-info">
                            <h3><?= htmlspecialchars(
                                $admin_data["username"]
                            ) ?></h3>
                            <p class="mb-2"><?= htmlspecialchars(
                                $admin_data["email"]
                            ) ?></p>
                            <span class="admin-badge">
                                <i class="fas fa-crown me-1"></i>
                                <?= $is_super_admin ? "Super Admin" : "Admin" ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-3">

<div class="mb-3">
    <strong><i class="fas fa-map-marker-alt me-2 text-danger"></i>Lokasi:</strong>
    <p class="mb-0 mt-1">
        <?php
        // Tampilkan lokasi admin dari session atau database
        $lokasi_tampil = "";
        if (isSuperAdmin()) {
            $lokasi_tampil = "UDD PMI Kabupaten Jember";
        } elseif (
            isset($_SESSION["admin_location"]) &&
            !empty($_SESSION["admin_location"])
        ) {
            $lokasi_tampil = $_SESSION["admin_location"];
        } elseif (!empty($admin_data["lokasi"])) {
            $lokasi_tampil = $admin_data["lokasi"];
        } else {
            $lokasi_tampil = "Lokasi belum diatur";
        }
        echo htmlspecialchars($lokasi_tampil);
        ?>
    </p>
</div>
                        <div class="mb-3">
                            <strong><i class="fas fa-calendar me-2 text-danger"></i>Bergabung:</strong>
                            <p class="mb-0 mt-1"><?= date(
                                "d F Y",
                                strtotime($admin_data["created_at"])
                            ) ?></p>
                        </div>
                        <div>
                            <strong><i class="fas fa-clock me-2 text-danger"></i>Login Terakhir:</strong>
                            <p class="mb-0 mt-1">
    <?php if (!empty($admin_data["last_login"])) {
        echo date("d F Y H:i", strtotime($admin_data["last_login"]));
    } else {
        echo "Belum ada data login";
    } ?>
</p>

                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->

            </div>

            <div class="col-lg-8">
                <!-- Alert Messages -->


                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= $error_message ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Edit Profile Form -->
                <div class="profile-card mb-4">
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fas fa-edit"></i>Edit Profil
                        </h4>
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?= htmlspecialchars(
                                               $admin_data["username"]
                                           ) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= htmlspecialchars(
                                               $admin_data["email"]
                                           ) ?>" required>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" name="update_profile" class="btn btn-custom">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Form -->
                <div class="profile-card">
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fas fa-lock"></i>Ganti Password
                        </h4>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" 
                                           name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="togglePassword('current_password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" 
                                               name="new_password" required minlength="8">
                                        <button class="btn btn-outline-secondary" type="button" 
                                                onclick="togglePassword('new_password', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Minimal 8 karakter</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" 
                                               name="confirm_password" required>
                                        <button class="btn btn-outline-secondary" type="button" 
                                                onclick="togglePassword('confirm_password', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-custom me-2" onclick="resetPasswordForm()">
                                    <i class="fas fa-times me-2"></i>Reset
                                </button>
                                <button type="submit" name="change_password" class="btn btn-custom">
                                    <i class="fas fa-key me-2"></i>Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function resetPasswordForm() {
            document.getElementById('current_password').value = '';
            document.getElementById('new_password').value = '';
            document.getElementById('confirm_password').value = '';
        }

        // Password validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });

        // Show success message with SweetAlert if available
        <?php if ($success_message): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $success_message ?>',
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>

        <?php if ($error_message): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $error_message ?>',
                confirmButtonColor: '#e05765'
            });
        <?php endif; ?>
    </script>
</body>
</html>