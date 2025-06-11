<!DOCTYPE html>
<html>
<head>
    <title>Scan QR - Verifikasi Donor</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        /* Pastikan elemen video tidak terbalik */
        #reader video {
            transform: rotate(0deg) !important;
        }
    </style>
</head>
<body>
    <div id="reader" style="width:600px; height:400px;"></div>
    <div id="result"></div>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Tampilkan QR yang berhasil dibaca
            document.getElementById('result').innerHTML = "<p><strong>QR Terdeteksi:</strong><br>" + decodedText + "</p>";
            // Kirim QR ke server untuk verifikasi
            fetch('verifikasi_qr.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'qr_data=' + encodeURIComponent(decodedText)
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('result').innerHTML += html;
            });

            // Stop scanning after success
            html5QrcodeScanner.clear();
        }
        // Konfigurasi scanner dengan kualitas lebih baik dan area pemindai lebih besar
        var html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
            fps: 20, // Mempercepat frame per second untuk deteksi yang lebih cepat
            qrbox: 500, // Ukuran kotak pemindai lebih besar agar QR lebih mudah terbaca
            aspectRatio: 1.5, // Menyesuaikan rasio aspek untuk kualitas yang lebih baik
            rememberLastUsedCamera: true,
            mirror: false // Nonaktifkan efek mirror pada kamera
        });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
