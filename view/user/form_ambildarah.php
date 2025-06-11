<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form ketika disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $golongan = $_POST["golongan_darah"];
    $rhesus = $_POST["rhesus"];
    $jumlah = (int) $_POST["jumlah"];
    date_default_timezone_set("Asia/Jakarta");
    $tanggal = date("Y-m-d H:i:s");

    $lokasi = $_POST["lokasi"]; // Lokasi deteksi PMI
    $lokasi_tujuan = $_POST["lokasi_tujuan"]; // Lokasi RS/pasien
    $keterangan = $_POST["keterangan"];

    $stmt = $conn->prepare(
        "INSERT INTO pengambilan_darah (golongan_darah, rhesus, jumlah_kantong, tanggal_keluar, lokasi, lokasi_tujuan, keterangan)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssissss",
        $golongan,
        $rhesus,
        $jumlah,
        $tanggal,
        $lokasi,
        $lokasi_tujuan,
        $keterangan
    );

    if ($stmt->execute()) {
        // Jika berhasil, tampilkan SweetAlert dan arahkan kembali ke home setelah 2 detik
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pengambilan darah berhasil diajukan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'home.php'; // Ganti dengan halaman utama
                    });
                };
              </script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data: " .
            $conn->error .
            "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengambilan Darah Urgent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
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
</style>
<body>
<a href="/sedalam/view/user/home.php" class="logo-home" title="Kembali ke Beranda">
  <i class="fas fa-home"></i>
</a>
<div class="container mt-5">
    <h2 class="mb-4">Form Pengambilan Darah</h2>
    <?php date_default_timezone_set("Asia/Jakarta"); ?>
    <div class="alert alert-info">
        <strong>Tanggal & Jam Saat Ini:</strong> <?= date("d-m-Y H:i:s") ?>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="golongan_darah" class="form-label">Golongan Darah</label>
            <select name="golongan_darah" id="golongan_darah" class="form-select" required>
                <option value="">-- Pilih Golongan --</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="AB">AB</option>
                <option value="O">O</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="rhesus" class="form-label">Rhesus</label>
            <select name="rhesus" id="rhesus" class="form-select" required>
                <option value="">-- Pilih Rhesus --</option>
                <option value="+">+</option>
                <option value="-">-</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Kantong</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
    <label for="lokasi" class="form-label">Lokasi PMI</label>
    <select name="lokasi" id="lokasi" class="form-select" required>
        <option value="">-- Pilih Lokasi PMI --</option>
        <option value="UDD PMI Kabupaten Probolinggo">UDD PMI Kabupaten Probolinggo</option>
        <option value="UDD PMI Kota Probolinggo">UDD PMI Kota Probolinggo</option>
        <option value="UDD PMI Kabupaten Lumajang">UDD PMI Kabupaten Lumajang</option>
        <option value="UDD PMI Kabupaten Jember">UDD PMI Kabupaten Jember</option>
        <option value="UDD PMI Kabupaten Bondowoso">UDD PMI Kabupaten Bondowoso</option>
        <option value="UDD PMI Kabupaten Situbondo">UDD PMI Kabupaten Situbondo</option>
        <option value="UDD PMI Kabupaten Banyuwangi">UDD PMI Kabupaten Banyuwangi</option>
    </select>
</div>

<div class="mb-3">
    <label for="lokasi_tujuan" class="form-label">Lokasi Tujuan (RS/Pasien)</label>
    <input type="text" name="lokasi_tujuan" id="lokasi_tujuan" class="form-control" required>
</div>


        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Simpan Pengambilan Darah</button>
    </form>
</div>
</body>
</html>
