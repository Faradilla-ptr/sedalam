<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel dan Video Edukasi Donor Darah</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .filter-section {
            text-align: center;
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .grid-item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .grid-item:hover {
            transform: scale(1.05);
        }
        .grid-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .grid-item h3 {
            padding: 15px;
            font-size: 18px;
        }
        .grid-item p {
            padding: 0 15px;
            font-size: 14px;
            color: #555;
        }
        .btn {
            display: block;
            text-align: center;
            background: #d9534f;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="filter-section">
            <h2>Filter Berdasarkan Kategori</h2>
            <select id="categoryFilter" onchange="filterContent()">
                <option value="all">Semua Kategori</option>
                <option value="artikel">Artikel Edukasi</option>
                <option value="video">Video Edukasi</option>
            </select>
        </div>

        <div id="contentGrid" class="grid-container">
            <div class="grid-item artikel">
                <h3>Manfaat Donor Darah bagi Kesehatan</h3>
                <p>Donor darah tidak hanya bermanfaat bagi penerima, tetapi juga memberikan manfaat kesehatan bagi pendonor...</p>
                <a href="https://www.halodoc.com/artikel/ini-9-manfaat-donor-darah-secara-rutin-untuk-kesehatan" class="btn" target="_blank">Baca Selengkapnya</a>
            </div>
            <div class="grid-item artikel">
                
                <h3>Persiapan Sebelum Melakukan Donor Darah</h3>
                <p>Sebelum mendonorkan darah, ada beberapa persiapan yang perlu dilakukan untuk memastikan proses berjalan lancar...</p>
                <a href="https://www.halodoc.com/artikel/8-hal-yang-perlu-dilakukan-sebelum-donor-darah" class="btn" target="_blank">Baca Selengkapnya</a>
            </div>
            <div class="grid-item video">
                
                <h3>Edukasi Donor Darah Sukarela</h3>
                <p>Video ini memberikan edukasi tentang pentingnya donor darah sukarela dan manfaatnya bagi kesehatan...</p>
                <a href="https://youtu.be/YmLwXsqsSvw" class="btn" target="_blank">Tonton Video</a>
            </div>
            <div class="grid-item video">
                
                <h3>Manfaat Donor Darah bagi Tubuh</h3>
                <p>Pelajari berbagai manfaat yang didapatkan dari mendonorkan darah secara rutin melalui video edukasi ini...</p>
                <a href="https://youtu.be/gpWzpbK3PDc" class="btn" target="_blank">Tonton Video</a>
            </div>
        </div>
    </div>

    <script>
        function filterContent() {
            var filter = document.getElementById("categoryFilter").value;
            var items = document.getElementsByClassName("grid-item");

            for (var i = 0; i < items.length; i++) {
                if (filter === "all") {
                    items[i].style.display = "block";
                } else if (items[i].classList.contains(filter)) {
                    items[i].style.display = "block";
                } else {
                    items[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>