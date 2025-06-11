<?php
// admin_filter_helper.php
// File helper untuk memfilter data berdasarkan lokasi admin

/**
 * Fungsi untuk mendapatkan kondisi WHERE berdasarkan lokasi admin untuk tabel dengan kolom lokasi
 * @param string $admin_location - lokasi admin yang sedang login
 * @param string $table_alias - alias tabel yang akan difilter
 * @return string - kondisi WHERE untuk query
 */
function getLocationFilter($admin_location, $table_alias = "")
{
    $where_condition = "";

    if (isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"]) {
        // Super admin dapat melihat semua data
        return $where_condition;
    }

    if ($admin_location && $admin_location !== "ALL") {
        $table_prefix = $table_alias ? $table_alias . "." : "";
        $where_condition =
            " AND {$table_prefix}lokasi = '" .
            mysqli_real_escape_string($GLOBALS["conn"], $admin_location) .
            "'";
    }

    return $where_condition;
}

/**
 * Fungsi untuk mendapatkan kondisi WHERE berdasarkan alamat untuk tabel akun
 * @param string $admin_location - lokasi admin yang sedang login
 * @param string $table_alias - alias tabel yang akan difilter
 * @return string - kondisi WHERE untuk query
 */
function getAlamatFilter($admin_location, $table_alias = "")
{
    $where_condition = "";

    if (isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"]) {
        // Super admin dapat melihat semua data
        return $where_condition;
    }

    if ($admin_location && $admin_location !== "ALL") {
        $table_prefix = $table_alias ? $table_alias . "." : "";

        // Mapping lokasi admin ke kata kunci alamat
        $location_keywords = getLocationKeywords($admin_location);

        if (!empty($location_keywords)) {
            $alamat_conditions = [];
            foreach ($location_keywords as $keyword) {
                $escaped_keyword = mysqli_real_escape_string(
                    $GLOBALS["conn"],
                    $keyword
                );
                $alamat_conditions[] = "{$table_prefix}alamat LIKE '%$escaped_keyword%'";
            }
            $where_condition =
                " AND (" . implode(" OR ", $alamat_conditions) . ")";
        }
    }

    return $where_condition;
}

/**
 * Fungsi untuk mendapatkan kata kunci alamat berdasarkan lokasi admin
 * @param string $admin_location - lokasi admin
 * @return array - array kata kunci untuk filter alamat
 */
