<?php
$conn = new mysqli("localhost", "root", "", "web_donor");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST["qr_data"])) {
    $qrData = $_POST["qr_data"];

    // Asumsikan isi QR adalah ID, Nama, dan Email
    // Contoh format QR: "ID: 123\nNama: John\nEmail: john@mail.com"
    preg_match("/ID:\s*(\d+)/", $qrData, $matches);
    $id = $matches[1] ?? null;

    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM pengajuan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            echo "<div style='border:1px solid green; padding:10px; margin-top:10px;'>
                    <p><strong>✅ QR Valid</strong></p>
                    <p><strong>Nama:</strong> {$data["nama"]}</p>
                    <p><strong>Email:</strong> {$data["email"]}</p>
                    <p><strong>Konfirmasi:</strong> {$data["konfirmasi"]}</p>
                  </div>";
        } else {
            echo "<p style='color:red;'>❌ Data tidak ditemukan di database.</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Format QR tidak valid.</p>";
    }
}
?>
