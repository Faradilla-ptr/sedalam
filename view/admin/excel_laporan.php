<?php
session_start();
require "../../admin_filter_helper.php"; // Tambahkan helper filter
date_default_timezone_set("Asia/Jakarta");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan admin sudah login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die("Akses ditolak. Harap login sebagai admin terlebih dahulu.");
}

// Ambil informasi lokasi admin
$admin_location = $_SESSION["admin_location"] ?? "ALL";
$is_super_admin = isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"];

// Dapatkan filter berdasarkan lokasi admin
$location_filter_pengajuan = getLocationFilter($admin_location, "p");
$location_filter_stok = getLocationFilter($admin_location, "s");
$location_filter_pengambilan = getLocationFilter($admin_location, "pd");

// Nama file berdasarkan lokasi
$filename = $is_super_admin ? 
    "laporan_stok_darah_semua_lokasi_" . date("Y-m-d") . ".xls" : 
    "laporan_stok_darah_" . str_replace(" ", "_", strtolower($admin_location)) . "_" . date("Y-m-d") . ".xls";

// Set header untuk download file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data statistik dengan filter lokasi
$total_pengajuan = $conn
    ->query("SELECT COUNT(*) as total FROM pengajuan p WHERE 1=1 $location_filter_pengajuan")
    ->fetch_assoc()["total"];

$total_terima = $conn
    ->query("SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi = 'sukses' $location_filter_pengajuan")
    ->fetch_assoc()["total"];

$total_tolak = $conn
    ->query("SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi = 'gagal' $location_filter_pengajuan")
    ->fetch_assoc()["total"];

// Menggunakan nama kolom yang benar sesuai database
$total_darah_masuk = $conn
    ->query("SELECT SUM(jumlah_kantong) as total FROM stok_darah s WHERE 1=1 $location_filter_stok")
    ->fetch_assoc()["total"] ?: 0;

$total_darah_keluar = $conn
    ->query("SELECT SUM(jumlah_kantong) as total FROM pengambilan_darah pd WHERE 1=1 $location_filter_pengambilan")
    ->fetch_assoc()["total"] ?: 0;

$stok_golongan = [];
$golongan = ["A", "B", "AB", "O"];
foreach ($golongan as $g) {
    $res = $conn
        ->query("SELECT SUM(jumlah_kantong) as total FROM stok_darah s WHERE golongan_darah = '$g' $location_filter_stok")
        ->fetch_assoc()["total"];
    $stok_golongan[$g] = $res ?: 0;
}

// Mulai output Excel
echo "<table border='1' style='border-collapse: collapse;'>";

// Header utama
echo "<tr><th colspan='4' style='background-color: #4CAF50; color: white; font-size: 16px; font-weight: bold;'>LAPORAN STATISTIK DONOR DARAH</th></tr>";

// Info lokasi dan tanggal
if ($is_super_admin) {
    echo "<tr><td colspan='4' style='background-color: #f2f2f2; font-weight: bold;'>Lokasi: Semua Lokasi PMI (Super Admin)</td></tr>";
} else {
    echo "<tr><td colspan='4' style='background-color: #f2f2f2; font-weight: bold;'>Lokasi: {$admin_location}</td></tr>";
}
echo "<tr><td colspan='4'>Tanggal Laporan: " . date("d-m-Y H:i:s") . "</td></tr>";
echo "<tr><td colspan='4'></td></tr>";

// Statistik Umum
echo "<tr><th colspan='4' style='background-color: #2196F3; color: white;'>A. STATISTIK UMUM</th></tr>";
echo "<tr><td style='width: 40%;'>Total Pengajuan Donor Darah</td><td style='width: 5%;'>:</td><td style='width: 25%;'>{$total_pengajuan} orang</td><td style='width: 30%;'></td></tr>";
echo "<tr><td>Pengajuan Diterima</td><td>:</td><td style='color: green; font-weight: bold;'>{$total_terima} orang</td><td></td></tr>";
echo "<tr><td>Pengajuan Ditolak</td><td>:</td><td style='color: red; font-weight: bold;'>{$total_tolak} orang</td><td></td></tr>";

