<?php
session_start();
include "db.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$query = $conn->prepare("SELECT * FROM akun WHERE id=?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $nama = $_POST["nama"];
    $nik = $_POST["nik"];
    $email = $_POST["email"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $gender = $_POST["gender"];
    $telepon = $_POST["telepon"];
    $alamat = $_POST["alamat"];
    $golongan_darah = $_POST["golongan_darah"];

    // Default menggunakan foto yang sudah ada
    $foto = $user["foto"];

    // Cek apakah ada upload foto baru
    if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) {
        $allowed_ext = ["jpg", "jpeg", "png", "gif"];
        $file_name = $_FILES["foto"]["name"];
        $file_size = $_FILES["foto"]["size"];
        $file_tmp = $_FILES["foto"]["tmp_name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validasi ekstensi file
        if (!in_array($file_ext, $allowed_ext)) {
            $error = "Tipe file tidak valid. Gunakan jpg, jpeg, png, atau gif.";
        }
        // Validasi ukuran file (max 5MB)
        elseif ($file_size > 5000000) {
            $error = "Ukuran file terlalu besar. Maksimal 5MB.";
        } else {
            // Buat direktori uploads jika belum ada
            if (!is_dir("profil")) {
                mkdir("profil", 0777, true);
            }

            // Hapus foto lama jika ada
            if (
                !empty($user["foto"]) &&
                strpos($user["foto"], "profil/") === 0 &&
                file_exists($user["foto"])
            ) {
                unlink($user["foto"]);
            }

            // Buat nama file unik dengan timestamp
            $foto_name = "profil_" . $user_id . "." . $file_ext;
            $foto_path = "profil/" . $foto_name;

            // Upload file baru
            if (move_uploaded_file($file_tmp, $foto_path)) {
                $foto = $foto_path;
            } else {
                $error =
                    "Gagal mengupload file. Periksa folder uploads memiliki permission yang benar.";
            }
        }
    }

    // Update data ke database jika tidak ada error
    if ($error === "") {
        $stmt = $conn->prepare(
            "UPDATE akun SET username=?, nama=?, email=?, tanggal_lahir=?, gender=?, telepon=?, alamat=?, nik=?, golongan_darah=?, foto=? WHERE id=?"
        );
        $stmt->bind_param(
            "ssssssssssi",
            $username,
            $nama,
            $email,
            $tanggal_lahir,
            $gender,
            $telepon,
            $alamat,
            $nik,
            $golongan_darah,
            $foto,
            $user_id
        );

        if ($stmt->execute()) {
            $success = "Profil berhasil diperbarui!";

            // Refresh data user setelah update
            $query->execute();
            $result = $query->get_result();
            $user = $result->fetch_assoc();
        } else {
            $error = "Gagal memperbarui profil: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 15px;
            overflow-y: auto;
        }

        .content {
            margin-left: 270px;
            padding: 30px 20px 20px 20px;
        }
        
        .preview-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }
        
        .form-label {
            font-weight: 500;
        }
        
        .card {
            border: none;
            border-radius: 15px;
        }
        
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 20px;
        }
        

        .btn {
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

.btn:hover{
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}
        .header-gradient {
            background: linear-gradient(135deg,rgb(224, 87, 101), #a71d2a);
    color: white;
    border-bottom: none;
}
.btn-custom  {
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

.btn-custom:hover{
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}





    </style>
</head>
<body class="bg-light">

<?php include "sidebar.php"; ?>

<div class="content">
    <div class="card shadow-lg">
    <div class="card-header header-gradient text-white">
    <h4 class="mb-0"><i class="bi bi-person-gear"></i> Edit Profil</h4>
</div>

        <div class="card-body p-4">
            <form method="post" enctype="multipart/form-data" id="profileForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="<?= htmlspecialchars(
                                $user["username"]
                            ) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" value="<?= htmlspecialchars(
                                $user["nama"]
                            ) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" value="<?= htmlspecialchars(
                                $user["nik"]
                            ) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars(
                                $user["email"]
                            ) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars(
                                $user["tanggal_lahir"]
                            ) ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="Laki-laki" <?= $user["gender"] ==
                                "Laki-laki"
                                    ? "selected"
                                    : "" ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $user["gender"] ==
                                "Perempuan"
                                    ? "selected"
                                    : "" ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="telepon" value="<?= htmlspecialchars(
                                $user["telepon"]
                            ) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars(
                                $user["alamat"]
                            ) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="A" <?= $user["golongan_darah"] ==
                                "A"
                                    ? "selected"
                                    : "" ?>>A</option>
                                <option value="B" <?= $user["golongan_darah"] ==
                                "B"
                                    ? "selected"
                                    : "" ?>>B</option>
                                <option value="AB" <?= $user[
                                    "golongan_darah"
                                ] == "AB"
                                    ? "selected"
                                    : "" ?>>AB</option>
                                <option value="O" <?= $user["golongan_darah"] ==
                                "O"
                                    ? "selected"
                                    : "" ?>>O</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">Foto Profil</label>
                            <div class="d-flex align-items-center mb-2">
                                <?php if (
                                    $user["foto"] &&
                                    file_exists($user["foto"])
                                ): ?>
                                    <img src="<?= $user[
                                        "foto"
                                    ] ?>?v=<?= time() ?>" alt="Foto Profil" class="preview-image me-3" id="currentPhoto">
                                <?php else: ?>
                                    <img src="uploads/default-profile.png" alt="Foto Profil Default" class="preview-image me-3" id="currentPhoto">
                                <?php endif; ?>
                                <div>
                                    <input type="file" name="foto" class="form-control" id="photoInput" accept=".jpg,.jpeg,.png,.gif">
                                    <small class="text-muted">Upload foto baru (JPG, JPEG, PNG, GIF. Max: 5MB)</small>
                                </div>
                            </div>
                            <div id="photoPreview" style="display: none;">
                                <p>Preview Foto Baru:</p>
                                <img src="" alt="Preview" class="preview-image" id="previewImage">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-custom"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
                    <a href="akun.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview foto sebelum upload
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').style.display = 'block';
            document.getElementById('previewImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Sweet Alert untuk success/error message
<?php if ($success): ?>
Swal.fire({
    title: 'Berhasil!',
    text: '<?= $success ?>',
    icon: 'success',
    confirmButtonText: 'OK'
});
<?php elseif ($error): ?>
Swal.fire({
    title: 'Error!',
    text: '<?= $error ?>',
    icon: 'error',
    confirmButtonText: 'OK'
});
<?php endif; ?>
</script>
</body>
</html>