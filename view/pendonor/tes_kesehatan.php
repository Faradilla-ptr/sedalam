<?php
include "db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login_user.php");
    exit();
}

$id_pendonor = $_SESSION["user_id"]; // Ambil ID dari session

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tanggal = $_POST["tanggal"];
    $lokasi = $_POST["lokasi"];
    $tekanan = $_POST["tekanan_darah"];
    $berat = $_POST["berat_badan"];
    $riwayat = $_POST["riwayat_penyakit"];

    // Insert data terlebih dahulu tanpa dokumen
    $stmt = $conn->prepare(
        "INSERT INTO tes_kesehatan (id_pendonor, tanggal,lokasi, tekanan_darah, berat_badan, riwayat_penyakit, dokumen) VALUES (?, ?, ?, ?, ?, ?,?)"
    );
    $dokumen_temp = ""; // Sementara kosong
    $stmt->bind_param(
        "isssdss",
        $id_pendonor,
        $tanggal,
        $lokasi,
        $tekanan,
        $berat,
        $riwayat,
        $dokumen_temp
    );

    if ($stmt->execute()) {
        // Ambil ID terakhir yang baru saja di-insert
        $id_tes_kesehatan = $conn->insert_id;

        $dokumen = "";
        if (!empty($_FILES["dokumen"]["name"])) {
            $ext = pathinfo($_FILES["dokumen"]["name"], PATHINFO_EXTENSION);
            $filename = "tes_kesehatan_" . $id_tes_kesehatan . "." . $ext; // Gunakan ID tes_kesehatan
            $target_dir = "uploads/";

            // Buat folder jika belum ada
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $path = $target_dir . $filename;
            if (move_uploaded_file($_FILES["dokumen"]["tmp_name"], $path)) {
                // Update record dengan path dokumen
                $update_stmt = $conn->prepare(
                    "UPDATE tes_kesehatan SET dokumen = ? WHERE id = ?"
                );
                $update_stmt->bind_param("si", $path, $id_tes_kesehatan);
                $update_stmt->execute();
                $update_stmt->close();
            }
        }

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Tes kesehatan berhasil disimpan.',
                    confirmButtonColor: '#3e6e85'
                }).then(function() {
                    window.location.href = 'tes_kesehatan.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Tes kesehatan gagal disimpan.',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Tes Kesehatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 15px;
        }

        .content {
            margin-left: 270px;
            padding: 40px 20px 20px 20px; /* tambahkan padding atas */
        }

        .card-custom {
            border: 1px solid #6f4e37;
            border-radius: 8px;
            background-color: white;
            padding: 20px;
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

        .form-control {
            border-radius: 6px;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <div class="card card-custom shadow">
        <h4 class="mb-4 text-center text-brown">Form Tes Kesehatan Pendonor</h4>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Tanggal Tes:</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
            <label class="form-label">Pilih Lokasi:</label>
                <select class="form-select" name="lokasi" required>
                    <option value="">-- Pilih Lokasi UDD Daerah Anda --</option>
                    <option value="UDD PMI Kabupaten Probolinggo ">UDD PMI Kabupaten Probolinggo</option>
                    <option value="UDD PMI Kota Probolinggo">UDD PMI Kota Probolinggo</option>
                    <option value="UDD PMI Kabupaten Jember">UDD PMI Kabupaten Jember</option>
                    <option value="UDD PMI Kabupaten Lumajang">UDD PMI Kabupaten Lumajang</option>
                    <option value="UDD PMI Kabupaten Bondowoso">UDD PMI Kabupaten Bondowoso</option>
                    <option value="UDD PMI Kabupaten Situbondo">UDD PMI Kabupaten Situbondo</option>
                    <option value="UDD PMI Kabupaten Banyuwangi">UDD PMI Kabupaten Banyuwangi</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tekanan Darah:</label>
                <input type="text" name="tekanan_darah" class="form-control" placeholder="120/80 mmHg" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Berat Badan (kg):</label>
                <input type="number" step="0.01" name="berat_badan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Riwayat Penyakit:</label>
                <textarea name="riwayat_penyakit" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Dokumen Pendukung :</label>
                <input type="file" name="dokumen" class="form-control">
            </div>
            <a href="template_2.php" target="_blank" class="btn btn-sm btn-outline-primary mb-2" title="Lihat Template Pengajuan">
    📄 Template
</a>


            <div class="text-end">
                <button type="submit" class="btn btn-custom">Simpan Tes</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
