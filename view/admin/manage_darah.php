<?php
// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file helper untuk filter lokasi
require_once "../../admin_filter_helper.php";

$host = "localhost";
$dbname = "web_donor";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Konversi PDO ke mysqli untuk kompatibilitas dengan helper
$mysqli_conn = new mysqli($host, $username, $password, $dbname);
if ($mysqli_conn->connect_error) {
    die("Connection failed: " . $mysqli_conn->connect_error);
}

// Set global connection untuk helper
$GLOBALS["conn"] = $mysqli_conn;

$notif = "";

// **Proses CRUD**
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        if (
            !empty($_POST["golongan_darah"]) &&
            !empty($_POST["rhesus"]) &&
            !empty($_POST["jumlah_kantong"]) &&
            !empty($_POST["lokasi"]) &&
            !empty($_POST["tanggal_stok_datang"]) &&
            !empty($_POST["status"]) &&
            !empty($_POST["tanggal_kadaluarsa"])
        ) {
            // Validasi lokasi untuk admin non-super
            $admin_location = $_SESSION["admin_location"] ?? "ALL";
            $is_super_admin =
                isset($_SESSION["is_super_admin"]) &&
                $_SESSION["is_super_admin"];

            if (
                !$is_super_admin &&
                $admin_location !== "ALL" &&
                $_POST["lokasi"] !== $admin_location
            ) {
                $notif = "error_location";
            } else {
                $stmt = $conn->prepare("INSERT INTO stok_darah 
                    (golongan_darah, rhesus, jumlah_kantong, lokasi, tanggal_stok_datang, status, tanggal_kadaluarsa) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST["golongan_darah"],
                    $_POST["rhesus"],
                    $_POST["jumlah_kantong"],
                    $_POST["lokasi"],
                    $_POST["tanggal_stok_datang"],
                    $_POST["status"],
                    $_POST["tanggal_kadaluarsa"],
                ]);
                $notif = "add";
            }
        }
    } elseif (isset($_POST["update"]) && isset($_POST["id"])) {
        if (
            !empty($_POST["golongan_darah"]) &&
            !empty($_POST["rhesus"]) &&
            !empty($_POST["jumlah_kantong"]) &&
            !empty($_POST["lokasi"]) &&
            !empty($_POST["tanggal_stok_datang"]) &&
            !empty($_POST["status"]) &&
            !empty($_POST["tanggal_kadaluarsa"])
        ) {
            // Validasi lokasi untuk admin non-super
            $admin_location = $_SESSION["admin_location"] ?? "ALL";
            $is_super_admin =
                isset($_SESSION["is_super_admin"]) &&
                $_SESSION["is_super_admin"];

            if (
                !$is_super_admin &&
                $admin_location !== "ALL" &&
                $_POST["lokasi"] !== $admin_location
            ) {
                $notif = "error_location";
            } else {
                $stmt = $conn->prepare("UPDATE stok_darah 
                    SET golongan_darah = ?, rhesus = ?, jumlah_kantong = ?, lokasi = ?, 
                        tanggal_stok_datang = ?, status = ?, tanggal_kadaluarsa = ? 
                    WHERE id = ?");
                $stmt->execute([
                    $_POST["golongan_darah"],
                    $_POST["rhesus"],
                    $_POST["jumlah_kantong"],
                    $_POST["lokasi"],
                    $_POST["tanggal_stok_datang"],
                    $_POST["status"],
                    $_POST["tanggal_kadaluarsa"],
                    $_POST["id"],
                ]);
                $notif = "update";
            }
        }
    } elseif (isset($_POST["delete"]) && isset($_POST["id"])) {
        $stmt = $conn->prepare("DELETE FROM stok_darah WHERE id = ?");
        $stmt->execute([$_POST["id"]]);

        // Reset ulang ID setelah penghapusan
        $conn->exec("SET @num := 0;");
        $conn->exec("UPDATE stok_darah SET id = (@num := @num + 1);");
        $conn->exec("ALTER TABLE stok_darah AUTO_INCREMENT = 1;");

        $notif = "delete";
    }
}

