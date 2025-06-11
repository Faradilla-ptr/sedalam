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
// Jika ada parameter lokasi (AJAX), balas JSON
if (isset($_GET["lokasi"])) {
    $lokasiMap = [
        "probolinggo_kab" => "UDD PMI Kabupaten Probolinggo",
        "probolinggo_kota" => "UDD PMI Kota Probolinggo",
        "lumajang" => "UDD PMI Kabupaten Lumajang",
        "jember" => "UDD PMI Kabupaten Jember",
        "bondowoso" => "UDD PMI Kabupaten Bondowoso",
        "situbondo" => "UDD PMI Kabupaten Situbondo",
        "banyuwangi" => "UDD PMI Kabupaten Banyuwangi"
    ];

    $lokasiKey = $_GET["lokasi"];
    
    // Tambahkan filter bulan Juni (bulan ke-6)
    $sql = "SELECT golongan_darah, SUM(jumlah_kantong) AS total_jumlah FROM stok_darah WHERE MONTH(tanggal_stok_datang) = 6 AND YEAR(tanggal_stok_datang) = YEAR(CURDATE())";

    if ($lokasiKey !== "all") {
        $lokasi = $lokasiMap[$lokasiKey] ?? "";
        $sql .= " AND lokasi = ?";
    }
    $sql .= " GROUP BY golongan_darah";

    $stmt = $conn->prepare($sql);
    if ($lokasiKey !== "all") {
        $stmt->bind_param("s", $lokasi);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $stokData = ["A" => 0, "B" => 0, "AB" => 0, "O" => 0];
    while ($row = $result->fetch_assoc()) {
        $stokData[$row["golongan_darah"]] = (int) $row["total_jumlah"];
    }

    header("Content-Type: application/json");
    echo json_encode($stokData);
    exit();
}

// Data awal saat halaman dibuka - tambahkan filter Juni
$sql = "SELECT golongan_darah, SUM(jumlah_kantong) AS total_jumlah FROM stok_darah WHERE MONTH(tanggal_stok_datang) = 6 AND YEAR(tanggal_stok_datang) = YEAR(CURDATE()) GROUP BY golongan_darah";
$result = $conn->query($sql);

$stokData = ["A" => 0, "B" => 0, "AB" => 0, "O" => 0];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stokData[$row["golongan_darah"]] = (int) $row["total_jumlah"];
    }
}
$conn->close();
$stokJson = json_encode($stokData);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Darah & Lokasi Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
html, body {
  background-color: #ffffff !important; /* transparan agar layer background baru terlihat */
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: 'Segoe UI', sans-serif; /* Jenis font */
  font-weight: bold;              
}
        .chart-container, .map {
            width: 70%;
            margin: 0 auto;
            display: block;
        }
        .chart-container {
            height: 400px;
            margin-top: 20px;
        }
        .map iframe {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .wrapper {
            width: 70%;
            margin: 0 auto;
        }


        /* Modal styling */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        
        .modal-header {
            background: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 20px 30px;
        }
        
        .modal-header .modal-title {
            font-weight: 600;
        }
        
        .modal-header .btn-close {
            color: white;
            filter: invert(1) brightness(200%);
            opacity: 0.8;
        }
        
        .modal-body {
            padding: 30px;
        }
        
        .modal-body ul {
            padding-left: 20px;
        }
        
        .modal-body ul li {
            margin-bottom: 12px;
            position: relative;
            padding-left: 10px;
        }
        
        .modal-body ul li:before {
            content: "•";
            color: var(--primary-color);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
        /* Card styling */
        .info-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            height: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .info-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-color);
            z-index: 2;
        }
        
        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
        }
        
        .info-card img {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover img {
            transform: scale(1.1) rotate(5deg);
        }
        
        .info-card h5 {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .info-card p {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        
        .info-card .btn-more {
            background: var(--light-color);
            color: var(--accent-color);
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .info-card .btn-more:hover {
            background: var(--accent-color);
            color: red;
        }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.info-content {
    max-width: 100%;
    padding: 15px;
}
.heading-bold {
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
    font-size: 2rem;
    color: #000000;
}

    </style>
</head>
<body>
<div id="stok_darah"></div>
<div class="wrapper mx-auto">
    <h2 class="mt-5 heading-bold">📊 Stok Darah</h2>
    <div class="mb-3">
        <label for="filterLokasi">Pilih Lokasi:</label>
<select id="filterLokasi" class="form-select w-25" onchange="updateStokDarah()">
    <option value="all">Semua Lokasi</option>
    <option value="probolinggo_kab">UDD PMI Kabupaten Probolinggo</option>
    <option value="probolinggo_kota">UDD PMI Kota Probolinggo</option>
    <option value="lumajang">UDD PMI Kabupaten Lumajang</option>
    <option value="jember">UDD PMI Kabupaten Jember</option>
    <option value="bondowoso">UDD PMI Kabupaten Bondowoso</option>
    <option value="situbondo">UDD PMI Kabupaten Situbondo</option>
    <option value="banyuwangi">UDD PMI Kabupaten Banyuwangi</option>
</select>

    </div>
</div>

<div class="chart-container">
    <canvas id="stokDarahChart"></canvas>
</div>

<div class="wrapper mx-auto">
    <div class="d-flex justify-content-end align-items-center gap-3 mt-4 px-5">
        <a href="form_ambildarah.php" class="btn btn-danger btn-lg">🚨 Form Pengajuan</a>
        <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#qrModal">📱 Scan WhatsApp</button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center" style="background-color: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border-radius: 15px;">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100">Scan untuk Hubungi WhatsApp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://wa.me/6285257619706" alt="QR WhatsApp" class="img-fluid">
        <p class="mt-3">Atau klik tombol di bawah:</p>
        <a href="https://wa.me/6285257619706" target="_blank" class="btn btn-primary">💬 Chat Sekarang</a>
      </div>
    </div>
  </div>
</div>

<div class="wrapper mx-auto">
    <h2 class="mt-5 heading-bold">Lokasi Fasilitas Donor</h2>
</div>

<div class="map mb-4">
    <iframe 
        src="https://www.google.com/maps?q=-8.157376209224998,113.72345793437795&z=17&output=embed" 
        width="100%" 
        height="300" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</div>
<div class="wrapper mx-auto animate-fade-in">
        <h2 class="mt-5 heading-bold text-center">Informasi Donor Darah</h2>
        
        <div class="row mt-4">
        <div class="col-md-4" data-aos="zoom-in" data-aos-duration="1000">
                <div class="info-card" data-info="sebelumDonor">
                    <img src="../../assets/hidup.png" alt="Sebelum Donor" class="mb-3 img-fluid">
                    <h5>Sebelum Donor</h5>
                    <p>Pastikan kondisi tubuh optimal dan siap untuk mendonorkan darah dengan persiapan yang tepat.</p>
                    <button class="btn-more" onclick="showInfo('sebelumDonor')">
                        <i class="fas fa-info-circle me-1"></i> Selengkapnya
                    </button>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
                <div class="info-card" data-info="saatDonor">
                    <img src="../../assets/donor.png" alt="Saat Donor" class="mb-3 img-fluid">
                    <h5>Saat Donor</h5>
                    <p>Proses pengambilan darah berlangsung dengan aman dan nyaman di bawah pengawasan tenaga medis.</p>
                    <button class="btn-more" onclick="showInfo('saatDonor')">
                        <i class="fas fa-info-circle me-1"></i> Selengkapnya
                    </button>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="400">
                <div class="info-card" data-info="setelahDonor">
                    <img src="../../assets/tidur.png" alt="Setelah Donor" class="mb-3 img-fluid">
                    <h5>Setelah Donor</h5>
                    <p>Langkah-langkah penting pasca donor untuk pemulihan cepat dan menjaga kesehatan tubuh Anda.</p>
                    <button class="btn-more" onclick="showInfo('setelahDonor')">
                        <i class="fas fa-info-circle me-1"></i> Selengkapnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Info -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Informasi Donor Darah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Konten akan dimasukkan via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data informasi donor darah
        const infoData = {
            sebelumDonor: {
                title: "Persiapan Sebelum Donor Darah",
                content: `
                    <ul>
                        <li>Tidur cukup minimal 6-8 jam sebelum melakukan donor darah</li>
                        <li>Konsumsi makanan bergizi dan minum air putih yang cukup (minimal 2 liter) untuk hidrasi</li>
                        <li>Sarapan atau makan 2-3 jam sebelum donor untuk mencegah pusing atau lemas</li>
                        <li>Hindari makanan berlemak tinggi dalam 24 jam sebelum donor</li>
                        <li>Hindari konsumsi alkohol minimal 24 jam sebelum donor</li>
                        <li>Hindari merokok minimal 2 jam sebelum donor</li>
                        <li>Kenakan pakaian dengan lengan yang mudah digulung</li>
                        <li>Bawa identitas diri seperti KTP/SIM/Paspor</li>
                    </ul>
                `
            },
            saatDonor: {
                title: "Proses Saat Donor Darah",
                content: `
                    <ul>
                        <li>Proses pendaftaran dan pengisian formulir kesehatan</li>
                        <li>Pemeriksaan kesehatan awal (tekanan darah, denyut nadi, suhu, hemoglobin)</li>
                        <li>Proses donor berlangsung sekitar 10-15 menit untuk pengambilan 350-450 ml darah</li>
                        <li>Rileks dan bernafas normal selama proses donor</li>
                        <li>Jika merasa tidak nyaman, segera beritahu petugas medis</li>
                        <li>Petugas akan memberikan bantalan steril untuk ditekan pada bekas tusukan jarum</li>
                        <li>Anda akan diminta untuk menekan bekas tusukan selama beberapa menit</li>
                        <li>Istirahat sejenak di tempat sebelum melanjutkan aktivitas</li>
                    </ul>
                `
            },
            setelahDonor: {
                title: "Perawatan Setelah Donor Darah",
                content: `
                    <ul>
                        <li>Istirahat minimal 10-15 menit setelah donor di area yang disediakan</li>
                        <li>Konsumsi makanan dan minuman ringan yang disediakan untuk mengembalikan energi</li>
                        <li>Minum lebih banyak air dalam 24-48 jam berikutnya untuk mengganti cairan tubuh</li>
                        <li>Hindari aktivitas berat atau olahraga intensif selama 24 jam</li>
                        <li>Hindari mengangkat beban berat dengan lengan yang digunakan untuk donor</li>
                        <li>Jangan lepas plester di tempat donor minimal 4-6 jam</li>
                        <li>Hindari merokok setidaknya 2 jam setelah donor</li>
                        <li>Hindari konsumsi alkohol minimal 24 jam setelah donor</li>
                        <li>Jika terjadi pendarahan di bekas tusukan, tekan dan angkat lengan di atas jantung</li>
                        <li>Segera hubungi petugas medis jika mengalami gejala seperti pusing berkepanjangan, mual atau demam</li>
                    </ul>
                `
            }
        };

        // Fungsi untuk menampilkan modal info
        function showInfo(type) {
            const info = infoData[type];
            if (!info) return;

            const modalTitle = document.getElementById("infoModalLabel");
            const modalContent = document.getElementById("modalContent");

            modalTitle.innerHTML = info.title;
            modalContent.innerHTML = info.content;

            const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
            infoModal.show();
        }

    const stokDarah = <?php echo $stokJson; ?>;

    const chartData = {
        labels: ["A", "B", "AB", "O"],
        datasets: [{
            label: "Jumlah Stok Darah",
            data: [stokDarah['A'], stokDarah['B'], stokDarah['AB'], stokDarah['O']],
            backgroundColor: [
  "rgba(220, 53, 69, 0.7)",   // #dc3545
  "rgba(13, 110, 253, 0.7)",  // #0d6efd
  "rgba(32, 201, 151, 0.7)",  // #20c997
  "rgba(253, 126, 20, 0.7)"   // #fd7e14
]

        }]
    };

    const chartConfig = {
        type: "bar",
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Stok Darah Tersedia',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    display: false
                }
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById("stokDarahChart").getContext("2d");
        window.stokChart = new Chart(ctx, chartConfig);
    });

    function updateStokDarah() {
        const lokasi = document.getElementById('filterLokasi').value;
        fetch('stok_darah.php?lokasi=' + lokasi)
            .then(response => response.json())
            .then(data => {
                window.stokChart.data.datasets[0].data = [
                    data['A'] || 0,
                    data['B'] || 0,
                    data['AB'] || 0,
                    data['O'] || 0
                ];
                window.stokChart.update();
            });
    }
</script>
<script>
    AOS.init({
        duration: 3000,
        once: true
    });
</script>
</body>
</html>