function getLocationKeywords($admin_location)
{
    $keywords = [];

    switch ($admin_location) {
        case "UDD PMI Kabupaten Probolinggo":
            $keywords = [
                "probolinggo",
                "kraksaan",
                "tongas",
                "tegalsiwalan",
                "bantaran",
                "pakuniran",
                "kotaanyar",
                "paiton",
                "besuk",
                "krucil",
                "gending",
                "wonomarto",
                "kuripan",
                "leces",
                "banyuanyar",
                "tiris",
                "maron",
                "dringu",
                "wongsorejo",
                "gading",
                "pajarakan",
                "krejengan",
                "sumber",
            ];
            break;

        case "UDD PMI Kota Probolinggo":
            $keywords = [
                "probolinggo",
                "kademangan",
                "kanigaran",
                "kedopok",
                "mayangan",
                "wonoasih",
            ];
            break;

        case "UDD PMI Kabupaten Lumajang":
            $keywords = [
                "lumajang",
                "sukodono",
                "klakah",
                "senduro",
                "pronojiwo",
                "candipuro",
                "tekung",
                "kunir",
                "yosowilangun",
                "tempursari",
                "lumajang",
                "gucialit",
                "jatiroto",
                "sumbersuko",
                "pasrujambe",
                "padang",
                "kedungjajang",
                "ranuyoso",
                "tempeh",
                "randuagung",
            ];
            break;

        case "UDD PMI Kabupaten Jember":
            $keywords = [
                "jember",
                "kalisat",
                "ledokombo",
                "silo",
                "mayang",
                "mumbulsari",
                "jenggawah",
                "ajung",
                "rambipuji",
                "balung",
                "umbulsari",
                "semboro",
                "jombang",
                "panti",
                "sukorambi",
                "arjasa",
                "pakusari",
                "kencong",
                "gumukmas",
                "puger",
                "wuluhan",
                "ambulu",
                "tempurejo",
                "sumberjambe",
                "sumberbaru",
                "tanggul",
                "bangsalsari",
                "panti",
                "sukowono",
                "jelbuk",
                "kaliwates",
                "sumbersari",
                "patrang",
            ];
            break;

        case "UDD PMI Kabupaten Bondowoso":
            $keywords = [
                "bondowoso",
                "sukosari",
                "grujugan",
                "jambesari",
                "curahdami",
                "tegalampel",
                "maesan",
                "tamanan",
                "wonosari",
                "wringin",
                "tenggarang",
                "binakal",
                "tapen",
                "sumberwringin",
                "prajekan",
                "kota bondowoso",
                "klabang",
                "sempol",
                "botolinggo",
                "tlogosari",
                "pakem",
                "cermee",
            ];
            break;

        case "UDD PMI Kabupaten Situbondo":
            $keywords = [
                "situbondo",
                "panarukan",
                "situbondo",
                "mangaran",
                "kendit",
                "arjasa",
                "jangkar",
                "asembagus",
                "bungatan",
                "kapongan",
                "sapeken",
                "sumbermalang",
                "besuki",
                "suboh",
                "mlandingan",
                "banyuputih",
                "jatibanteng",
                "banyuglugur",
            ];
            break;

        case "UDD PMI Kabupaten Banyuwangi":
            $keywords = [
                "banyuwangi",
                "genteng",
                "srono",
                "rogojampi",
                "kabat",
                "singojuruh",
                "sempu",
                "songgon",
                "muncar",
                "cluring",
                "gambiran",
                "tegaldlimo",
                "purwoharjo",
                "tegalsari",
                "wongsorejo",
                "glagah",
                "kalibaru",
                "banyuwangi",
                "giri",
                "kalipuro",
                "siliragung",
                "bangorejo",
                "pesanggaran",
                "licin",
            ];
            break;

        default:
            $keywords = [];
            break;
    }

    return $keywords;
}

/**
 * Fungsi untuk mendapatkan data pengajuan dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @param string $additional_where - kondisi WHERE tambahan
 * @return mysqli_result - hasil query
 */
function getFilteredPengajuan($conn, $additional_where = "")
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p");

    $query = "SELECT p.*, a.nama as nama_pendonor, a.telepon 
              FROM pengajuan p 
              LEFT JOIN akun a ON p.id_pendonor = a.id 
              WHERE 1=1 $location_filter $additional_where 
              ORDER BY p.id DESC, p.created_at DESC"; // Tambahkan ORDER BY id DESC untuk data terbaru

    return mysqli_query($conn, $query);
}

/**
 * Fungsi untuk mendapatkan data akun dengan filter alamat
 * @param mysqli $conn - koneksi database
 * @param string $additional_where - kondisi WHERE tambahan
 * @return mysqli_result - hasil query
 */
function getFilteredAkun($conn, $additional_where = "")
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $alamat_filter = getAlamatFilter($admin_location, "a");

    $query = "SELECT * FROM akun a 
              WHERE 1=1 $alamat_filter $additional_where 
              ORDER BY a.id DESC, a.created_at DESC"; // Tambahkan ORDER BY id DESC untuk data terbaru

    return mysqli_query($conn, $query);
}
/**
 * Fungsi untuk mendapatkan jumlah pengajuan pending dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @return int - jumlah pengajuan pending
 */
function getPendingPengajuanCount($conn)
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p");

    $query = "SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi = 'pending' $location_filter";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result)["total"];
}
/**
 * Fungsi untuk mendapatkan data stok darah dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @param string $additional_where - kondisi WHERE tambahan
 * @return mysqli_result - hasil query
 */
// Perbaikan untuk fungsi getFilteredStokDarah
function getFilteredStokDarah($conn, $additional_where = "")
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "s");

    $query = "SELECT * FROM stok_darah s 
              WHERE 1=1 $location_filter $additional_where 
              ORDER BY s.id DESC, s.created_at DESC"; // Tambahkan ORDER BY id DESC untuk data terbaru

    return mysqli_query($conn, $query);
}

