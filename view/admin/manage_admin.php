<?php
// Kirim Email via PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
session_start();
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "../../../admin_filter_helper.php"; // Include helper filter

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set global connection for helper functions
$GLOBALS["conn"] = $conn;

// Pencarian data berdasarkan Scan QR
if (isset($_GET["scan_id"])) {
    $scan_id = $_GET["scan_id"];
    if (strpos($scan_id, "ID:") !== false) {
        $scan_id = trim(explode("\n", explode("ID:", $scan_id)[1])[0]);
    }

    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p"); // Tambahkan alias tabel

    $query = "SELECT * FROM pengajuan p WHERE p.id = ? $location_filter";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $scan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $searchData = $result->fetch_assoc();
        $searchName = $searchData["nama"];
        $searchMonth = date("m", strtotime($searchData["created_at"]));
        $searchStatus = $searchData["konfirmasi"];
    } else {
        echo "<script>alert('Data tidak ditemukan atau tidak ada akses untuk lokasi ini!');</script>";
    }
}

// Fungsi pengiriman email jika ada ID terdeteksi
if (isset($_POST["kirim_email"]) && isset($_POST["id"])) {
    $id = $_POST["id"];

    // Verifikasi akses berdasarkan lokasi admin sebelum kirim email
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location);

    // Ambil data dari database dengan filter lokasi
    $stmt = $conn->prepare(
        "SELECT nama, email, konfirmasi FROM pengajuan WHERE id = ? $location_filter"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nama, $email, $konfirmasi);

    if (!$stmt->fetch()) {
        echo "<script>alert('Data tidak ditemukan atau Anda tidak memiliki akses untuk data ini!');</script>";
        $stmt->close();
        exit();
    }
    $stmt->close();

    $body =
        '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f2f9ff; margin: 0; padding: 20px; }
            .container { max-width: 600px; background: #ffffff; margin: auto; border-radius: 8px; overflow: hidden; border: 1px solid #cce5ff; }
            .header { background: #007BFF; color: white; padding: 20px; text-align: center; }
            .content { padding: 30px; color: #333; }
            .footer { background: #e9f5ff; text-align: center; padding: 15px; font-size: 12px; color: #555; }
            .status { font-size: 18px; margin: 20px 0; font-weight: bold; color: #007BFF; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>Konfirmasi Pengajuan Donor</h2>
            </div>
            <div class="content">
            <p>Halo, ' .
        htmlspecialchars($nama) .
        "</p>";

    if ($konfirmasi == "sukses") {
        $body .= '<p class="status">Pengajuan donor darah Anda telah <strong>DITERIMA</strong>.</p>
                  <p>Berikut adalah QR Code Anda. Tunjukkan ini saat proses verifikasi donor:</p>
                  <img src="cid:qrcodeimage" alt="QR Code">
                  <p>Terima kasih atas kontribusi Anda.</p>';
    } elseif ($konfirmasi == "gagal") {
        $body .= '<p class="status">Pengajuan donor darah Anda <strong>TIDAK DAPAT DIPROSES</strong>.</p>
                  <p>Mohon maaf atas ketidaknyamanan ini. Anda dapat mencoba kembali di lain waktu atau menghubungi admin untuk bantuan lebih lanjut.</p>';
    } else {
        $body .=
            '<p class="status">Status pengajuan Anda: <strong>' .
            htmlspecialchars($konfirmasi) .
            '</strong></p>
                  <p>Silakan hubungi admin untuk informasi lebih lanjut mengenai status ini.</p>';
    }

    $body .= '<p>Salam hangat,<br><strong>Tim Sedalam</strong></p>
            </div>
            <div class="footer">
                Email ini dikirim secara otomatis. Mohon untuk tidak membalas.
            </div>
        </div>
    </body>
    </html>';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "faradilla.anastasyaptr@gmail.com";
        $mail->Password = "fmup yyoi gntj bush";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("sedalam@gmail.com", "Admin Web Donor");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Konfirmasi Pengajuan Donor";
        $mail->Body = $body;

        require_once __DIR__ . "/../../lib/phpqrcode/qrlib.php";
        $qrData = "ID: $id\nNama: $nama\nEmail: $email";
        $qrFile = __DIR__ . "/../../temp_qr_$id.png"; // path file QR sementara
        QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 5);

        // Menambahkan gambar QR Code ke email
        $mail->addEmbeddedImage($qrFile, "qrcodeimage", "qr_code.png");

        $mail->send();
        echo "<script>alert('Email berhasil dikirim!'); window.location.href='manage_admin.php';</script>";
    } catch (Exception $e) {
        echo "Gagal kirim email. Error: {$mail->ErrorInfo}";
    }
}

// Pencarian data dengan filter lokasi
$searchName = isset($_POST["search_name"])
    ? $_POST["search_name"]
    : (isset($searchName)
        ? $searchName
        : "");
$searchMonth = isset($_POST["search_month"])
    ? $_POST["search_month"]
    : (isset($searchMonth)
        ? $searchMonth
        : "");
$searchStatus = isset($_POST["search_status"])
    ? $_POST["search_status"]
    : (isset($searchStatus)
        ? $searchStatus
        : "");

// Get location filter
$admin_location = $_SESSION["admin_location"] ?? "ALL";
$location_filter = getLocationFilter($admin_location, "p");

// Pagination setup
$limit = 200; // Number of items per page
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1; // Get the current page, default is 1
$offset = ($page - 1) * $limit; // Calculate the offset for SQL query
$no = $offset + 1;
$query = "SELECT p.* FROM pengajuan p WHERE p.nama LIKE ? AND p.tanggal LIKE ? AND p.konfirmasi LIKE ? $location_filter ORDER BY p.id DESC, p.created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($query);
$nameLike = "%$searchName%";
$monthLike = "%$searchMonth%";
$statusLike = "%$searchStatus%";
$stmt->bind_param("sss", $nameLike, $monthLike, $statusLike);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Query to count the total number of records for pagination with location filter - TIDAK PERLU ORDER BY di COUNT
$total_query = "SELECT COUNT(*) FROM pengajuan p WHERE p.nama LIKE ? AND p.tanggal LIKE ? AND p.konfirmasi LIKE ? $location_filter";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("sss", $nameLike, $monthLike, $statusLike);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_data = $total_result->fetch_row()[0];

// Calculate total pages
$total_pages = ceil($total_data / $limit);

// Generate pagination URLs with existing filters
$pagination_url = "?";
if (!empty($searchName)) {
    $pagination_url .= "search_name=" . urlencode($searchName) . "&";
}
if (!empty($searchMonth)) {
    $pagination_url .= "search_month=" . urlencode($searchMonth) . "&";
}
if (!empty($searchStatus)) {
    $pagination_url .= "search_status=" . urlencode($searchStatus) . "&";
}

// Generate pagination buttons
function renderPagination($currentPage, $totalPages, $url)
{
    $pagination = "";
    if ($currentPage > 1) {
        $pagination .=
            "<a href='{$url}page=" . ($currentPage - 1) . "'>Previous</a> ";
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            $pagination .= "<a href='{$url}page=$i' class='active'>$i</a> ";
        } else {
            $pagination .= "<a href='{$url}page=$i'>$i</a> ";
        }
    }
    if ($currentPage < $totalPages) {
        $pagination .=
            "<a href='{$url}page=" . ($currentPage + 1) . "'>Next</a>";
    }
    return $pagination;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Admin - Pengajuan Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>

    <style>
    body {
        background-color: #f8f9fa;
    }
    h1, h2, h3, .card-header{
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
}
    #qrOverlay {
    display: none;
    position: fixed;
    z-index: 998;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
}

#qrPopup {
    display: none;
    position: fixed;
    z-index: 999;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    text-align: center;
    width: 80%;  /* Sesuaikan dengan lebar form */
    max-width: 600px; /* Maksimal lebar popup */
    height: 80%; /* Sesuaikan dengan tinggi form */
    max-height: 600px; /* Maksimal tinggi form */
}

