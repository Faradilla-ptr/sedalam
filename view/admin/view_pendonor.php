<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_donor";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set global connection for helper functions
$GLOBALS["conn"] = $conn;

// Include helper filter
require_once __DIR__ . "../../../admin_filter_helper.php";

$id_pendonor = isset($_GET["id"]) ? (int) $_GET["id"] : null;
$show_dokumen = $_GET["show_dokumen"] ?? null;

// TAMBAHAN: Handle konfirmasi pengajuan (terima/tolak)
if (isset($_POST["konfirmasi"]) && isset($_POST["id_pengajuan"]) && isset($_POST["status"])) {
    $id_pengajuan = $_POST["id_pengajuan"];
    $status = $_POST["status"]; // 'sukses' atau 'gagal'
    
    // Verifikasi akses berdasarkan lokasi admin
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location);
    
    // Update status konfirmasi
    $stmt = $conn->prepare("UPDATE pengajuan SET konfirmasi = ? WHERE id = ? $location_filter");
    $stmt->bind_param("si", $status, $id_pengajuan);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Set session untuk menampilkan alert sukses
            $_SESSION['konfirmasi_status'] = 'success';
            $_SESSION['konfirmasi_message'] = 'Status pengajuan berhasil diperbarui!';
            $_SESSION['konfirmasi_type'] = $status == 'sukses' ? 'Diterima' : 'Ditolak';
            
            // Redirect untuk mencegah resubmission
            header("Location: view_pendonor.php?id=" . $id_pendonor);
            exit();
        } else {
            $_SESSION['konfirmasi_status'] = 'error';
            $_SESSION['konfirmasi_message'] = 'Data tidak ditemukan atau Anda tidak memiliki akses untuk data ini!';
        }
    } else {
        $_SESSION['konfirmasi_status'] = 'error';
        $_SESSION['konfirmasi_message'] = 'Gagal memperbarui status pengajuan!';
    }
    $stmt->close();
}

// Initialize variables
$pengajuan = null;
$tes_kesehatan = null;
$pendonor = null;

