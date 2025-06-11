<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_donor";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
if (!isset($_SESSION["user_id"])) {
    header("Location: login_user.php");
    exit();
}
$id_pendonor = $_SESSION["user_id"];
// Proses pencarian data user (AJAX request)
if (
    isset($_GET["action"]) &&
    $_GET["action"] == "search" &&
    isset($_GET["nama"])
) {
    $nama = trim($_GET["nama"]);

    if (strlen($nama) < 5) {
        echo json_encode([
            "success" => false,
            "message" => "Masukkan nama lengkap (minimal 5 karakter).",
        ]);
        exit();
    }

    // Gunakan pencocokan nama secara tepat (bukan LIKE)
    $sql = "SELECT nik, golongan_darah, email, tanggal_lahir, gender, telepon, alamat 
    FROM akun 
    WHERE nama = '$nama' AND id = '$id_pendonor'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode([
            "success" => true,
            "nik" => $data["nik"],
            "golongan_darah" => $data["golongan_darah"],
            "email" => $data["email"],
            "tanggal_lahir" => $data["tanggal_lahir"],
            "gender" => $data["gender"],
            "telepon" => $data["telepon"],
            "alamat" => $data["alamat"],
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Nama tidak ditemukan atau tidak lengkap.",
        ]);
    }
    exit();
}

// Proses request OTP (AJAX)
if (
    isset($_GET["action"]) &&
    $_GET["action"] == "request_otp" &&
    isset($_GET["hp"])
) {
    $hp = $_GET["hp"];

    // Cek apakah user sudah mencapai batas percobaan OTP
    if (
        isset($_SESSION["otp_blocked_until"]) &&
        $_SESSION["otp_blocked_until"] > time()
    ) {
        $remaining_time = $_SESSION["otp_blocked_until"] - time();
        echo json_encode([
            "success" => false,
            "message" =>
                "Terlalu banyak percobaan. Harap tunggu " .
                ceil($remaining_time / 60) .
                " menit " .
                $remaining_time % 60 .
                " detik lagi.",
        ]);
        exit();
    }

    // Reset counter jika ini adalah permintaan baru setelah kadaluwarsa
    if (
        !isset($_SESSION["otp_attempts"]) ||
        (isset($_SESSION["otp_last_attempt_time"]) &&
            time() - $_SESSION["otp_last_attempt_time"] >= 600)
    ) {
        // Changed to 10 minutes
        $_SESSION["otp_attempts"] = 0;
    }

    // Generate OTP
    $otp = mt_rand(100000, 999999);
    $_SESSION["otp"] = $otp;
    $_SESSION["otp_time"] = time();
    $_SESSION["otp_hp"] = $hp;
    $_SESSION["otp_attempts"] = isset($_SESSION["otp_attempts"])
        ? $_SESSION["otp_attempts"]
        : 0;
    $_SESSION["otp_last_attempt_time"] = time();

    // Kirim OTP ke WhatsApp dengan pesan
    $pesan =
        "Halo, berikut adalah kode OTP Anda: " .
        $otp .
        ". Kode berlaku selama 10 menit."; // Changed to 10 minutes
    $url = "https://wa.me/" . $hp . "?text=" . urlencode($pesan);

    echo json_encode([
        "success" => true,
        "message" => "OTP telah dikirim, silakan cek WhatsApp Anda.",
        "url" => $url,
    ]);
    exit();
}
if (
    isset($_GET["action"]) &&
    $_GET["action"] == "verify_otp" &&
    isset($_GET["otp"]) &&
    isset($_GET["hp"])
) {
    $input_otp = trim($_GET["otp"]);
    $hp = trim($_GET["hp"]);

    // Format HP (harus sama seperti saat kirim OTP)
    if (strpos($hp, "0") === 0) {
        $hp = "62" . substr($hp, 1);
    }

    // Cek jika sedang dalam masa block
    if (
        isset($_SESSION["otp_blocked_until"]) &&
        $_SESSION["otp_blocked_until"] > time()
    ) {
        $remaining_time = $_SESSION["otp_blocked_until"] - time();
        echo json_encode([
            "success" => false,
            "blocked" => true,
            "message" =>
                "Terlalu banyak percobaan. Harap tunggu " .
                ceil($remaining_time / 60) .
                " menit " .
                $remaining_time % 60 .
                " detik lagi.",
        ]);
        exit();
    }

    $valid = false;

    // Validasi OTP
    if (
        isset($_SESSION["otp"]) &&
        isset($_SESSION["otp_time"]) &&
        isset($_SESSION["otp_hp"]) &&
        time() - $_SESSION["otp_time"] <= 600 && // 10 menit
        $_SESSION["otp"] == $input_otp &&
        $_SESSION["otp_hp"] == $hp
    ) {
        $valid = true;
        $_SESSION["otp_verified"] = true;
        $_SESSION["otp_attempts"] = 0;
        unset($_SESSION["otp_blocked_until"]);
    } else {
        // Tambah percobaan gagal
        $_SESSION["otp_attempts"] = isset($_SESSION["otp_attempts"])
            ? $_SESSION["otp_attempts"] + 1
            : 1;
        $_SESSION["otp_last_attempt_time"] = time();

        // Blokir jika 3 kali gagal
        if ($_SESSION["otp_attempts"] >= 3) {
            $_SESSION["otp_blocked_until"] = time() + 600;
            echo json_encode([
                "success" => false,
                "blocked" => true,
                "message" =>
                    "Terlalu banyak percobaan salah. Harap tunggu 10 menit sebelum mencoba lagi.",
            ]);
            exit();
        }
    }

    echo json_encode([
        "success" => $valid,
        "message" => $valid
            ? "OTP valid."
            : "OTP salah atau telah kedaluwarsa.",
        "attempts_left" => $valid ? 0 : 3 - $_SESSION["otp_attempts"],
    ]);
    exit();
}

