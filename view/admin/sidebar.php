<?php
$username = $_SESSION["username"] ?? "Administrator";
// Include helper function untuk mengecek super admin
require_once "../../admin_filter_helper.php";
?>

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: linear-gradient(135deg,rgb(224, 87, 101), #a71d2a);
        color: white;
        padding: 20px 15px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        font-family: 'Segoe UI', sans-serif;
    }

    .sidebar h4 {
        margin-bottom: 30px;
        font-weight: bold;
        font-size: 22px;
        text-align: center;
    }

    .nav-link {
        color: #ffffff;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        padding-left: 20px;
        color: #ffddcc;
        text-decoration: none;
    }

    .nav-link i {
        margin-right: 10px;
    }

    .nav-item:last-child {
        margin-top: auto;
    }

    .content {
        margin-left: 260px;
        padding: 20px;
    }
</style>

<!-- Sidebar HTML -->
<div class="sidebar">

<h4><?= htmlspecialchars($username) ?></h4>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard_admin.php" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="manage_admin.php" class="nav-link">
                <i class="fas fa-user-cog"></i> Manajemen Admin
            </a>
        </li>
        <li class="nav-item">
            <a href="manage_darah.php" class="nav-link">
                <i class="fas fa-tint"></i> Manajemen Stok Darah
            </a>
        </li>
        
        <?php if (isSuperAdmin()): ?>
        <li class="nav-item">
            <a href="manage_faq.php" class="nav-link">
                <i class="fas fa-question-circle"></i> Pertanyaan User
            </a>
        </li>
        <?php endif; ?>

        <li class="nav-item">
            <a href="review_user.php" class="nav-link">
                <i class="fas fa-star"></i> Review User
            </a>
        </li>
        <li class="nav-item">
            <a href="profil.php" class="nav-link d-flex align-items-center">
                <i class="fas fa-user-circle me-2"></i>
                <span>Profil</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link fw-bold" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Kamu akan keluar dari aplikasi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../../login_admin.php';
            }
        });
    });
</script>