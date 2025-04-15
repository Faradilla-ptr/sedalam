<?php
$host = 'localhost';
$dbname = 'web_donor';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

$notif = '';

// **Proses CRUD**
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        if (!empty($_POST['golongan_darah']) && !empty($_POST['rhesus']) && !empty($_POST['jumlah']) &&
            !empty($_POST['lokasi']) && !empty($_POST['tanggal_stok_datang']) &&
            !empty($_POST['status']) && !empty($_POST['tanggal_kadaluarsa'])) {
            
            $stmt = $conn->prepare("INSERT INTO stok_darah 
                (golongan_darah, rhesus, jumlah, lokasi, tanggal_stok_datang, status, tanggal_kadaluarsa) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['golongan_darah'],
                $_POST['rhesus'],
                $_POST['jumlah'],
                $_POST['lokasi'],
                $_POST['tanggal_stok_datang'],
                $_POST['status'],
                $_POST['tanggal_kadaluarsa']
            ]);
            $notif = 'add';
        }
    } elseif (isset($_POST['update']) && isset($_POST['id'])) {
        if (!empty($_POST['golongan_darah']) && !empty($_POST['rhesus']) && !empty($_POST['jumlah']) &&
            !empty($_POST['lokasi']) && !empty($_POST['tanggal_stok_datang']) &&
            !empty($_POST['status']) && !empty($_POST['tanggal_kadaluarsa'])) {
            
            $stmt = $conn->prepare("UPDATE stok_darah 
                SET golongan_darah = ?, rhesus = ?, jumlah = ?, lokasi = ?, 
                    tanggal_stok_datang = ?, status = ?, tanggal_kadaluarsa = ? 
                WHERE id = ?");
            $stmt->execute([
                $_POST['golongan_darah'],
                $_POST['rhesus'],
                $_POST['jumlah'],
                $_POST['lokasi'],
                $_POST['tanggal_stok_datang'],
                $_POST['status'],
                $_POST['tanggal_kadaluarsa'],
                $_POST['id']
            ]);
            $notif = 'update';
        }
    } elseif (isset($_POST['delete']) && isset($_POST['id'])) {
        $stmt = $conn->prepare("DELETE FROM stok_darah WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    
        // Reset ulang ID setelah penghapusan
        $conn->exec("SET @num := 0;");
        $conn->exec("UPDATE stok_darah SET id = (@num := @num + 1);");
        $conn->exec("ALTER TABLE stok_darah AUTO_INCREMENT = 1;");
    
        $notif = 'delete';
    }
    
}

// **Filter Data**
$filter_lokasi = $_GET['lokasi'] ?? '';
$filter_golongan = $_GET['golongan_darah'] ?? '';

$query = "SELECT * FROM stok_darah WHERE 1=1";

if (!empty($filter_lokasi)) {
    $query .= " AND lokasi LIKE '%$filter_lokasi%'";
}
if (!empty($filter_golongan)) {
    $query .= " AND golongan_darah = '$filter_golongan'";
}

// **Pagination**
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$total_query = "SELECT COUNT(*) FROM stok_darah WHERE 1=1";

if (!empty($filter_lokasi)) {
    $total_query .= " AND lokasi LIKE '%$filter_lokasi%'";
}
if (!empty($filter_golongan)) {
    $total_query .= " AND golongan_darah = '$filter_golongan'";
}

$total_stmt = $conn->query($total_query);
$total_data = $total_stmt->fetchColumn();
$total_pages = ceil($total_data / $limit);

$query .= " LIMIT $limit OFFSET $offset";
$stmt = $conn->query($query);
$stok_darah = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        /* Sidebar tetap pada tempatnya */
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
        }
        if (msg) {
            Swal.fire({
                title: msg,
                icon: icon,
                confirmButtonText: 'OK',
                timer: 2000
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
</script>

<?php if ($notif) : ?>
    <script>showNotification('<?= $notif ?>');</script>
<?php endif; ?>


<div class="sidebar">
    <h4>Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
        <li class="nav-item"><a href="manajemen_admin.php" class="nav-link text-white">Manajemen Admin</a></li>
        <li class="nav-item"><a href="manage_darah.php" class="nav-link text-white">Manajemen Stok Darah</a></li>
        <li class="nav-item mt-auto"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
    </ul>
</div>
<div class="content">
    <h2 class="mb-4">Tambah Stok Darah</h2>
    <div class="card p-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Golongan Darah</label>
                <select name="golongan_darah" class="form-control">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Rhesus</label>
                <select name="rhesus" class="form-control">
                    <option value="+">+</option>
                    <option value="-">-</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Stok Datang</label>
                <input type="date" name="tanggal_stok_datang" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="Aman">Aman</option>
                    <option value="Menipis">Menipis</option>
                    <option value="Darurat">Darurat</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Kadaluarsa</label>
                <input type="date" name="tanggal_kadaluarsa" class="form-control" required>
            </div>
            <button type="submit" name="add" class="btn btn-success">Simpan Stok</button>
        </form>
    </div>

    <!-- Modal Update -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Perbarui Data Stok Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="updateId">

                    <div class="mb-3">
                        <label for="updateGolonganDarah" class="form-label">Golongan Darah</label>
                        <select class="form-control" id="updateGolonganDarah" name="golongan_darah" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="updateRhesus" class="form-label">Rhesus</label>
                        <select class="form-control" id="updateRhesus" name="rhesus" required>
                            <option value="+">+</option>
                            <option value="-">-</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="updateJumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="updateJumlah" name="jumlah" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateLokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="updateLokasi" name="lokasi" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateTanggalStokDatang" class="form-label">Tanggal Stok Datang</label>
                        <input type="date" class="form-control" id="updateTanggalStokDatang" name="tanggal_stok_datang" required>
                    </div>

                    <div class="mb-3">
                    <label for="updateStatus" class="form-label">Status</label>
                    <select class="form-control" id="updateStatus" name="status" required>
                        <option value="Aman">Aman</option>
                        <option value="Menipis">Menipis</option>
                        <option value="Darurat">Darurat</option>
                    </select>
                    </div>


                    <div class="mb-3">
                        <label for="updateTanggalKadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" id="updateTanggalKadaluarsa" name="tanggal_kadaluarsa" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="update">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showUpdateModal(id, golongan_darah, rhesus, jumlah, lokasi, tanggal_stok_datang, status, tanggal_kadaluarsa) {
        console.log(id, golongan_darah, rhesus, jumlah, lokasi, tanggal_stok_datang, status, tanggal_kadaluarsa); // Debugging

        document.getElementById('updateId').value = id;
        document.getElementById('updateGolonganDarah').value = golongan_darah;
        document.getElementById('updateRhesus').value = rhesus;
        document.getElementById('updateJumlah').value = jumlah;
        document.getElementById('updateLokasi').value = lokasi;
        document.getElementById('updateTanggalStokDatang').value = tanggal_stok_datang;
        document.getElementById('updateStatus').value = status;
        document.getElementById('updateTanggalKadaluarsa').value = tanggal_kadaluarsa;

        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        updateModal.show();
    }
</script>


<div class="container mt-5">
    <h3>Data Stok Darah</h3>
    
    <!-- Form Filter -->
    <form method="GET" class="mb-3">
        <div class="row justify-content-start">
            <div class="col-auto">
                <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" value="<?= htmlspecialchars($filter_lokasi) ?>">
            </div>
            <div class="col-auto">
                <select name="golongan_darah" class="form-control">
                    <option value="">Pilih Golongan Darah</option>
                    <option value="A" <?= $filter_golongan == 'A' ? 'selected' : '' ?>>A</option>
                    <option value="B" <?= $filter_golongan == 'B' ? 'selected' : '' ?>>B</option>
                    <option value="AB" <?= $filter_golongan == 'AB' ? 'selected' : '' ?>>AB</option>
                    <option value="O" <?= $filter_golongan == 'O' ? 'selected' : '' ?>>O</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="?" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Golongan Darah</th>
                <th>Rhesus</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Tanggal Stok Datang</th>
                <th>Status</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stok_darah as $stok): ?>
            <tr>
                <td><?= $stok['id'] ?></td>
                <td><?= $stok['golongan_darah'] ?></td>
                <td><?= $stok['rhesus'] ?></td>
                <td><?= $stok['jumlah'] ?></td>
                <td><?= $stok['lokasi'] ?></td>
                <td><?= $stok['tanggal_stok_datang'] ?></td>
                <td><?= $stok['status'] ?></td>
                <td><?= $stok['tanggal_kadaluarsa'] ?></td>
                <td>
                    <button class="btn btn-warning" onclick="showUpdateModal(
                        '<?= $stok['id'] ?>', 
                        '<?= $stok['golongan_darah'] ?>', 
                        '<?= $stok['rhesus'] ?>', 
                        '<?= $stok['jumlah'] ?>', 
                        '<?= $stok['lokasi'] ?>', 
                        '<?= $stok['tanggal_stok_datang'] ?>', 
                        '<?= $stok['status'] ?>', 
                        '<?= $stok['tanggal_kadaluarsa'] ?>')">
                        Perbarui
                    </button>

                    <form method="POST" id="deleteForm<?= $stok['id'] ?>" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $stok['id'] ?>">
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $stok['id'] ?>)">
                            Hapus
                        </button>
                        <input type="hidden" name="delete" value="true">
                    </form>
                    
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

</body>
</html>