echo "<tr><td colspan='4'></td></tr>";

// Statistik Darah
echo "<tr><th colspan='4' style='background-color: #FF9800; color: white;'>B. STATISTIK DARAH</th></tr>";
echo "<tr><td>Total Darah Masuk</td><td>:</td><td style='color: blue; font-weight: bold;'>{$total_darah_masuk} kantong</td><td></td></tr>";
echo "<tr><td>Total Darah Keluar</td><td>:</td><td style='color: orange; font-weight: bold;'>{$total_darah_keluar} kantong</td><td></td></tr>";
echo "<tr><td>Stok Darah Saat Ini</td><td>:</td><td style='color: purple; font-weight: bold;'>" .
    ($total_darah_masuk - $total_darah_keluar) .
    " kantong</td><td></td></tr>";

foreach ($stok_golongan as $gol => $jumlah) {
    $color = $jumlah > 0 ? "green" : "red";
    echo "<tr><td>&nbsp;&nbsp;&nbsp;- Golongan $gol</td><td>:</td><td style='color: $color; font-weight: bold;'>$jumlah kantong</td><td></td></tr>";
}

echo "<tr><td colspan='4'></td></tr>";

// Rincian Stok Darah Detail
echo "<tr><th colspan='4' style='background-color: #9C27B0; color: white;'>C. RINCIAN STOK DARAH DETAIL</th></tr>";
echo "<tr>
        <th style='background-color: #E1BEE7;'>No</th>
        <th style='background-color: #E1BEE7;'>Golongan Darah</th>
        <th style='background-color: #E1BEE7;'>Rhesus</th>
        <th style='background-color: #E1BEE7;'>Jumlah (kantong)</th>
      </tr>";

if ($is_super_admin) {
    echo "<tr>
            <th style='background-color: #E1BEE7;'>Lokasi</th>
            <th style='background-color: #E1BEE7;'>Tanggal Update</th>
            <th style='background-color: #E1BEE7;'>Status</th>
            <th style='background-color: #E1BEE7;'>Keterangan</th>
          </tr>";
}

$query = "SELECT * FROM stok_darah s WHERE 1=1 $location_filter_stok ORDER BY golongan_darah, rhesus, created_at DESC";
$result = $conn->query($query);
$no = 1;
$total_all_stok = 0;

while ($row = $result->fetch_assoc()) {
    $total_all_stok += $row["jumlah_kantong"];
    $status = $row["jumlah_kantong"] > 10 ? "Aman" : ($row["jumlah_kantong"] > 5 ? "Perlu Perhatian" : "Kritis");
    $status_color = $row["jumlah_kantong"] > 10 ? "green" : ($row["jumlah_kantong"] > 5 ? "orange" : "red");
    
    if ($is_super_admin) {
        echo "<tr>
                <td>{$no}</td>
                <td style='text-align: center; font-weight: bold;'>{$row["golongan_darah"]}</td>
                <td style='text-align: center;'>{$row["rhesus"]}</td>
                <td style='text-align: center; color: $status_color; font-weight: bold;'>{$row["jumlah_kantong"]}</td>
              </tr>";
        echo "<tr>
                <td>{$row["lokasi"]}</td>
                <td>" . date("d/m/Y", strtotime($row["created_at"])) . "</td>
                <td style='color: $status_color; font-weight: bold;'>$status</td>
                <td>" . ($row["keterangan"] ?? "-") . "</td>
              </tr>";
    } else {
        echo "<tr>
                <td>{$no}</td>
                <td style='text-align: center; font-weight: bold;'>{$row["golongan_darah"]}</td>
                <td style='text-align: center;'>{$row["rhesus"]}</td>
                <td style='text-align: center; color: $status_color; font-weight: bold;'>{$row["jumlah_kantong"]}</td>
              </tr>";
    }
    $no++;
}

