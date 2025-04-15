<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login dan memiliki peran sebagai admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect ke halaman login jika bukan admin
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin PMI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="d-flex">
    <div class="bg-dark text-white vh-100 p-3" style="width: 250px;">
        <h4>Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="manajemen_admin.php" class="nav-link text-white">Manajemen Admin</a></li>
            <li class="nav-item"><a href="manage_darah.php" class="nav-link text-white">Manajemen Stok Darah</a></li>
            <li class="nav-item mt-auto"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
        </ul>
    </div>

    <div class="container mt-4">
        <h2>Dashboard Overview</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Donor</div>
                    <div class="card-body">
                        <h5 class="card-title">1500</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Stok Darah</div>
                    <div class="card-body">
                        <h5 class="card-title">250 Kantong</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Pengajuan Pending</div>
                    <div class="card-body">
                        <h5 class="card-title">30</h5>
                    </div>
                </div>
            </div>
        </div>

        <h3>Grafik Aktivitas</h3>
        <canvas id="activityChart"></canvas>

        <script>
            var ctx = document.getElementById('activityChart').getContext('2d');
            var activityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Donor Harian',
                        data: [20, 25, 30, 40, 35, 50, 60],
                        borderColor: 'blue',
                        borderWidth: 2,
                        fill: false
                    }]
                }
            });
        </script>
    </div>
</body>
</html>
