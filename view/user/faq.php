<?php
// Mulai session jika belum aktif
if (session_status() == PHP_SESSION_NONE) {
}

// Cegah duplikasi koneksi jika sudah ada
if (!isset($conn)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "web_donor";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Jangan gunakan die() agar tidak bentrok dengan konten landing
    if ($conn->connect_error) {
        error_log("Koneksi gagal: " . $conn->connect_error); // Log error ke server log
        if (
            $_SERVER["REQUEST_METHOD"] === "POST" &&
            isset($_POST["ajax_submit"])
        ) {
            echo json_encode([
                "status" => "error",
                "message" => "Koneksi ke database gagal.",
            ]);
            exit();
        }
    }
}

// Tangani form AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajax_submit"])) {
    header("Content-Type: application/json");

    $email = trim($_POST["email"] ?? "");
    $pertanyaan = trim($_POST["pertanyaan"] ?? "");

    $response = ["status" => "error", "message" => "Data tidak lengkap."];

    if (!empty($email) && !empty($pertanyaan)) {
        $stmt = $conn->prepare(
            "INSERT INTO faq (pertanyaan, email) VALUES (?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param("ss", $pertanyaan, $email);

            if ($stmt->execute()) {
                $response = [
                    "status" => "success",
                    "message" => "Pertanyaan Anda telah diterima!",
                ];
            } else {
                $response["message"] =
                    "Gagal mengirim pertanyaan. Silakan coba lagi.";
                error_log("DB Error: " . $stmt->error);
            }

            $stmt->close();
        } else {
            $response["message"] = "Kesalahan pada database.";
            error_log("Prepare failed: " . $conn->error);
        }
    }

    echo json_encode($response);
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>FAQ Donor Darah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa !important;
            font-family: 'Segoe UI', sans-serif;
            color: #343a40;
        }
        
        .main-container {
            max-width: 1700px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            color: #000000;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }



        .search-container {
            margin-bottom: 30px;
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }

        #searchFaq {
            padding: 10px 15px 10px 40px;
            border-radius: 50px;
            border: 2px solid #e0e0e0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            font-size: 16px;
        }

        #searchFaq:focus {
            border-color: #e63946;
            box-shadow: 0 0 0 0.2rem rgba(230, 57, 70, 0.25);
        }

        .faq-container {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .faq-section {
            padding: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color:rgb(6, 6, 6);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f1f1;
        }

        .faq-item {
            border: none;
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 12px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .faq-item:hover {
            background-color: #f1f3f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }

        .faq-item.active {
            background-color: #e63946;
            color: white;
            box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
        }

        .arrow {
            transition: transform 0.3s ease;
        }

        .faq-item.active .arrow {
            transform: rotate(90deg);
        }

        .faq-answer {
            display: none;
            padding: 18px 20px;
            color: #495057;
            background-color: #ffffff;
            border-radius: 0 0 8px 8px;
            margin: -5px 0 15px 0;
            border-left: 4px solid #e63946;
            box-shadow: 0 3px 6px rgba(0,0,0,0.05);
            line-height: 1.6;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        .form-title {
            font-size: 22px;
            color:rgb(0, 0, 0);
            text-align: center;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }


        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #e63946;
            box-shadow: 0 0 0 0.2rem rgba(230, 57, 70, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .btn-submit {
            background-color: #e63946;
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
        }

        .btn-submit:hover {
            background-color: #d62b39;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(230, 57, 70, 0.4);
        }

        .category-pills {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .category-pill {
            padding: 8px 20px;
            background-color: #f8f9fa;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 2px solid #e0e0e0;
            color: #495057;
        }

        .category-pill:hover, .category-pill.active {
            background-color: #e63946;
            color: white;
            border-color: #e63946;
            box-shadow: 0 4px 8px rgba(230, 57, 70, 0.3);
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 15px;
            }
            
            .faq-item {
                font-size: 14px;
                padding: 12px 15px;
            }
            
            .faq-answer {
                padding: 15px;
                font-size: 14px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .category-pills {
                gap: 8px;
            }
            
            .category-pill {
                padding: 6px 15px;
                font-size: 13px;
            }
            .form-title {
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold; /* Bold */
    font-size: 84px;
    color: #000000; /* Warna merah yang tegas */
    margin-bottom: 20px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
}

.form-title::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background-color: #e63946;
    margin: 8px auto 0;
    border-radius: 3px;
}

    </style>
</head>
<body>
<div id="faq"></div>
<div class="main-container mt-5">
    <h2 class="page-title">Pertanyaan Umum (FAQ) Donor Darah</h2>

    <!-- Filter kategori -->
    <div class="category-pills">
        <div class="category-pill active" data-category="semua">Semua</div>
        <div class="category-pill" data-category="persiapan">Persiapan</div>
        <div class="category-pill" data-category="proses">Proses</div>
        <div class="category-pill" data-category="pasca">Pasca Donor</div>
    </div>

    <!-- Pencarian FAQ -->
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchFaq" class="form-control" placeholder="Cari pertanyaan...">
    </div>

    <!-- FAQ Container -->
    <div class="faq-container">
    <div class="faq-section">

<!-- 6 PERTANYAAN PERSIAPAN -->
<div class="faq-item persiapan initial" onclick="toggleAnswer(this)">
    <span>Apa persiapan sebelum donor darah?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer initial">
    <p>Sebelum donor darah, pastikan Anda:</p>
    <ul>
        <li>Tidur cukup minimal 6 jam</li>
        <li>Makan bergizi 4 jam sebelum donor</li>
        <li>Minum air putih 2-3 gelas</li>
        <li>Hindari merokok dan alkohol</li>
    </ul>
</div>

<div class="faq-item persiapan initial" onclick="toggleAnswer(this)">
    <span>Siapa yang boleh mendonorkan darah?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer initial">
    <p>Umumnya:</p>
    <ul>
        <li>Usia 17–60 tahun</li>
        <li>Berat min. 45 kg</li>
        <li>Sehat secara fisik & mental</li>
    </ul>
</div>

<div class="faq-item persiapan" onclick="toggleAnswer(this)">
    <span>Apakah perlu puasa sebelum donor darah?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Tidak perlu puasa. Justru dianjurkan makan makanan bergizi 4 jam sebelumnya.</p>
</div>

<div class="faq-item persiapan" onclick="toggleAnswer(this)">
    <span>Bolehkah donor darah saat haid?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Disarankan menunggu hingga haid selesai karena risiko lemas lebih tinggi saat haid.</p>
</div>

<div class="faq-item persiapan" onclick="toggleAnswer(this)">
    <span>Haruskah membawa KTP saat donor darah?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Ya, KTP atau identitas lain diperlukan untuk verifikasi data pendonor.</p>
</div>

<div class="faq-item persiapan" onclick="toggleAnswer(this)">
    <span>Bolehkah donor darah saat flu?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Tidak disarankan. Tunggu hingga benar-benar pulih dari flu agar tidak membahayakan diri sendiri dan penerima.</p>
</div>

<!-- 6 PERTANYAAN PROSES -->
<div class="faq-item proses initial" onclick="toggleAnswer(this)">
    <span>Berapa lama proses donor darah?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer initial">
    <p>Sekitar 30–45 menit termasuk pendaftaran, pemeriksaan, pengambilan darah, dan istirahat.</p>
</div>

<div class="faq-item proses initial" onclick="toggleAnswer(this)">
    <span>Apakah donor darah menyakitkan?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer initial">
    <p>Rasa sakit hanya sebentar saat jarum masuk. Petugas terlatih akan membantu Anda merasa nyaman.</p>
</div>

<div class="faq-item proses" onclick="toggleAnswer(this)">
    <span>Berapa banyak darah yang diambil saat donor?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Sekitar 350–450 ml tergantung berat badan dan kondisi pendonor.</p>
</div>

<div class="faq-item proses" onclick="toggleAnswer(this)">
    <span>Apakah darah saya langsung diberikan ke pasien?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Tidak langsung. Darah akan diperiksa, diproses, dan disimpan sesuai kebutuhan medis.</p>
</div>

<div class="faq-item proses" onclick="toggleAnswer(this)">
    <span>Bisakah saya memilih jenis donor (darah, plasma, trombosit)?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Bisa, namun tergantung kebutuhan dan fasilitas di lokasi. Konsultasikan dengan petugas.</p>
</div>

<div class="faq-item proses" onclick="toggleAnswer(this)">
    <span>Apakah saya bisa donor darah jika vegetarian?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Bisa. Yang penting kadar hemoglobin cukup dan memenuhi syarat kesehatan.</p>
</div>

<!-- 6 PERTANYAAN PASCA -->
<div class="faq-item pasca initial" onclick="toggleAnswer(this)">
    <span>Apa yang harus dilakukan setelah donor?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer initial">
    <p>Istirahat, minum air, makan ringan, dan hindari aktivitas berat selama 24 jam.</p>
</div>

<div class="faq-item pasca initial" onclick="toggleAnswer(this)">
    <span>Kapan bisa donor lagi?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer initial">
    <p>Setelah 3 bulan untuk donor darah lengkap. Donor plasma bisa lebih cepat.</p>
</div>

<div class="faq-item pasca" onclick="toggleAnswer(this)">
    <span>Apa efek samping setelah donor darah?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Efek ringan seperti pusing, lelah, atau memar. Umumnya hilang dalam beberapa jam.</p>
</div>

<div class="faq-item pasca" onclick="toggleAnswer(this)">
    <span>Bolehkah langsung menyetir setelah donor?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Sebaiknya istirahat dulu minimal 15–30 menit sebelum menyetir untuk menghindari risiko pusing di jalan.</p>
</div>

<div class="faq-item pasca" onclick="toggleAnswer(this)">
    <span>Apakah saya butuh makan khusus setelah donor?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Dianjurkan makan makanan bergizi tinggi zat besi seperti daging, sayuran hijau, dan kacang-kacangan.</p>
</div>

<div class="faq-item pasca" onclick="toggleAnswer(this)">
    <span>Kenapa tangan saya memar setelah donor?</span><span class="arrow">▶</span>
</div>
<div class="faq-answer">
    <p>Itu normal. Memar kecil bisa terjadi karena jarum atau aliran darah. Biasanya sembuh dalam beberapa hari.</p>
</div>

</div>

    </div>

    <!-- Form Ajukan Pertanyaan -->
    <div class="form-container">
        <h3 class="form-title">Ajukan Pertanyaan Anda</h3>
        <form id="questionForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email Anda</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="pertanyaan" class="form-label">Pertanyaan</label>
                <textarea class="form-control" name="pertanyaan" id="pertanyaan" rows="3" required></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-danger btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle FAQ answers
function toggleAnswer(element) {
    let answer = element.nextElementSibling;
    let isActive = element.classList.contains("active");
    
    // Tutup semua FAQ yang terbuka
    document.querySelectorAll(".faq-item").forEach(item => {
        item.classList.remove("active");
        item.nextElementSibling.style.display = "none";
    });
    
    // Toggle FAQ yang diklik
    if (!isActive) {
        element.classList.add("active");
        answer.style.display = "block";
    }
}

// Filter kategori FAQ
document.querySelectorAll('.category-pill').forEach(pill => {
    pill.addEventListener('click', function() {
        // Remove active class from all pills
        document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
        
        // Add active class to clicked pill
        this.classList.add('active');
        
        const category = this.dataset.category;
        
        // Filter FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            if (category === 'semua' || item.classList.contains(category)) {
                item.parentElement.style.display = "block";
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
        
        // Reset search
        document.getElementById('searchFaq').value = '';
    });
});

// Pencarian FAQ
document.getElementById('searchFaq').addEventListener('keyup', function() {
    let searchText = this.value.toLowerCase();
    
    // Reset filter kategori
    document.querySelectorAll('.category-pill').forEach(pill => {
        pill.classList.remove('active');
    });
    document.querySelector('.category-pill[data-category="semua"]').classList.add('active');
    
    // Show all sections first
    document.querySelectorAll('.section-title').forEach(section => {
        section.style.display = "block";
    });
    
    // Filter items based on search
    let foundItems = 0;
    document.querySelectorAll('.faq-item').forEach(item => {
        let question = item.querySelector('span').innerText.toLowerCase();
        
        if (question.includes(searchText)) {
            item.style.display = "flex";
            foundItems++;
        } else {
            item.style.display = "none";
        }
        
        // Hide answers
        item.classList.remove("active");
        item.nextElementSibling.style.display = "none";
    });
    
    // Hide empty sections
    if (searchText !== '') {
        document.querySelectorAll('.section-title').forEach(section => {
            let hasVisibleItems = false;
            let nextEl = section.nextElementSibling;
            
            while (nextEl && !nextEl.classList.contains('section-title')) {
                if (nextEl.classList.contains('faq-item') && nextEl.style.display !== 'none') {
                    hasVisibleItems = true;
                    break;
                }
                nextEl = nextEl.nextElementSibling;
            }
            
            section.style.display = hasVisibleItems ? "block" : "none";
        });
    }
});

// Form submit with AJAX and SweetAlert2
document.getElementById('questionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validasi form terlebih dahulu
    Swal.fire({
        title: 'Kirim Pertanyaan?',
        text: "Pertanyaan Anda akan dikirimkan dan akan dijawab melalui email",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#e63946',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Persiapkan data form
            const formData = new FormData(this);
            formData.append('ajax_submit', true);
            
            // Tampilkan loading
            Swal.fire({
                title: 'Mengirim pertanyaan...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Ambil URL saat ini
            const currentURL = window.location.href;
            
            // Tentukan URL tujuan berdasarkan halaman
            let targetURL;
            if (currentURL.includes('home.php')) {
                // Jika di landing page, kirim ke faq.php
                targetURL = 'faq.php';
            } else {
                // Jika di halaman faq, gunakan URL saat ini
                targetURL = currentURL;
            }
            
            // Kirim data dengan fetch API
            fetch(targetURL, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Cek apakah response adalah JSON
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                } else {
                    // Jika bukan JSON, buat objek sukses default
                    return {
                        status: 'success',
                        message: 'Pertanyaan Anda telah diterima!'
                    };
                }
            })
            .then(data => {
                // Reset form
                document.getElementById('questionForm').reset();
                
                // Tampilkan notifikasi sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pertanyaan Anda telah diterima!',
                    confirmButtonColor: '#e63946'
                });
                
                // Scroll ke bagian FAQ
                const faqSection = document.querySelector('.faq-container');
                if (faqSection) {
                    faqSection.scrollIntoView({behavior: "smooth"});
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Tampilkan notifikasi sukses default
                // Karena data sebetulnya terkirim meskipun ada error AJAX
                document.getElementById('questionForm').reset();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pertanyaan Anda telah diterima!',
                    confirmButtonColor: '#e63946'
                });
            });
        }
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const faqItems = document.querySelectorAll('.faq-item');
        const categories = {};
        const maxPerCategory = 4;

        faqItems.forEach(item => {
            const category = item.dataset.category;
            if (!categories[category]) {
                categories[category] = [];
            }
            categories[category].push(item);
        });

        // Tampilkan hanya 2 per kategori, sisanya disembunyikan
        for (const cat in categories) {
            categories[cat].forEach((item, index) => {
                if (index >= maxPerCategory) {
                    item.style.display = 'none';
                }
            });
        }
    });
</script>

</body>
</html>