/**
 * Fungsi untuk mendapatkan data pengambilan darah dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @param string $additional_where - kondisi WHERE tambahan
 * @return mysqli_result - hasil query
 */
function getFilteredPengambilanDarah($conn, $additional_where = "")
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "pd");

    $query = "SELECT * FROM pengambilan_darah pd 
              WHERE 1=1 $location_filter $additional_where 
              ORDER BY pd.id DESC, pd.created_at DESC"; // Tambahkan ORDER BY id DESC untuk data terbaru

    return mysqli_query($conn, $query);
}

/**
 * Fungsi untuk mendapatkan data tes kesehatan dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @param string $additional_where - kondisi WHERE tambahan
 * @return mysqli_result - hasil query
 */
function getFilteredTesKesehatan($conn, $additional_where = "")
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "tk");

    $query = "SELECT * FROM tes_kesehatan tk 
              WHERE 1=1 $location_filter $additional_where 
              ORDER BY tk.id DESC, tk.created_at DESC"; // Tambahkan ORDER BY id DESC untuk data terbaru

    return mysqli_query($conn, $query);
}

function getFilteredReview(
    $conn,
    $additional_where = "",
    $limit = 150,
    $offset = 0
) {
    $admin_location = $_SESSION["admin_location"] ?? "ALL";

    if (isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"]) {
        // Super admin melihat semua review
        $query = "SELECT r.*, a.nama as nama_pendonor, a.alamat
                  FROM review r 
                  LEFT JOIN akun a ON r.id_pendonor = a.id 
                  WHERE 1=1 $additional_where 
                  ORDER BY r.id DESC, r.created_at DESC 
                  LIMIT $limit OFFSET $offset";
    } else {
        // Admin lokasi melihat review berdasarkan alamat pendonor
        $location_keywords = getLocationKeywords($admin_location);

        if (!empty($location_keywords)) {
            $alamat_conditions = [];
            foreach ($location_keywords as $keyword) {
                $escaped_keyword = mysqli_real_escape_string($conn, $keyword);
                $alamat_conditions[] = "(a.alamat LIKE '%$escaped_keyword%' OR r.lokasi LIKE '%$escaped_keyword%')";
            }
            $alamat_filter =
                " AND (" . implode(" OR ", $alamat_conditions) . ")";
        } else {
            $alamat_filter = " AND 1=0"; // Jika tidak ada keywords, tidak tampilkan data
        }

        $query = "SELECT r.*, a.nama as nama_pendonor, a.alamat
                  FROM review r 
                  INNER JOIN akun a ON r.id_pendonor = a.id 
                  WHERE 1=1 $alamat_filter $additional_where 
                  ORDER BY r.id DESC, r.created_at DESC 
                  LIMIT $limit OFFSET $offset";
    }

    return mysqli_query($conn, $query);
}

/**
 * Fungsi untuk menghitung total review dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @param string $additional_where - kondisi WHERE tambahan
 * @return int - jumlah total review
 */
function getFilteredReviewCount($conn, $additional_where = "")
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";

    if (isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"]) {
        // Super admin melihat semua review
        $query = "SELECT COUNT(*) as total
                  FROM review r 
                  LEFT JOIN akun a ON r.id_pendonor = a.id 
                  WHERE 1=1 $additional_where";
    } else {
        // Admin lokasi melihat review berdasarkan alamat pendonor
        $location_keywords = getLocationKeywords($admin_location);

        if (!empty($location_keywords)) {
            $alamat_conditions = [];
            foreach ($location_keywords as $keyword) {
                $escaped_keyword = mysqli_real_escape_string($conn, $keyword);
                $alamat_conditions[] = "(a.alamat LIKE '%$escaped_keyword%' OR r.lokasi LIKE '%$escaped_keyword%')";
            }
            $alamat_filter =
                " AND (" . implode(" OR ", $alamat_conditions) . ")";
        } else {
            $alamat_filter = " AND 1=0"; // Jika tidak ada keywords, tidak tampilkan data
        }

        $query = "SELECT COUNT(*) as total
                  FROM review r 
                  INNER JOIN akun a ON r.id_pendonor = a.id 
                  WHERE 1=1 $alamat_filter $additional_where";
    }

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result)["total"];
}

