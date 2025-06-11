<?php
session_start();
require "../../lib/fpdf.php"; // sesuaikan path
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
if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] !== "admin"
) {
    die("Akses ditolak. Harap login sebagai admin terlebih dahulu.");
}

// Ambil informasi lokasi admin
$admin_location = $_SESSION["admin_location"] ?? "ALL";
$is_super_admin =
    isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"];

// Dapatkan filter berdasarkan lokasi admin
$location_filter_pengajuan = getLocationFilter($admin_location, "p");
$location_filter_stok = getLocationFilter($admin_location, "s");
$location_filter_pengambilan = getLocationFilter($admin_location, "pd");

// Ambil data statistik dengan filter lokasi
$total_pengajuan = $conn
    ->query(
        "SELECT COUNT(*) as total FROM pengajuan p WHERE 1=1 $location_filter_pengajuan"
    )
    ->fetch_assoc()["total"];

$total_terima = $conn
    ->query(
        "SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi = 'sukses' $location_filter_pengajuan"
    )
    ->fetch_assoc()["total"];

$total_tolak = $conn
    ->query(
        "SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi = 'gagal' $location_filter_pengajuan"
    )
    ->fetch_assoc()["total"];

// Menggunakan nama kolom yang benar sesuai database
$total_darah_masuk =
    $conn
        ->query(
            "SELECT SUM(jumlah_kantong) as total FROM stok_darah s WHERE 1=1 $location_filter_stok"
        )
        ->fetch_assoc()["total"] ?:
    0;

$total_darah_keluar =
    $conn
        ->query(
            "SELECT SUM(jumlah_kantong) as total FROM pengambilan_darah pd WHERE 1=1 $location_filter_pengambilan"
        )
        ->fetch_assoc()["total"] ?:
    0;

$stok_golongan = [];
$golongan = ["A", "B", "AB", "O"];
foreach ($golongan as $g) {
    $res = $conn
        ->query(
            "SELECT SUM(jumlah_kantong) as total FROM stok_darah s WHERE golongan_darah = '$g' $location_filter_stok"
        )
        ->fetch_assoc()["total"];
    $stok_golongan[$g] = $res ?: 0;
}

class PDF_Generator extends FPDF
{
    private $admin_location;
    private $is_super_admin;

    function __construct($admin_location = "", $is_super_admin = false)
    {
        parent::__construct();
        $this->admin_location = $admin_location;
        $this->is_super_admin = $is_super_admin;
    }

    function Header()
    {
        $this->Image("../../assets/logo_sedalam.png", 10, 10, 20); // Sesuaikan path logo
        $this->SetFont("Arial", "B", 14);
        $this->Cell(30);
        $this->Cell(130, 7, "PALANG MERAH INDONESIA (PMI)", 0, 1, "C");
        $this->SetFont("Arial", "", 12);
        $this->Cell(30);

        // Tampilkan lokasi berdasarkan admin
        if ($this->is_super_admin) {
            $this->Cell(130, 6, "Semua Lokasi (Super Admin)", 0, 1, "C");
        } else {
            $this->Cell(130, 6, $this->admin_location, 0, 1, "C");
        }

        $this->Cell(30);
        $this->Cell(
            130,
            6,
            "Jl. Jawa No.57, Sumbersari, Jember | Telp: (0331) 412-891",
            0,
            1,
            "C"
        );
        $this->Cell(30);
        $this->Cell(
            130,
            6,
            "Email: pmi@jember.or.id | Website: www.pmijember.or.id",
            0,
            1,
            "C"
        );

        $this->Ln(5);
        $this->SetLineWidth(1);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->SetLineWidth(0.1);
        $this->Ln(10);
    }

