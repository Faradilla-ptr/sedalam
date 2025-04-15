<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Donor Darah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .faq-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .faq-item.active {
            background-color: #007bff;
            color: white;
        }
        .faq-answer {
            display: none;
            padding: 10px;
            color: #555;
            margin-bottom: 10px;
        }
        .arrow {
            transition: transform 0.3s;
        }
        .faq-item.active .arrow {
            transform: rotate(90deg);
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Pertanyaan Umum (FAQ) Donor Darah</h2>

    <!-- Pencarian FAQ -->
    <input type="text" id="searchFaq" class="form-control mb-3" placeholder="Cari pertanyaan...">

    <!-- Kategori FAQ -->
    <div class="mb-3">
        <button class="btn btn-primary filter-btn" onclick="filterFAQ('all')">Semua</button>
        <button class="btn btn-secondary filter-btn" onclick="filterFAQ('persiapan')">Persiapan</button>
        <button class="btn btn-secondary filter-btn" onclick="filterFAQ('proses')">Proses</button>
        <button class="btn btn-secondary filter-btn" onclick="filterFAQ('pasca')">Pasca Donor</button>
    </div>

    <div id="faqContainer">
        <div class="faq-item persiapan" onclick="toggleAnswer(this)">
            <span>Apa persiapan sebelum donor darah?</span>
            <span class="arrow">▶</span>
        </div>
        <div class="faq-answer">Pastikan cukup tidur, makan bergizi, dan minum air putih.</div>

        <div class="faq-item persiapan" onclick="toggleAnswer(this)">
            <span>Apakah ada batasan makanan sebelum donor?</span>
            <span class="arrow">▶</span>
        </div>
        <div class="faq-answer">Hindari makanan berlemak tinggi dan kafein agar hasil darah lebih optimal.</div>

        <div class="faq-item proses" onclick="toggleAnswer(this)">
            <span>Berapa lama waktu yang dibutuhkan untuk donor darah?</span>
            <span class="arrow">▶</span>
        </div>
        <div class="faq-answer">Proses donor darah biasanya memakan waktu sekitar 10-15 menit.</div>

        <div class="faq-item proses" onclick="toggleAnswer(this)">
            <span>Apakah donor darah sakit?</span>
            <span class="arrow">▶</span>
        </div>
        <div class="faq-answer">Donor darah hanya melibatkan sedikit rasa tidak nyaman saat jarum dimasukkan, tetapi umumnya tidak sakit.</div>

        <div class="faq-item pasca" onclick="toggleAnswer(this)">
            <span>Apa yang harus dilakukan setelah donor darah?</span>
            <span class="arrow">▶</span>
        </div>
        <div class="faq-answer">Minum air putih yang cukup, hindari aktivitas berat, dan istirahat jika merasa lelah.</div>

        <div class="faq-item pasca" onclick="toggleAnswer(this)">
            <span>Kapan saya bisa donor darah lagi?</span>
            <span class="arrow">▶</span>
        </div>
        <div class="faq-answer">Pria dapat mendonorkan darah setiap 12 minggu, sedangkan wanita setiap 16 minggu.</div>
    </div>
</div>

<script>
// Toggle jawaban saat pertanyaan diklik
function toggleAnswer(element) {
    let answer = element.nextElementSibling;
    let isActive = element.classList.contains("active");

    // Tutup semua pertanyaan sebelum membuka yang baru
    document.querySelectorAll(".faq-item").forEach(item => {
        item.classList.remove("active");
        item.nextElementSibling.style.display = "none";
    });

    // Jika pertanyaan tidak aktif sebelumnya, buka
    if (!isActive) {
        element.classList.add("active");
        answer.style.display = "block";
    }
}

// Pencarian FAQ
document.getElementById('searchFaq').addEventListener('keyup', function() {
    let searchText = this.value.toLowerCase();
    let faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        let question = item.querySelector('span').innerText.toLowerCase();
        item.style.display = question.includes(searchText) ? "flex" : "none";
        item.nextElementSibling.style.display = "none"; // Tutup jawaban saat pencarian berubah
        item.classList.remove("active"); // Hapus status aktif dari pertanyaan lain
    });
});

// Filter FAQ berdasarkan kategori
function filterFAQ(category) {
    let faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        item.style.display = (category === "all" || item.classList.contains(category)) ? "flex" : "none";
        item.nextElementSibling.style.display = "none"; // Tutup jawaban saat filter berubah
        item.classList.remove("active"); // Hapus status aktif dari pertanyaan lain
    });

    // Update tombol kategori aktif
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('btn-primary'));
    event.target.classList.add('btn-primary');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
