<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";
require_once "../../admin_filter_helper.php";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: login_admin.php");
    exit();
}

// Ambil informasi admin yang login
$admin_location = $_SESSION["admin_location"] ?? "ALL";
$is_super_admin = $_SESSION["is_super_admin"] ?? false;
$username = $_SESSION["username"] ?? "";

// --------- NOTIFIKASI LONCENG - PERBAIKAN ----------
$notif_list = [];
$location_filter = getLocationFilter($admin_location, "p"); // Tambahkan alias tabel
$alamat_filter = getAlamatFilter($admin_location, "a"); // Tambahkan alias tabel

// Query notifikasi dengan filter yang benar dan alias tabel
$queries = [
    "SELECT 'Akun Baru' as sumber, a.nama as isi, a.created_at FROM akun a WHERE a.created_at >= NOW() - INTERVAL 12 HOUR $alamat_filter ORDER BY a.created_at DESC LIMIT 10",
    "SELECT 'FAQ Baru' as sumber, email as isi, created_at FROM faq WHERE created_at >= NOW() - INTERVAL 12 HOUR ORDER BY created_at DESC LIMIT 10",
    "SELECT 'Pengajuan Baru' as sumber, p.nama as isi, p.created_at FROM pengajuan p WHERE p.created_at >= NOW() - INTERVAL 12 HOUR $location_filter ORDER BY p.created_at DESC LIMIT 10",
    "SELECT 'Pengambilan Darah Baru' as sumber, pd.lokasi_tujuan as isi, pd.created_at FROM pengambilan_darah pd WHERE pd.created_at >= NOW() - INTERVAL 12 HOUR " .
    getLocationFilter($admin_location, "pd") .
    " ORDER BY pd.created_at DESC LIMIT 10",
    "SELECT 'Tes Kesehatan Baru' as sumber, tk.id as isi, tk.created_at FROM tes_kesehatan tk WHERE tk.created_at >= NOW() - INTERVAL 12 HOUR " .
    getLocationFilter($admin_location, "tk") .
    " ORDER BY tk.created_at DESC LIMIT 10",
];

$notif_list = [];
$notif_count = 0;

foreach ($queries as $sql) {
    $res = $conn->query($sql);
    if ($res) {
        while ($notif_count < 30 && ($row = $res->fetch_assoc())) {
            $notif_list[] = "<strong>{$row["sumber"]}</strong>: {$row["isi"]}<br><small class='text-muted'>{$row["created_at"]}</small>";
            $notif_count++;
        }
    }
}

// -------- GRAFIK STOK DARAH --------
$bulan_terpilih = isset($_GET["bulan"]) ? $_GET["bulan"] : "semua";

$bulan_array = [
    "2025-01" => "Januari 2025",
    "2025-02" => "Februari 2025",
    "2025-03" => "Maret 2025",
    "2025-04" => "April 2025",
    "2025-05" => "Mei 2025",
    "2025-06" => "Juni 2025",
];

// Filter lokasi untuk stok darah (menggunakan kolom lokasi)
$stok_location_filter = getLocationFilter($admin_location, "s");

