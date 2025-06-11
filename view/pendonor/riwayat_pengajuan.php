<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login_user.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_user = $_SESSION["user_id"]; // Ambil id_user dari session

// Proses simpan review
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["rating"]) &&
    isset($_POST["ulasan"])
) {
    $username = htmlspecialchars($_POST["username"]);
    $rating = $_POST["rating"];
    $ulasan = $_POST["ulasan"];
    $lokasi = $_POST["lokasi"];

    // Validasi rating agar hanya angka
    if (is_numeric($rating) && $rating >= 1 && $rating <= 5) {
        // Simpan review ke tabel review
        $query =
            "INSERT INTO review (id_pendonor, username, rating, ulasan, lokasi,created_at) VALUES (?, ?, ?, ?,?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "isiss",
            $id_user,
            $username,
            $rating,
            $ulasan,
            $lokasi
        );

        if ($stmt === false) {
            // Error preparing statement
            echo "Error preparing the statement: " . $conn->error;
            exit();
        }

        if ($stmt->execute()) {
            // Jika berhasil, set session untuk menampilkan SweetAlert
            $_SESSION["review_success"] = true;
            // Redirect agar SweetAlert muncul
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit();
        } else {
            // Jika gagal simpan data
            echo "Error executing the query: " . $stmt->error;
        }
    } else {
        // Jika rating tidak valid (bukan angka atau di luar rentang 1-5)
        echo "Rating harus berupa angka antara 1 dan 5.";
    }
}

// Ambil data pengajuan donor
$queryPengajuan = "SELECT * FROM pengajuan WHERE id_pendonor = ?";
$stmtPengajuan = $conn->prepare($queryPengajuan);
$stmtPengajuan->bind_param("i", $id_user);
$stmtPengajuan->execute();
$resultPengajuan = $stmtPengajuan->get_result();
$showReviewButton = false;

// Ambil data tes kesehatan
$queryTes = "SELECT * FROM tes_kesehatan WHERE id_pendonor = ?";
$stmtTes = $conn->prepare($queryTes);
$stmtTes->bind_param("i", $id_user);
$stmtTes->execute();
$resultTes = $stmtTes->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pengajuan </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .no-data {
            padding: 20px;
            text-align: center;
            color: #666;
        }
        .page-header {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .badge {
            font-size: 0.9em;
            padding: 5px 10px;
        }
        .header-gradient {
            background: linear-gradient(135deg,rgb(224, 87, 101), #a71d2a);
    color: white;
    border-bottom: none;
}

    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    
    <div class="content">
        <!-- Tampilkan SweetAlert jika review berhasil disimpan -->
        <?php if (
            isset($_SESSION["review_success"]) &&
            $_SESSION["review_success"]
        ): ?>
            <script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Review Anda berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
            <?php unset($_SESSION["review_success"]);
            // Hapus session agar tidak muncul lagi
            ?>
        <?php endif; ?>
        
        <div class="page-header">
            <h2>Riwayat Pengajuan Anda</h2>
            <p>Berikut adalah daftar semua pengajuan donor darah dan riwayat tes kesehatan Anda</p>
        </div>
        
        <!-- Tabel Riwayat Pengajuan -->
        <div class="card mb-4">
        <div class="card-header header-gradient text-white">
    <h4 class="mb-0">
        <i class="bi bi-droplet-half"></i> Pengajuan Donor Darah
    </h4>
</div>

            <div class="card-body">
                <?php if ($resultPengajuan->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Donor</th>
                                <th>Waktu</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $resultPengajuan->fetch_assoc()):

                                $statusKonfirmasi = $row["konfirmasi"];
                                if ($statusKonfirmasi === "sukses") {
                                    $showReviewButton = true;
                                }
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["nama"]
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["tanggal"]
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["waktu"]
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["lokasi"]
                                    ) ?></td>
                                    <td>
                                        <?php if (
                                            $statusKonfirmasi === "pending"
                                        ) {
                                            echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                        } elseif (
                                            $statusKonfirmasi === "sukses"
                                        ) {
                                            echo "<span class='badge bg-success'>Diterima</span>";
                                        } elseif (
                                            $statusKonfirmasi === "gagal"
                                        ) {
                                            echo "<span class='badge bg-danger'>Ditolak</span>";
                                        } else {
                                            echo "<span class='badge bg-secondary'>Tidak Diketahui</span>";
                                        } ?>
                                    </td>
                                    <td><?= htmlspecialchars(
                                        $row["created_at"] ?? "N/A"
                                    ) ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="no-data">
                        <p>Belum ada pengajuan donor darah.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabel Riwayat Tes Kesehatan -->
        <div class="card">
        <div class="card-header header-gradient text-white">
    <h4 class="mb-0"><i class="bi bi-clipboard-heart"></i> Riwayat Tes Kesehatan</h4>
</div>

            <div class="card-body">
                <?php if ($resultTes->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tekanan Darah</th>
                                <th>Berat Badan</th>
                                <th>Hemoglobin</th>
                                <th>Riwayat Penyakit</th>
                                <th>Tanggal Tes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $resultTes->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["tekanan_darah"] ?? "N/A"
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["berat_badan"] ?? "N/A"
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["hemoglobin"] ?? "N/A"
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["riwayat_penyakit"] ?? "N/A"
                                    ) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row["tanggal"] ??
                                            ($row["created_at"] ?? "N/A")
                                    ) ?></td>
                                </tr>
                            <?php endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="no-data">
                        <p>Belum ada catatan tes kesehatan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($showReviewButton): ?>
    <div class="text-end mt-3">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
            Review
        </button>
    </div>
<?php endif; ?>
    </div>


    <!-- Modal Review -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= htmlspecialchars(
            $_SERVER["PHP_SELF"]
        ) ?>" method="POST" class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Beri Review Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Input Nama -->
                <label for="username" class="form-label">Nama Anda (boleh nama asli / nama panggilan):</label>
                <input type="text" name="username" id="username" class="form-control mb-3" placeholder="Contoh: Maya, Pendonor Semangat, dll" required>
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
                <!-- Slider Bintang -->
                <label class="form-label">Rating (slide bintang):</label>
                <input type="range" name="rating" id="ratingSlider" min="1" max="5" value="3" class="form-range" oninput="updateStars(this.value)">
                <div id="starDisplay" class="mb-3 fs-4 text-warning">⭐⭐⭐</div>

                <!-- Ulasan -->
                <label for="ulasan" class="form-label">Ulasan:</label>
                <textarea name="ulasan" id="ulasan" class="form-control" rows="4" placeholder="Tulis ulasan Anda di sini..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Kirim Review</button>
            </div>
        </form>
    </div>
</div>


    <script>
        function updateStars(value) {
            const starFull = '⭐';
            document.getElementById('starDisplay').innerText = starFull.repeat(value);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
