<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "web_donor"; // Nama database tujuan

// Koneksi ke MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Path ke file SQL
$sqlFile = "web_donor.sql"; 

// Baca isi file SQL
$sql = file_get_contents($sqlFile);

// Eksekusi multi query
if ($conn->multi_query($sql)) {
    do {
        // Lewati semua hasil
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());

    echo "Database berhasil dimigrasi dari $sqlFile.";
} else {
    echo "Error saat eksekusi SQL: " . $conn->error;
}

$conn->close();
?>