if ($bulan_terpilih === "semua") {
    $labels = [];
    $data_masuk = [];
    $data_keluar = [];
    $data_total = [];

    foreach ($bulan_array as $bulan_kode => $bulan_nama) {
        $bulan_filter = $conn->real_escape_string($bulan_kode);

        // Query stok masuk dengan filter lokasi dan alias tabel
        $sql_masuk = "SELECT COALESCE(SUM(s.jumlah_kantong), 0) as total FROM stok_darah s 
                      WHERE DATE_FORMAT(s.tanggal_stok_datang, '%Y-%m') = '$bulan_filter' $stok_location_filter";
        $res_masuk = $conn->query($sql_masuk);
        $jumlah_masuk = (int) $res_masuk->fetch_assoc()["total"];

        // Query stok keluar dengan filter lokasi dan alias tabel
        $sql_keluar =
            "SELECT COALESCE(SUM(pd.jumlah_kantong), 0) as total FROM pengambilan_darah pd 
                       WHERE DATE_FORMAT(pd.tanggal_keluar, '%Y-%m') = '$bulan_filter' " .
            getLocationFilter($admin_location, "pd");
        $res_keluar = $conn->query($sql_keluar);
        $jumlah_keluar = (int) $res_keluar->fetch_assoc()["total"];

        $labels[] = $bulan_nama;
        $data_masuk[] = $jumlah_masuk;
        $data_keluar[] = $jumlah_keluar;
        $data_total[] = $jumlah_masuk;
    }
} else {
    $bulan_filter = $conn->real_escape_string($bulan_terpilih);
    $bulan_label = $bulan_array[$bulan_terpilih] ?? "Bulan Tidak Diketahui";

    $sql_masuk = "SELECT COALESCE(SUM(s.jumlah_kantong), 0) as total FROM stok_darah s 
                  WHERE DATE_FORMAT(s.tanggal_stok_datang, '%Y-%m') = '$bulan_filter' $stok_location_filter";
    $res_masuk = $conn->query($sql_masuk);
    $jumlah_masuk = (int) $res_masuk->fetch_assoc()["total"];

    $sql_keluar =
        "SELECT COALESCE(SUM(pd.jumlah_kantong), 0) as total FROM pengambilan_darah pd 
                   WHERE DATE_FORMAT(pd.tanggal_keluar, '%Y-%m') = '$bulan_filter' " .
        getLocationFilter($admin_location, "pd");
    $res_keluar = $conn->query($sql_keluar);
    $jumlah_keluar = (int) $res_keluar->fetch_assoc()["total"];

    $labels = [$bulan_label];
    $data_masuk = [$jumlah_masuk];
    $data_keluar = [$jumlah_keluar];
    $data_total = [$jumlah_masuk];
}

$labels = json_encode($labels);
$data_masuk = json_encode($data_masuk);
$data_keluar = json_encode($data_keluar);
$data_total = json_encode($data_total);

// -------- DATA GRAFIK PENDONOR BULANAN (PERBAIKAN) --------
$pendonor_labels = [];
$pendonor_data = [];

$filter_bulan = isset($_GET["filter_bulan"]) ? $_GET["filter_bulan"] : "semua";
$filter_konfirmasi = isset($_GET["filter_konfirmasi"])
    ? $_GET["filter_konfirmasi"]
    : "all";

// Filter konfirmasi
$konfirmasi_where = "";
if ($filter_konfirmasi !== "all") {
    $filter_konfirmasi_esc = $conn->real_escape_string($filter_konfirmasi);
    $konfirmasi_where = "AND konfirmasi = '$filter_konfirmasi_esc'";
}

// -------- DATA GRAFIK PENDONOR BULANAN - PERBAIKAN --------
// Filter lokasi untuk pendonor dengan alias tabel
$pendonor_location_filter = getLocationFilter($admin_location, "p");

// Jika filter bulan dipilih selain "semua", tampilkan data bulan tersebut saja
if ($filter_bulan && $filter_bulan !== "semua") {
    $filter_bulan_esc = $conn->real_escape_string($filter_bulan);

    // Query untuk bulan tertentu dengan alias tabel
    $sql_pendonor = "SELECT 
                        DATE_FORMAT(p.created_at, '%Y-%m-%d') as day,
                        DATE_FORMAT(p.created_at, '%d') as day_name,
                        COUNT(*) as total
                    FROM pengajuan p
                    WHERE DATE_FORMAT(p.created_at, '%Y-%m') = '$filter_bulan_esc'
                    $konfirmasi_where $pendonor_location_filter
                    GROUP BY DATE_FORMAT(p.created_at, '%Y-%m-%d'), DATE_FORMAT(p.created_at, '%d')
                    ORDER BY day ASC";

    $res_pendonor = $conn->query($sql_pendonor);
    $pendonor_by_day = [];

    while ($row = $res_pendonor->fetch_assoc()) {
        $pendonor_by_day[$row["day"]] = [
            "label" => $row["day_name"],
            "total" => (int) $row["total"],
        ];
    }

    // Buat array untuk semua hari dalam bulan tersebut
    $year_month = explode("-", $filter_bulan);
    $year = (int) $year_month[0];
    $month = (int) $year_month[1];
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    for ($day = 1; $day <= $days_in_month; $day++) {
        $day_key = sprintf("%s-%02d", $filter_bulan, $day);
        if (isset($pendonor_by_day[$day_key])) {
            $pendonor_labels[] = $day;
            $pendonor_data[] = $pendonor_by_day[$day_key]["total"];
        } else {
            $pendonor_labels[] = $day;
            $pendonor_data[] = 0;
        }
    }
} else {
    // Query untuk semua bulan dengan alias tabel
    $sql_pendonor = "SELECT 
                        DATE_FORMAT(p.created_at, '%Y-%m') as month,
                        DATE_FORMAT(p.created_at, '%b %Y') as month_name,
                        COUNT(*) as total
                    FROM pengajuan p
                    WHERE p.created_at BETWEEN '2025-01-01' AND '2025-06-30'
                    $konfirmasi_where $pendonor_location_filter
                    GROUP BY DATE_FORMAT(p.created_at, '%Y-%m'), DATE_FORMAT(p.created_at, '%b %Y')
                    ORDER BY month ASC";

    $res_pendonor = $conn->query($sql_pendonor);
    $pendonor_by_month = [];

    while ($row = $res_pendonor->fetch_assoc()) {
        $pendonor_by_month[$row["month"]] = [
            "label" => $row["month_name"],
            "total" => (int) $row["total"],
        ];
    }

    $target_months = [
        "2025-01" => "Jan 2025",
        "2025-02" => "Feb 2025",
        "2025-03" => "Mar 2025",
        "2025-04" => "Apr 2025",
        "2025-05" => "May 2025",
        "2025-06" => "June 2025",
    ];

    foreach ($target_months as $month => $month_name) {
        if (isset($pendonor_by_month[$month])) {
            $pendonor_labels[] = $pendonor_by_month[$month]["label"];
            $pendonor_data[] = $pendonor_by_month[$month]["total"];
        } else {
            $pendonor_labels[] = $month_name;
            $pendonor_data[] = 0;
        }
    }
}