/**
 * Fungsi untuk mendapatkan statistik dashboard dengan filter lokasi
 * @param mysqli $conn - koneksi database
 * @return array - data statistik
 */
function getDashboardStats($conn)
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p");
    $location_filter_stok = getLocationFilter($admin_location, "s");
    $location_filter_pengambilan = getLocationFilter($admin_location, "pd");
    $alamat_filter = getAlamatFilter($admin_location, "a");

    $stats = [];

    // Total pengajuan
    $query = "SELECT COUNT(*) as total FROM pengajuan p WHERE 1=1 $location_filter";
    $result = mysqli_query($conn, $query);
    $stats["total_pengajuan"] = mysqli_fetch_assoc($result)["total"];

    // Pengajuan pending
    $query = "SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi='pending' $location_filter";
    $result = mysqli_query($conn, $query);
    $stats["pengajuan_pending"] = mysqli_fetch_assoc($result)["total"];

    // Pengajuan sukses
    $query = "SELECT COUNT(*) as total FROM pengajuan p WHERE konfirmasi='sukses' $location_filter";
    $result = mysqli_query($conn, $query);
    $stats["pengajuan_sukses"] = mysqli_fetch_assoc($result)["total"];

    // Total stok darah
    $query = "SELECT SUM(jumlah_kantong) as total FROM stok_darah s WHERE 1=1 $location_filter_stok";
    $result = mysqli_query($conn, $query);
    $stats["total_stok_darah"] = mysqli_fetch_assoc($result)["total"] ?? 0;

    // Total darah keluar
    $query = "SELECT SUM(jumlah_kantong) as total FROM pengambilan_darah pd WHERE 1=1 $location_filter_pengambilan";
    $result = mysqli_query($conn, $query);
    $stats["total_darah_keluar"] = mysqli_fetch_assoc($result)["total"] ?? 0;

    // Tambahan: Total pendonor berdasarkan lokasi
    $query = "SELECT COUNT(*) as total FROM akun a WHERE 1=1 $alamat_filter";
    $result = mysqli_query($conn, $query);
    $stats["total_pendonor"] = mysqli_fetch_assoc($result)["total"];

    return $stats;
}

/**
 * Fungsi untuk mendapatkan data chart stok darah berdasarkan golongan darah
 * @param mysqli $conn - koneksi database
 * @return array - data chart
 */
function getChartStokDarah($conn)
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "s");

    $query = "SELECT golongan_darah, rhesus, SUM(jumlah_kantong) as total 
              FROM stok_darah s 
              WHERE 1=1 $location_filter 
              GROUP BY golongan_darah, rhesus 
              ORDER BY golongan_darah, rhesus";

    $result = mysqli_query($conn, $query);
    $chart_data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $chart_data[] = [
            "golongan" => $row["golongan_darah"] . $row["rhesus"],
            "jumlah" => (int) $row["total"],
        ];
    }

    return $chart_data;
}

/**
 * Fungsi untuk mendapatkan data chart pengajuan bulanan
 * @param mysqli $conn - koneksi database
 * @return array - data chart
 */
function getChartPengajuanBulanan($conn)
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p");

    $query = "SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as bulan,
                COUNT(*) as total,
                SUM(CASE WHEN konfirmasi='sukses' THEN 1 ELSE 0 END) as sukses,
                SUM(CASE WHEN konfirmasi='pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN konfirmasi='ditolak' THEN 1 ELSE 0 END) as ditolak
              FROM pengajuan p 
              WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH) $location_filter
              GROUP BY DATE_FORMAT(created_at, '%Y-%m') 
              ORDER BY bulan DESC"; // Urutkan dari bulan terbaru

    $result = mysqli_query($conn, $query);
    $chart_data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $chart_data[] = [
            "bulan" => $row["bulan"],
            "total" => (int) $row["total"],
            "sukses" => (int) $row["sukses"],
            "pending" => (int) $row["pending"],
            "ditolak" => (int) $row["ditolak"],
        ];
    }

    return array_reverse($chart_data); // Reverse untuk menampilkan urutan kronologis
}