// **Filter Data dengan Location Filter**
$filter_lokasi = $_GET["lokasi"] ?? "";
$filter_golongan = $_GET["golongan_darah"] ?? "";

// Menggunakan helper function untuk mendapatkan data dengan filter lokasi
$admin_location = $_SESSION["admin_location"] ?? "ALL";
$location_filter = getLocationFilter($admin_location, "");

$additional_where = "";
if (!empty($filter_lokasi)) {
    $additional_where .=
        " AND lokasi LIKE '%" .
        mysqli_real_escape_string($mysqli_conn, $filter_lokasi) .
        "%'";
}
if (!empty($filter_golongan)) {
    $additional_where .=
        " AND golongan_darah = '" .
        mysqli_real_escape_string($mysqli_conn, $filter_golongan) .
        "'";
}

// **Pagination dengan filter lokasi**
$limit = 200;
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$offset = ($page - 1) * $limit;

// Menggunakan helper untuk mendapatkan total data dengan filter lokasi
$total_query = "SELECT COUNT(*) FROM stok_darah WHERE 1=1" . $location_filter;

if (!empty($filter_lokasi)) {
    $total_query .=
        " AND lokasi LIKE '%" .
        mysqli_real_escape_string($mysqli_conn, $filter_lokasi) .
        "%'";
}
if (!empty($filter_golongan)) {
    $total_query .=
        " AND golongan_darah = '" .
        mysqli_real_escape_string($mysqli_conn, $filter_golongan) .
        "'";
}

$total_result = mysqli_query($mysqli_conn, $total_query);
$total_data = mysqli_fetch_row($total_result)[0];
$total_pages = ceil($total_data / $limit);

// Query untuk mendapatkan data dengan filter lokasi
$query =
    "SELECT * FROM stok_darah WHERE 1=1" .
    $location_filter .
    $additional_where .
    " ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($mysqli_conn, $query);
$stok_darah = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stok_darah[] = $row;
}

// Mempertahankan parameter filter saat paging
$pagination_url = "?";
if (!empty($filter_lokasi)) {
    $pagination_url .= "lokasi=" . urlencode($filter_lokasi) . "&";
}
if (!empty($filter_golongan)) {
    $pagination_url .= "golongan_darah=" . urlencode($filter_golongan) . "&";
}

