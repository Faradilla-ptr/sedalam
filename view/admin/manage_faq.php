<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../vendor/autoload.php";

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$limit = 30; // jumlah data per halaman
$page =
    isset($_GET["page"]) && is_numeric($_GET["page"]) ? (int) $_GET["page"] : 1;
$offset = ($page - 1) * $limit;
$countQuery = "SELECT COUNT(*) as total FROM faq WHERE 1=1";
if (!empty($_GET["bulan"])) {
    $bulan = $conn->real_escape_string($_GET["bulan"]);
    $countQuery .= " AND MONTH(created_at) = '$bulan'";
}
if (!empty($_GET["tahun"])) {
    $tahun = $conn->real_escape_string($_GET["tahun"]);
    $countQuery .= " AND YEAR(created_at) = '$tahun'";
}
$resultCount = $conn->query($countQuery);
$totalData = $resultCount->fetch_assoc()["total"];
$total_pages = ceil($totalData / $limit);

$filterQuery = "SELECT * FROM faq WHERE 1=1";

if (!empty($_GET["bulan"])) {
    $bulan = $conn->real_escape_string($_GET["bulan"]);
    $filterQuery .= " AND MONTH(created_at) = '$bulan'";
}

if (!empty($_GET["tahun"])) {
    $tahun = $conn->real_escape_string($_GET["tahun"]);
    $filterQuery .= " AND YEAR(created_at) = '$tahun'";
}