// Ganti bagian upload dokumen dan insert data (sekitar baris 241-282) dengan kode berikut:

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $otp_verified =
        isset($_SESSION["otp_verified"]) && $_SESSION["otp_verified"] === true;

    if (!$otp_verified) {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'OTP Belum Diverifikasi',
                        text: 'Silakan verifikasi OTP terlebih dahulu.'
                    });
                  </script>";
    } else {
        // Ambil data dari form
        $nama = $_POST["nama"];
        $nik = $_POST["nik"];
        $golongan_darah = $_POST["golongan_darah"];
        $email = $_POST["email"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $gender = $_POST["gender_hidden"]; // Dari hidden field
        $hp = $_POST["hp"];
        $alamat = $_POST["alamat"];
        $tanggal = $_POST["tanggal"];
        $waktu = $_POST["waktu"];
        $lokasi = $_POST["lokasi"];
        $sehat = $_POST["sehat"];
        $obat = $_POST["obat"];
        $gejala = $_POST["gejala"];
        $otp = $_POST["otp"];
        $konfirmasi = isset($_POST["konfirmasi"]) ? 1 : 0;

        // PERTAMA: Insert data pengajuan tanpa dokumen terlebih dahulu
        $sql = "INSERT INTO pengajuan (
                id_pendonor, nama, nik, email, hp, tanggal, waktu, lokasi,
                sehat, obat, gejala, otp, konfirmasi
            ) VALUES (
                '$id_pendonor', '$nama', '$nik', '$email', '$hp', '$tanggal', '$waktu', '$lokasi',
                '$sehat', '$obat', '$gejala', '$otp', '$konfirmasi'
            )";

        if ($conn->query($sql) === true) {
            // Dapatkan ID pengajuan yang baru saja dibuat
            $id_pengajuan = $conn->insert_id;

            // KEDUA: Upload dokumen dengan nama yang menggunakan ID pengajuan
            $target_file = null;
            if (!empty($_FILES["dokumen"]["name"])) {
                $target_dir = "dokumen/";

                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $ext = pathinfo($_FILES["dokumen"]["name"], PATHINFO_EXTENSION);
                // Menggunakan ID pengajuan sebagai nama file
                $filename = "dokumen_pengajuan_" . $id_pengajuan . "." . $ext;
                $target_file = $target_dir . $filename;

                if (
                    move_uploaded_file(
                        $_FILES["dokumen"]["tmp_name"],
                        $target_file
                    )
                ) {
                    // Update record pengajuan dengan path dokumen
                    $update_sql = "UPDATE pengajuan SET dokumen = '$target_file' WHERE id = $id_pengajuan";
                    $conn->query($update_sql);
                }
            }

            // Reset OTP verification
            unset($_SESSION["otp"]);
            unset($_SESSION["otp_time"]);
            unset($_SESSION["otp_hp"]);
            unset($_SESSION["otp_verified"]);
            unset($_SESSION["otp_attempts"]);
            unset($_SESSION["otp_last_attempt_time"]);
            unset($_SESSION["otp_blocked_until"]);

            // Tampilkan SweetAlert sukses
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Pengajuan Berhasil!',
                text: 'Data pengajuan donor darah Anda telah berhasil disimpan dengan ID Pengajuan: $id_pengajuan',
                confirmButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'pengajuan_donor.php';
                }
            });
        </script>";
        } else {
            // Tampilkan SweetAlert error
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan data: " .
                $conn->error .
                "',
                confirmButtonColor: '#dc3545'
            });
        </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <title>Form Pengajuan Donor Darah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
                h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }
        body {
            background-color: #f8f9fa;
            
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
        }

        .content {
            margin-left: 270px;
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
        }

        .btn-submit:hover {
            background-color: #157347;
        }
        
        /* Untuk field yang tidak bisa diedit */
        .readonly-field {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        
        /* OTP Verification */
        .otp-container {
            display: none;
        }
        
        .otp-container.show {
            display: block;
        }
        
        .otp-status {
            padding: 5px 0;
            font-weight: 500;
        }
        
        .otp-verified {
            color: #198754;
        }
        
        .otp-pending {
            color: #ffc107;
        }
        
        .otp-error {
            color: #dc3545;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <div class="card">
        <h1 class="mb-3">Pengajuan Donor Darah</h1>
        <form id="donorForm" action="" method="POST" enctype="multipart/form-data">
            <!-- Form Data Diri -->
            <h5>Data Diri</h5>
            <div class="mb-3 d-flex align-items-center">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                <button type="button" id="cariNamaBtn" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="mb-3"><input type="text" class="form-control" name="nik" id="nik" placeholder="NIK" required readonly></div>
            <div class="mb-3"><input type="text" class="form-control" name="golongan_darah" id="golongan_darah" placeholder="Golongan Darah" required readonly></div>
            <div class="mb-3"><input type="email" class="form-control" name="email" id="email" placeholder="Email" required readonly></div>
            <div class="mb-3"><input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required readonly></div>
            <div class="mb-3">
                <select class="form-select" name="gender" id="gender" required disabled>
                    <option value="">-- Pilih Gender --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <input type="hidden" name="gender_hidden" id="gender_hidden">
            </div>
            <div class="mb-3"><input type="text" class="form-control" name="hp" id="hp" placeholder="Nomor HP" required readonly></div>
            <div class="mb-3"><textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" required readonly></textarea></div>


<input type="hidden" name="tanggal" id="tanggal_auto">
<input type="hidden" name="waktu" id="waktu_auto">

<p><strong>Tanggal:</strong> <span id="tanggal_display"></span></p>
<p><strong>Waktu:</strong> <span id="waktu_display"></span></p>

<script>
    const now = new Date();
    const tanggal = now.toISOString().slice(0, 10); // Format: YYYY-MM-DD
    const waktu = now.toTimeString().slice(0, 5);   // Format: HH:MM
    document.getElementById('tanggal_auto').value = tanggal;
    document.getElementById('waktu_auto').value = waktu;
    document.getElementById('tanggal_display').textContent = tanggal;
    document.getElementById('waktu_display').textContent = waktu;
</script>
            <h5>Lokasi Donor</h5>
            <div class="mb-3">
                <select class="form-select" name="lokasi" required>
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="UDD PMI Kabupaten Probolinggo ">UDD PMI Kabupaten Probolinggo</option>
                    <option value="UDD PMI Kota Probolinggo">UDD PMI Kota Probolinggo</option>
                    <option value="UDD PMI Kabupaten Jember">UDD PMI Kabupaten Jember</option>
                    <option value="UDD PMI Kabupaten Lumajang">UDD PMI Kabupaten Lumajang</option>
                    <option value="UDD PMI Kabupaten Bondowoso">UDD PMI Kabupaten Bondowoso</option>
                    <option value="UDD PMI Kabupaten Situbondo">UDD PMI Kabupaten Situbondo</option>
                    <option value="UDD PMI Kabupaten Banyuwangi">UDD PMI Kabupaten Banyuwangi</option>
                </select>
            </div>

            <h5>Screening Kesehatan</h5>
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="sehat" class="form-label">Kondisi Kesehatan</label>
        <select class="form-select" name="sehat" id="sehat" required>
            <option value="">-- Pilih --</option>
            <option value="Ya">Saya dalam kondisi sehat</option>
            <option value="Tidak">Saya sedang sakit</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="obat" class="form-label">Konsumsi Obat</label>
        <select class="form-select" name="obat" id="obat" required>
            <option value="">-- Pilih --</option>
            <option value="Tidak">Saya tidak mengonsumsi obat</option>
            <option value="Ya">Saya sedang mengonsumsi obat</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="gejala" class="form-label">Gejala Penyakit</label>
        <select class="form-select" name="gejala" id="gejala" required>
            <option value="">-- Pilih --</option>
            <option value="Tidak">Saya tidak mengalami gejala seperti demam, batuk, pilek</option>
            <option value="Ya">Saya sedang mengalami gejala tersebut</option>
        </select>
    </div>
</div>
            <h5>Upload Dokumen</h5>
            <div class="mb-3"><input type="file" class="form-control" name="dokumen"></div>
            <a href="template_1.php" target="_blank" class="btn btn-sm btn-outline-primary mb-2" title="Lihat Template Pengajuan">
    📄 Template
</a>

            <h5>Verifikasi OTP</h5>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-100" id="sendOtpBtn" onclick="kirimOTP()">
                    Kirim OTP ke WhatsApp
                </button>
                
                <div class="otp-container mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Masukkan OTP (6 Digit)" name="otp" id="otp-input" maxlength="6" required>
                        <button type="button" class="btn btn-success" id="verifyOtpBtn">Verifikasi</button>
                    </div>
                    <div class="otp-status otp-pending mt-1">
                        <i class="bi bi-clock"></i> Menunggu verifikasi OTP
                    </div>
                </div>
            </div>

            <h5>Konfirmasi</h5>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="konfirmasi" required>
                <label class="form-check-label">Saya menyatakan bahwa data yang diisi benar</label>
            </div>

            <button type="submit" class="btn btn-submit w-100" id="submitBtn" disabled>Kirim Pengajuan</button>
        </form>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Global variables
    let otpVerified = false;
    let userDataFilled = false;
    let otpCooldown = false;
    
    // Function untuk kirim OTP ke WhatsApp
    function kirimOTP() {
        var nomorHP = document.querySelector("input[name='hp']").value.trim();
        if (nomorHP === "") {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Masukkan nomor HP terlebih dahulu!' });
            return;
        }
        
        // Format nomor HP
        if (nomorHP.startsWith("0")) {
            nomorHP = "62" + nomorHP.substring(1);
        }
        
        // Disable button saat proses
        document.getElementById('sendOtpBtn').disabled = true;
        document.getElementById('sendOtpBtn').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim OTP...';
        
        // Request OTP ke server
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?action=request_otp&hp=' + encodeURIComponent(nomorHP), true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Tampilkan form input OTP
                        document.querySelector('.otp-container').classList.add('show');
                        
                        // Update status button
                        document.getElementById('sendOtpBtn').disabled = false;
                        document.getElementById('sendOtpBtn').innerHTML = 'Kirim Ulang OTP';
                        
                        // Buka WhatsApp untuk OTP
                        window.open(response.url, "_blank");
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Terkirim',
                            text: 'Kode OTP telah dikirim ke WhatsApp Anda. Silakan cek dan masukkan kode OTP.',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    } else {
                        // Kondisi ketika request OTP gagal (terlalu banyak percobaan)
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'OTP Dibatasi', 
                            text: response.message
                        });
                        document.getElementById('sendOtpBtn').disabled = false;
                        document.getElementById('sendOtpBtn').innerHTML = 'Kirim OTP ke WhatsApp';
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat memproses data.' });
                    document.getElementById('sendOtpBtn').disabled = false;
                    document.getElementById('sendOtpBtn').innerHTML = 'Kirim OTP ke WhatsApp';
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal terhubung ke server.' });
                document.getElementById('sendOtpBtn').disabled = false;
                document.getElementById('sendOtpBtn').innerHTML = 'Kirim OTP ke WhatsApp';
            }
        };
        xhr.send();
    }
    
    // Function untuk verifikasi OTP
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('verifyOtpBtn')) {
            document.getElementById('verifyOtpBtn').addEventListener('click', function() {
                var inputOTP = document.getElementById('otp-input').value.trim();
                var nomorHP = document.querySelector("input[name='hp']").value.trim();
                
                if (inputOTP.length !== 6) {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'OTP harus 6 digit!' });
                    return;
                }
                
                // Disable button saat verifikasi
                document.getElementById('verifyOtpBtn').disabled = true;
                document.getElementById('verifyOtpBtn').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                
                // Kirim verifikasi ke server
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '?action=verify_otp&otp=' + encodeURIComponent(inputOTP) + '&hp=' + encodeURIComponent(nomorHP), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            
                            // Cek jika user di-block karena terlalu banyak percobaan
                            if (response.blocked) {
                                document.querySelector('.otp-status').className = 'otp-status otp-error mt-1';
                                document.querySelector('.otp-status').innerHTML = '<i class="bi bi-x-circle-fill"></i> ' + response.message;
                                
                                // Disable semua input OTP
                                document.getElementById('otp-input').disabled = true;
                                document.getElementById('verifyOtpBtn').disabled = true;
                                document.getElementById('sendOtpBtn').disabled = true;
                                
                                // Tampilkan pesan block
                                Swal.fire({ 
                                    icon: 'error', 
                                    title: 'Akses Ditolak', 
                                    text: response.message,
                                    timer: 5000,
                                    timerProgressBar: true
                                });
                                
                                // Set timer untuk re-enable setelah masa block
                                setTimeout(function() {
                                    document.getElementById('otp-input').disabled = false;
                                    document.getElementById('verifyOtpBtn').disabled = false;
                                    document.getElementById('sendOtpBtn').disabled = false;
                                    document.querySelector('.otp-status').className = 'otp-status otp-pending mt-1';
                                    document.querySelector('.otp-status').innerHTML = '<i class="bi bi-clock"></i> Menunggu verifikasi OTP';
                                }, 600000); // 10 menit
                                
                                return;
                            }
                            
                            if (response.success) {
                                // OTP valid
                                otpVerified = true;
                                
                                // Update status
                                document.querySelector('.otp-status').className = 'otp-status otp-verified mt-1';
                                document.querySelector('.otp-status').innerHTML = '<i class="bi bi-check-circle-fill"></i> OTP Terverifikasi';
                                
                                // Disable semua input OTP
                                document.getElementById('otp-input').readOnly = true;
                                document.getElementById('otp-input').classList.add('readonly-field');
                                document.getElementById('verifyOtpBtn').disabled = true;
                                document.getElementById('sendOtpBtn').disabled = true;
                                
                                // Update tombol submit
                                checkFormCompletion();
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'OTP Terverifikasi',
                                    text: 'Verifikasi berhasil. Silakan lanjutkan pengisian form.',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                // OTP tidak valid
                                document.querySelector('.otp-status').className = 'otp-status otp-error mt-1';
                                document.querySelector('.otp-status').innerHTML = '<i class="bi bi-x-circle-fill"></i> OTP Tidak Valid (Sisa percobaan: ' + response.attempts_left + ')';
                                
                                Swal.fire({ 
                                    icon: 'error', 
                                    title: 'OTP Tidak Valid', 
                                    text: response.message + ' Sisa percobaan: ' + response.attempts_left
                                });
                                
                                document.getElementById('verifyOtpBtn').disabled = false;
                                document.getElementById('verifyOtpBtn').innerHTML = 'Verifikasi';
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat memproses data.' });
                            document.getElementById('verifyOtpBtn').disabled = false;
                            document.getElementById('verifyOtpBtn').innerHTML = 'Verifikasi';
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal terhubung ke server.' });
                        document.getElementById('verifyOtpBtn').disabled = false;
                        document.getElementById('verifyOtpBtn').innerHTML = 'Verifikasi';
                    }
                };
                xhr.send();
            });
        }
    
        // Script untuk pencarian data
        if (document.getElementById('cariNamaBtn')) {
            document.getElementById('cariNamaBtn').addEventListener('click', function() {
                var nama = document.getElementById('nama').value.trim();
                if (nama === "") {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Nama harus diisi terlebih dahulu!' });
                    return;
                }
                
                // AJAX request ke file ini sendiri
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '?action=search&nama=' + encodeURIComponent(nama), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            var data = JSON.parse(xhr.responseText);
                            if (data.success) {
                                // Isi data ke form
                                document.getElementById('nik').value = data.nik;
                                document.getElementById('golongan_darah').value = data.golongan_darah;
                                document.getElementById('email').value = data.email;
                                document.getElementById('tanggal_lahir').value = data.tanggal_lahir;
                                
                                // Untuk dropdown gender gunakan hidden field
                                document.getElementById('gender').value = data.gender;
                                document.getElementById('gender_hidden').value = data.gender;
                                
                                document.getElementById('hp').value = data.telepon;
                                document.getElementById('alamat').value = data.alamat;
                                
                                // Tambahkan class untuk styling readonly
                                document.querySelectorAll('#donorForm input[readonly], #donorForm textarea[readonly]').forEach(function(el) {
                                    el.classList.add('readonly-field');
                                });
                                
                                // Set flag data terisi
                                userDataFilled = true;
                                checkFormCompletion();
                                
                                Swal.fire({ 
                                    icon: 'success', 
                                    title: 'Data ditemukan', 
                                    text: 'Data pendonor berhasil ditemukan. Silakan kirim OTP untuk verifikasi.'
                                });
                            } else {
                                Swal.fire({ 
                                    icon: 'error', 
                                    title: 'Data tidak ditemukan', 
                                    text: 'Nama yang dimasukkan tidak ditemukan.'
                                });
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            Swal.fire({ 
                                icon: 'error', 
                                title: 'Error', 
                                text: 'Terjadi kesalahan saat memproses data.'
                            });
                        }
                    }
                };
                xhr.send();
            });
        }
    });
    
    // Function untuk check apakah form sudah lengkap
    function checkFormCompletion() {
        // Enable tombol submit jika OTP sudah diverifikasi dan data user sudah diisi
        if (otpVerified && userDataFilled) {
            document.getElementById('submitBtn').disabled = false;
        } else {
            document.getElementById('submitBtn').disabled = true;
        }
    }
    
    // Form submission event handlers