// Mendapatkan informasi admin untuk tampilan
$admin_location_name = getAdminLocationName();
$is_super_admin = isSuperAdmin();
$all_locations = getAllLocations($mysqli_conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Darah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            margin-left: 260px;
            padding: 20px;
        }
        /* Flex container untuk form */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
        .form-row > .form-group {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 5px;
        }
        /* Style untuk card dan tabel */
        .card {
            margin-bottom: 20px;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        /* Anchor untuk navigasi */
        #data-table {
            scroll-margin-top: 20px;
        }
        /* Form filter yang lebih rapi */
        .filter-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        /* Warna status */
        .status-aman {
            background-color: #d4edda;
        }
        .status-menipis {
            background-color: #fff3cd;
        }
        .status-darurat {
            background-color: #f8d7da;
        }
        /* Fixed-width tabel untuk kolom yang lurus */
        .table {
            width: 100%;
            table-layout: fixed;
        }
        .table th, .table td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .table th {
            font-weight: bold;
            vertical-align: middle;
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
        .btn-success {
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

.btn-success:hover {
  letter-spacing: 3px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(167, 29, 42, 0.5);
}
h1, h2, h3, .card-header{
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
}
    </style>
</head>
<body>

<script>
    function showNotification(type) {
        let msg = '';
        let icon = '';
        if (type === 'add') {
            msg = 'Stok darah berhasil ditambahkan!';
            icon = 'success';
        } else if (type === 'update') {
            msg = 'Data stok darah diperbarui!';
            icon = 'info';
        } else if (type === 'delete') {
            msg = 'Stok darah dihapus!';
            icon = 'warning';
        } else if (type === 'error_location') {
            msg = 'Anda hanya dapat mengelola data untuk lokasi Anda sendiri!';
            icon = 'error';
        }
        if (msg) {
            Swal.fire({
                title: msg,
                icon: icon,
                confirmButtonText: 'OK',
                timer: type === 'error_location' ? 3000 : 2000
            });
        }
    }
    function confirmDelete(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }
    
    // Function untuk scroll ke tabel saat halaman di-load
    window.onload = function() {
        // Periksa jika ini adalah hasil paging
        if (window.location.href.includes('page=')) {
            // Scroll ke tabel
            document.getElementById('data-table').scrollIntoView();
        }
    }
</script>

<?php if ($notif): ?>
<script>showNotification('<?= $notif ?>');</script>
<?php endif; ?>

<?php include "sidebar.php"; ?>

<div class="content">

    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="mb-4">Tambah Stok Darah</h2>
            <div class="location-info">
            <i class="fas fa-map-marker-alt"></i>
            <strong>Lokasi Anda:</strong> <?= htmlspecialchars(
                getAdminLocationName()
            ) ?>
            <?php if (!isSuperAdmin()): ?>
                <small>(Data ditampilkan sesuai wilayah Anda)</small>
            <?php endif; ?>
        </div>
            <div class="card p-4">
                <form method="POST" class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Golongan Darah</label>
                        <select name="golongan_darah" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Rhesus</label>
                        <select name="rhesus" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="+">+</option>
                            <option value="-">-</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Jumlah Kantong</label>
                        <input type="number" name="jumlah_kantong" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lokasi</label>
                        <?php if ($is_super_admin): ?>
                            <select name="lokasi" class="form-control" required>
                                <option value="">Pilih Lokasi</option>
                                <?php foreach ($all_locations as $location): ?>
                                    <option value="<?= htmlspecialchars(
                                        $location
                                    ) ?>"><?= htmlspecialchars(
    $location
) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars(
                                $admin_location
                            ) ?>" readonly required>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Stok Datang</label>
                        <input type="date" name="tanggal_stok_datang" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Aman">Aman</option>
                            <option value="Menipis">Menipis</option>
                            <option value="Darurat">Darurat</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" name="tanggal_kadaluarsa" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="add" class="btn btn-success">Simpan Stok</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-12">
            <h3 id="data-table">Data Stok Darah</h3>
            
            <!-- Form Filter -->
            <div class="filter-form">
                <form method="GET" class="mb-3">
                    <div class="row align-items-end">
                        <?php if ($is_super_admin): ?>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Cari lokasi..." value="<?= htmlspecialchars(
                                $filter_lokasi
                            ) ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                        <?php else: ?>
                        <div class="col-md-4 mb-2">
                        <?php endif; ?>
                            <label class="form-label">Golongan Darah</label>
                            <select name="golongan_darah" class="form-control">
                                <option value="">Semua Golongan</option>
                                <option value="A" <?= $filter_golongan == "A"
                                    ? "selected"
                                    : "" ?>>A</option>
                                <option value="B" <?= $filter_golongan == "B"
                                    ? "selected"
                                    : "" ?>>B</option>
                                <option value="AB" <?= $filter_golongan == "AB"
                                    ? "selected"
                                    : "" ?>>AB</option>
                                <option value="O" <?= $filter_golongan == "O"
                                    ? "selected"
                                    : "" ?>>O</option>
                            </select>
                        </div>
                        <?php if ($is_super_admin): ?>
                        <div class="col-md-6 mb-2">
                        <?php else: ?>
                        <div class="col-md-8 mb-2">
                        <?php endif; ?>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">Cari</button>
                                <a href="?" class="btn btn-secondary flex-grow-1">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>



            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="5%">ID</th>
                            <th width="8%">Golongan</th>
                            <th width="6%">Rhesus</th>
                            <th width="6%">Jumlah</th>
                            <th width="20%">Lokasi</th>
                            <th width="12%">Tanggal Stok</th>
                            <th width="8%">Status</th>
                            <th width="12%">Kadaluarsa</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>