if ($id_pendonor) {
    // Ambil data pendonor
    $detail_query = "SELECT * FROM akun WHERE id = ?";
    $stmt = $conn->prepare($detail_query);
    $stmt->bind_param("i", $id_pendonor);
    $stmt->execute();
    $detail_result = $stmt->get_result();

    if ($detail_result && $detail_result->num_rows > 0) {
        $pendonor = $detail_result->fetch_assoc();
    } else {
        die("Data pendonor tidak ditemukan.");
    }

    // Ambil data pengajuan dengan filter lokasi
    $admin_location = $_SESSION["admin_location"] ?? "ALL";
    $location_filter = getLocationFilter($admin_location, "p");
    
    $pengajuan_query = "SELECT p.* FROM pengajuan p WHERE p.id_pendonor = ? $location_filter";
    $stmt = $conn->prepare($pengajuan_query);
    $stmt->bind_param("i", $id_pendonor);
    $stmt->execute();
    $pengajuan_result = $stmt->get_result();
    $pengajuan =
        $pengajuan_result && $pengajuan_result->num_rows > 0
            ? $pengajuan_result->fetch_assoc()
            : null;

    // Ambil data tes kesehatan
    $tes_kesehatan_query = "SELECT * FROM tes_kesehatan WHERE id_pendonor = ?";
    $stmt = $conn->prepare($tes_kesehatan_query);
    $stmt->bind_param("i", $id_pendonor);
    $stmt->execute();
    $tes_kesehatan_result = $stmt->get_result();
    $tes_kesehatan =
        $tes_kesehatan_result && $tes_kesehatan_result->num_rows > 0
            ? $tes_kesehatan_result->fetch_assoc()
            : null;
} else {
    die("ID Pendonor tidak valid.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pendonor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            padding-top: 60px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        .modal-xl {
            max-width: 90%;
        }
        .pdf-viewer {
            width: 100%;
            height: 600px;
            border: none;
        }
        .pdf-error {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }
        .status-badge {
            font-size: 1.1em;
            padding: 8px 16px;
        }
        .confirmation-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            border: 2px solid #dee2e6;
        }
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="content">
<div class="container mt-5">
    <!-- Status Pengajuan Badge -->
    <?php if ($pengajuan): ?>
    <div class="alert alert-info d-flex align-items-center justify-content-between">
        <div>
            <strong>Status Pengajuan: </strong>
            <?php if ($pengajuan["konfirmasi"] === "pending"): ?>
                <span class="badge bg-warning text-dark status-badge">Menunggu Konfirmasi</span>
            <?php elseif ($pengajuan["konfirmasi"] === "sukses"): ?>
                <span class="badge bg-success status-badge">Diterima</span>
            <?php elseif ($pengajuan["konfirmasi"] === "gagal"): ?>
                <span class="badge bg-danger status-badge">Ditolak</span>
            <?php endif; ?>
        </div>
        <small class="text-muted">ID Pengajuan: <?= $pengajuan['id'] ?></small>
    </div>
    <?php endif; ?>

    <h3>Data Diri Pendonor</h3>
    <div class="mb-3"><label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars(
            $pendonor["nama"]
        ) ?>" readonly>
    </div>
    <div class="mb-3"><label class="form-label">Email</label>
        <input type="email" class="form-control" value="<?= htmlspecialchars(
            $pendonor["email"]
        ) ?>" readonly>
    </div>
    <div class="mb-3"><label class="form-label">Tanggal Lahir</label>
        <input type="date" class="form-control" value="<?= htmlspecialchars(
            $pendonor["tanggal_lahir"]
        ) ?>" readonly>
    </div>
    <div class="mb-3"><label class="form-label">Gender</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars(
            $pendonor["gender"]
        ) ?>" readonly>
    </div>
    <div class="mb-3"><label class="form-label">Telepon</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars(
            $pendonor["telepon"]
        ) ?>" readonly>
    </div>
    <div class="mb-3"><label class="form-label">Alamat</label>
        <textarea class="form-control" rows="3" readonly><?= htmlspecialchars(
            $pendonor["alamat"]
        ) ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Dokumen Pengajuan</label>
        <div class="d-flex align-items-center">
            <input type="text" class="form-control me-2"
            value="<?= isset($pengajuan["dokumen"]) && $pengajuan["dokumen"]
                ? "dokumen_pengajuan_" . $pengajuan["id"] . ".pdf"
                : "Tidak ada dokumen" ?>"
                readonly>
            <?php if (isset($pengajuan["dokumen"]) && $pengajuan["dokumen"]): ?>
                <button type="button" class="btn btn-primary" onclick="showPDF('pengajuan', <?= $pengajuan[
                    "id"
                ] ?>)">Lihat</button>
            <?php else: ?>
                <button type="button" class="btn btn-secondary" disabled>Lihat</button>
            <?php endif; ?>
        </div>
    </div>

    <h3 class="mt-5">Data Tes Kesehatan</h3>
    <?php if ($tes_kesehatan): ?>
        <div class="mb-3"><label class="form-label">Tekanan Darah</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars(
                $tes_kesehatan["tekanan_darah"]
            ) ?>" readonly>
        </div>
        <div class="mb-3"><label class="form-label">Berat Badan</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars(
                $tes_kesehatan["berat_badan"]
            ) ?>" readonly>
        </div>
        <div class="mb-3"><label class="form-label">Riwayat Penyakit</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars(
                $tes_kesehatan["riwayat_penyakit"]
            ) ?>" readonly>
        </div>
        <?php if (!empty($tes_kesehatan["dokumen"])): ?>
            <div class="mb-3">
                <label class="form-label">Dokumen Tes Kesehatan</label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2"
                    value="tes_kesehatan_<?= $tes_kesehatan["id"] ?>.pdf"
                    readonly>
                    <button type="button" class="btn btn-primary" onclick="showPDF('tes_kesehatan', <?= $tes_kesehatan[
                        "id"
                    ] ?>)">Lihat</button>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning">Data Tes Kesehatan tidak ditemukan.</div>
    <?php endif; ?>

    <!-- Konfirmasi Section -->
    <?php if ($pengajuan && $pengajuan["konfirmasi"] === "pending"): ?>
    <div class="confirmation-section">
        <h4 class="mb-4">
            <i class="bi bi-check-circle"></i> Konfirmasi Pengajuan
        </h4>
        <p class="text-muted mb-4">
            Silakan review semua data di atas dengan teliti sebelum memberikan konfirmasi.
        </p>
        
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-success btn-lg" onclick="confirmSubmission('sukses', '<?= $pengajuan['id'] ?>')">
                <i class="bi bi-check-lg"></i> Terima Pengajuan
            </button>
            <button type="button" class="btn btn-danger btn-lg" onclick="confirmSubmission('gagal', '<?= $pengajuan['id'] ?>')">
                <i class="bi bi-x-lg"></i> Tolak Pengajuan
            </button>
        </div>
    </div>
    <?php elseif ($pengajuan): ?>
    <div class="confirmation-section">
        <h4 class="mb-3">Status Konfirmasi</h4>
        <p class="mb-0">
            <?php if ($pengajuan["konfirmasi"] === "sukses"): ?>
                <i class="bi bi-check-circle-fill text-success"></i>
                <strong class="text-success">Pengajuan ini telah DITERIMA</strong>
            <?php elseif ($pengajuan["konfirmasi"] === "gagal"): ?>
                <i class="bi bi-x-circle-fill text-danger"></i>
                <strong class="text-danger">Pengajuan ini telah DITOLAK</strong>
            <?php endif; ?>
        </p>
    </div>
    <?php endif; ?>

    <!-- Navigation Buttons -->
    <div class="mt-4 d-flex gap-2">
        <a href="manage_admin.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <?php if ($pengajuan && $pengajuan["konfirmasi"] !== "pending"): ?>
        <form method="POST" action="manage_admin.php" class="d-inline">
            <input type="hidden" name="id" value="<?= $pengajuan["id"] ?>">
        </form>
        <?php endif; ?>
    </div>
</div>
</div>