// Form submission event handlers
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('donorForm'); // Ubah ke donorForm sesuai ID di HTML
    const submitBtn = document.getElementById('submitBtn');

    // Pastikan form ada sebelum melanjutkan
    if (!form) {
        console.error("Form dengan ID 'donorForm' tidak ditemukan");
        return;
    }
    
    // Validasi input form
    form.addEventListener('input', function() {
        // Cek semua input wajib sudah terisi
        const requiredInputsFilled = Array.from(form.elements).every(input => {
            if (input.type !== 'submit' && input.hasAttribute('required')) {
                return input.value.trim() !== '';
            }
            return true;
        });

        // Hanya enable tombol jika semua validasi terpenuhi
        if (requiredInputsFilled && (otpVerified && userDataFilled)) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    });

    // Handle form submission dengan SweetAlert
    form.addEventListener('submit', function(e) {
        if (!otpVerified || !userDataFilled) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Formulir Belum Lengkap',
                text: 'Pastikan data diri dan OTP sudah diverifikasi.'
            });
            return;
        }
        
        // Tampilkan konfirmasi SweetAlert jika ingin mengonfirmasi sebelum submit
        if (!e.submitter || e.submitter.id !== 'submitBtnConfirmed') {
            e.preventDefault(); // Cegah form submit default
            
            Swal.fire({
                title: 'Yakin ingin mengirim pengajuan?',
                text: "Pastikan semua data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                // Jika user mengkonfirmasi
                if (result.isConfirmed) {
                    // Submit form secara manual
                    form.submit();
                }
            });
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>