#qrScanner {
    width: 80%; /* Menggunakan 100% lebar dari elemen popup */
    height: 80vh; /* Menggunakan 100% tinggi dari elemen popup */
    border-radius: 12px;
    object-fit: cover;
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

    .content {
        margin-left: 270px;
        padding: 30px;
    }

    .table thead {
        background-color: #e9ecef;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 14px;
    }

    h3.title-with-icon {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    /* Fixed search-bar styling */
    .search-bar {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-bar .form-control {
        flex: 1;
        min-width: 100px;
        margin: 0;
    }

    .search-input {
        width: 200px;
    }
    
    .search-select {
        width: 150px;
    }

    .icon-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-button lord-icon {
        width: 30px;
        height: 30px;
    }

    /* Additional utility class for grouping button icons */
    .search-actions {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .location-info {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border-left: 4px solid #2196F3;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
}

.location-info h6 {
    margin: 0;
    color: #1976D2;
    font-weight: bold;
}

.location-info p {
    margin: 5px 0 0 0;
    color: #424242;
}

    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <div class="card p-4">


        <h3 class="title-with-icon mb-4">
            <lord-icon
                src="https://cdn.lordicon.com/egmlnyku.json"
                trigger="loop"
                colors="primary:#121331,secondary:#08a88a"
                style="width:40px;height:40px">
            </lord-icon>
            Pengajuan Donor Darah
        </h3>
        <div class="location-info">
            <i class="fas fa-map-marker-alt"></i>
            <strong>Lokasi Anda:</strong> <?= htmlspecialchars(
                getAdminLocationName()
            ) ?>
            <?php if (!isSuperAdmin()): ?>
                <small>(Data ditampilkan sesuai wilayah Anda)</small>
            <?php endif; ?>
        </div>
        <form method="POST" class="search-bar">
            <input type="text" name="search_name" class="form-control search-input" placeholder="Cari Nama" value="<?= htmlspecialchars(
                $searchName
            ) ?>">
            
            <select name="search_month" class="form-control search-select">
                <option value="">Pilih Bulan</option>
                <option value="01" <?= $searchMonth == "01"
                    ? "selected"
                    : "" ?>>Januari</option>
                <option value="02" <?= $searchMonth == "02"
                    ? "selected"
                    : "" ?>>Februari</option>
                <option value="03" <?= $searchMonth == "03"
                    ? "selected"
                    : "" ?>>Maret</option>
                <option value="04" <?= $searchMonth == "04"
                    ? "selected"
                    : "" ?>>April</option>
                <option value="05" <?= $searchMonth == "05"
                    ? "selected"
                    : "" ?>>Mei</option>
                <option value="06" <?= $searchMonth == "06"
                    ? "selected"
                    : "" ?>>Juni</option>
                <option value="07" <?= $searchMonth == "07"
                    ? "selected"
                    : "" ?>>Juli</option>
                <option value="08" <?= $searchMonth == "08"
                    ? "selected"
                    : "" ?>>Agustus</option>
                <option value="09" <?= $searchMonth == "09"
                    ? "selected"
                    : "" ?>>September</option>
                <option value="10" <?= $searchMonth == "10"
                    ? "selected"
                    : "" ?>>Oktober</option>
                <option value="11" <?= $searchMonth == "11"
                    ? "selected"
                    : "" ?>>November</option>
                <option value="12" <?= $searchMonth == "12"
                    ? "selected"
                    : "" ?>>Desember</option>
            </select>
            
            <select name="search_status" class="form-control search-select">
                <option value="">Pilih Status</option>
                <option value="pending" <?= $searchStatus == "pending"
                    ? "selected"
                    : "" ?>>Pending</option>
                <option value="sukses" <?= $searchStatus == "sukses"
                    ? "selected"
                    : "" ?>>Diterima</option>
                <option value="gagal" <?= $searchStatus == "gagal"
                    ? "selected"
                    : "" ?>>Ditolak</option>
            </select>
            
            <div class="search-actions">
                <button type="submit" class="btn btn-primary btn-sm">
                    Cari
                </button>
                
                <a href="manage_admin.php" class="btn btn-secondary btn-sm">
                    Reset
                </a>
                
                <!-- Tombol Scan -->
                <button type="button" class="btn btn-primary" onclick="startScanner(event)">Scan QR</button>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Donor</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
<td>
    <?= $no++ ?>
</td>

                <td><?= htmlspecialchars($row["nama"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td><?= htmlspecialchars($row["tanggal"]) ?></td>
                <td>
                    <small class="text-muted">
                        <?= htmlspecialchars(
                            $row["lokasi"] ?? "Tidak tersedia"
                        ) ?>
                    </small>
                </td>
                <td>
                    <?php if ($row["konfirmasi"] === "pending") {
                        echo "<span class='badge bg-warning text-dark'>Pending</span>";
                    } elseif ($row["konfirmasi"] === "sukses") {
                        echo "<span class='badge bg-success'>Diterima</span>";
                    } elseif ($row["konfirmasi"] === "gagal") {
                        echo "<span class='badge bg-danger'>Ditolak</span>";
                    } ?>
                </td>
                <td>
                    <?php if ($row["konfirmasi"] === "pending"): ?>
                        <!-- PENTING: Selalu gunakan ID asli database untuk tombol Lihat -->
                        <a href="view_pendonor.php?id=<?= $row[
                            "id_pendonor"
                        ] ?>" class="btn btn-outline-primary btn-sm">
                            Lihat
                        </a>
                    <?php else: ?>
                        <span class="text-muted">✔ Sudah dikonfirmasi</span>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" action="manage_admin.php">
                        <?php if ($row["konfirmasi"] !== "pending"): ?>
                            <!-- PENTING: Selalu gunakan ID asli database untuk form kirim email -->
                            <input type="hidden" name="id" value="<?= $row[
                                "id"
                            ] ?>">
                            <button type="submit" name="kirim_email" class="btn btn-outline-success btn-sm">
                                Kirim Email
                            </button>
                        <?php else: ?>
                            <span class="text-muted">Belum bisa kirim</span>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" class="text-center">
                <?php if (!isSuperAdmin()): ?>
                    Tidak ada data pengajuan donor untuk wilayah Anda
                <?php else: ?>
                    Tidak ada data yang ditemukan
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>

        <!-- Statistics Info -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>Total Data:</strong> <?= $total_data ?> pengajuan 
                    <?php if (!isSuperAdmin()): ?>
                        untuk wilayah <?= htmlspecialchars(
                            getAdminLocationName()
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                    <?php if ($total_pages > 1): ?>
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $pagination_url ?>page=<?= $page -
    1 ?>#data-table">Previous</a>
                            </li>
                        <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        <?php endif; ?>

                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        if ($start_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $pagination_url ?>page=1#data-table">1</a>
                            </li>
                            <?php if ($start_page > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif;
                        ?>

                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?= $i == $page
                                ? "active"
                                : "" ?>">
                                <a class="page-link" href="<?= $pagination_url ?>page=<?= $i ?>#data-table"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $pagination_url ?>page=<?= $total_pages ?>#data-table"><?= $total_pages ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $pagination_url ?>page=<?= $page +
    1 ?>#data-table">Next</a>
                            </li>
                        <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
                    </ul>
                </nav>
            </div>
    </div>
</div>

<!-- QR Scanner Overlay and Popup -->
<div id="qrOverlay" onclick="stopScanner()"></div>
<div id="qrPopup">
    <h5>Pindai QR Code</h5>
    <div id="qr-reader" style="width: 300px;"></div>
    <button onclick="stopScanner()" class="btn btn-danger mt-3">Tutup</button>
</div>

<script>
    let html5QrCode;

    function startScanner(e) {
        if (e) e.preventDefault(); // Prevent form submission
        
        document.getElementById("qrOverlay").style.display = "block";
        document.getElementById("qrPopup").style.display = "block";

        html5QrCode = new Html5Qrcode("qr-reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrCode.start(
            { facingMode: "environment" }, // kamera belakang jika ada
            config,
            (decodedText, decodedResult) => {
                console.log(`QR Code: ${decodedText}`);
                stopScanner(); // stop scanner setelah dapat hasil

                // Redirect ke halaman dengan id hasil scan
                window.location.href = `manage_admin.php?scan_id=${encodeURIComponent(decodedText)}`;
            },
            (errorMessage) => {
                // ignore errors or show them if needed
                console.log(errorMessage);
            }
        ).catch(err => {
            console.error("Failed to start scanner", err);
            alert("Gagal memulai kamera: " + err);
            stopScanner();
        });
    }
        // Konfigurasi scanner dengan kualitas lebih baik dan area pemindai lebih besar
        var html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
            fps: 20, // Mempercepat frame per second untuk deteksi yang lebih cepat
            qrbox: 500, // Ukuran kotak pemindai lebih besar agar QR lebih mudah terbaca
            aspectRatio: 1.5, // Menyesuaikan rasio aspek untuk kualitas yang lebih baik
            rememberLastUsedCamera: true,
            mirror: false // Nonaktifkan efek mirror pada kamera
        });
        html5QrcodeScanner.render(onScanSuccess);
    function stopScanner() {
        document.getElementById("qrOverlay").style.display = "none";
        document.getElementById("qrPopup").style.display = "none";
        
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                console.log("QR Scanner stopped");
            }).catch(err => {
                console.error("Failed to stop scanner", err);
            });
        }
    }
</script>

</body>
</html>