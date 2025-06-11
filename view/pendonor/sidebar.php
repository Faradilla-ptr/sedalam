<!-- Font Awesome & Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .sidebar-custom {
        width: 250px;
        height: 100vh;
        position: fixed;
        background: linear-gradient(135deg,rgb(224, 87, 101), #a71d2a);
        color: white;
        padding: 20px 15px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        font-family: 'Segoe UI', sans-serif;
        z-index: 1000;
    }

    .sidebar-custom a {
        color: #ffffff;
    }

    .sidebar-custom .nav-link {
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease-in-out;
        font-size: 15px;
    }

    .sidebar-custom .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        padding-left: 20px;
        color: #ffeadd;
        text-decoration: none;
    }

    .sidebar-custom .nav-link i {
        margin-right: 10px;
    }

    .sidebar-custom hr {
        border-color: rgba(255,255,255,0.3);
    }

    .sidebar-custom .logout-link {
        color: #ffdddd !important;
        font-weight: bold;
    }

    .sidebar-custom .logout-link i {
        color: #ff4d4d;
    }
</style>

<!-- Sidebar Navbar -->
<div class="sidebar-custom d-flex flex-column flex-shrink-0">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <span class="fs-4 fw-bold">Menu</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="akun.php" class="nav-link">
                <i class="bi bi-person"></i> Akun
            </a>
        </li>
        <li>
            <a href="pengajuan_donor.php" class="nav-link">
                <i class="bi bi-droplet-half"></i> Pengajuan Donor Darah
            </a>
        </li>
        <li>
            <a href="tes_kesehatan.php" class="nav-link">
                <i class="bi bi-heart-pulse"></i> Tes Kesehatan
            </a>
        </li>

        <li>
    <a href="riwayat_pengajuan.php" class="nav-link">
        <i class="fas fa-history"></i> Riwayat Pengajuan
    </a>
</li>

        <li class="nav-item">
            <a class="nav-link fw-bold" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
    <hr>
</div>
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
                window.location.href = 'login_user.php';
            }
        });
    });
</script>
