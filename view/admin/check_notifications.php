<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Ambil timestamp terakhir kali di cek dari session
$last_check = isset($_SESSION["last_notif_check"])
    ? $_SESSION["last_notif_check"]
    : date("Y-m-d H:i:s", strtotime("-12 hours"));

// Update timestamp
$_SESSION["last_notif_check"] = date("Y-m-d H:i:s");

// Hitung notifikasi baru sejak terakhir cek
$count = 0;
$notifications = [];

$tables = [
    ["akun", "nama", "Akun Baru"],
    ["faq", "email", "FAQ Baru"],
    ["pengajuan", "nama", "Pengajuan Baru"],
    ["pengambilan_darah", "lokasi_tujuan", "Pengambilan Darah Baru"],
    ["tes_kesehatan", "id", "Tes Kesehatan Baru"],
];

foreach ($tables as $table) {
    $tableName = $table[0];
    $contentField = $table[1];
    $label = $table[2];

    $sql = "SELECT '$label' as sumber, $contentField as isi, created_at FROM $tableName WHERE created_at > ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $last_check);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $count++;
        $notifications[] = [
            "sumber" => $row["sumber"],
            "isi" => $row["isi"],
            "created_at" => $row["created_at"],
        ];
    }
    $stmt->close();
}

echo json_encode([
    "count" => $count,
    "notifications" => $notifications,
]);
