<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Donor Darah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 15px;
            overflow-y: auto;
        }

        .content {
            margin-left: 270px; /* Pastikan ini lebih besar dari sidebar agar tidak tertimpa */
            padding: 20px;
        }

        .card {
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: white;
        }

        .form-control, .form-select {
            border-radius: 6px;
        }

        .btn-submit {
            background-color: #198754;
            color: white;
            border-radius: 6px;
        }

        .btn-submit:hover {
            background-color: #157347;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
        <li class="nav-item"><a href="manajemen_admin.php" class="nav-link text-white">Manajemen Admin</a></li>
        <li class="nav-item"><a href="manage_darah.php" class="nav-link text-white">Manajemen Stok Darah</a></li>
        <li class="nav-item mt-auto"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
    </ul>
</div>

<div class="content">
    <div class="card">
        <h4 class="mb-3">Pengajuan Donor Darah</h4>
        <form id="donorForm" action="proses_pengajuan.php" method="POST" enctype="multipart/form-data">
            
            <!-- Data Diri -->
            <h5>Data Diri</h5>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="NIK" name="nik" required>
            </div>
            <div class="mb-3">
    <input type="email" class="form-control" placeholder="Alamat Email" name="email" required>
</div>

            <div class="mb-3">
                <input type="text" class="form-control" placeholder="No. HP (WhatsApp)" name="hp" required>
            </div>

            <!-- Tanggal & Waktu -->
            <h5>Pilih Tanggal & Waktu</h5>
            <div class="mb-3">
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <div class="mb-3">
                <input type="time" class="form-control" name="waktu" required>
            </div>

            <!-- Lokasi Donor -->
            <h5>Lokasi Donor</h5>
            <div class="mb-3">
                <select class="form-select" name="lokasi" required>
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="PMI Jakarta">PMI Jakarta</option>
                    <option value="PMI Bandung">PMI Bandung</option>
                    <option value="PMI Surabaya">PMI Surabaya</option>
                </select>
            </div>

            <!-- Screening Kesehatan -->
            <h5>Screening Kesehatan Awal</h5>
            <div class="mb-3">
                <select class="form-select" name="sehat" required>
                    <option value="Ya">Saya dalam kondisi sehat</option>
                    <option value="Tidak">Saya sedang sakit</option>
                </select>
            </div>
            <div class="mb-3">
                <select class="form-select" name="obat" required>
                    <option value="Tidak">Saya tidak mengonsumsi obat</option>
                    <option value="Ya">Saya sedang mengonsumsi obat</option>
                </select>
            </div>

            <!-- Upload Dokumen -->
            <h5>Upload Dokumen (Opsional)</h5>
            <div class="mb-3">
                <input type="file" class="form-control" name="dokumen">
            </div>

            <!-- Verifikasi OTP -->
            <h5>Verifikasi OTP</h5>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-100" onclick="kirimOTP()">Kirim OTP ke WhatsApp</button>
                <input type="text" class="form-control mt-2" placeholder="Masukkan OTP" name="otp" required>
            </div>

            <!-- Konfirmasi Pengajuan -->
            <h5>Konfirmasi</h5>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="konfirmasi" required>
                <label class="form-check-label">Saya menyatakan bahwa data yang diisi benar</label>
            </div>

            <button type="submit" class="btn btn-submit w-100">Kirim Pengajuan</button>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function kirimOTP() {
        var nomorHP = document.querySelector("input[name='hp']").value.trim();

        // Validasi input
        if (nomorHP === "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Masukkan nomor HP terlebih dahulu!',
            });
            return;
        }

        // Format nomor agar cocok dengan format internasional (contoh: 62xxx)
        if (nomorHP.startsWith("0")) {
            nomorHP = "62" + nomorHP.substring(1);
        }

        // Buat pesan OTP random
        var otp = Math.floor(100000 + Math.random() * 900000);
        var pesan = `Halo, berikut adalah kode OTP Anda: ${otp}. Jangan berikan kode ini kepada siapapun!`;

        // Buka WhatsApp Web/app
        var url = "https://wa.me/" + nomorHP + "?text=" + encodeURIComponent(pesan);
        window.open(url, "_blank");
    }
</script>


<script>
    document.getElementById("donorForm").addEventListener("submit", function(event) {
        event.preventDefault(); // biar form dikonfirmasi dulu sama sistem

        Swal.fire({
            title: "Pengajuan Berhasil!",
            text: "Terima kasih telah mengajukan donor darah.",
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            // Setelah OK ditekan, kirim form
            document.getElementById("donorForm").submit();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
