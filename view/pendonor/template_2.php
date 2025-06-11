<?php
require "../../lib/fpdf.php";

$pdf = new FPDF("P", "mm", "A4");
$pdf->AddPage();

$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 10, "Surat Keterangan Kesehatan", 0, 1, "C");
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 8, "Untuk Kepentingan Donor Darah", 0, 1, "C");

$pdf->Ln(10);
$pdf->Cell(
    0,
    8,
    "Yang bertanda tangan di bawah ini, Dokter Pemeriksa, menerangkan bahwa:",
    0,
    1
);

$data = [
    "Nama" => "",
    "Jenis Kelamin" => "",
    "Usia" => "",
    "Alamat" => "",
];

foreach ($data as $label => $value) {
    $pdf->Cell(50, 8, $label, 0, 0);
    $pdf->Cell(5, 8, ":", 0, 0);
    $pdf->Cell(0, 8, $value, 0, 1);
}

$pdf->Ln(10);
$pdf->MultiCell(
    0,
    8,
    "Setelah dilakukan pemeriksaan kesehatan, yang bersangkutan dinyatakan:\n\n[  ] SEHAT\n[  ] TIDAK SEHAT\n\ndan dapat / tidak dapat melakukan donor darah sesuai standar medis."
);

$pdf->Ln(30);
$pdf->Cell(
    0,
    8,
    "..............................., ...............................",
    0,
    1,
    "R"
);
$pdf->Cell(0, 8, "Dokter Pemeriksa,", 0, 1, "R");

$pdf->Ln(25);
$pdf->Cell(0, 8, "( ....................................... )", 0, 1, "R");
$pdf->Cell(0, 8, "SIP: ..................................", 0, 1, "R");

$pdf->Output("I", "surat_kesehatan_a4.pdf");
?>
