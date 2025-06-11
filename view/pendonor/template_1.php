<?php
require "../../lib/fpdf.php";

$pdf = new FPDF("P", "mm", "A4");
$pdf->AddPage();

// Judul
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 10, "Formulir Pengajuan Donor Darah", 0, 1, "C");
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 8, "Palang Merah Indonesia (PMI)", 0, 1, "C");

$pdf->Ln(10);

// Data Pribadi
$pdf->SetFont("Arial", "", 12);
$data = [
    "Nama Lengkap" => "",
    "NIK" => "",
    "Jenis Kelamin" => "",
    "Tanggal Lahir" => "",
    "Golongan Darah" => "",
    "Telepon" => "",
    "Alamat" => "",
];

foreach ($data as $label => $value) {
    $pdf->Cell(50, 8, $label, 0, 0);
    $pdf->Cell(5, 8, ":", 0, 0);
    $pdf->Cell(0, 8, $value, 0, 1);
}

$pdf->Ln(10);

// Data Donor
$pdf->Cell(0, 8, "Saya mengajukan permohonan donor darah pada:", 0, 1);
$jadwal = [
    "Tanggal" => "",
    "Waktu" => "",
    "Lokasi Donor" => "",
];

foreach ($jadwal as $label => $value) {
    $pdf->Cell(50, 8, $label, 0, 0);
    $pdf->Cell(5, 8, ":", 0, 0);
    $pdf->Cell(0, 8, $value, 0, 1);
}

$pdf->Ln(30);

// Tanda tangan
$pdf->Cell(
    0,
    8,
    "..............................., ...............................",
    0,
    1,
    "R"
);
$pdf->Cell(0, 8, "Hormat Saya,", 0, 1, "R");

$pdf->Ln(25);
$pdf->Cell(0, 8, "( ....................................... )", 0, 1, "R");

$pdf->Output("I", "pengajuan_donor_a4.pdf");
?>
