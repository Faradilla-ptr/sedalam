<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sedalam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .banner {
            position: relative;
            background: url('images/donor.jpg') center/cover no-repeat;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .banner::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .banner h1, .banner p {
            position: relative;
            z-index: 1;
        }
        .countdown {
            font-size: 2rem;
            font-weight: bold;
        }

    </style>
</head>
<body>

<?php include 'navbar.php'; ?>


<!-- Banner -->
<div class="banner">
    <div class="container">
        <h1>Aplikasi Sedalam</h1>
        <p>Manajemen Donor Darah untuk Kesehatan yang Lebih Baik</p>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Status Donor Selanjutnya -->
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header bg-danger text-white">
                    Status Donor Selanjutnya
                </div>
                <div class="card-body">
                    <h3 id="countdown" class="countdown">00:00:00</h3>
                    <p>Waktu tersisa hingga donor berikutnya</p>
                </div>
            </div>
        </div>

        <!-- Ringkasan Riwayat Donor -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Riwayat Donor
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Terakhir Donor: 15 Februari 2025</li>
                        <li class="list-group-item">Total Donor: 5 kali</li>
                        <li class="list-group-item">Golongan Darah: O+</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Darah Terdekat (Quick View) -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Stok Darah Terdekat
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Golongan Darah</th>
                                <th>Stok Tersedia</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A+</td>
                                <td>12 Kantong</td>
                                <td>RSUD Kota</td>
                            </tr>
                            <tr>
                                <td>B-</td>
                                <td>8 Kantong</td>
                                <td>PMI Pusat</td>
                            </tr>
                            <tr>
                                <td>O+</td>
                                <td>5 Kantong</td>
                                <td>RS Swasta</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="#" class="btn btn-success">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const countdownEl = document.getElementById("countdown");
    if (!countdownEl) return;

    const donorDate = new Date();
    donorDate.setDate(donorDate.getDate() + 5);

    const interval = setInterval(() => {
        const now = new Date().getTime();
        const distance = donorDate - now;

        if (distance < 0) {
            clearInterval(interval);
            countdownEl.innerText = "Waktunya Donor!";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownEl.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
    }, 1000);
});
</script>


<?php include 'artikel.php'; ?>
<?php include 'stok_darah.php'; ?>
<?php include 'faq.php'; ?>
<?php include 'footer.php'; ?>




</body>
</html>