$pendonor_labels_json = json_encode($pendonor_labels);
$pendonor_data_json = json_encode($pendonor_data);

// -------- STATISTIK DASHBOARD DENGAN FILTER LOKASI --------
$location_filter_stats = getLocationFilter($admin_location);

// Total pengajuan dengan alias tabel
$sql_total_pengajuan = "SELECT COUNT(*) as total FROM pengajuan  WHERE 1=1 $location_filter_stats";
$total_pengajuan = $conn->query($sql_total_pengajuan)->fetch_assoc()["total"];

// Pengajuan pending dengan alias tabel
$sql_pengajuan_pending = "SELECT COUNT(*) as total FROM pengajuan WHERE konfirmasi = 'pending' $location_filter_stats";
$pengajuan_pending = $conn->query($sql_pengajuan_pending)->fetch_assoc()[
    "total"
];

// Total stok dengan alias tabel
$sql_total_stok =
    "SELECT COALESCE(SUM(s.jumlah_kantong), 0) as total FROM stok_darah s WHERE 1=1 " .
    getLocationFilter($admin_location, "s");
$total_stok = $conn->query($sql_total_stok)->fetch_assoc()["total"];

// Total stok berdasarkan lokasi admin (menggunakan kolom lokasi)
$sql_total_stok = "SELECT COALESCE(SUM(jumlah_kantong), 0) as total FROM stok_darah WHERE 1=1 $location_filter_stats";
$total_stok = $conn->query($sql_total_stok)->fetch_assoc()["total"];

// Generate Pusher API key
$pusher_app_id = "1989886";
$pusher_key = "9160beb03fddb9b72bc6";
$pusher_secret = "1f8be6cbb35607f7e1c8";
$pusher_cluster = "ap1";

