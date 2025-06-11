<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Scroll</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            transition: top 0.3s;
        }
        .scrolled {
            background: rgba(0, 0, 0, 0.9) !important;
        }
        .navbar-nav {
            width: 100%;
            display: flex;
            justify-content: center;
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
                <li class="nav-item"><a href="view/user/home.php" class="nav-link">Home</a></li>

                    <li class="nav-item"><a href="#faq" class="nav-link">FAQ</a></li>
                    <li class="nav-item"><a href="#artikel" class="nav-link">Artikel</a></li>
                    <li class="nav-item"><a href="#video" class="nav-link">Video</a></li>
                    <li class="nav-item"><a href="#stok" class="nav-link">Stok Darah</a></li>
                    <li class="nav-item"><a href="#pengajuan" class="nav-link">Pengajuan Donor</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
                </ul>
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