    function BodyContent($data)
    {
        extract($data);

        $this->SetFont("Arial", "B", 14);
        $this->Cell(0, 10, "LAPORAN STATISTIK DONOR DARAH", 0, 1, "C");
        $this->SetFont("Arial", "", 12);

        // Tambahkan keterangan filter lokasi
        if ($this->is_super_admin) {
            $this->Cell(
                0,
                10,
                "Laporan Komprehensif - Semua Lokasi PMI",
                0,
                1,
                "C"
            );
        } else {
            $this->Cell(
                0,
                10,
                "Laporan Lokasi: " . $this->admin_location,
                0,
                1,
                "C"
            );
        }

        $this->Cell(
            0,
            10,
            "Berikut ini adalah ringkasan kegiatan dan stok darah yang tercatat dalam sistem",
            0,
            1,
            "C"
        );
        $this->Ln(10);

        $this->SetFont("Arial", "B", 12);
        $this->Cell(0, 10, "A. STATISTIK UMUM", 0, 1);
        $this->SetFont("Arial", "", 12);

        $this->Cell(70, 8, "Total Pengajuan Donor Darah", 0, 0);
        $this->Cell(5, 8, ":", 0, 0);
        $this->Cell(50, 8, $total_pengajuan . " orang", 0, 1);

        $this->Cell(70, 8, "Pengajuan Diterima", 0, 0);
        $this->Cell(5, 8, ":", 0, 0);
        $this->Cell(50, 8, $total_terima . " orang", 0, 1);

        $this->Cell(70, 8, "Pengajuan Ditolak", 0, 0);
        $this->Cell(5, 8, ":", 0, 0);
        $this->Cell(50, 8, $total_tolak . " orang", 0, 1);

        $this->Ln(5);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(0, 10, "B. STATISTIK DARAH", 0, 1);
        $this->SetFont("Arial", "", 12);

        $this->Cell(70, 8, "Total Darah Masuk", 0, 0);
        $this->Cell(5, 8, ":", 0, 0);
        $this->Cell(50, 8, $total_darah_masuk . " kantong", 0, 1);

        $this->Cell(70, 8, "Total Darah Keluar", 0, 0);
        $this->Cell(5, 8, ":", 0, 0);
        $this->Cell(50, 8, $total_darah_keluar . " kantong", 0, 1);

        $this->Cell(70, 8, "Stok Darah Saat Ini (Total)", 0, 0);
        $this->Cell(5, 8, ":", 0, 0);
        $this->Cell(
            50,
            8,
            $total_darah_masuk - $total_darah_keluar . " kantong",
            0,
            1
        );

        foreach ($stok_golongan as $gol => $jumlah) {
            $this->Cell(70, 8, "- Golongan $gol", 0, 0);
            $this->Cell(5, 8, ":", 0, 0);
            $this->Cell(50, 8, $jumlah . " kantong", 0, 1);
        }

        // Tambahan: Detail stok darah per rhesus
        $this->Ln(5);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(0, 10, "C. RINCIAN STOK DARAH DETAIL", 0, 1);
        $this->SetFont("Arial", "", 10);

        // Header tabel
        $this->Cell(15, 8, "No", 1, 0, "C");
        $this->Cell(40, 8, "Gol. Darah", 1, 0, "C");
        $this->Cell(30, 8, "Rhesus", 1, 0, "C");
        $this->Cell(35, 8, "Jumlah", 1, 0, "C");
        $this->Cell(40, 8, "Lokasi", 1, 0, "C");
        $this->Cell(30, 8, "Tgl Update", 1, 1, "C");

        // Data stok detail
        global $conn, $location_filter_stok;
        $query = "SELECT * FROM stok_darah s WHERE 1=1 $location_filter_stok ORDER BY golongan_darah, rhesus, created_at DESC";
        $result = $conn->query($query);
        $no = 1;

        while ($row = $result->fetch_assoc()) {
            $this->Cell(15, 6, $no, 1, 0, "C");
            $this->Cell(40, 6, $row["golongan_darah"], 1, 0, "C");
            $this->Cell(30, 6, $row["rhesus"], 1, 0, "C");
            $this->Cell(35, 6, $row["jumlah_kantong"] . " kantong", 1, 0, "C");
            $this->Cell(
                40,
                6,
                substr($row["lokasi"], 0, 15) . "...",
                1,
                0,
                "C"
            );
            $this->Cell(
                30,
                6,
                date("d/m/Y", strtotime($row["created_at"])),
                1,
                1,
                "C"
            );
            $no++;

            // Cek jika perlu halaman baru
            if ($this->GetY() > 250) {
                $this->AddPage();
                $this->SetFont("Arial", "", 10);
                // Ulangi header tabel
                $this->Cell(15, 8, "No", 1, 0, "C");
                $this->Cell(40, 8, "Gol. Darah", 1, 0, "C");
                $this->Cell(30, 8, "Rhesus", 1, 0, "C");
                $this->Cell(35, 8, "Jumlah", 1, 0, "C");
                $this->Cell(40, 8, "Lokasi", 1, 0, "C");
                $this->Cell(30, 8, "Tgl Update", 1, 1, "C");
            }
        }

        $this->Ln(10);
        $this->SetFont("Arial", "I", 10);
        $this->Cell(
            0,
            10,
            "Laporan ini dibuat otomatis pada: " . date("d-m-Y H:i:s"),
            0,
            1,
            "R"
        );

        if ($this->is_super_admin) {
            $this->Cell(
                0,
                5,
                "Dibuat oleh: Super Admin (Akses Semua Lokasi)",
                0,
                1,
                "R"
            );
        } else {
            $this->Cell(
                0,
                5,
                "Dibuat oleh: Admin " . $this->admin_location,
                0,
                1,
                "R"
            );
        }
    }

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont("Arial", "I", 8);
        $this->Cell(
            0,
            8,
            "Laporan Sistem Donor Darah | www.pmijember.or.id",
            0,
            1,
            "C"
        );
        $this->Cell(0, 8, "Halaman " . $this->PageNo() . "/{nb}", 0, 0, "C");
    }
}

// Data untuk dikirim ke PDF
$data = [
    "total_pengajuan" => $total_pengajuan,
    "total_terima" => $total_terima,
    "total_tolak" => $total_tolak,
    "total_darah_masuk" => $total_darah_masuk,
    "total_darah_keluar" => $total_darah_keluar,
    "stok_golongan" => $stok_golongan,
];

// Generate PDF
$pdf = new PDF_Generator($admin_location, $is_super_admin);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BodyContent($data);

// Nama file berdasarkan lokasi
$filename = $is_super_admin
    ? "Laporan_Donor_Darah_Semua_Lokasi_" . date("Y-m-d") . ".pdf"
    : "Laporan_Donor_Darah_" .
        str_replace(" ", "_", $admin_location) .
        "_" .
        date("Y-m-d") .
        ".pdf";

$pdf->Output("D", $filename);
?>