$filterQuery .= " ORDER BY created_at DESC, id DESC LIMIT $limit OFFSET $offset";
$faqs = $conn->query($filterQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send_answer"])) {
    $email = $_POST["email"];
    $jawaban = $_POST["jawaban"];
    $pertanyaan = $_POST["pertanyaan"];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "faradilla.anastasyaptr@gmail.com"; // Email pengirim
        $mail->Password = "fmup yyoi gntj bush";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("web_sedalam@gmail.com", "Sedalam Support");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Tanggapan atas Pertanyaan Anda";
        $nama_pengirim = explode("@", $email)[0]; // Ambil bagian sebelum @ dari email
        $mail->Body =
            '
<html>
<head>
  <style>
    body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #f0fbfc; padding: 20px; }
    .container { max-width: 600px; margin: auto; background: #ffffff; border: 1px solid #b2ebf2; border-radius: 8px; }
    .header { background-color: #00bcd4; color: #fff; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
    .content { padding: 20px; color: #333; }
    .question { background: #e0f7fa; padding: 15px; border-left: 4px solid #00acc1; margin-bottom: 20px; }
    .answer { background: #f1f8e9; padding: 15px; border-left: 4px solid #8bc34a; }
    .footer { text-align: center; font-size: 12px; color: #777; padding: 15px; background: #f9f9f9; border-top: 1px solid #eee; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Tanggapan Sedalam</h2>
    </div>
    <div class="content">
      <p>Halo, ' .
            htmlspecialchars($nama_pengirim) .
            '</p>
      <p>Terima kasih telah mengirimkan pertanyaan kepada kami. Berikut adalah jawaban dari tim Sedalam:</p>
      
      <div class="question">
        <strong>Pertanyaan Anda:</strong><br>
        ' .
            nl2br(htmlspecialchars($pertanyaan)) .
            '
      </div>

      <div class="answer">
        <strong>Jawaban:</strong><br>
        ' .
            nl2br(htmlspecialchars($jawaban)) .
            '
      </div>

      <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan balas email ini atau hubungi kami melalui halaman kontak.</p>
      <p>Salam hangat,<br>Tim Sedalam</p>
    </div>
    <div class="footer">
      Email ini dikirim secara otomatis oleh sistem Sedalam.
    </div>
  </div>
</body>
</html>';
        $mail->AltBody = "Pertanyaan Anda:\n$pertanyaan\n\nJawaban:\n$jawaban\n\nSalam,\nTim Sedalam";

        $mail->send();

        $stmt = $conn->prepare(
            "UPDATE faq SET jawaban = ? WHERE email = ? AND pertanyaan = ?"
        );
        $stmt->bind_param("sss", $jawaban, $email, $pertanyaan);
        $stmt->execute();

        $msg = "Jawaban berhasil dikirim ke email!";
    } catch (Exception $e) {
        $msg = "Pesan tidak terkirim. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin FAQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tambahkan SweetAlert2 CDN di bagian <head> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tambahkan ini di bagian <head> -->
<script src="https://cdn.lordicon.com/lordicon.js"></script>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f8f9fa;
    }

    .content-wrapper {
        margin-left: 260px;
        padding: 30px 30px 30px 20px;
    }

    .faq-item {
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 5px solid transparent;
    }

    .faq-item:hover {
        background-color: #eef6ff;
        border-left: 5px solid #4dabf7;
    }

    .right-panel {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.06);
        padding: 25px;
    }

    .faq-form input,
    .faq-form textarea {
        border-radius: 8px;
    }

    .faq-form button {
        background: linear-gradient(45deg, #00c6ff, #0072ff);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
    }

    .faq-form button:hover {
        opacity: 0.9;
    }


    .jawab-btn {
  position: relative;
  border-radius: 20px;
  border: none;
  background: linear-gradient(135deg, rgb(224, 87, 101), #a71d2a);
  color: #ffffff;
  font-size: 13px; /* lebih kecil dari 15px */
  font-weight: 600;
  margin: 4px; /* lebih kecil dari 10px */
  padding: 8px 20px; /* lebih kecil dari 12px 80px */
  letter-spacing: 0.5px;
  text-transform: capitalize;
  transition: all 0.3s ease;
  box-shadow: 0 3px 10px rgba(167, 29, 42, 0.3);
  cursor: pointer;
}

.jawab-btn:hover {
  letter-spacing: 2px;
  background: linear-gradient(135deg, #a71d2a, rgb(224, 87, 101));
  transform: translateY(-2px);
  box-shadow: 0 5px 16px rgba(167, 29, 42, 0.4);
}
h1, h2, h3, .card-header{
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
}

</style>

</head>
<body>
<?php include "sidebar.php"; ?>
<div class="content-wrapper">
<h3 class="text-center">FAQ Admin - Pusat Pertanyaan Pengguna</h3>


    <?php if (isset($msg)): ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>
    <form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label">Bulan</label>
        <select name="bulan" class="form-select">
            <option value="">Semua</option>
            <?php for ($i = 1; $i <= 12; $i++) {
                $selected =
                    isset($_GET["bulan"]) && $_GET["bulan"] == $i
                        ? "selected"
                        : "";
                echo "<option value='$i' $selected>" .
                    date("F", mktime(0, 0, 0, $i, 1)) .
                    "</option>";
            } ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Tahun</label>
        <select name="tahun" class="form-select">
            <option value="">Semua</option>
            <?php
            $tahunSekarang = date("Y");
            for ($t = 2023; $t <= $tahunSekarang; $t++) {
                $selected =
                    isset($_GET["tahun"]) && $_GET["tahun"] == $t
                        ? "selected"
                        : "";
                echo "<option value='$t' $selected>$t</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Cari</button>
        <a href="faq.php" class="btn btn-secondary"><i class="bi bi-arrow-repeat"></i> Reset</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
<?php
$no = $offset + 1;
while ($row = $faqs->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row["email"] ?></td>
        <td><?= $row["pertanyaan"] ?></td>
        <td><?= !empty($row["jawaban"])
            ? $row["jawaban"]
            : "<i><small>(Belum dijawab)</small></i>" ?></td>
        <td><?= $row["created_at"] ?></td>
        <td>
            <?php if (!empty($row["jawaban"])): ?>
                <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Terjawab</span>
            <?php else: ?>
                <button 
                    class="btn btn-sm btn-outline-primary jawab-btn float-end"
                    data-email="<?= htmlspecialchars($row["email"]) ?>"
                    data-pertanyaan="<?= htmlspecialchars(
                        $row["pertanyaan"]
                    ) ?>"
                    data-bs-toggle="modal" data-bs-target="#modalJawab">
                    <i class="bi bi-reply-fill"></i> Jawab Sekarang
                </button>
            <?php endif; ?>
        </td>
    </tr>
<?php endwhile;
?>
</tbody>

    </table>
    <nav>
  <ul class="pagination justify-content-center mt-4">
  <?php if ($total_pages > 1): ?>
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page -
                            1 ?>&bulan=<?= $_GET["bulan"] ??
    "" ?>&tahun=<?= $_GET["tahun"] ?? "" ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                <?php endif; ?>

                <?php
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);

                if ($start_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=1&bulan=<?= $_GET[
                            "bulan"
                        ] ?? "" ?>&tahun=<?= $_GET["tahun"] ?? "" ?>">1</a>
                    </li>
                    <?php if ($start_page > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif;
                ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <li class="page-item <?= $i == $page ? "active" : "" ?>">
                        <a class="page-link" href="?page=<?= $i ?>&bulan=<?= $_GET[
    "bulan"
] ?? "" ?>&tahun=<?= $_GET["tahun"] ?? "" ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                    <?php if ($end_page < $total_pages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $total_pages ?>&bulan=<?= $_GET[
    "bulan"
] ?? "" ?>&tahun=<?= $_GET["tahun"] ?? "" ?>"><?= $total_pages ?></a>
                    </li>
                <?php endif; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page +
                            1 ?>&bulan=<?= $_GET["bulan"] ??
    "" ?>&tahun=<?= $_GET["tahun"] ?? "" ?>">Next</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>

                    </ul>
                </nav>
            </div>


</div>
<!-- Modal Jawab Pertanyaan -->
<div class="modal fade" id="modalJawab" tabindex="-1" aria-labelledby="modalJawabLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalJawabLabel"><i class="bi bi-envelope-open"></i> Jawab Pertanyaan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="email" id="emailModal">
          <input type="hidden" name="pertanyaan" id="pertanyaanModal">
          <div class="mb-3">
            <label class="form-label">Email Pengirim</label>
            <input type="text" class="form-control" id="emailDisplay" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Pertanyaan</label>
            <textarea class="form-control" id="pertanyaanDisplay" rows="3" disabled></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Jawaban Anda</label>
            <textarea name="jawaban" class="form-control" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="send_answer" class="btn btn-success">
            <i class="bi bi-send-check-fill"></i> Kirim Jawaban
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script isi data modal -->
<script>
  document.querySelectorAll('.jawab-btn').forEach(button => {
    button.addEventListener('click', function () {
      const email = this.getAttribute('data-email');
      const pertanyaan = this.getAttribute('data-pertanyaan');
      
      document.getElementById('emailModal').value = email;
      document.getElementById('pertanyaanModal').value = pertanyaan;
      document.getElementById('emailDisplay').value = email;
      document.getElementById('pertanyaanDisplay').value = pertanyaan;
    });
  });
</script>

<!-- Tambahkan Bootstrap JS jika belum ada -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<script>
        <?php if (isset($msg)): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?= $msg ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
    
</script>

</script>

</body>
</html>
