<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$sql = "SELECT rating, ulasan, username FROM review ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>About Us - Sedalam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
    }
    .judul {
        text-align: center;
        font-weight: bold;
        font-family: 'Segoe UI', sans-serif;
        font-size: 32px;
        color: #000000;
        margin: 30px 0;
        text-transform: uppercase;
    }
    .img-custom {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 20px;
    }
    .about-section { padding: 60px 20px 40px 20px; }
.story-section { padding: 60px 60px 60px 60px; }
.features-section { padding: 50px 20px 30px 20px; }
.review-section { padding: 50px 20px; }

.section-title {
    text-align: center;
    font-weight: bold;
    font-family: 'Segoe UI', sans-serif;
    font-size: 2rem;
    margin-bottom: 40px;
}

/* Tambahan untuk heading khusus menggunakan Segoe UI Bold */
.semibold {
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
    font-size: 2rem;
    color: #000000;
}

/* Feature title menggunakan Segoe UI Bold */
.feature-title {
    font-weight: bold;
    font-family: 'Segoe UI', sans-serif;
    font-size: 1.3rem;
    color: var(--secondary);
    margin-bottom: 15px;
}


    /* Features Card */
    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        height: 100%;
    }
    .feature-card:hover {
        transform: translateY(-10px);
    }

       /* REVIEW CARD */
       .review-section {
    padding: 60px 20px;
    background-color: #ffffff;
}
.review-scroll {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    scroll-behavior: smooth;
    padding-bottom: 10px;
    scrollbar-width: none; /* Firefox */
}
.review-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}
.review-card {
    flex: 0 0 auto;
    width: 300px;
    background: #fff;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15); /* Lebih tajam dan tebal */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    scroll-snap-align: start;
}

.review-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2); /* lebih dalam saat hover */
}
.review-card:hover::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 20px;
    border: 2px solid rgba(0, 123, 255, 0.1);
    box-shadow: 0 0 15px rgba(0, 123, 255, 0.15);
    pointer-events: none;
}
.review-icon {
    position: absolute;
    top: -20px;
    right: -20px;
    font-size: 3rem;
    opacity: 0.1;
    transform: rotate(-20deg);
}
.review-content p {
    font-size: 0.95rem;
    color: #555;
}
.username {
    font-weight: bold;
    color: #333;
}
.star {
    color: gold;
    font-size: 1.2rem;
}

/* Tambahan animasi ikon */
.animated-icon {
    animation: bounce 1.5s infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}
.feature-card {
    background: linear-gradient(145deg, #ffffff, #f2f2f2);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2); /* lebih dalam */
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
    z-index: 2;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.feature-card:before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 180px;
    height: 180px;
    background: rgba(0, 123, 255, 0.1);
    border-radius: 50%;
    z-index: -1;
    filter: blur(20px);
    transition: transform 0.5s ease;
}

.feature-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
}

.feature-card:hover:before {
    transform: scale(1.2);
}

.feature-img-container {
    height: 200px;
    overflow: hidden;
    border-radius: 10px;
    margin-bottom: 25px;
}

.feature-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.feature-card:hover .feature-img {
    transform: scale(1.1);
}

.feature-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
}

.col-md-6 > p {
    font-size: 1.2rem;   /* Ukuran lebih besar dari default */
    line-height: 1.8;    /* Jarak baris agar lebih nyaman dibaca */
    color: #444;         /* Warna teks sedikit lebih gelap dari #555 */
}
.story-section .col-md-6:first-child {
    padding-right: 40px; /* Tambah jarak dari sisi kanan gambar */
}

.story-section .col-md-6:last-child {
    padding-left: 40px; /* Tambah jarak dari sisi kiri teks */
}

    </style>
</head>
<body>
<div id="about us"></div>
<h1 class="judul">Ayo Kenali Kami Lebih Dalam</h1>