<?php if (empty($stok_darah)): ?>
<tr>
    <td colspan="9" class="text-center">Tidak ada data stok darah</td>
</tr>
<?php // Hitung nomor urut berdasarkan halaman
    // Increment nomor urut
    // Hitung nomor urut berdasarkan halaman
    // Increment nomor urut
    else: ?>
<?php
$no = ($page - 1) * $limit + 1;
foreach ($stok_darah as $stok):

    $statusClass = "";
    if ($stok["status"] == "Aman") {
        $statusClass = "status-aman";
    } elseif ($stok["status"] == "Menipis") {
        $statusClass = "status-menipis";
    } elseif ($stok["status"] == "Darurat") {
        $statusClass = "status-darurat";
    }
    ?>
<tr>
    <td class="text-center"><?= $no ?></td> <!-- Tampilkan nomor urut -->
    <td class="text-center"><?= $stok["golongan_darah"] ?></td>
    <td class="text-center"><?= $stok["rhesus"] ?></td>
    <td class="text-center"><?= $stok["jumlah_kantong"] ?></td>
    <td title="<?= htmlspecialchars($stok["lokasi"]) ?>"><?= htmlspecialchars(
    $stok["lokasi"]
) ?></td>
    <td class="text-center"><?= $stok["tanggal_stok_datang"] ?></td>
    <td class="text-center <?= $statusClass ?>"><?= $stok["status"] ?></td>
    <td class="text-center"><?= $stok["tanggal_kadaluarsa"] ?></td>
    <td class="text-center">
        <button class="btn btn-sm btn-warning" onclick="showUpdateModal(
            '<?= $stok["id"] ?>', // Tetap gunakan ID database asli
            '<?= $stok["golongan_darah"] ?>', 
            '<?= $stok["rhesus"] ?>', 
            '<?= $stok["jumlah_kantong"] ?>', 
            '<?= htmlspecialchars($stok["lokasi"]) ?>', 
            '<?= $stok["tanggal_stok_datang"] ?>', 
            '<?= $stok["status"] ?>', 
            '<?= $stok["tanggal_kadaluarsa"] ?>')">
            Perbarui
        </button>

        <form method="POST" id="deleteForm<?= $stok[
            "id"
        ] ?>" style="display:inline; margin-left:2px;">
            <input type="hidden" name="id" value="<?= $stok[
                "id"
            ] ?>"> <!-- Tetap gunakan ID database asli -->
            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $stok[
                "id"
            ] ?>)">
                Hapus
            </button>
            <input type="hidden" name="delete" value="true">
        </form>
    </td>
</tr>
<?php $no++;
endforeach;
?>
<?php endif; ?>

                    </tbody>
                </table>
            </div>
                        <!-- Info Data -->
                        <div class="alert alert-info">
                <strong>Total Data:</strong> <?= $total_data ?> record
                <?php if (!$is_super_admin): ?>
                    (Hanya menampilkan data untuk lokasi: <?= htmlspecialchars(
                        $admin_location
                    ) ?>)
                <?php endif; ?>
            </div>
            <!-- Pagination - centered -->
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
        </div>
    </div>
</div>
    </div>
</div>

<script>
    function showUpdateModal(id, golongan_darah, rhesus, jumlah_kantong, lokasi, tanggal_stok_datang, status, tanggal_kadaluarsa) {
        document.getElementById('updateId').value = id;
        document.getElementById('updateGolonganDarah').value = golongan_darah;
        document.getElementById('updateRhesus').value = rhesus;
        document.getElementById('updateJumlah').value = jumlah_kantong;
        document.getElementById('updateLokasi').value = lokasi;
        document.getElementById('updateTanggalStokDatang').value = tanggal_stok_datang;
        document.getElementById('updateStatus').value = status;
        document.getElementById('updateTanggalKadaluarsa').value = tanggal_kadaluarsa;

        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        updateModal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>