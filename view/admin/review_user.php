<?php
session_start();

// Include helper filter lokasi admin
require_once "../../admin_filter_helper.php";

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// --- Pagination Logic ---
$limit = 150; // jumlah data per halaman
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

$totalRows = getFilteredReviewCount($conn, "");
$totalPages = ceil($totalRows / $limit);

// Ambil data review berdasarkan halaman
$result = getFilteredReview($conn, "", $limit, $offset);

$admin_location_name = getAdminLocationName();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<?php include "sidebar.php"; ?>
    <meta charset="UTF-8">
    <title>Review Pengguna | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
h1, h2, h3, .card-header{
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
}
.nav-link {
    color: #ffffff;
    padding: 10px 15px;
    margin: 5px 0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
    padding-left: 20px;
    color: #ffddcc;
    text-decoration: none;
}

.nav-link i {
    margin-right: 10px;
}

.nav-item:last-child {
    margin-top: auto;
}

.content {
    margin-left: 260px; /* atau sesuai sidebar */
    padding: 20px;
}

.card {
    margin-top: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border: none;
}

.star {
    color: gold;
}

.form-label {
    font-weight: bold;
}

h2 {
    margin-top: 0; /* Added margin to create space above the heading */
}

.table thead {
    background: linear-gradient(135deg, #669BBC, #3e6e85);
    color: white;
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
}

.lordicon-review {
    width: 60px;
    height: 60px;
    margin-bottom: 15px;
}

.card-header {
    background: linear-gradient(135deg, #669BBC, #3e6e85);
    color: white;
    font-weight: bold;
}

.table-responsive {
    margin-top: 20px;
}

.table-bordered {
    border-radius: 10px;
    border: none;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd;
}

.no-reviews {
    text-align: center;
    font-size: 18px;
    color: #999;
    margin-top: 20px;
}

.star-rating {
    font-size: 1.2rem;
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
    <div class="content"> <!-- Tambahkan pembungkus content -->
    <div class="container-fluid px-0">

            <h2 class="text-center">Daftar Review Pengguna</h2>
            
            <!-- Info Lokasi Admin -->
            <div class="location-info">
            <i class="fas fa-map-marker-alt"></i>
            <strong>Lokasi Anda:</strong> <?= htmlspecialchars(
                getAdminLocationName()
            ) ?>
            <?php if (!isSuperAdmin()): ?>
                <small>(Data ditampilkan sesuai wilayah Anda)</small>
            <?php endif; ?>
        </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Tabel Review</h5>
                </div>

                <div class="card-body">
                    <?php if ($result && $result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pendonor</th>
                                    <th>Rating</th>
                                    <th>Ulasan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $offset + 1;

                                while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if (
                                                !empty($row["nama_pendonor"])
                                            ): ?>
                                                <?= htmlspecialchars(
                                                    $row["nama_pendonor"]
                                                ) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Nama tidak tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="star-rating">
                                                <?php
                                                $stars = intval($row["rating"]);
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $stars) {
                                                        echo '<span class="star">⭐</span>';
                                                    } else {
                                                        echo '<span class="text-muted">☆</span>';
                                                    }
                                                }
                                                ?>
                                                <small class="text-muted">(<?= $stars ?>/5)</small>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (
                                                !empty($row["ulasan"])
                                            ): ?>
                                                <div class="text-start">
                                                    <?= nl2br(
                                                        htmlspecialchars(
                                                            $row["ulasan"]
                                                        )
                                                    ) ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak ada ulasan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small>
                                                <?= date(
                                                    "d-m-Y",
                                                    strtotime(
                                                        $row["created_at"]
                                                    )
                                                ) ?><br>
                                                <?= date(
                                                    "H:i",
                                                    strtotime(
                                                        $row["created_at"]
                                                    )
                                                ) ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Informasi total review -->
                    <div class="mt-3">
                        <small class="text-muted">
                            Total: <?= $result->num_rows ?> review
                            <?php if (!isSuperAdmin()): ?>
                                dari wilayah <?= htmlspecialchars(
                                    $admin_location_name
                                ) ?>
                            <?php endif; ?>
                        </small>
                    </div>
                    
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-comment-slash fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Belum ada review</h5>
                            <p class="text-muted">
                                <?php if (!isSuperAdmin()): ?>
                                    Belum ada review dari pengguna di wilayah <?= htmlspecialchars(
                                        $admin_location_name
                                    ) ?>
                                <?php else: ?>
                                    Belum ada review dari pengguna di seluruh lokasi
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Pagination -->
<?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation example" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page -
                        1 ?>">Sebelumnya</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? "active" : "" ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page +
                        1 ?>">Berikutnya</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>