/**
 * Fungsi untuk mendapatkan nama lokasi admin yang sedang login
 * @return string - nama lokasi
 */
function getAdminLocationName()
{
    if (isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"]) {
        return "Semua Lokasi (Super Admin)";
    }

    if (isset($_SESSION["admin_location"])) {
        return $_SESSION["admin_location"];
    }

    return "Lokasi Tidak Diketahui";
}

/**
 * Fungsi untuk mengecek apakah user adalah super admin
 * @return bool
 */
function isSuperAdmin()
{
    return isset($_SESSION["is_super_admin"]) && $_SESSION["is_super_admin"];
}

/**
 * Fungsi untuk mendapatkan daftar lokasi untuk super admin
 * @param mysqli $conn - koneksi database
 * @return array - daftar lokasi
 */
function getAllLocations($conn)
{
    $locations = [
        "UDD PMI Kabupaten Probolinggo",
        "UDD PMI Kota Probolinggo",
        "UDD PMI Kabupaten Lumajang",
        "UDD PMI Kabupaten Jember",
        "UDD PMI Kabupaten Bondowoso",
        "UDD PMI Kabupaten Situbondo",
        "UDD PMI Kabupaten Banyuwangi",
    ];

    return $locations;
}

/**
 * Fungsi untuk mendapatkan statistik per lokasi (untuk super admin)
 * @param mysqli $conn - koneksi database
 * @return array - statistik per lokasi
 */
function getLocationStats($conn)
{
    if (!isSuperAdmin()) {
        return [];
    }

    $locations = getAllLocations($conn);
    $stats = [];

    foreach ($locations as $location) {
        $escaped_location = mysqli_real_escape_string($conn, $location);

        // Pengajuan per lokasi
        $query = "SELECT COUNT(*) as total FROM pengajuan WHERE lokasi = '$escaped_location'";
        $result = mysqli_query($conn, $query);
        $pengajuan_total = mysqli_fetch_assoc($result)["total"];

        // Stok darah per lokasi
        $query = "SELECT SUM(jumlah_kantong) as total FROM stok_darah WHERE lokasi = '$escaped_location'";
        $result = mysqli_query($conn, $query);
        $stok_total = mysqli_fetch_assoc($result)["total"] ?? 0;

        $stats[] = [
            "lokasi" => $location,
            "pengajuan" => $pengajuan_total,
            "stok_darah" => $stok_total,
        ];
    }

    return $stats;
}
// Fungsi tambahan untuk mendapatkan data terbaru dengan limit
function getRecentPengajuan($conn, $limit = 10)
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p");

    $query = "SELECT p.*, a.nama as nama_pendonor, a.telepon 
              FROM pengajuan p 
              LEFT JOIN akun a ON p.id_pendonor = a.id 
              WHERE 1=1 $location_filter 
              ORDER BY p.id DESC, p.created_at DESC 
              LIMIT $limit";

    return mysqli_query($conn, $query);
}

// Fungsi tambahan untuk mendapatkan pendonor terbaru
function getRecentPendonor($conn, $limit = 10)
{
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $alamat_filter = getAlamatFilter($admin_location, "a");

    $query = "SELECT * FROM akun a 
              WHERE 1=1 $alamat_filter 
              ORDER BY a.id DESC, a.created_at DESC 
              LIMIT $limit";

    return mysqli_query($conn, $query);
}

// Fungsi untuk refresh cache data (jika diperlukan)
function refreshAdminData($conn)
{
    // Hapus cache jika menggunakan caching
    if (function_exists("apc_clear_cache")) {
        apc_clear_cache("user");
    }

    // Atau reset session cache jika ada
    if (isset($_SESSION["cache_data"])) {
        unset($_SESSION["cache_data"]);
    }

    return true;
}
?>