// Tampilkan informasi lokasi admin di dashboard (opsional)
$location_info = "";
if (!$is_super_admin) {
    $location_info = "<div class='alert alert-info'>
        <i class='bi bi-info-circle'></i> 
        Anda login sebagai: <strong>$username</strong> - Menampilkan data untuk: <strong>$admin_location</strong>
    </div>";
} else {
    $location_info = "<div class='alert alert-success'>
        <i class='bi bi-shield-check'></i> 
        Anda login sebagai: <strong>Super Admin</strong> - Menampilkan data seluruh wilayah
    </div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin PMI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Defer non-critical CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Reduced JS bundle size -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <!-- Pusher JS -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <style>
        body { 
            margin: 0; 
            padding: 0; 
            display: flex;
            background-color: #f5f5f5;
        }
        h1, h2, h3, .card-header, .btn {
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
}

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            border-right: 1px solid #dee2e6;
            z-index: 100;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        .notif-container {
            position: relative;
        }
        .notif-bell {
            cursor: pointer;
            position: relative;
        }
        .notif-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .notif-dropdown {
            position: absolute;
            top: 40px;
            right: 0;
            width: 300px;
            max-height: 300px;
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            display: none;
            z-index: 1000;
        }
        .notif-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .notif-item:last-child {
            border-bottom: none;
        }
        .notif-item small {
            color: #888;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        .card-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        .chart-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
        }
        .chart-box {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
        }
        @media (max-width: 1100px) {
            .chart-row {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            .main-content {
                margin-left: 60px;
                width: calc(100% - 60px);
            }
            .card-stats {
                grid-template-columns: 1fr;
            }
        }
        /* Efek loading */
        .chart-loading {
            position: relative;
            min-height: 200px;
        }
        .chart-loading::before {
            content: "Memuat grafik...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #777;
        }
        /* Animasi untuk notifikasi baru */
        @keyframes highlight {
            0% { background-color: rgba(220, 53, 69, 0.2); }
            100% { background-color: transparent; }
        }
        .notif-new {
            animation: highlight 2s ease-out;
        }
        /* Untuk Export Buttons */
        .export-buttons {
            text-align: right;
            margin-bottom: 10px;
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

<div class="sidebar">
    <?php include "sidebar.php"; ?>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Dashboard PMI</h2>
        
        <div class="notif-container">
            <div class="notif-bell" onclick="toggleNotif()">
                <img src="https://cdn-icons-png.flaticon.com/512/1827/1827349.png" width="30" alt="Notifikasi">
                <?php if (count($notif_list) > 0): ?>
                    <span class="notif-count" id="notifCount"><?= count(
                        $notif_list
                    ) ?></span>
                <?php else: ?>
                    <span class="notif-count" id="notifCount" style="display:none">0</span>
                <?php endif; ?>
            </div>
            <div class="notif-dropdown" id="notifDropdown">
                <div id="notifItems">
                    <?php if (count($notif_list) > 0): ?>
                        <?php foreach ($notif_list as $notif): ?>
                            <div class="notif-item"><?= $notif ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="notif-item">Tidak ada notifikasi baru</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="location-info">
            <i class="fas fa-map-marker-alt"></i>
            <strong>Lokasi Anda:</strong> <?= htmlspecialchars(
                getAdminLocationName()
            ) ?>
            <?php if (!isSuperAdmin()): ?>
                <small>(Data ditampilkan sesuai wilayah Anda)</small>
            <?php endif; ?>
        </div>
    <div class="dashboard-grid">
        <div class="card-stats">
        <div class="card bg-primary text-white">
    <div class="card-header fw-bold">Total Pengajuan Donor</div>
    <div class="card-body">
        <h5 class="card-title "><?= $total_pengajuan ?> Orang</h5>
    </div>
</div>

<div class="card bg-success text-white">
                <div class="card-header fw-bold">Total Stok Darah</div>
                <div class="card-body">
                    <h5 class="card-title "><?= $total_stok ?> Kantong</h5>
                </div>
            </div>
            <div class="card bg-warning text-white">
                <div class="card-header fw-bold">Pengajuan Pending</div>
                <div class="card-body">
                    <h5 class="card-title "><?= $pengajuan_pending ?> Permintaan</h5>
                </div>
            </div>
        </div>
        <div class="export-buttons">
            <a href="pdf_laporan.php" target="_blank" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
            <a href="excel_laporan.php" target="_blank" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel"></i> EXCEL
            </a>
        </div>
        <!-- Data Statistik heading moved up -->
        <h4>Data Statistik</h4>

        <!-- Combined filters in one row -->
<!-- Combined filters in one row -->
<div class="row mb-3">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
            <form method="GET" id="filterForm">
                <!-- Pertahankan filter pendonor yang sudah ada -->
                <input type="hidden" name="filter_bulan" value="<?= $filter_bulan ?>">
                <input type="hidden" name="filter_konfirmasi" value="<?= $filter_konfirmasi ?>">
                
                <label for="bulanSelect" class="form-label">Filter Grafik Donor Bulanan</label>
                <select id="bulanSelect" name="bulan" class="form-select" onchange="this.form.submit()">
                <option value="semua" <?= $bulan_terpilih == "semua"
                    ? "selected"
                    : "" ?>>Semua Bulan</option>
                <?php foreach ($bulan_array as $key => $label): ?>
                <option value="<?= $key ?>" <?= $key === $bulan_terpilih
    ? "selected"
    : "" ?>><?= $label ?></option>
                <?php endforeach; ?>
                </select>
                </form>
            </div>
            <div class="col-md-6">
                <label for="chartType" class="form-label">Jenis Data</label>
                <select id="chartType" class="form-select" onchange="updateChart()">
                    <option value="total">Total Darah Keseluruhan</option>
                    <option value="masuk">Total Darah Masuk</option>
                    <option value="keluar">Total Darah Keluar</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
<div class="row">
    <div class="col-md-6">
        <form method="GET" id="pendonorFilterForm">
            <!-- Pertahankan filter bulan dari grafik donor bulanan -->
            <input type="hidden" name="bulan" value="<?= $bulan_terpilih ?>">
            
            <label for="filter_bulan" class="form-label">Filter Grafik Pendonor</label>
            <select name="filter_bulan" id="filter_bulan" class="form-select" onchange="this.form.submit()">
                <option value="semua" <?= $filter_bulan == "semua"
                    ? "selected"
                    : "" ?>>Semua Bulan</option>
                <?php foreach ($bulan_array as $key => $val): ?>
                    <option value="<?= $key ?>" <?= $filter_bulan == $key
    ? "selected"
    : "" ?>>
                        <?= $val ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <div class="col-md-6">
        <form method="GET" id="konfirmasiFilterForm">
            <!-- Pertahankan filter bulan dari grafik donor bulanan dan filter bulan pendonor -->
            <input type="hidden" name="bulan" value="<?= $bulan_terpilih ?>">
            <input type="hidden" name="filter_bulan" value="<?= $filter_bulan ?>">
            
            <label for="filter_konfirmasi" class="form-label">Status Konfirmasi</label>
            <select name="filter_konfirmasi" id="filter_konfirmasi" class="form-select" onchange="this.form.submit()">
                <option value="all" <?= $filter_konfirmasi == "all"
                    ? "selected"
                    : "" ?>>Semua</option>
                <option value="sukses" <?= $filter_konfirmasi == "sukses"
                    ? "selected"
                    : "" ?>>Diterima</option>
                <option value="gagal" <?= $filter_konfirmasi == "gagal"
                    ? "selected"
                    : "" ?>>Ditolak</option>
            </select>
        </form>
    </div>
</div>
</div>


        <div class="chart-row">
            <div class="chart-box">
                <h5>Grafik Donor Bulanan</h5>
                <div class="chart-loading">
                    <canvas id="activityChart" height="300"></canvas>
                </div>
            </div>
            <div class="chart-box">
                <h5>Grafik Pendonor</h5>
                <div class="chart-loading">
                    <canvas id="pendonorChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Inisialisasi Pusher
const pusher = new Pusher('<?= $pusher_key ?>', {
    cluster: '<?= $pusher_cluster ?>',
    encrypted: true
});

// Subscribe ke channel notifikasi PMI
const channel = pusher.subscribe('pmi-notifications');

// Menangani event notifikasi baru
channel.bind('new-notification', function(data) {
    // Update counter
    const countElement = document.getElementById('notifCount');
    let currentCount = parseInt(countElement.textContent || '0');
    currentCount++;
    countElement.textContent = currentCount;
    countElement.style.display = 'flex';
    
    // Tambahkan notifikasi baru ke dropdown
    const notifItems = document.getElementById('notifItems');
    const newNotif = document.createElement('div');
    newNotif.className = 'notif-item notif-new';
    newNotif.innerHTML = `<strong>${data.sumber}</strong>: ${data.isi}<br><small class="text-muted">${data.waktu}</small>`;
    
    // Tambahkan ke awal list
    if (notifItems.firstChild) {
        notifItems.insertBefore(newNotif, notifItems.firstChild);
    } else {
        notifItems.appendChild(newNotif);
    }
    
    // Hapus pesan "tidak ada notifikasi" jika ada
    const noNotif = notifItems.querySelector('.notif-item');
    if (noNotif && noNotif.textContent === 'Tidak ada notifikasi baru') {
        notifItems.removeChild(noNotif);
    }
    
    // Tampilkan notifikasi toast
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: `${data.sumber}: ${data.isi}`,
        showConfirmButton: false,
        timer: 5000
    });
});

// Lazy load charts untuk performa lebih baik
document.addEventListener('DOMContentLoaded', function() {
    // Grafik Donor Bulanan 
    setTimeout(() => {
        initActivityChart();
    }, 100);
    
    // Grafik Pendonor Bulanan
    setTimeout(() => {
        initPendonorChart();
    }, 200);
});

function initActivityChart() {
    const labels = <?= $labels ?>;
    const dataMasuk = <?= $data_masuk ?>;
    const dataKeluar = <?= $data_keluar ?>;
    const dataTotal = <?= $data_total ?>;

    const ctx = document.getElementById('activityChart').getContext('2d');
    window.activityChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Darah Keseluruhan',
                data: dataTotal,
                backgroundColor: 'rgba(220, 53, 69, 0.5)',
                borderColor: '#dc3545',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#000' }
                },
                x: {
                    ticks: { color: '#000' }
                }
            },
            plugins: { 
                legend: { display: true },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            }
        }
    });
    
    // Hapus kelas loading
    document.getElementById('activityChart').parentElement.classList.remove('chart-loading');
}

