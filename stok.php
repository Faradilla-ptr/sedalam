<?php
$host = 'localhost';
$dbname = 'web_donor';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$notif = '';

// Proses CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $golongan_darah = $_POST['golongan_darah'];
        $rhesus = $_POST['rhesus'];
        $jumlah = $_POST['jumlah'];
        $stmt = $conn->prepare("INSERT INTO stok_darah (golongan_darah, rhesus, jumlah) VALUES (?, ?, ?)");
        $stmt->execute([$golongan_darah, $rhesus, $jumlah]);
        $notif = 'add';
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $jumlah = $_POST['jumlah'];
        $stmt = $conn->prepare("UPDATE stok_darah SET jumlah = ? WHERE id = ?");
        $stmt->execute([$jumlah, $id]);
        $notif = 'update';
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM stok_darah WHERE id = ?");
        $stmt->execute([$id]);
        $notif = 'delete';
    }
}

// Ambil data stok darah
$stmt = $conn->prepare("SELECT golongan_darah, SUM(jumlah) as total FROM stok_darah GROUP BY golongan_darah");
$stmt->execute();
$stok_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stok_golongan = [];
foreach ($stok_data as $stok) {
    $stok_golongan[$stok['golongan_darah']] = $stok['total'];
}

// Status stok darah
$min_stok = 50; // Batas minimum stok darah
$status_stok = [];
foreach ($stok_golongan as $golongan => $jumlah) {
    $status_stok[$golongan] = ($jumlah >= $min_stok) ? 'Aman' : 'Menipis';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Darah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Ringkasan Stok Darah</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Golongan Darah</th>
                <th>Jumlah Kantong</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stok_golongan as $golongan => $jumlah): ?>
            <tr>
                <td><?= $golongan ?></td>
                <td><?= $jumlah ?></td>
                <td><?= $status_stok[$golongan] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h2>Grafik Stok Darah</h2>
    <canvas id="bloodStockChart"></canvas>
    <script>
        var ctx = document.getElementById("bloodStockChart").getContext("2d");
        var bloodStockChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: <?= json_encode(array_keys($stok_golongan)) ?>,
                datasets: [{
                    label: "Jumlah Kantong",
                    data: <?= json_encode(array_values($stok_golongan)) ?>,
                    backgroundColor: ["red", "blue", "green", "orange"]
                }]
            }
        });
    </script>
</div>
</body>
</html>
