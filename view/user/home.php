<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sedalam</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff !important;
            color: #333;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Hero wrapper dengan background putih dan layout flex */
        .hero-wrapper {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background:
linear-gradient(135deg, rgba(255,255,255,0.9), rgba(243, 243, 243, 0.95)),
        url('../../assets/bgheronew.jpeg') center/cover no-repeat;
    display: flex;
    align-items: center;
    overflow: hidden;
    background-blend-mode: lighten;
}
.hero-content-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    padding-left: 4%;
    padding-right: 2%;
    gap: 3rem;
}


        /* Bagian kiri - Teks */
        .hero-text {
            flex: 1;
            padding-right: 1rem;
            z-index: 2;
        }
        
        .judul-utama {
            font-size: 3rem;
            font-weight: 800;
            background:#000000 ;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .subjudul {
            font-size: 2.2rem;
            font-weight: 600;
            color: #000000;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
        }

        .hero-text p {
            font-size: 1.3rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            color: #000000;
        }
        
        .hero-btn {
            display: inline-block;
            background-color: #dc3545;
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        
        .hero-btn:hover {
            background-color: #c82333;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
            color: white;
        }

/* Bagian kanan - Animasi */
.hero-animation {
    flex: 1;
    padding-left: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    min-height: 700px; /* Ditinggikan agar animasi besar bisa muat */
}

.animation-container {
    position: relative;
    width: 100%;
    height: 100%;
    max-width: 1000px; /* Tambahan agar animasi tidak mentok kiri-kanan */
    display: flex;
    justify-content: center;
    align-items: center;
}

.lottie-animation {
    width: 100%;       /* Gunakan width responsif */
    max-width: 1000px;  /* Batasi maksimum agar tidak terlalu besar */
    height: auto;      /* Agar tetap proporsional */
    opacity: 0;
    transition: opacity 1s ease-in-out;
    position: relative;
}

.lottie-animation.active {
    opacity: 1;
}


        /* Responsive design */
        @media (max-width: 768px) {
            .hero-content-container {
                flex-direction: column;
                text-align: center;
                padding: 2rem 1rem;
            }

            .hero-text {
                padding-right: 0;
                margin-bottom: 2rem;
            }

            .judul-utama {
                font-size: 1.5rem;
            }

            .subjudul {
                font-size: 1.8rem;
            }

            .hero-text p {
                font-size: 1.1rem;
            }

            .lottie-animation {
                width: 600px;
                height: 600px;
            }
        }

        /* Content section dengan margin-top dan background putih solid */
        .content-section {
            position: relative;
            z-index: 1;
            background-color: #ffffff;
            box-shadow: 0px -10px 20px rgba(0,0,0,0.05);
            padding: 2rem 0;
        }

        /* Table enhancement */
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .table th {
            background-color: #dc3545;
            color: #fff;
            font-weight: bold;
            border: none;
            text-align: center;
        }

        .table td, .table th {
            vertical-align: middle;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            font-size: 1rem;
        }

        .table tbody tr:hover {
            background-color: #fff0f0;
            transition: 0.3s;
        }

        /* Badge style for status */
        .status-badge {
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            display: inline-block;
        }

        .status-badge.text-success {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.text-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.text-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .card-header {
            font-weight: bold;
        }
        
        .table th, .table td {
            padding: 0.75rem;
        }
        .scrolled {
  background-color: #ffffff !important;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05); /* opsional: bayangan halus saat scroll */
}

    </style>
</head>
<body>

<!-- Hero Section dengan layout baru -->
<div class="hero-wrapper">
    <div class="hero-content-container">
        <!-- Left side - Text content -->
        <div class="hero-text">
            <h1 class="judul-utama">Donor Darah Selamatkan Nyawa</h1>
            <h1 class="subjudul">Kontribusimu Akan Sangat Berarti</h1>
            <p>Bergabunglah bersama jutaan pendonor di Indonesia dalam misi kemanusiaan untuk menyelamatkan nyawa sesama.</p>
            <div>
                <a href="#donor-info" class="hero-btn">Mulai Donor Sekarang</a>
            </div>
        </div>

        <!-- Right side - Animation -->
        <div class="hero-animation">
<script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
<dotlottie-player src="https://lottie.host/0ae51264-4c1b-47f5-841f-b167ace08a87/dAK6gBEs0g.lottie" background="transparent" speed="0.25" style="width: 600px; height: 600px" loop autoplay></dotlottie-player>
        </div>
    </div>
</div>

<!-- Content Section dengan background putih solid -->
<div class="content-section" id="donor-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center mb-4">
                    <div class="card-header bg-danger text-white">
                        Status Donor Selanjutnya
                    </div>
                    <div class="card-body">
                        <h3 id="countdown" class="countdown">00:00:00</h3>
                        <p>Waktu tersisa hingga donor berikutnya</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white text-center">
                        Donor Darah Terakhir
                    </div>
                    <div class="card-body p-0">
                        <?php
                        // Koneksi ke database
                        $host = "localhost";
                        $user = "root";
                        $pass = "";
                        $dbname = "web_donor";

                        $conn = new mysqli($host, $user, $pass, $dbname);
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        // Query untuk mengambil data stok darah terakhir (menggunakan tanggal_update terbaru)
                        $sql =
                            "SELECT * FROM stok_darah ORDER BY tanggal_update DESC LIMIT 1";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $lastDonor = $result->fetch_assoc(); ?>
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <th>Golongan Darah</th>
                                        <td><?= htmlspecialchars(
                                            $lastDonor["golongan_darah"]
                                        ) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Rhesus</th>
                                        <td><?= htmlspecialchars(
                                            $lastDonor["rhesus"]
                                        ) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <td><?= htmlspecialchars(
                                            $lastDonor["jumlah_kantong"]
                                        ) ?> kantong</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Update</th>
                                        <td><?= date(
                                            "d-m-Y H:i",
                                            strtotime(
                                                $lastDonor["tanggal_update"]
                                            )
                                        ) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td><?= htmlspecialchars(
                                            $lastDonor["lokasi"]
                                        ) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Stok Datang</th>
                                        <td><?= $lastDonor[
                                            "tanggal_stok_datang"
                                        ]
                                            ? date(
                                                "d-m-Y",
                                                strtotime(
                                                    $lastDonor[
                                                        "tanggal_stok_datang"
                                                    ]
                                                )
                                            )
                                            : "Tidak tersedia" ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <?php
                                            $statusClass = "";
                                            switch ($lastDonor["status"]) {
                                                case "Aman":
                                                    $statusClass =
                                                        "text-success";
                                                    break;
                                                case "Menipis":
                                                    $statusClass =
                                                        "text-warning";
                                                    break;
                                                case "Darurat":
                                                    $statusClass =
                                                        "text-danger";
                                                    break;
                                            }
                                            ?>
                                            <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars(
    $lastDonor["status"]
) ?></span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Kadaluarsa</th>
                                        <td><?= $lastDonor["tanggal_kadaluarsa"]
                                            ? date(
                                                "d-m-Y",
                                                strtotime(
                                                    $lastDonor[
                                                        "tanggal_kadaluarsa"
                                                    ]
                                                )
                                            )
                                            : "Tidak tersedia" ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        } else {
                            echo '<div class="alert alert-warning m-3">Belum ada data donor darah tersimpan.</div>';
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('donorChart')?.getContext('2d');
    if (ctx) {
        var donorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Jumlah Pendonor',
                    data: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160],
                    borderColor: 'rgb(255, 99, 132)',
                    fill: false
                }]
            }
        });
    }

    // Animation rotation script
    const animations = document.querySelectorAll('.lottie-animation');
    let currentAnimation = 0;

    setInterval(() => {
        animations[currentAnimation].classList.remove('active');
        currentAnimation = (currentAnimation + 1) % animations.length;
        animations[currentAnimation].classList.add('active');
    }, 5000); 

    // Countdown Timer
    const countdownEl = document.getElementById("countdown");
    if (countdownEl) {
        let targetDate = localStorage.getItem('targetDate');
        if (!targetDate) {
            targetDate = new Date();
            targetDate.setMonth(targetDate.getMonth() + 1);
            localStorage.setItem('targetDate', targetDate);
        } else {
            targetDate = new Date(targetDate);
        }

        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = targetDate - now;

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
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Check for URL hash on page load
    if (window.location.hash) {
        var target = document.querySelector(window.location.hash);
        if (target) {
            setTimeout(() => {
                target.scrollIntoView({ behavior: "smooth" });
            }, 500);
        }
    }
</script>
<?php include "about_us.php"; ?>
<?php include "stok_darah.php"; ?>
<?php include "artikel.php"; ?>
<?php include "faq.php"; ?>
<?php include "footer.php"; ?>
<?php include "navbar.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>