function initPendonorChart() {
    const pendonorLabels = <?= $pendonor_labels_json ?>;
    const pendonorData = <?= $pendonor_data_json ?>;

    const ctxPendonor = document.getElementById('pendonorChart').getContext('2d');
    window.pendonorChart = new Chart(ctxPendonor, {
        type: 'line',
        data: {
            labels: pendonorLabels,
            datasets: [{
                label: 'Jumlah Pendonor',
                data: pendonorData,
                fill: false,
                borderColor: '#20c997',
                tension: 0.1,
                backgroundColor: 'rgba(32, 201, 151, 0.5)',
                pointBackgroundColor: '#20c997',
                pointBorderColor: '#fff',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        color: '#000',
                        stepSize: 1 // Untuk menampilkan angka bulat
                    }
                },
                x: {
                    ticks: { color: '#000' }
                }
            },
            plugins: { 
                legend: { display: true },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(context) {
                            // Jika menampilkan per hari, tambahkan info bulan
                            const filterBulan = '<?= $filter_bulan ?>';
                            if (filterBulan && filterBulan !== 'semua') {
                                const bulanNama = <?= json_encode(
                                    $bulan_array
                                ) ?>[filterBulan];
                                return `Tanggal ${context[0].label} ${bulanNama}`;
                            }
                            return context[0].label;
                        }
                    }
                }
            }
        }
    });
    
    // Hapus kelas loading
    document.getElementById('pendonorChart').parentElement.classList.remove('chart-loading');
}


