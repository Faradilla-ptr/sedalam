<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Scroll</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .navbar {
            transition: top 0.3s;
        }
        .scrolled {
            background: rgba(0, 0, 0, 0.9) !important;
        }
        .navbar-nav {
            flex-grow: 1;
            justify-content: center;
        }
        .nav-icons {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .nav-icons a {
            font-size: 20px;
            transition: 0.3s;
        }
        .nav-icons a:hover {
            color: #ffcc00 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Menu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="faq.php" class="nav-link">FAQ</a></li>
                    <li class="nav-item"><a href="artikel.php" class="nav-link">Artikel</a></li>
                    <li class="nav-item"><a href="stok_darah.php" class="nav-link">Stok Darah</a></li>
                    <li class="nav-item"><a href="pengajuan_donor.php" class="nav-link">Pengajuan Donor</a></li>
                </ul>
                <div class="nav-icons ms-auto">
                    <a href="login.php" class="nav-link text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Login">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="logout.php" class="nav-link text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        window.addEventListener("scroll", function () {
            let navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        // Aktifkan tooltip Bootstrap
        document.addEventListener("DOMContentLoaded", function() {
            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