<!-- Hidden Form for Confirmation -->
<form id="confirmationForm" method="POST" style="display: none;">
    <input type="hidden" name="konfirmasi" value="1">
    <input type="hidden" name="id_pengajuan" id="hiddenIdPengajuan">
    <input type="hidden" name="status" id="hiddenStatus">
</form>

<!-- Modal tampilkan dokumen PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfModalLabel">Preview Dokumen PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div id="pdfContainer">
          <!-- PDF akan dimuat di sini -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <a id="downloadBtn" href="#" class="btn btn-primary" download>Download PDF</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Function untuk konfirmasi dengan SweetAlert
function confirmSubmission(status, idPengajuan) {
    const isAccept = status === 'sukses';
    const title = isAccept ? 'Terima Pengajuan?' : 'Tolak Pengajuan?';
    const text = isAccept 
        ? 'Apakah Anda yakin ingin menerima pengajuan donor ini? Pendonor akan menerima email konfirmasi dengan QR Code.'
        : 'Apakah Anda yakin ingin menolak pengajuan donor ini? Pendonor akan menerima email pemberitahuan penolakan.';
    const confirmButtonText = isAccept ? 'Ya, Terima!' : 'Ya, Tolak!';
    const confirmButtonColor = isAccept ? '#28a745' : '#dc3545';
    
    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'swal-wide'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Set values and submit form
            document.getElementById('hiddenIdPengajuan').value = idPengajuan;
            document.getElementById('hiddenStatus').value = status;
            document.getElementById('confirmationForm').submit();
        }
    });
}

// Function untuk menampilkan PDF
function showPDF(type, recordId) {
    var modal = new bootstrap.Modal(document.getElementById('pdfModal'));
    var pdfContainer = document.getElementById('pdfContainer');
    var downloadBtn = document.getElementById('downloadBtn');
    var modalTitle = document.getElementById('pdfModalLabel');
    
    var pdfPath = '';
    var fileName = '';
    
    if (type === 'pengajuan') {
        pdfPath = '/sedalam/view/pendonor/dokumen/dokumen_pengajuan_' + recordId + '.pdf';
        fileName = 'dokumen_pengajuan_' + recordId + '.pdf';
        modalTitle.textContent = 'Preview Dokumen Pengajuan';
    } else if (type === 'tes_kesehatan') {
        pdfPath = '/sedalam/view/pendonor/uploads/tes_kesehatan_' + recordId + '.pdf';
        fileName = 'tes_kesehatan_' + recordId + '.pdf';
        modalTitle.textContent = 'Preview Dokumen Tes Kesehatan';
    }
    
    // Set download link
    downloadBtn.href = pdfPath;
    downloadBtn.download = fileName;
    
    // Clear previous content
    pdfContainer.innerHTML = '<div class="text-center p-3">Loading PDF...</div>';
    
    // Create iframe and handle load/error events
    var iframe = document.createElement('iframe');
    iframe.src = pdfPath;
    iframe.className = 'pdf-viewer';
    
    iframe.onload = function() {
        console.log('PDF loaded successfully');
    };
    
    iframe.onerror = function() {
        handlePDFError();
    };
    
    // Replace loading message with iframe
    setTimeout(function() {
        pdfContainer.innerHTML = '';
        pdfContainer.appendChild(iframe);
    }, 500);
    
    modal.show();
}

function handlePDFError() {
    var pdfContainer = document.getElementById('pdfContainer');
    pdfContainer.innerHTML = '<div class="pdf-error"><h5>Gagal memuat PDF</h5><p>File PDF tidak dapat ditampilkan. Silakan coba download file atau periksa apakah file ada di server.</p></div>';
}

// Auto-show modal if show_dokumen parameter exists
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const showDokumen = urlParams.get('show_dokumen');
    
    if (showDokumen === 'pengajuan' && <?= $pengajuan
        ? $pengajuan["id"]
        : "null" ?>) {
        showPDF('pengajuan', <?= $pengajuan ? $pengajuan["id"] : "null" ?>);
    } else if (showDokumen === 'tes_kesehatan' && <?= $tes_kesehatan
        ? $tes_kesehatan["id"]
        : "null" ?>) {
        showPDF('tes_kesehatan', <?= $tes_kesehatan
            ? $tes_kesehatan["id"]
            : "null" ?>);
    }
    
    // Show success/error alerts from session
    <?php if (isset($_SESSION['konfirmasi_status'])): ?>
        <?php if ($_SESSION['konfirmasi_status'] === 'success'): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: '<?= $_SESSION["konfirmasi_message"] ?>',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        <?php else: ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= $_SESSION["konfirmasi_message"] ?>',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        <?php endif; ?>
        <?php 
        // Clear session variables
        unset($_SESSION['konfirmasi_status']);
        unset($_SESSION['konfirmasi_message']);
        unset($_SESSION['konfirmasi_type']);
        ?>
    <?php endif; ?>
});

// Custom CSS for SweetAlert
const style = document.createElement('style');
style.textContent = `
    .swal-wide {
        width: 600px !important;
    }
`;
document.head.appendChild(style);
</script>
</body>
</html>