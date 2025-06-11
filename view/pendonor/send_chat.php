<?php
$sender = $_POST["sender"] ?? null;
$receiver = $_POST["receiver"] ?? null;
$message = trim($_POST["message"] ?? "");

if (!$sender || !$receiver || $message === "") {
    echo json_encode(["success" => false, "error" => "Data tidak lengkap"]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "web_donor");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Koneksi gagal"]);
    exit();
}

$stmt = $conn->prepare(
    "INSERT INTO chat (sender, receiver, message, time) VALUES (?, ?, ?, NOW())"
);
$stmt->bind_param("sss", $sender, $receiver, $message);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Gagal menyimpan pesan"]);
}

$stmt->close();
$conn->close();
?>