<!-- About Us -->
<section class="about-section">
    <div class="container px-4">
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="fade-right">
                <h2 class="semibold">Setetes Darah Menyelamatkan</h2>
                <p class="mt-3">Sedalam adalah platform digital yang mempermudah proses donor darah lebih cepat, efisien, dan terintegrasi. Dengan dukungan dari PMI, kami hadir untuk menjembatani kebutuhan darah dan kepedulian masyarakat melalui teknologi yang humanis dan intuitif.</p>
                <p>Pantau stok darah, akses artikel kesehatan, dan jadwalkan donor langsung dari satu aplikasi. Bersama Sedalam, #DonorLebihMudah jadi kenyataan.</p>
            </div>
            <div class="col-md-6 text-center" data-aos="fade-left">
                <img src="../../assets/poster.jpeg" class="img-fluid img-custom" alt="Aplikasi Sedalam">
            </div>
        </div>
    </div>
</section>

<!-- Story -->
<section class="story-section bg-light">
    <div class="container px-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center mb-4 mb-md-0" data-aos="fade-left">
                <img src="../../assets/profil.jpg" class="img-fluid img-custom shadow" alt="Cerita">
            </div>
            <div class="col-md-6" data-aos="fade-right">
                <h2 class="semibold text-center">Cerita di Balik Sedalam</h2>
                <p>Sedalam lahir dari kepedulian dan semangat kolaborasi untuk menjadikan donor darah lebih terorganisir dan mudah dijangkau. Berawal dari proyek penelitian mahasiswa, kini berkembang menjadi solusi nyata yang digunakan masyarakat luas.</p>
                <p>Dengan pendekatan desain modern, fitur interaktif, dan data real-time, kami menghadirkan pengalaman digital yang intuitif. Sedalam dikembangkan oleh tim muda yang percaya bahwa teknologi dapat menjadi jembatan antara kemanusiaan dan aksi nyata.</p>
                <p><em>"Karena setetes darah menyelamatkan banyak nyawa."</em></p>
            </div>
        </div>
    </div>
</section>

<section class="features-section" id="fitur">
        <div class="container">
            <h2 class="semibold text-center " data-aos="fade-up">Kenapa Memilih Sedalam?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="zoom-in" data-aos-duration="800">
                    <div class="feature-card">
                        <div class="feature-img-container">
                            <img src="../../assets/jadwal.jpeg" class="feature-img" alt="Donor Mudah">
                        </div>
                        <h4 class="feature-title"><i class="fas fa-calendar-alt text-primary me-2"></i>Jadwal Fleksibel</h4>
                        <p class="feature-text">Atur dan pantau jadwal donor dengan mudah. Dilengkapi pengingat otomatis agar kamu tidak melewatkan kesempatan berbagi kehidupan.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-img-container">
                            <img src="../../assets/maps.jpeg" class="feature-img" alt="Lokasi Terdekat">
                        </div>
                        <h4 class="feature-title"><i class="fas fa-map-marker-alt text-primary me-2"></i>Lokasi Terdekat</h4>
                        <p class="feature-text">Temukan lokasi donor terdekat dengan data stok darah terkini dan navigasi langsung ke titik lokasi.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-img-container">
                            <img src="../../assets/riwayat.jpeg" class="feature-img" alt="Riwayat Donor">
                        </div>
                        <h4 class="feature-title"><i class="fas fa-history text-primary me-2"></i>Riwayat Lengkap</h4>
                        <p class="feature-text">Lihat riwayat donormu dan pantau kontribusimu terhadap sesama. Dapatkan insight kesehatan dari setiap donor yang kamu lakukan.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="review-section">
    <div class="container">
        <h2 class="semibold text-center " data-aos="zoom-in" data-aos-duration="800" data-aos-delay="400">Apa Kata Mereka?</h2>
        <div class="review-scroll">
            <?php
            $delay = 0;
            while ($row = $result->fetch_assoc()):
                $delay += 200;
                // Tambahkan delay agar animasi muncul satu per satu
                ?>
            <div class="review-card" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
                <div class="review-icon"><i class="fas fa-quote-left"></i></div>
                <div class="review-content">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="username"><i class="fas fa-user animated-icon me-1"></i><?= htmlspecialchars(
                            $row["username"]
                        ) ?></span>
                        <span class="star">
                            <?= str_repeat("★", $row["rating"]) ?>
                            <?= str_repeat("☆", 5 - $row["rating"]) ?>
                        </span>
                    </div>
                    <p><?= htmlspecialchars($row["ulasan"]) ?></p>
                </div>
            </div>
            <?php
            endwhile;
            ?>
        </div>
    </div>
</section>


<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 2500,
        once: true
    });
</script>
</body>
</html>