function updateChart() {
    if (!window.activityChart) return;
    
    const value = document.getElementById('chartType').value;
    let newData = [], newLabel = '';
    
    if (value === 'masuk') {
        newData = <?= $data_masuk ?>;
        newLabel = 'Total Darah Masuk';
    } else if (value === 'keluar') {
        newData = <?= $data_keluar ?>;
        newLabel = 'Total Darah Keluar';
    } else {
        newData = <?= $data_total ?>;
        newLabel = 'Total Darah Keseluruhan';
    }
    
    window.activityChart.data.datasets[0].data = newData;
    window.activityChart.data.datasets[0].label = newLabel;
    window.activityChart.update('none'); // 'none' untuk animasi yang lebih cepat
}



// Fungsi toggle notifikasi
function toggleNotif() {
    const dropdown = document.getElementById("notifDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

// Tutup dropdown notifikasi jika klik di luar
window.onclick = function(event) {
    const dropdown = document.getElementById("notifDropdown");
    const bell = document.querySelector('.notif-bell img');
    if (!event.target.matches('.notif-bell') && event.target !== bell) {
        dropdown.style.display = "none";
    }
}
</script>
<?php if (isset($_SESSION["login_success"])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Login',
            text: <?= json_encode(
                $_SESSION["is_super_admin"]
                    ? "Anda login sebagai Super Admin. Anda dapat mengakses semua data di wilayah Tapal Kuda."
                    : "Anda login sebagai Admin. Anda hanya dapat mengelola data sesuai lokasi Anda."
            ) ?>,
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION["login_success"]); ?>
<?php endif; ?>

</body>
</html>