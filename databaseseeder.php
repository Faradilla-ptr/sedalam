<?php

class DatabaseSeeder
{
    private $connection;
    private $baseDir;

    public function __construct(
        $host = "localhost",
        $username = "root",
        $password = "",
        $database = "web_donor"
    ) {
        // Set base directory dari lokasi file seeder ini
        $this->baseDir = dirname(__FILE__);

        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$database",
                $username,
                $password
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            echo "Database connection successful!\n";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function showInterface()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
            $this->handleAction($_POST["action"]);
            return;
        }

        echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Seeder Interface</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
            background-color: #f5f5f5; 
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #333; 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .seeder-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .seeder-card { 
            border: 1px solid #ddd; 
            padding: 20px; 
            border-radius: 8px; 
            background: #fafafa; 
        }
        .seeder-card h3 { 
            margin-top: 0; 
            color: #555; 
        }
        .seeder-card p { 
            color: #666; 
            margin: 10px 0; 
        }
        button { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%; 
            font-size: 14px;
            margin-top: 10px;
        }
        button:hover { 
            background: #0056b3; 
        }
        .run-all { 
            background: #28a745; 
            font-size: 16px; 
            padding: 15px 30px; 
            margin: 20px auto; 
            display: block; 
            width: auto;
        }
        .run-all:hover { 
            background: #1e7e34; 
        }
        .clear-btn { 
            background: #dc3545; 
        }
        .clear-btn:hover { 
            background: #c82333; 
        }
        .setup-btn { 
            background: #17a2b8; 
        }
        .setup-btn:hover { 
            background: #138496; 
        }
        .output { 
            background: #f8f9fa; 
            border: 1px solid #dee2e6; 
            padding: 15px; 
            border-radius: 5px; 
            margin-top: 20px; 
            white-space: pre-wrap; 
            font-family: monospace; 
            max-height: 400px; 
            overflow-y: auto; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🩸 Database Seeder Interface - Sistem Donor Darah</h1>
        
        <form method="POST">
            <div class="seeder-grid">
                <div class="seeder-card">
                    <h3>👥 Setup & Clear</h3>
                    <p>Setup folder struktur dan clear database</p>
                    <button type="submit" name="action" value="setup" class="setup-btn">Setup Folders</button>
                    <button type="submit" name="action" value="clear" class="clear-btn">Clear All Tables</button>
                </div>
                
                <div class="seeder-card">
                    <h3>👨‍💼 Users</h3>
                    <p>Membuat 8 admin users untuk sistem</p>
                    <button type="submit" name="action" value="users">Seed Users (8)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>👤 Akun Pendonor</h3>
                    <p>Membuat 6300 akun pendonor (150/bulan × 7 daerah × 6 bulan)</p>
                    <button type="submit" name="action" value="akun">Seed Akun (6300)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>🖼️ Profile Images</h3>
                    <p>Membuat 6300 dummy profile images</p>
                    <button type="submit" name="action" value="images">Create Images (6300)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>📝 Pengajuan</h3>
                    <p>Membuat 6300 pengajuan donor (4200 sukses + 2100 gagal)</p>
                    <button type="submit" name="action" value="pengajuan">Seed Pengajuan (6300)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>🏥 Tes Kesehatan</h3>
                    <p>Membuat 6300 tes kesehatan untuk semua akun</p>
                    <button type="submit" name="action" value="kesehatan">Seed Tes Kesehatan (6300)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>🩸 Stok Darah</h3>
                    <p>Membuat 4200 stok darah (hanya untuk yang sukses)</p>
                    <button type="submit" name="action" value="stok">Seed Stok Darah (4200)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>💉 Pengambilan Darah</h3>
                    <p>Membuat 2000 data pengambilan darah</p>
                    <button type="submit" name="action" value="pengambilan">Seed Pengambilan (2000)</button>
                </div>
                
                <div class="seeder-card">
                    <h3>❓ FAQ</h3>
                    <p>Membuat 100 FAQ entries</p>
                    <button type="submit" name="action" value="faq">Seed FAQ (100)</button>
                </div>
                <div class="seeder-card">
        <h3>⭐ Review & Rating</h3>
        <p>Membuat review dari pendonor yang sukses donor</p>
        <button type="submit" name="action" value="review">Seed Reviews</button>
    </div>;
            </div>
            
            <button type="submit" name="action" value="all" class="run-all">
                🚀 Jalankan Semua Seeder
            </button>
        </form>
    </div>
</body>
</html>';
    }

    // Method untuk handle action dari form
    private function handleAction($action)
    {
        echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeder Output</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .output { background: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px; white-space: pre-wrap; font-family: monospace; }
        .back-btn { background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 20px; }
        .back-btn:hover { background: #5a6268; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Output Seeder</h1>
        <div class="output">';

        ob_start();

        try {
            switch ($action) {
                case "setup":
                    echo "Setting up folder structure...\n";
                    $this->setupFolders();
                    break;
                case "clear":
                    echo "Clearing database tables...\n";
                    $this->clearTables();
                    break;
                case "users":
                    echo "Seeding users...\n";
                    $this->seedUsers(8);
                    break;
                case "akun":
                    echo "Seeding akun pendonor...\n";
                    $this->seedAkun(6300);
                    break;
                case "images":
                    echo "Creating dummy images...\n";
                    $this->createDummyImages(6300);
                    break;
                case "pengajuan":
                    echo "Seeding pengajuan...\n";
                    $this->seedPengajuan(6300);
                    break;
                case "kesehatan":
                    echo "Seeding tes kesehatan...\n";
                    $this->seedTesKesehatan(6300);
                    break;
                case "stok":
                    echo "Seeding stok darah...\n";
                    $this->seedStokDarah(4200);
                    break;
                case "pengambilan":
                    echo "Seeding pengambilan darah...\n";
                    $this->seedPengambilanDarah(2000);
                    break;
                case "faq":
                    echo "Seeding FAQ...\n";
                    $this->seedFAQ(100);
                    break;
                case "review":
                    echo "Seeding reviews...\n";
                    $this->seedReview();
                    break;
                case "all":
                    $this->runAllSeeders();
                    break;
                default:
                    echo "Unknown action: $action\n";
            }
            echo "\n✅ Seeder completed successfully!";
        } catch (Exception $e) {
            echo "\n❌ Error: " . $e->getMessage();
        }

        $output = ob_get_clean();
        echo htmlspecialchars($output);

        echo '</div>
        <a href="' .
            $_SERVER["PHP_SELF"] .
            '" class="back-btn">← Kembali ke Menu</a>
    </div>
</body>
</html>';
    }
    // Generate random data helpers
    private function generateRandomString($length = 6)
    {
        return substr(
            str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"),
            0,
            $length
        );
    }

    private function generateRandomNIK()
    {
        return mt_rand(1000000000000000, 9999999999999999);
    }

    private function generateRandomPhone()
    {
        return "628" . mt_rand(10000000000, 99999999999);
    }

    private function generateRandomEmail($name)
    {
        $domains = ["gmail.com", "yahoo.com", "outlook.com", "protonmail.com"];
        $cleanName = strtolower(str_replace(" ", "", $name));
        return $cleanName .
            mt_rand(1, 999) .
            "@" .
            $domains[array_rand($domains)];
    }
    private function emailExists($email)
    {
        $stmt = $this->connection->prepare(
            "SELECT COUNT(*) FROM akun WHERE email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    private function generateRandomDate($startYear = 1990, $endYear = 2005)
    {
        $start = mktime(0, 0, 0, 1, 1, $startYear);
        $end = mktime(0, 0, 0, 12, 31, $endYear);
        return date("Y-m-d", mt_rand($start, $end));
    }

    private function generateRandomDateInRange($startDate, $endDate)
    {
        $start = strtotime($startDate);
        $end = strtotime($endDate);
        return date("Y-m-d", mt_rand($start, $end));
    }

    // Fungsi untuk generate created_at dengan timestamp otomatis
    private function generateRandomDateTime(
        $startDate = "2025-01-01",
        $endDate = "2025-06-30"
    ) {
        $start = strtotime($startDate);
        $end = strtotime($endDate);
        $randomTimestamp = mt_rand($start, $end);

        // Tambahkan waktu random (jam, menit, detik)
        $randomHour = mt_rand(0, 23);
        $randomMinute = mt_rand(0, 59);
        $randomSecond = mt_rand(0, 59);

        return date("Y-m-d", $randomTimestamp) .
            " " .
            sprintf(
                "%02d:%02d:%02d",
                $randomHour,
                $randomMinute,
                $randomSecond
            );
    }

    // Setup folder structure sesuai permintaan
    private function setupFolders()
    {
        $folders = [
            $this->baseDir . "/view/pendonor/dokumen", // untuk dokumen pengajuan
            $this->baseDir . "/view/pendonor/uploads", // untuk tes kesehatan
            $this->baseDir . "/view/pendonor/profil", // untuk foto profil
        ];

        foreach ($folders as $folder) {
            if (!file_exists($folder)) {
                if (mkdir($folder, 0777, true)) {
                    echo "Created folder: $folder\n";
                } else {
                    echo "Failed to create folder: $folder\n";
                }
            } else {
                echo "Folder already exists: $folder\n";
            }
        }
    }

    // Clear all tables
    public function clearTables()
    {
        try {
            $this->connection->exec("SET FOREIGN_KEY_CHECKS = 0");

            $tables = [
                "tes_kesehatan",
                "review",
                "pengajuan",
                "stok_darah",
                "pengambilan_darah",
                "faq",
                "akun",
                "users",
            ];

            foreach ($tables as $table) {
                $this->connection->exec("DELETE FROM $table");
                $this->connection->exec(
                    "ALTER TABLE $table AUTO_INCREMENT = 1"
                );
            }

            $this->connection->exec("SET FOREIGN_KEY_CHECKS = 1");
            echo "All tables cleared successfully!\n";
        } catch (PDOException $e) {
            echo "Error clearing tables: " . $e->getMessage() . "\n";
        }
    }

    // Create dummy PDF with better content
    private function createDummyPdf($filename, $folder)
    {
        require_once "lib/fpdf.php"; // pastikan fpdf.php ada di direktori ini

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $fullPath = $folder . "/" . $filename;

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 14);
        $pdf->Cell(0, 10, "DOKUMEN DUMMY UNTUK TESTING", 0, 1, "C");

        $pdf->SetFont("Arial", "", 12);
        $pdf->Ln(10);
        $pdf->Cell(0, 10, "File: " . $filename, 0, 1);
        $pdf->Cell(0, 10, "Tanggal: " . date("Y-m-d H:i:s"), 0, 1);
        $pdf->Cell(0, 10, "Status: Valid untuk testing", 0, 1);
        $pdf->Ln(5);
        $pdf->MultiCell(
            0,
            10,
            "Ini adalah dokumen PDF dummy yang dibuat secara otomatis oleh database seeder.\nDigunakan untuk keperluan pengujian dokumen PDF dalam aplikasi donor darah."
        );

        if ($pdf->Output("F", $fullPath)) {
            echo "Created valid PDF: $fullPath\n";
            return true;
        } else {
            echo "Failed to create valid PDF at: $fullPath\n";
            return false;
        }
    }

    // Seed Users table
    public function seedUsers($count = 8)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO users (username, email, lokasi, password, role, created_at, otp, otp_expiry) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $adminNames = [
            "Super Admin Pusat",
            "Admin PMI Kab Probolinggo",
            "Admin PMI Kota Probolinggo",
            "Admin PMI Kab Jember",
            "Admin PMI Kab Lumajang",
            "Admin PMI Kab Bondowoso",
            "Admin PMI Kab Situbondo",
            "Admin PMI Kab Banyuwangi",
        ];

        $lokasiList = [
            "UDD PMI Kabupaten Jember", // Super Admin Pusat
            "UDD PMI Kabupaten Probolinggo",
            "UDD PMI Kota Probolinggo",
            "UDD PMI Kabupaten Jember",
            "UDD PMI Kabupaten Lumajang",
            "UDD PMI Kabupaten Bondowoso",
            "UDD PMI Kabupaten Situbondo",
            "UDD PMI Kabupaten Banyuwangi",
        ];

        for ($i = 0; $i < $count; $i++) {
            $username = $adminNames[$i];
            $email = $this->generateRandomEmail($username);
            $lokasi = $lokasiList[$i];
            $password = password_hash("password123", PASSWORD_DEFAULT);
            $role = "admin";
            $created_at = $this->generateRandomDateTime(
                "2025-01-01",
                "2025-06-30"
            );
            $otp = mt_rand(100000, 999999);
            $otp_expiry = date("Y-m-d H:i:s", time() + 300);

            $stmt->execute([
                $username,
                $email,
                $lokasi,
                $password,
                $role,
                $created_at,
                $otp,
                $otp_expiry,
            ]);
        }

        echo "Seeded $count users successfully!\n";
    }

    // Seed Akun table
    public function seedAkun($count = 6300)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO akun (username, nama, nik, email, tanggal_lahir, password, gender, alamat, telepon, foto, golongan_darah, kode_unik, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $firstNames = [
            "Yunino",
            "Dianara",
            "Nina",
            "Zakii",
            "Rahmatra",
            "Ekay",
            "Maya",
            "Yuniy",
            "Dianano",
            "Fajarza",
            "Gitaza",
            "Omar",
            "Gitai",
            "Zakiu",
            "Rahmat",
            "Kartika",
            "Dianati",
            "Vinao",
            "Dianau",
            "Handia",
            "Yuniy",
            "Dianawan",
            "Yuniza",
            "Ekaza",
            "Xanderu",
            "Xandera",
            "Ahmady",
            "Wawanno",
            "Wawany",
            "Sarino",
            "Xander",
            "Vinaa",
            "Lilay",
            "Sariy",
            "Vinano",
            "Ninay",
            "Sarino",
            "Xanderra",
            "Tono",
            "Handiti",
            "Indirai",
            "Tonora",
            "Vinai",
            "Yunino",
            "Ninano",
            "Indirati",
            "Santikati",
            "Tonoti",
            "Saria",
            "Yuniti",
            "Wawanza",
            "Ahmada",
            "Umiti",
            "Kartikao",
            "Ahmad",
            "Umiti",
            "Umiza",
            "Rahmatti",
            "Ninawan",
            "Indirau",
            "Kartika",
            "Dianano",
            "Ekati",
            "Tonou",
            "Santikaa",
            "Handiti",
            "Handi",
            "Lilati",
            "Kartikara",
            "Dianawan",
            "Vinao",
            "Tonoa",
            "Zakino",
            "Ahmadwan",
            "Ahmada",
            "Tonoi",
            "Umiwan",
            "Jokoo",
            "Vinau",
            "Mayai",
            "Ekawan",
            "Rahmatwan",
            "Sariy",
            "Xanderi",
            "Ekaa",
            "Putriu",
            "Xanderu",
            "Rahmatti",
            "Handi",
            "Yunira",
            "Putri",
            "Umi",
            "Indira",
            "Xanderza",
            "Handiti",
            "Umia",
            "Xander",
            "Dianawan",
            "Handiy",
            "Lilawan",
            "Yuni",
            "Ekaza",
            "Kartikawan",
            "Santikao",
            "Ekai",
            "Wawanwan",
            "Tonora",
            "Santikaa",
            "Yuniza",
            "Rahmati",
            "Fajaro",
            "Kartikawan",
            "Fajari",
            "Mayawan",
            "Maya",
            "Joko",
            "Putrii",
            "Wawanti",
            "Sariy",
            "Budio",
            "Santika",
            "Handiza",
            "Wawanu",
            "Jokoy",
            "Ninaa",
            "Diana",
            "Eka",
            "Vina",
            "Tonoza",
            "Tonoa",
            "Yuniy",
            "Ahmadi",
            "Ninaza",
            "Omaro",
            "Budiu",
            "Omari",
            "Mayaa",
            "Wawan",
            "Umiti",
            "Rahmaty",
            "Zaki",
            "Fajarra",
            "Wawanwan",
            "Indirara",
            "Ekati",
            "Jokoi",
            "Budio",
            "Wawani",
            "Omar",
            "Santikara",
            "Umii",
            "Budiu",
            "Yuni",
            "Xandero",
            "Dianay",
            "Wawano",
            "Umi",
            "Indirawan",
            "Indiray",
            "Omaro",
            "Budii",
            "Handio",
            "Vinano",
            "Omarti",
            "Ahmadti",
            "Budia",
            "Zakii",
            "Nina",
            "Tonoy",
            "Budiy",
            "Wawanza",
            "Zakio",
            "Indirano",
            "Tono",
            "Fajarra",
            "Ekawan",
            "Kartika",
            "Santikao",
            "Dianau",
            "Omari",
            "Ahmad",
            "Xandera",
            "Xanderti",
            "Santikau",
            "Wawan",
            "Santika",
            "Yunira",
            "Mayao",
            "Ekara",
            "Umira",
            "Fajar",
            "Joko",
            "Kartikay",
            "Handi",
            "Ninaa",
            "Lilara",
            "Rahmat",
            "Dianay",
            "Dianaza",
            "Santikao",
            "Gita",
            "Budio",
            "Ahmadra",
            "Omari",
            "Umiti",
            "Tono",
            "Lilay",
            "Zakiwan",
            "Zakiza",
            "Santikano",
            "Ekay",
            "Fajara",
            "Vinai",
            "Ahmadti",
            "Fajar",
            "Sariwan",
            "Ninay",
            "Putrio",
            "Ninaza",
            "Wawanti",
            "Tonora",
            "Handi",
            "Kartikai",
            "Santikawan",
            "Xanderra",
            "Zaki",
            "Zakiza",
            "Indiraa",
            "Putriwan",
            "Lilano",
            "Lilaza",
            "Ninaa",
            "Vinaa",
            "Ninaa",
            "Ekaza",
            "Umino",
            "Putriti",
            "Kartikaa",
            "Rahmati",
            "Zaki",
            "Jokowan",
            "Kartikay",
            "Santikay",
            "Putrino",
            "Vinai",
            "Ekau",
            "Santikara",
            "Umiu",
            "Dianati",
            "Ahmadti",
            "Handi",
            "Tonora",
            "Gitao",
            "Omar",
            "Budiu",
            "Budi",
            "Ahmadza",
            "Indirano",
            "Vina",
            "Vinawan",
            "Yunino",
            "Yunii",
            "Tonono",
            "Handiwan",
            "Maya",
            "Dianawan",
            "Wawany",
            "Joko",
            "Ninati",
            "Kartikai",
            "Gitawan",
            "Mayawan",
            "Mayao",
            "Rahmat",
            "Omara",
            "Gita",
            "Putria",
            "Dianay",
            "Ninara",
            "Tono",
            "Putriti",
            "Ninai",
            "Handiza",
            "Santikati",
            "Mayai",
            "Kartikai",
            "Xanderwan",
            "Gitano",
            "Mayano",
            "Jokoa",
            "Gitay",
            "Kartikawan",
            "Umiza",
            "Mayai",
            "Tonowan",
            "Lilai",
            "Ekaza",
            "Indiraa",
            "Tonono",
            "Handiti",
            "Sariy",
            "Dianay",
            "Sarira",
            "Umii",
            "Ninano",
            "Kartikawan",
            "Ekawan",
            "Kartika",
            "Sari",
            "Fajarra",
            "Xanderti",
            "Buditi",
            "Kartikawan",
            "Fajar",
            "Indiray",
            "Umia",
            "Dianano",
            "Santika",
            "Rahmatu",
            "Umiza",
            "Buditi",
            "Rahmati",
            "Indirano",
            "Wawanu",
            "Fajarti",
            "Handi",
            "Kartikawan",
            "Ahmadra",
            "Jokoi",
            "Kartikati",
            "Gitano",
            "Mayao",
            "Vinati",
            "Santikaa",
            "Rahmat",
            "Fajaru",
            "Santikai",
            "Budi",
            "Eka",
            "Putriza",
            "Putriu",
            "Ninano",
            "Ahmadno",
            "Fajara",
            "Tonoy",
            "Vinano",
            "Dianano",
            "Santikawan",
            "Zakino",
            "Tonoi",
            "Umiu",
            "Yunii",
            "Budiu",
            "Santikai",
            "Fajarza",
            "Mayati",
            "Omari",
            "Fajaru",
            "Mayano",
            "Handi",
            "Sariza",
            "Xandera",
            "Dianati",
            "Ekai",
            "Ninau",
            "Ekay",
            "Ahmadno",
            "Kartikano",
            "Ahmadra",
            "Yunii",
            "Ahmadu",
            "Tono",
            "Jokowan",
            "Zakiwan",
            "Umia",
            "Sariza",
            "Ninaza",
            "Indirao",
            "Wawana",
            "Budiy",
            "Lilawan",
            "Sari",
            "Omar",
            "Zakiti",
            "Sario",
            "Ekaa",
            "Vinati",
            "Wawani",
            "Ahmad",
            "Indiraza",
            "Santikau",
            "Diana",
            "Vinai",
            "Umino",
            "Wawanu",
            "Kartikano",
            "Xanderu",
            "Lilano",
            "Lila",
            "Santikaza",
            "Dianao",
            "Dianaa",
            "Santikano",
            "Santikaza",
            "Mayaa",
            "Fajarza",
            "Fajarti",
            "Xanderu",
            "Budiu",
            "Dianay",
            "Kartikay",
            "Omarti",
            "Ninawan",
            "Ahmad",
            "Omarza",
            "Xanderza",
            "Fajarza",
            "Vinau",
            "Putriwan",
            "Santika",
            "Budiu",
            "Putriy",
            "Fajaro",
            "Ahmadra",
            "Ahmadti",
            "Fajaru",
            "Rahmato",
            "Rahmat",
            "Vinati",
            "Tonora",
            "Fajara",
            "Omarti",
            "Santikano",
            "Handi",
            "Xanderi",
            "Putri",
            "Xanderi",
            "Zakiu",
            "Santikara",
            "Rahmato",
            "Handio",
            "Indira",
            "Handiza",
            "Yunia",
            "Sario",
            "Santikao",
            "Zakiza",
            "Sariza",
            "Xandera",
            "Lilati",
            "Vinao",
            "Gita",
            "Buditi",
            "Lilau",
            "Rahmatno",
            "Ninaa",
            "Saria",
            "Handiza",
            "Xanderti",
            "Yuni",
            "Omar",
            "Wawany",
            "Handio",
            "Yuniy",
            "Jokoi",
            "Rahmatti",
            "Tonoti",
            "Kartikau",
            "Yuniza",
            "Sariza",
            "Budiy",
            "Tono",
            "Santikau",
            "Wawanno",
            "Indirai",
            "Wawano",
            "Yunii",
            "Umi",
            "Ekano",
            "Rahmato",
            "Fajari",
            "Kartikati",
            "Putrira",
            "Diana",
            "Jokoza",
            "Kartika",
            "Budii",
            "Dianaza",
            "Ninati",
            "Kartikai",
            "Gitao",
            "Omaro",
            "Yuniu",
            "Indira",
            "Sarii",
            "Santikawan",
            "Xanderi",
            "Zakira",
            "Mayaza",
            "Yuniza",
        ];

        $lastNames = [
            "Nugrohowan",
            "Wijayay",
            "Utomo",
            "Santosou",
            "Susantou",
            "Sarira",
            "Putrawan",
            "Santosoo",
            "Rahmawatiza",
            "Handayanino",
            "Pratamara",
            "Pratamau",
            "Wardanati",
            "Ningrum",
            "Dewio",
            "Handayaniy",
            "Susantoy",
            "Ningrumu",
            "Pratamawan",
            "Wijayay",
            "Santosoi",
            "Ningruma",
            "Ningruma",
            "Santosou",
            "Lestari",
            "Ningrumi",
            "Putrao",
            "Putrara",
            "Wardanano",
            "Rahmawati",
            "Kusumano",
            "Wijayawan",
            "Maharanira",
            "Susantoo",
            "Kusumay",
            "Maharaniy",
            "Ningrumti",
            "Pratamau",
            "Utomora",
            "Kusumati",
            "Rahmawatino",
            "Maharani",
            "Dewiwan",
            "Susantoza",
            "Putraza",
            "Kusumati",
            "Utomoi",
            "Sari",
            "Wijayati",
            "Kusumano",
            "Nugrohoza",
            "Susantoa",
            "Maharanino",
            "Utomoza",
            "Wardanano",
            "Wijayati",
            "Kusumati",
            "Maharaniwan",
            "Lestariti",
            "Putrao",
            "Maharani",
            "Wardanay",
            "Dewiu",
            "Maharaniti",
            "Santosowan",
            "Ningrumo",
            "Wardanay",
            "Wijayara",
            "Pratamau",
            "Nugrohora",
            "Handayaniza",
            "Kusumay",
            "Lestarino",
            "Handayaniy",
            "Santoso",
            "Pratamati",
            "Kusumara",
            "Putra",
            "Lestaria",
            "Utomoa",
            "Wijayara",
            "Wijayaa",
            "Maharanii",
            "Utomoy",
            "Maharanino",
            "Handayanii",
            "Wardanai",
            "Pratamaa",
            "Handayaniy",
            "Rahmawatino",
            "Dewi",
            "Santosoy",
            "Nugrohono",
            "Handayaniwan",
            "Utomoza",
            "Sariti",
            "Susantoti",
            "Pratama",
            "Rahmawatiti",
            "Kusumay",
            "Sariza",
            "Susantoa",
            "Sariza",
            "Pratamawan",
            "Kusumau",
            "Nugrohoza",
            "Dewi",
            "Nugrohou",
            "Wardanati",
            "Handayani",
            "Nugrohoo",
            "Lestariti",
            "Rahmawatiwan",
            "Wijaya",
            "Maharani",
            "Dewia",
            "Dewii",
            "Dewii",
            "Wijayano",
            "Wardana",
            "Pratamay",
            "Ningrumo",
            "Wardanara",
            "Sariwan",
            "Santosoa",
            "Rahmawati",
            "Putrao",
            "Utomoti",
            "Sariti",
            "Susantoa",
            "Rahmawatira",
            "Maharanino",
            "Handayaniti",
            "Utomoo",
            "Handayaniu",
            "Wardanano",
            "Susantoti",
            "Santosowan",
            "Handayaniwan",
            "Dewiti",
            "Pratamaza",
            "Saria",
            "Rahmawatio",
            "Nugrohoti",
            "Wardanay",
            "Nugrohoo",
            "Nugrohoo",
            "Utomou",
            "Pratamay",
            "Wijayaza",
            "Pratamaa",
            "Wardanay",
            "Susantora",
            "Pratamaza",
            "Wardanano",
            "Rahmawatiwan",
            "Ningrumwan",
            "Sarira",
            "Dewiy",
            "Santosoza",
            "Kusumara",
            "Sariza",
            "Ningrumy",
            "Kusumano",
            "Sariy",
            "Nugrohoo",
            "Lestariwan",
            "Putra",
            "Putrao",
            "Nugrohoi",
            "Pratamati",
            "Maharanii",
            "Wardanawan",
            "Rahmawatio",
            "Wardanati",
            "Susanto",
            "Lestariwan",
            "Pratamaza",
            "Rahmawati",
            "Wardanaza",
            "Kusumai",
            "Nugrohowan",
            "Utomo",
            "Pratamara",
            "Putrara",
            "Nugrohoo",
            "Nugrohoy",
            "Santosono",
            "Rahmawatiy",
            "Susantora",
            "Utomoy",
            "Wardanara",
            "Ningrumo",
            "Nugrohoa",
            "Utomoa",
            "Lestariti",
            "Kusumano",
            "Sarira",
            "Wardanano",
            "Kusumaa",
            "Kusumara",
            "Sariu",
            "Kusumati",
            "Nugrohoa",
            "Handayanio",
            "Dewio",
            "Utomoti",
            "Nugroho",
            "Rahmawati",
            "Putrai",
            "Handayanii",
            "Putrara",
            "Utomou",
            "Kusumawan",
            "Kusumano",
            "Putrai",
            "Putray",
            "Ningrumu",
            "Rahmawatira",
            "Lestariza",
            "Wardanaza",
            "Wijayati",
            "Susantoy",
            "Wardanano",
            "Nugrohoa",
            "Wijayati",
            "Santosoti",
            "Wijayaa",
            "Rahmawatiu",
            "Maharanira",
            "Wardana",
            "Lestari",
            "Wardanau",
            "Kusumay",
            "Susantoa",
            "Dewiti",
            "Putrati",
            "Santoso",
            "Rahmawatino",
            "Handayaniti",
            "Utomowan",
            "Rahmawatiy",
            "Nugrohoa",
            "Sario",
            "Susantoa",
            "Wijayawan",
            "Nugrohoi",
            "Kusumay",
            "Sarii",
            "Putrawan",
            "Kusumao",
            "Handayani",
            "Putraza",
            "Pratamay",
            "Maharaniti",
            "Utomono",
            "Putraa",
            "Maharaniti",
            "Wijayao",
            "Nugroho",
            "Santosora",
            "Sariti",
            "Sariu",
            "Pratamau",
            "Dewiu",
            "Maharania",
            "Pratamawan",
            "Santosoti",
            "Wardanao",
            "Susantono",
            "Kusumai",
            "Lestario",
            "Wardanano",
            "Wijayay",
            "Handayanino",
            "Nugrohora",
            "Pratamaza",
            "Sarino",
            "Rahmawati",
            "Sariza",
            "Wardanano",
            "Santosoy",
            "Pratamaa",
            "Lestaria",
            "Wardanati",
            "Lestario",
            "Santosoi",
            "Putrai",
            "Rahmawatia",
            "Handayaniti",
            "Santosoa",
            "Wijaya",
            "Utomoza",
            "Utomoi",
            "Maharaniu",
            "Maharania",
            "Lestario",
            "Dewii",
            "Sario",
            "Wijayao",
            "Utomoy",
            "Susanto",
            "Rahmawatiza",
            "Wardana",
            "Susantoi",
            "Kusumati",
            "Maharaniti",
            "Handayani",
            "Pratamara",
            "Kusumai",
            "Wardanaa",
            "Dewi",
            "Rahmawatiza",
            "Rahmawatiza",
            "Saria",
            "Putrao",
            "Wijayaa",
            "Utomoo",
            "Dewino",
            "Nugrohora",
            "Sariu",
            "Susantou",
            "Putray",
            "Handayania",
            "Maharaniza",
            "Santosono",
            "Nugrohoa",
            "Sario",
            "Putrai",
            "Nugrohowan",
            "Putrao",
            "Ningrumo",
            "Putra",
            "Kusuma",
            "Pratamao",
            "Putra",
            "Susantoa",
            "Rahmawatiza",
            "Wijayati",
            "Putra",
            "Lestariu",
            "Maharanino",
            "Putray",
            "Putraza",
            "Wardanara",
            "Utomoi",
            "Sariza",
            "Rahmawatio",
            "Rahmawatiwan",
            "Handayaniza",
            "Kusumaza",
            "Wardanao",
            "Utomowan",
            "Sari",
            "Wijayaza",
            "Ningrum",
            "Utomoti",
            "Wardanaza",
            "Rahmawatino",
            "Wijaya",
            "Putrao",
            "Kusumaza",
            "Putrano",
            "Wijaya",
            "Handayanino",
            "Ningrumra",
            "Kusumara",
            "Pratamawan",
            "Wijaya",
            "Lestarira",
            "Kusumawan",
            "Santoso",
            "Kusumano",
            "Maharanira",
            "Lestaria",
            "Kusumay",
            "Nugrohoo",
            "Putrau",
            "Ningrum",
            "Wijayai",
            "Putrau",
            "Wijayano",
            "Lestariza",
            "Handayanii",
            "Nugrohoti",
            "Saria",
            "Wijaya",
            "Sariy",
            "Handayaniti",
            "Nugrohoy",
            "Pratamau",
            "Wijayati",
            "Kusumay",
            "Santosoza",
            "Maharaniwan",
            "Lestariti",
            "Rahmawati",
            "Santosoza",
            "Kusuma",
            "Nugrohou",
            "Dewiy",
            "Lestario",
            "Wardanaa",
            "Wijayati",
            "Handayaniti",
            "Ningrumo",
            "Handayanio",
            "Lestariy",
            "Ningrumi",
            "Susanto",
            "Handayaniza",
            "Sariza",
            "Dewii",
            "Sariy",
            "Pratamano",
            "Ningrumti",
            "Susantora",
            "Dewii",
            "Utomoa",
            "Wardana",
            "Wijayaza",
            "Putrano",
            "Dewiti",
            "Handayaniy",
            "Nugrohora",
            "Susantoza",
            "Wardanara",
            "Nugrohowan",
            "Susanto",
            "Utomo",
            "Dewiti",
            "Putraa",
            "Kusumara",
            "Wardana",
            "Handayania",
            "Dewiu",
            "Kusumati",
            "Handayanino",
            "Pratamau",
            "Saria",
            "Lestarira",
            "Utomoo",
            "Wardanai",
            "Wardanay",
            "Rahmawatiy",
            "Utomoy",
            "Nugrohoa",
            "Rahmawatiwan",
            "Utomou",
            "Santosowan",
            "Pratamano",
            "Nugrohowan",
            "Rahmawati",
            "Rahmawatira",
            "Putraza",
            "Pratamai",
            "Rahmawatiwan",
            "Susantowan",
            "Wardanay",
            "Utomo",
            "Rahmawatia",
            "Handayania",
            "Sari",
            "Rahmawatiy",
            "Putray",
            "Ningrumno",
            "Dewi",
            "Utomo",
            "Sariu",
            "Susantoa",
            "Wijayano",
            "Maharanino",
            "Wardanara",
            "Pratamao",
            "Dewino",
            "Susantora",
            "Maharaniy",
            "Pratamay",
            "Nugrohoza",
            "Nugrohoi",
            "Pratama",
            "Ningruma",
            "Kusumay",
            "Wijayau",
            "Utomo",
            "Handayanira",
            "Handayaniu",
            "Sariti",
            "Lestariwan",
            "Pratamano",
            "Lestarii",
            "Pratamaza",
            "Maharani",
            "Wijaya",
            "Sariu",
            "Rahmawatino",
            "Ningrumti",
            "Pratamati",
            "Handayanio",
            "Dewira",
        ];

        // Cities dari 6 kabupaten/kota
        $cities = [
            // Probolinggo Kabupaten
            "Kraksaan",
            "Paiton",
            "Kotaanyar",
            "Gending",
            "Wonomerto",
            "Tegalsiwalan",
            "Kuripan",
            "Bantaran",
            "Pakuniran",
            "Krucil",
            "Gading",
            "Pajarakan",
            "Besuk",
            "Banyuanyar",
            "Tiris",
            "Tegal Siwalan",
            "Sumber",
            "Maron",
            "Dringu",
            "Sukapura",
            "Sumberasih",
            "Wonomerto",
            "Lumbang",
            "Tongas",

            // Probolinggo Kota
            "Kademangan",
            "Mayangan",
            "Kanigaran",
            "Kedopok",
            "Wonoasih",

            // Lumajang
            "Lumajang",
            "Sukodono",
            "Klakah",
            "Senduro",
            "Pronojiwo",
            "Pasirian",
            "Candipuro",
            "Kunir",
            "Lumajang",
            "Rowokangkung",
            "Tekung",
            "Tempursari",
            "Randuagung",
            "Ranuyoso",
            "Padang",
            "Sumbersuko",
            "Pasrujambe",
            "Jatiroto",
            "Yosowilangun",
            "Gucialit",
            "Kedungjajang",

            // Jember
            "Jember",
            "Sumbersari",
            "Kaliwates",
            "Patrang",
            "Tanggul",
            "Rambipuji",
            "Bangsalsari",
            "Ambulu",
            "Tempurejo",
            "Jenggawah",
            "Arjasa",
            "Pakusari",
            "Kalisat",
            "Ledokombo",
            "Silo",
            "Mayang",
            "Mumbulsari",
            "Jelbuk",
            "Kencong",
            "Gumukmas",
            "Puger",
            "Wuluhan",
            "Balung",
            "Semboro",
            "Jombang",
            "Sumberbaru",
            "Umbulsari",
            "Sumber Baru",

            // Bondowoso
            "Bondowoso",
            "Grujugan",
            "Jambesari Darus Sholah",
            "Taman Krocok",
            "Sukosari",
            "Binakal",
            "Bunder",
            "Tegalampel",
            "Wringin",
            "Tenggarang",
            "Wonosari",
            "Klabang",
            "Sempol",
            "Tapen",
            "Maesan",
            "Sumber Wringin",
            "Pujer",
            "Cermee",
            "Pakem",
            "Tlogosari",
            "Tamanan",
            "Prajekan",

            // Situbondo
            "Situbondo",
            "Panarukan",
            "Arjasa",
            "Jangkar",
            "Asembagus",
            "Banyuputih",
            "Besuki",
            "Suboh",
            "Mlandingan",
            "Banyuglugur",
            "Kapongan",
            "Arjasa",
            "Jatibanteng",
            "Sumbermalang",
            "Mangaran",
            "Kendit",
            "Bungatan",

            // Banyuwangi
            "Banyuwangi",
            "Rogojampi",
            "Kabat",
            "Genteng",
            "Srono",
            "Cluring",
            "Gambiran",
            "Muncar",
            "Tegaldlimo",
            "Bangorejo",
            "Purwoharjo",
            "Tegalsari",
            "Siliragung",
            "Wongsorejo",
            "Kalibaru",
            "Glenmore",
            "Kalipuro",
            "Giri",
            "Songgon",
            "Sempu",
            "Singojuruh",
            "Glagah",
            "Licin",
            "Banyuwangi",
        ];

        $bloodTypes = ["A", "B", "AB", "O"];
        $genders = ["Laki-laki", "Perempuan"];
        $usedUsernames = [];

        // Generate data per bulan per daerah
        $months = [
            "2025-01",
            "2025-02",
            "2025-03",
            "2025-04",
            "2025-05",
            "2025-06",
        ];
        $accountsPerMonthPerCity = 150; // 100 sukses + 50 gagal

        $counter = 1;
        $totalCreated = 0;
        foreach ($months as $month) {
            foreach ($cities as $city) {
                for ($i = 0; $i < $accountsPerMonthPerCity; $i++) {
                    // Cek apakah sudah mencapai batas maksimal
                    if ($totalCreated >= $count) {
                        echo "Reached maximum count of $count accounts. Stopping.\n";
                        break 3; // Keluar dari semua loop
                    }

                    $firstName = $firstNames[array_rand($firstNames)];
                    $lastName = $lastNames[array_rand($lastNames)];
                    $nama = $firstName . " " . $lastName;

                    // Generate unique username
                    do {
                        $username = strtolower(
                            $firstName . $lastName . mt_rand(1, 9999)
                        );
                    } while (
                        in_array($username, $usedUsernames) ||
                        $this->usernameExists($username)
                    );
                    $usedUsernames[] = $username;

                    $nik = $this->generateRandomNIK();

                    // Generate unique email
                    do {
                        $email = $this->generateRandomEmail($nama);
                    } while ($this->emailExists($email));

                    $tanggal_lahir = $this->generateRandomDate(1990, 2005);
                    $password = password_hash("password123", PASSWORD_DEFAULT);
                    $gender = $genders[array_rand($genders)];
                    $alamat =
                        $city .
                        ", Jl. " .
                        $firstNames[array_rand($firstNames)] .
                        " No. " .
                        mt_rand(1, 100);
                    $telepon = $this->generateRandomPhone();
                    $foto = "view/pendonor/profil/profil_" . $counter . ".jpg";
                    $golongan_darah = $bloodTypes[array_rand($bloodTypes)];
                    $kode_unik = $this->generateRandomString(6);

                    // Set created_at dalam bulan yang sesuai
                    $created_at = $this->generateRandomDateTime(
                        $month . "-01",
                        $month . "-28"
                    );
                    $updated_at = $created_at;

                    $stmt->execute([
                        $username,
                        $nama,
                        $nik,
                        $email,
                        $tanggal_lahir,
                        $password,
                        $gender,
                        $alamat,
                        $telepon,
                        $foto,
                        $golongan_darah,
                        $kode_unik,
                        $created_at,
                        $updated_at,
                    ]);

                    $counter++;
                    $totalCreated++; // Increment total created counter

                    // Progress report setiap 500 data
                    if ($totalCreated % 300 == 0) {
                        echo "Created $totalCreated accounts so far...\n";
                    }
                }
            }
        }

        echo "Seeded $totalCreated akun successfully! (Target was $count)\n";
    }

    // Fungsi tambahan untuk mengecek apakah username sudah ada di database
    private function usernameExists($username)
    {
        $stmt = $this->connection->prepare(
            "SELECT COUNT(*) FROM akun WHERE username = ?"
        );
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // Seed Pengajuan table
    public function seedPengajuan($count = 6300)
    {
        $akunIds = $this->connection
            ->query(
                "SELECT id, nama, nik, email, telepon, created_at FROM akun ORDER BY created_at"
            )
            ->fetchAll(PDO::FETCH_ASSOC);

        if (empty($akunIds)) {
            echo "No akun found. Please seed akun table first.\n";
            return;
        }

        $stmt = $this->connection->prepare("
        INSERT INTO pengajuan (id_pendonor, nama, nik, email, hp, tanggal, waktu, lokasi, sehat, obat, gejala, dokumen, otp, konfirmasi, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

        $locations = [
            "UDD PMI Kabupaten Probolinggo",
            "UDD PMI Kota Probolinggo",
            "UDD PMI Kabupaten Jember",
            "UDD PMI Kabupaten Lumajang",
            "UDD PMI Kabupaten Bondowoso",
            "UDD PMI Kabupaten Situbondo",
            "UDD PMI Kabupaten Banyuwangi",
        ];

        $yesNo = ["Ya", "Tidak"];
        $months = [
            "2025-01",
            "2025-02",
            "2025-03",
            "2025-04",
            "2025-05",
            "2025-06",
        ];

        $counter = 1;
        $akunIndex = 0;

        foreach ($months as $month) {
            foreach ($locations as $lokasi) {
                // 100 sukses per bulan per lokasi
                for ($i = 0; $i < 100; $i++) {
                    $akun = $akunIds[$akunIndex];

                    $tanggal = $this->generateRandomDateInRange(
                        $month . "-01",
                        $month . "-28"
                    );
                    $waktu = sprintf(
                        "%02d:%02d:00",
                        mt_rand(8, 17),
                        mt_rand(0, 59)
                    );

                    $filename = "dokumen_pengajuan_" . $counter . ".pdf";
                    $folderPath = $this->baseDir . "/view/pendonor/dokumen";
                    $this->createDummyPdf($filename, $folderPath);
                    $dokumen = "view/pendonor/dokumen/" . $filename;

                    $otp = mt_rand(100000, 999999);
                    $created_at = $this->generateRandomDateTime(
                        $month . "-01",
                        $month . "-28"
                    );

                    $stmt->execute([
                        $akun["id"],
                        $akun["nama"],
                        $akun["nik"],
                        $akun["email"],
                        $akun["telepon"],
                        $tanggal,
                        $waktu,
                        $lokasi,
                        "Ya",
                        "Tidak",
                        "Tidak",
                        $dokumen,
                        $otp,
                        "sukses",
                        $created_at,
                    ]);

                    $counter++;
                    $akunIndex++;
                }

                // 50 gagal per bulan per lokasi
                for ($i = 0; $i < 50; $i++) {
                    $akun = $akunIds[$akunIndex];

                    $tanggal = $this->generateRandomDateInRange(
                        $month . "-01",
                        $month . "-28"
                    );
                    $waktu = sprintf(
                        "%02d:%02d:00",
                        mt_rand(8, 17),
                        mt_rand(0, 59)
                    );

                    $filename = "dokumen_pengajuan_" . $counter . ".pdf";
                    $folderPath = $this->baseDir . "/view/pendonor/dokumen";
                    $this->createDummyPdf($filename, $folderPath);
                    $dokumen = "view/pendonor/dokumen/" . $filename;

                    $otp = mt_rand(100000, 999999);
                    $created_at = $this->generateRandomDateTime(
                        $month . "-01",
                        $month . "-28"
                    );

                    $stmt->execute([
                        $akun["id"],
                        $akun["nama"],
                        $akun["nik"],
                        $akun["email"],
                        $akun["telepon"],
                        $tanggal,
                        $waktu,
                        $lokasi,
                        $yesNo[array_rand($yesNo)],
                        $yesNo[array_rand($yesNo)],
                        $yesNo[array_rand($yesNo)],
                        $dokumen,
                        $otp,
                        "gagal",
                        $created_at,
                    ]);

                    $counter++;
                    $akunIndex++;
                }
            }
        }

        echo "Seeded $count pengajuan successfully!\n";
    }
    // Add this method to the DatabaseSeeder class
    public function seedStokDarah($count = 4200)
    {
        // Ambil data pengajuan yang sukses beserta golongan darah pendonor
        $suksesPengajuan = $this->connection
            ->query(
                "
        SELECT p.id, p.id_pendonor, p.lokasi, p.created_at, a.golongan_darah 
        FROM pengajuan p 
        JOIN akun a ON p.id_pendonor = a.id 
        WHERE p.konfirmasi = 'sukses' 
        ORDER BY p.created_at
    "
            )
            ->fetchAll(PDO::FETCH_ASSOC);

        if (empty($suksesPengajuan)) {
            echo "No successful pengajuan found. Please seed pengajuan table first.\n";
            return;
        }

        $stmt = $this->connection->prepare("
        INSERT INTO stok_darah (
            id_pengajuan, 
            golongan_darah, 
            rhesus, 
            jumlah_kantong, 
            tanggal_update, 
            lokasi, 
            tanggal_stok_datang, 
            status, 
            tanggal_kadaluarsa, 
            created_at, 
            updated_at
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

        $statusOptions = ["Aman", "Menipis", "Darurat"];
        $rhesusOptions = ["+", "-"];

        foreach ($suksesPengajuan as $pengajuan) {
            $jumlah_kantong = mt_rand(1, 2);
            $rhesus = $rhesusOptions[array_rand($rhesusOptions)];

            $tanggalPengajuan = new DateTime($pengajuan["created_at"]);
            $tanggalKadaluarsa = clone $tanggalPengajuan;
            $tanggalKadaluarsa->add(new DateInterval("P35D"));

            $now = new DateTime();
            $status =
                $tanggalKadaluarsa < $now
                    ? "Menipis"
                    : $statusOptions[array_rand($statusOptions)];

            $created_at = $pengajuan["created_at"];
            $updated_at = $created_at;
            $tanggal_update = $now->format("Y-m-d H:i:s");

            $stmt->execute([
                $pengajuan["id"], // id_pengajuan
                $pengajuan["golongan_darah"],
                $rhesus,
                $jumlah_kantong,
                $tanggal_update,
                $pengajuan["lokasi"],
                $created_at, // tanggal_stok_datang
                $status,
                $tanggalKadaluarsa->format("Y-m-d"),
                $created_at,
                $updated_at,
            ]);
        }

        echo "Seeded " .
            count($suksesPengajuan) .
            " stok darah successfully!\n";
    }

    // DIPERBAIKI: Seed Review table - hanya untuk pengajuan yang statusnya 'sukses'
    private function generateReviewText($rating)
    {
        // Array kata sifat positif
        $positiveAdjectives = [
            "sangat baik",
            "luar biasa",
            "memuaskan",
            "excellent",
            "prima",
            "fantastis",
            "sempurna",
            "menakjubkan",
            "istimewa",
            "berkualitas",
            "profesional",
            "ramah",
            "responsif",
            "cepat",
            "efisien",
            "bersih",
            "nyaman",
            "aman",
            "modern",
            "canggih",
        ];

        // Array aspek pelayanan
        $serviceAspects = [
            "pelayanan",
            "fasilitas",
            "petugas medis",
            "staff administrasi",
            "sistem pendaftaran",
            "aplikasi",
            "website",
            "proses donor",
            "prosedur",
            "lingkungan",
            "kebersihan",
            "keamanan",
            "alat medis",
            "screening kesehatan",
            "customer service",
        ];

        // Array aktivitas/pengalaman
        $experiences = [
            "donor darah",
            "pendaftaran online",
            "screening kesehatan",
            "proses administrasi",
            "konsultasi medis",
            "pemeriksaan darah",
            "pengambilan darah",
            "pelayanan medis",
            "antrian online",
        ];

        // Array feedback positif
        $positiveFeedback = [
            "sangat membantu",
            "tidak mengecewakan",
            "beyond expectation",
            "sesuai harapan",
            "patut diapresiasi",
            "recommended",
            "akan kembali lagi",
            "puas dengan hasilnya",
            "terima kasih",
            "keep up the good work",
            "terus tingkatkan",
        ];

        // Array manfaat yang dirasakan
        $benefits = [
            "menghemat waktu",
            "proses lebih mudah",
            "tidak perlu antre lama",
            "jadwal fleksibel",
            "informasi lengkap",
            "transparan",
            "mudah dijangkau",
            "parkir luas",
            "lokasi strategis",
        ];

        // Generate review berdasarkan rating
        $reviewParts = [];

        // Pilih adjective berdasarkan rating
        if ($rating == 5) {
            $selectedAdj = array_rand(
                array_flip([
                    "luar biasa",
                    "excellent",
                    "sempurna",
                    "fantastis",
                    "menakjubkan",
                ])
            );
        } else {
            $selectedAdj = array_rand(
                array_flip([
                    "sangat baik",
                    "memuaskan",
                    "prima",
                    "berkualitas",
                    "profesional",
                ])
            );
        }

        // Struktur kalimat 1: Aspek + Adjective
        $aspect1 = $serviceAspects[array_rand($serviceAspects)];
        $reviewParts[] = ucfirst($aspect1) . " " . $selectedAdj;

        // Struktur kalimat 2: Experience + benefit
        $experience = $experiences[array_rand($experiences)];
        $benefit = $benefits[array_rand($benefits)];
        $reviewParts[] = ucfirst($experience) . " " . $benefit;

        // Struktur kalimat 3: Feedback (60% kemungkinan)
        if (mt_rand(1, 100) <= 60) {
            $feedback = $positiveFeedback[array_rand($positiveFeedback)];
            $reviewParts[] = ucfirst($feedback);
        }

        // Gabungkan dengan variasi penghubung
        $connectors = [". ", " dan ", ", ", " serta "];
        $review = implode($connectors[array_rand($connectors)], $reviewParts);

        // Tambah tanda seru untuk rating 5
        if ($rating == 5) {
            $review .= "!";
        } else {
            $review .= ".";
        }

        return $review;
    }

    /**
     * Generate random rating berdasarkan distribusi realistis
     */
    private function generateRating()
    {
        $rand = mt_rand(1, 100);

        if ($rand <= 60) {
            return 5;
        }
        // 60% rating 5
        elseif ($rand <= 85) {
            return 4;
        }
        // 25% rating 4
        elseif ($rand <= 95) {
            return 3;
        }
        // 10% rating 3
        elseif ($rand <= 98) {
            return 2;
        }
        // 3% rating 2
        else {
            return 1;
        } // 2% rating 1
    }

    /**
     * Seed review dari pengajuan yang sukses
     */
    public function seedReview()
    {
        // Ambil pengajuan terakhir yang sukses untuk tiap pendonor
        $successfulApplications = $this->connection
            ->query(
                "
            SELECT 
                p.id_pendonor, 
                a.username, 
                p.lokasi,
                MAX(p.created_at) as pengajuan_date
            FROM pengajuan p
            JOIN akun a ON p.id_pendonor = a.id
            WHERE p.konfirmasi = 'sukses'
            AND NOT EXISTS (
                SELECT 1 FROM review r WHERE r.id_pendonor = p.id_pendonor
            )
            GROUP BY p.id_pendonor, a.username, p.lokasi
            ORDER BY pengajuan_date
        "
            )
            ->fetchAll(PDO::FETCH_ASSOC);

        if (empty($successfulApplications)) {
            echo "No successful applications found or all have been reviewed.\n";
            return;
        }

        $stmt = $this->connection->prepare("
        INSERT INTO review (id_pendonor, username, rating, ulasan, lokasi, created_at) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

        $reviewCount = 0;

        foreach ($successfulApplications as $application) {
            // 75% kemungkinan membuat review
            if (mt_rand(1, 100) <= 75) {
                $id_pendonor = $application["id_pendonor"];
                $username = $application["username"];
                $lokasi = $application["lokasi"];
                $rating = $this->generateRating();
                $ulasan = $this->generateReviewText($rating);

                $pengajuanDate = strtotime($application["pengajuan_date"]);
                $reviewDate = $pengajuanDate + mt_rand(1, 30) * 86400;
                $created_at = date("Y-m-d H:i:s", $reviewDate);

                try {
                    $stmt->execute([
                        $id_pendonor,
                        $username,
                        $rating,
                        $ulasan,
                        $lokasi,
                        $created_at,
                    ]);
                    $reviewCount++;
                } catch (PDOException $e) {
                    echo "Error inserting review for user $username: " .
                        $e->getMessage() .
                        "\n";
                }
            }
        }

        echo "Seeded $reviewCount reviews from " .
            count($successfulApplications) .
            " successful applications.\n";
        echo "Average review participation: " .
            round(($reviewCount / count($successfulApplications)) * 100, 1) .
            "%\n";
    }

    // Seed Tes Kesehatan table
    public function seedTesKesehatan($count = 6300)
    {
        $akunIds = $this->connection
            ->query("SELECT id, created_at FROM akun ORDER BY created_at")
            ->fetchAll(PDO::FETCH_ASSOC);

        if (empty($akunIds)) {
            echo "No akun found. Please seed akun table first.\n";
            return;
        }

        // Ambil lokasi pengajuan terakhir per akun
        $pengajuanLokasi = $this->connection
            ->query(
                "SELECT id_pendonor, lokasi FROM (
                        SELECT id_pendonor, lokasi, created_at,
                            ROW_NUMBER() OVER(PARTITION BY id_pendonor ORDER BY created_at DESC) AS rn
                        FROM pengajuan
                    ) AS subquery WHERE rn = 1"
            )
            ->fetchAll(PDO::FETCH_KEY_PAIR);

        $stmt = $this->connection->prepare("
            INSERT INTO tes_kesehatan (id_pendonor, tanggal, lokasi, tekanan_darah, berat_badan, riwayat_penyakit, dokumen, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $riwayatPenyakitOptions = [
            "Tidak ada riwayat penyakit serius",
            "Riwayat alergi ringan",
            "Pernah mengalami anemia ringan",
            "Sehat tanpa riwayat penyakit",
            "Riwayat hipertensi terkontrol",
            "Tidak ada keluhan kesehatan",
            "Riwayat asma ringan",
            "Pernah operasi usus buntu",
            "Riwayat diabetes terkontrol",
            "Riwayat migrain",
            "Tidak ada masalah kesehatan berarti",
            "Pernah patah tulang",
            "Riwayat maag ringan",
            "Sehat walafiat",
            "Riwayat vertigo ringan",
        ];

        for ($i = 0; $i < $count; $i++) {
            $akun = $akunIds[$i];
            $akunCreatedAt = new DateTime($akun["created_at"]);

            $tesDate = $akunCreatedAt->format("Y-m-d");
            $month = $akunCreatedAt->format("Y-m");

            $tekanan_darah = mt_rand(90, 140) . "/" . mt_rand(60, 90);
            $berat_badan = mt_rand(45, 90) + mt_rand(0, 99) / 100;
            $riwayat_penyakit =
                $riwayatPenyakitOptions[array_rand($riwayatPenyakitOptions)];

            $filename = "tes_kesehatan_" . ($i + 1) . ".pdf";
            $folderPath = $this->baseDir . "/view/pendonor/uploads";
            $this->createDummyPdf($filename, $folderPath);
            $dokumen = "view/pendonor/uploads/" . $filename;

            $created_at = $this->generateRandomDateTime(
                $month . "-01",
                $month . "-28"
            );

            $lokasi = isset($pengajuanLokasi[$akun["id"]])
                ? $pengajuanLokasi[$akun["id"]]
                : "UDD PMI Kabupaten Probolinggo";

            $stmt->execute([
                $akun["id"],
                $tesDate,
                $lokasi,
                $tekanan_darah,
                $berat_badan,
                $riwayat_penyakit,
                $dokumen,
                $created_at,
            ]);
        }

        echo "Seeded $count tes kesehatan successfully!\n";
    }

    // Seed Pengambilan Darah table
    public function seedPengambilanDarah($count = 8)
    {
        $stmt = $this->connection->prepare("
        INSERT INTO pengambilan_darah (golongan_darah, rhesus, jumlah_kantong, tanggal_keluar, lokasi, lokasi_tujuan, keterangan, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

        $bloodTypes = ["A", "B", "AB", "O"];
        $rhesusTypes = ["+", "-"];

        $uddList = [
            "UDD PMI Kabupaten Probolinggo",
            "UDD PMI Kota Probolinggo",
            "UDD PMI Kabupaten Lumajang",
            "UDD PMI Kabupaten Jember",
            "UDD PMI Kabupaten Bondowoso",
            "UDD PMI Kabupaten Situbondo",
            "UDD PMI Kabupaten Banyuwangi",
        ];

        $hospitals = [
            // Probolinggo
            "RSUD Tongas Probolinggo",
            "RS Bayangkara Probolinggo",
            "RS Islam Probolinggo",
            "RS Kraksaan",
            "RS Umum Daerah Kraksaan",
            "RS Panti Nirmala Probolinggo",

            // Lumajang
            "RSUD Lumajang",
            "RS Bhayangkara Lumajang",
            "RS Islam Lumajang",
            "RS Katolik Lumajang",
            "RS Wijaya Lumajang",
            "RS Bunda Lumajang",

            // Bondowoso
            "RSUD Bondowoso",
            "RS Islam Bondowoso",
            "RS Kodam Bondowoso",
            "RS Bhayangkara Bondowoso",
            "RS Umum Bondowoso",

            // Situbondo
            "RSUD Situbondo",
            "RS Islam Situbondo",
            "RS Bhayangkara Situbondo",
            "RS Umum Panarukan",
            "RS Bersalin Situbondo",

            // Banyuwangi
            "RSUD Blambangan Banyuwangi",
            "RS Islam Banyuwangi",
            "RS Bhayangkara Banyuwangi",
            "RS Umum Genteng",
            "RS Bunda Banyuwangi",
            "RS Katolik Banyuwangi",
            "RS Panti Waluya Banyuwangi",
            "RS Umum Muncar",

            // Jember
            "RSUD dr. Soebandi Jember",
            "RS Kaliwates Jember",
            "RS Islam Jember",
        ];

        $keteranganOptions = [
            "Untuk pasien operasi darurat",
            "Kebutuhan transfusi rutin",
            "Pasien thalassemia",
            "Kecelakaan lalu lintas",
            "Operasi besar",
            "Persediaan IGD",
            "Pasien kanker",
            "Operasi jantung",
            "Pasien anemia berat",
            "Kebutuhan darah emergency",
            "Operasi caesar",
            "Pasien DBD",
            "Transfusi rutin",
            "Persediaan bank darah",
            "Kebutuhan ICU",
        ];

        for ($i = 0; $i < $count; $i++) {
            $golongan_darah = $bloodTypes[array_rand($bloodTypes)];
            $rhesus = $rhesusTypes[array_rand($rhesusTypes)];
            $jumlah = mt_rand(1, 5);
            $tanggal_keluar = $this->generateRandomDateInRange(
                "2025-01-01",
                "2025-06-30"
            );
            $lokasi_udd = $uddList[array_rand($uddList)];
            $lokasi_tujuan = $hospitals[array_rand($hospitals)];
            $keterangan = $keteranganOptions[array_rand($keteranganOptions)];
            $created_at = $this->generateRandomDateTime(
                "2025-01-01",
                "2025-06-30"
            );

            $stmt->execute([
                $golongan_darah,
                $rhesus,
                $jumlah,
                $tanggal_keluar,
                $lokasi_udd, // <== lokasi pengambilan darah
                $lokasi_tujuan, // <== rumah sakit tujuan
                $keterangan,
                $created_at,
            ]);
        }

        echo "Seeded $count pengambilan darah successfully!\n";
    }

    // Seed FAQ table
    public function seedFAQ($count = 10)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO faq (email, pertanyaan, jawaban, created_at) 
            VALUES (?, ?, ?, ?)
        ");

        $questions = [
            "Bagaimana cara mendaftar sebagai donor darah?",
            "Apa saja syarat untuk menjadi donor darah?",
            "Berapa lama proses donor darah berlangsung?",
            "Apakah ada efek samping setelah donor darah?",
            "Kapan saya bisa donor darah lagi setelah donor terakhir?",
            "Bagaimana cara mengecek stok darah yang tersedia?",
            "Apa yang harus dipersiapkan sebelum donor darah?",
            "Bisakah donor darah jika sedang menstruasi?",
            "Apakah donor darah aman untuk kesehatan?",
            "Bagaimana cara membatalkan jadwal donor darah?",
        ];

        $answers = [
            "Anda dapat mendaftar melalui website kami dengan mengisi formulir pendaftaran.",
            "Syarat donor darah antara lain berusia 17-65 tahun, berat badan minimal 45kg, dan kondisi sehat.",
            "Proses donor darah biasanya berlangsung sekitar 10-15 menit untuk pengambilan darah.",
            "Efek samping ringan seperti pusing atau lemas bisa terjadi, namun akan hilang dalam beberapa jam.",
            "Interval donor darah minimal 3 bulan atau 12 minggu setelah donor terakhir.",
            "Stok darah dapat dicek melalui halaman stok darah di website kami.",
            "Pastikan istirahat cukup, makan bergizi, dan minum air putih yang cukup.",
            "Sebaiknya menunggu hingga menstruasi selesai untuk kondisi yang optimal.",
            "Donor darah sangat aman jika dilakukan dengan prosedur yang benar dan steril.",
            "Pembatalan dapat dilakukan melalui kontak customer service kami.",
        ];

        for ($i = 0; $i < $count; $i++) {
            $email = "user" . ($i + 1) . "@gmail.com";
            $pertanyaan = $questions[$i % count($questions)];
            $jawaban = mt_rand(0, 1) ? $answers[$i % count($answers)] : null;
            $created_at = $this->generateRandomDateTime(
                "2024-12-01",
                "2025-06-30"
            );

            $stmt->execute([$email, $pertanyaan, $jawaban, $created_at]);
        }

        echo "Seeded $count FAQ successfully!\n";
    }

    // Function to create dummy profile images
    private function createDummyImages($count)
    {
        $profilFolder = $this->baseDir . "/view/pendonor/profil";

        for ($i = 1; $i <= $count; $i++) {
            $filename = "profil_$i.jpg";
            $filepath = $profilFolder . "/" . $filename;

            // Create simple colored square as dummy image
            $image = imagecreate(200, 200);
            $bgColor = imagecolorallocate(
                $image,
                mt_rand(100, 255),
                mt_rand(100, 255),
                mt_rand(100, 255)
            );
            $textColor = imagecolorallocate($image, 255, 255, 255);

            imagestring($image, 5, 50, 90, "User $i", $textColor);

            if (imagejpeg($image, $filepath)) {
                echo "Created image: $filepath\n";
            }

            imagedestroy($image);
        }
    }

    // Run all seeders
    public function runAllSeeders()
    {
        echo "Starting database seeding...\n\n";

        // Setup folders first
        echo "Setting up folder structure...\n";
        $this->setupFolders();

        echo "\nClearing database tables...\n";
        $this->clearTables();

        echo "\nSeeding data...\n";
        $this->seedUsers(8);
        $this->seedAkun(6300); // 6300 akun (150/bulan × 7 daerah × 6 bulan)
        $this->createDummyImages(6300); // 6300 profile images
        $this->seedPengajuan(6300); // 6300 pengajuan (4200 sukses + 2100 gagal)
        $this->seedTesKesehatan(6300); // 6300 tes kesehatan (untuk semua akun)
        $this->seedStokDarah(4200); // 4200 stok darah (hanya untuk yang sukses)
        $this->seedPengambilanDarah(2000);
        $this->seedFAQ(100);
        echo "\n=== Seeding Reviews ===\n";
        $this->seedReview();

        echo "\n=================================\n";
        echo "All seeders completed successfully!\n";
        echo "=================================\n";
        echo "Data Summary:\n";
        echo "- 8 Admin users\n";
        echo "- 6300 Donor accounts (150/month × 7 locations × 6 months)\n";
        echo "- 6300 Applications (4200 approved + 2100 rejected)\n";
        echo "- 6300 Health tests (one per account)\n";
        echo "- 4200 Blood stock entries (only for approved donations)\n";
        echo "- 300 Blood withdrawals\n";
        echo "- 100 FAQ entries\n\n";
        echo "Monthly breakdown per location:\n";
        echo "- 100 successful donations per month\n";
        echo "- 50 rejected applications per month\n";
        echo "- Total: 150 accounts per month per location\n\n";

        echo "Folder structure created:\n";
        echo "- " .
            $this->baseDir .
            "/view/pendonor/profil/ (for profile images)\n";
        echo "- " .
            $this->baseDir .
            "/view/pendonor/uploads/ (for health test documents)\n";
        echo "- " .
            $this->baseDir .
            "/view/pendonor/dokumen/ (for application documents)\n";

        echo "\nFiles created:\n";
        echo "- 6300 profile images (profil_1.jpg to profil_6300.jpg)\n";
        echo "- 6300 document PDFs (dokumen_pengajuan_*.pdf)\n";
        echo "- 6300 health test PDFs (tes_kesehatan_*.pdf)\n";

        echo "\nAll created_at timestamps include random date and time!\n";
        echo "Data spans from January 2025 to June 2025 (6 months)\n";
    }
}

// Usage example
try {
    $seeder = new DatabaseSeeder("localhost", "root", "", "web_donor");

    // Jika diakses via web browser, tampilkan interface
    if (isset($_SERVER["HTTP_HOST"])) {
        $seeder->showInterface();
    } else {
        // Jika dijalankan via command line, jalankan semua seeder
        $seeder->runAllSeeders();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