// Total summary
echo "<tr><td colspan='4'></td></tr>";
echo "<tr><th colspan='3' style='background-color: #607D8B; color: white;'>TOTAL KESELURUHAN STOK</th><th style='background-color: #607D8B; color: white; font-size: 14px;'>{$total_all_stok} kantong</th></tr>";

echo "<tr><td colspan='4'></td></tr>";

// Tambahan: Data Pengajuan Terbaru
echo "<tr><th colspan='4' style='background-color: #795548; color: white;'>D. PENGAJUAN TERBARU (10 DATA TERAKHIR)</th></tr>";
echo "<tr>
        <th style='background-color: #D7CCC8;'>No</th>
        <th style='background-color: #D7CCC8;'>Nama Pendonor</th>
        <th style='background-color: #D7CCC8;'>Tanggal Pengajuan</th>
        <th style='background-color: #D7CCC8;'>Status</th>
      </tr>";

if ($is_super_admin) {
    echo "<tr>
            <th style='background-color: #D7CCC8;'>Lokasi</th>
            <th style='background-color: #D7CCC8;'>Telepon</th>
            <th style='background-color: #D7CCC8;'>Golongan Darah</th>
            <th style='background-color: #D7CCC8;'>Catatan</th>
          </tr>";
}

$pengajuan_query = "SELECT p.*, a.nama as nama_pendonor, a.telepon, a.golongan_darah 
                    FROM pengajuan p 
                    LEFT JOIN akun a ON p.id_pendonor = a.id 
                    WHERE 1=1 $location_filter_pengajuan 
                    ORDER BY p.created_at DESC 
                    LIMIT 10";
$pengajuan_result = $conn->query($pengajuan_query);
$no = 1;

while ($row = $pengajuan_result->fetch_assoc()) {
    $status_color = $row["konfirmasi"] == "sukses" ? "green" : ($row["konfirmasi"] == "pending" ? "orange" : "red");
    
    if ($is_super_admin) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row["nama_pendonor"]}</td>
                <td>" . date("d/m/Y", strtotime($row["created_at"])) . "</td>
                <td style='color: $status_color; font-weight: bold;'>" . strtoupper($row["konfirmasi"]) . "</td>
              </tr>";
        echo "<tr>
                <td>{$row["lokasi"]}</td>
                <td>{$row["telepon"]}</td>
                <td>{$row["golongan_darah"]}</td>
                <td>" . ($row["catatan"] ?? "-") . "</td>
              </tr>";
    } else {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row["nama_pendonor"]}</td>
                <td>" . date("d/m/Y", strtotime($row["created_at"])) . "</td>
                <td style='color: $status_color; font-weight: bold;'>" . strtoupper($row["konfirmasi"]) . "</td>
              </tr>";
    }
    $no++;
}

echo "<tr><td colspan='4'></td></tr>";

// Footer
echo "<tr><td colspan='4' style='background-color: #f2f2f2; font-style: italic; text-align: center;'>Laporan dibuat otomatis pada: " . date("d-m-Y H:i:s") . "</td></tr>";

if ($is_super_admin) {
    echo "<tr><td colspan='4' style='background-color: #f2f2f2; font-style: italic; text-align: center;'>Dibuat oleh: Super Admin (Akses Semua Lokasi)</td></tr>";
} else {
    echo "<tr><td colspan='4' style='background-color: #f2f2f2; font-style: italic; text-align: center;'>Dibuat oleh: Admin {$admin_location}</td></tr>";
}

echo "<tr><td colspan='4' style='background-color: #f2f2f2; font-style: italic; text-align: center;'>Sistem Donor Darah PMI | www.pmijember.or.id</td></tr>";

echo "</table>";

$conn->close();
?>