<?php
// pusher_processor.php - File ini digunakan untuk mengirim notifikasi real-time saat ada data baru

require __DIR__ . "/vendor/autoload.php"; // Path ke Composer autoload

use Pusher\Pusher;

class NotificationProcessor
{
    private $conn;
    private $pusher;
    private $lastCheckFile;

    public function __construct()
    {
        // Konfigurasi database
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "web_donor";

        // Koneksi database
        $this->conn = new mysqli($host, $user, $pass, $dbname);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }

        // Konfigurasi Pusher
        $options = [
            "cluster" => "ap1",
            "useTLS" => true,
        ];

        // Inisialisasi Pusher
        // Ganti dengan kredensial Pusher Anda
        $this->pusher = new Pusher(
            "9160beb03fddb9b72bc6",
            "1f8be6cbb35607f7e1c8",
            "1989886",
            $options
        );

        // File untuk menyimpan timestamp terakhir cek
        $this->lastCheckFile = __DIR__ . "/last_check.txt";

        // Membuat file timestamp jika belum ada
        if (!file_exists($this->lastCheckFile)) {
            file_put_contents(
                $this->lastCheckFile,
                date("Y-m-d H:i:s", strtotime("-1 hour"))
            );
        }
    }

    public function processNotifications()
    {
        // Baca timestamp terakhir cek
        $lastCheck = trim(file_get_contents($this->lastCheckFile));

        // Update timestamp
        $currentTime = date("Y-m-d H:i:s");
        file_put_contents($this->lastCheckFile, $currentTime);

        $tables = [
            ["akun", "nama", "Akun Baru"],
            ["faq", "email", "FAQ Baru"],
            ["pengajuan", "nama", "Pengajuan Baru"],
            ["pengambilan_darah", "lokasi_tujuan", "Pengambilan Darah Baru"],
            ["tes_kesehatan", "id", "Tes Kesehatan Baru"],
        ];

        $newItems = [];

        foreach ($tables as $table) {
            $tableName = $table[0];
            $contentField = $table[1];
            $label = $table[2];

            $sql = "SELECT '$label' as sumber, $contentField as isi, created_at 
                    FROM $tableName 
                    WHERE created_at > ? 
                    ORDER BY created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $lastCheck);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                // Kirim notifikasi menggunakan Pusher
                // Kirim notifikasi menggunakan Pusher
                $data = [
                    "sumber" => $row["sumber"],
                    "isi" => $row["isi"],
                    "waktu" => $row["created_at"],
                ];

                // Trigger ke channel dan event yang sesuai
                $this->pusher->trigger(
                    "notifikasi-channel",
                    "notifikasi-event",
                    $data
                );

                // Simpan item baru ke array (jika ingin digunakan)
                $newItems[] = $data;
            }
        }

        return $newItems; // Jika ingin dipakai untuk logging atau debug
    }
}

// Jalankan proses notifikasi (bisa dipanggil dari cron job atau script lainnya)
$processor = new NotificationProcessor();
$processor->processNotifications();
