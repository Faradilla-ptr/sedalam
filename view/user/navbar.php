<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Navbar Sedalam</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }
    .navbar {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 10;
  background-color: transparent;
  transition: all 0.4s ease;
  padding: 1rem 2rem;
}
    .navbar-brand img {
      height: 55px;
      width: auto;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 20px;
      color: #222 !important;
    }
    .nav-link {
  font-weight: 500;
  text-transform: uppercase;
  padding: 0.5rem 1rem;
  transition: color 0.3s ease, font-size 0.3s ease;
  font-size: 25px; /* Ukuran default */
}

.scrolled .nav-link {
  color: #222 !important;
}

.nav-link:hover {
  color: red !important;
  font-size: 25px; /* Sedikit membesar saat hover */
}


.nav-icons a {
  color: #000; /* warna hitam */
  font-size: 35px;
  transition: color 0.3s ease, transform 0.3s ease;
}

    .scrolled .nav-icons a {
      color: #222;
    }

    .nav-icons a:hover {
  color: red;
  transform: scale(1.1);
}

    .navbar-toggler {
      border: none;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba%280, 0, 0, 0.5%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .nav-item {
      animation: fadeInDown 0.6s ease;
    }

    @keyframes fadeInDown {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .sedalam-text {
  font-family: 'Fredoka', sans-serif;
  font-size: 28px;
  background: linear-gradient(270deg, #ff0000, #ffffff, #ff0000);
  background-size: 600% 100%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: gradientShift 5s linear infinite, bounce 3s ease-in-out infinite;
  transition: transform 0.3s ease;
}

.sedalam-text:hover {
  transform: scale(1.1) rotate(-2deg);
  filter: brightness(1.2);
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.navbar-brand,
.nav-link {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
  font-weight: 700 !important;
}


  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
  <a class="navbar-brand d-flex align-items-center" href="#">
  <img src="../../assets/logo_sedalam.png" alt="Logo Sedalam" class="me-2">
  <span class="sedalam-text">Sedalam</span>
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about us">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#stok_darah">Stok Darah</a></li>
        <li class="nav-item"><a class="nav-link" href="#artikel">Artikel</a></li>
        <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="/sedalam/view/pendonor/login_user.php">Pengajuan Donor</a></li>
      </ul>
      <div class="nav-icons d-flex align-items-center">
        <a href="../../login_admin.php" data-bs-toggle="tooltip" title="Login">
        <i class="fa-solid fa-circle-user"></i>
        </a>
      </div>
    </div>
  </div>
</nav>

<script>
  window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    navbar.classList.toggle("scrolled", window.scrollY > 50);
  });

  document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) {
      return new bootstrap.Tooltip(el);
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
