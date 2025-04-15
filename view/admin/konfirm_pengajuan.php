<?php
include 'db.php'; // koneksi ke database

// Ambil semua data pengajuan
$query = mysqli_query($koneksi, "SELECT * FROM pengajuan_donor ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pengajuan Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Konfirmasi Pengajuan Donor</h3>

    <form action="proses_konfirmasi_admin.php" method="post">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Cek</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Sehat</th>
                    <th>Obat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($data = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td>
                        <input type="checkbox" name="cek[]" value="<?= $data['id'] ?>">
                    </td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['nik'] ?></td>
                    <td><input type="hidden" name="email[<?= $data['id'] ?>]" value="<?= $data['email'] ?>"><?= $data['email'] ?></td>
                    <td><?= $data['hp'] ?></td>
                    <td><?= $data['tanggal'] ?></td>
                    <td><?= $data['waktu'] ?></td>
                    <td><?= $data['lokasi'] ?></td>
                    <td><?= $data['sehat'] ?></td>
                    <td><?= $data['obat'] ?></td>
                    <td>
                        <select name="status[<?= $data['id'] ?>]" class="form-select">
                            <option value="ditinjau" <?= $data['konfirmasi'] == 'ditinjau' ? 'selected' : '' ?>>Ditinjau</option>
                            <option value="diterima" <?= $data['konfirmasi'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                            <option value="ditolak" <?= $data['konfirmasi'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">Kirim Konfirmasi Email</button>
    </form>
</div>
</body>
</html>
