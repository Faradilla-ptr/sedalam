<?php
include "db.php";

// Ambil data pengajuan donor
$query = "SELECT * FROM pengajuan WHERE konfirmasi IS NULL"; // Mengambil pengajuan yang belum dikonfirmasi
$result = $conn->query($query);

// Ambil data tes kesehatan untuk masing-masing pendonor
$tes_query = "SELECT * FROM tes_kesehatan";
$tes_result = $conn->query($tes_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "sidebar.php"; ?>
    <div class="container mt-5">
        <h3>Pengajuan Donor Darah</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Donor</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["nama"] ?></td>
                        <td><?= $row["email"] ?></td>
                        <td><?= $row["tanggal"] ?></td>
                        <td><?= $row["lokasi"] ?></td>
                        <td><?= $row["konfirmasi"] === null
                            ? "Menunggu"
                            : ($row["konfirmasi"] == 1
                                ? "Diterima"
                                : "Ditolak") ?></td>
                        <td>
                            <a href="konfirmasi.php?id=<?= $row[
                                "id"
                            ] ?>&status=1" class="btn btn-success">Terima</a>
                            <a href="konfirmasi.php?id=<?= $row[
                                "id"
                            ] ?>&status=0" class="btn btn-danger">Tolak</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Data Tes Kesehatan Pendonor</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Pendonor</th>
                    <th>Tanggal Tes</th>
                    <th>Tekanan Darah</th>
                    <th>Berat Badan</th>
                    <th>Hemoglobin</th>
                    <th>Riwayat Penyakit</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($tes = $tes_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $tes["id"] ?></td>
                        <td><?= $tes["id_pendonor"] ?></td>
                        <td><?= $tes["tanggal"] ?></td>
                        <td><?= $tes["tekanan_darah"] ?></td>
                        <td><?= $tes["berat_badan"] ?></td>
                        <td><?= $tes["hemoglobin"] ?></td>
                        <td><?= $tes["riwayat_penyakit"] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
