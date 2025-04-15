<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Darah & Lokasi Donor</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
   
    <div class="container">
        <h1>Informasi Proses Donor</h1>

        <!-- Timeline Proses Donor -->
        <div class="timeline">
            <div class="timeline-item">
                <h3>Sebelum Donor</h3>
                <p>Pastikan Anda dalam kondisi sehat, tidur cukup, dan makan makanan bergizi sebelum mendonorkan darah.</p>
            </div>
            <div class="timeline-item">
                <h3>Saat Donor</h3>
                <p>Proses donor biasanya berlangsung sekitar 10-15 menit. Pastikan tetap tenang dan rileks.</p>
            </div>
            <div class="timeline-item">
                <h3>Setelah Donor</h3>
                <p>Istirahat sebentar, minum air putih yang cukup, dan hindari aktivitas berat selama beberapa jam.</p>
            </div>
        </div>

        <!-- Checklist Persiapan Donor -->
        <h2>Checklist Persiapan Donor</h2>
        <ul class="checklist">
            <li><input type="checkbox"> Tidur minimal 6 jam sebelum donor</li>
            <li><input type="checkbox"> Konsumsi makanan bergizi</li>
            <li><input type="checkbox"> Tidak mengonsumsi alkohol atau merokok sebelum donor</li>
            <li><input type="checkbox"> Minum air putih sebelum datang</li>
            <li><input type="checkbox"> Membawa kartu identitas</li>
        </ul>

        <h2>Stok Darah</h2>
        <!-- Filter Lokasi -->
        <select id="filterLokasi" onchange="updateStokDarah()">
            <option value="all">Semua Lokasi</option>
            <option value="jakarta">Jakarta</option>
            <option value="surabaya">Surabaya</option>
            <option value="bandung">Bandung</option>
        </select>

        <!-- Grafik Stok Darah -->
        <canvas id="stokDarahChart"></canvas>

        <!-- Notifikasi Stok Darah Menipis -->
        <div id="alertStok" class="alert hidden">⚠️ Stok darah golongan O menipis!</div>

        <h2>Lokasi Fasilitas Donor</h2>
        <div id="map" style="width: 100%; height: 400px;"></div>

        <!-- List Fasilitas -->
        <div id="listFasilitas">
            <div class="fasilitas">
                <h3>PMI Jakarta</h3>
                <p>Alamat: Jl. Kramat Raya No.47, Jakarta</p>
                <p>Kontak: 021-3906666</p>
                <button onclick="navigateTo(-6.186486, 106.834091)">Navigasi</button>
            </div>
            <div class="fasilitas">
                <h3>RS Dr. Soetomo, Surabaya</h3>
                <p>Alamat: Jl. Mayjen Prof. Dr. Moestopo No.6-8, Surabaya</p>
                <p>Kontak: 031-5501321</p>
                <button onclick="navigateTo(-7.270646, 112.758469)">Navigasi</button>
            </div>
        </div>
    </div>

    <script>
        function updateStokDarah() {
            var stokDarah = {
                all: [50, 40, 60, 30],
                jakarta: [10, 8, 15, 5],
                surabaya: [20, 15, 25, 10],
                bandung: [20, 17, 20, 15]
            };

            var lokasi = document.getElementById("filterLokasi").value;
            var dataStok = stokDarah[lokasi] || stokDarah['all'];
            
            stokChart.data.datasets[0].data = dataStok;
            stokChart.update();

            document.getElementById("alertStok").classList.toggle("hidden", dataStok[3] > 10);
        }

        // Grafik Stok Darah
        var ctx = document.getElementById("stokDarahChart").getContext("2d");
        var stokChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["A", "B", "AB", "O"],
                datasets: [{
                    label: "Jumlah Stok",
                    data: [50, 40, 60, 30],
                    backgroundColor: ["red", "blue", "green", "orange"]
                }]
            }
        });

        // Google Maps
        function initMap() {
            var map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -6.200000, lng: 106.816666 },
                zoom: 5
            });

            var locations = [
                { lat: -6.186486, lng: 106.834091, name: "PMI Jakarta" },
                { lat: -7.270646, lng: 112.758469, name: "RS Dr. Soetomo, Surabaya" }
            ];

            locations.forEach(loc => {
                new google.maps.Marker({
                    position: { lat: loc.lat, lng: loc.lng },
                    map: map,
                    title: loc.name
                });
            });
        }

        function navigateTo(lat, lng) {
            window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
        }
    </script>
</body>
</html>
