<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Splash Screen Sedalam</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #000;
      color: white;
      overflow: hidden;
      position: relative;
    }

    #bg-video {
      position: absolute;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      object-fit: cover;
      z-index: -2;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: -1;
    }

    .splash-wrapper {
      display: flex;
      width: 90%;
      max-width: 1200px;
      padding: 2rem;
      gap: 2rem;
      align-items: center;
      justify-content: center;
    }

    .left-column, .right-column {
      flex: 1;
    }

    .left-column {
      text-align: center;
    }

    .splash-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1rem;
      color: #ffffff;
    }

    .animation-scene {
      width: 100%;
      max-width: 400px;
      margin: 0 auto;
    }

    #doctor-patient-animation {
      width: 100%;
      height: 100%;
    }

    .right-column .splash-subtitle {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1.2rem;
      color: #f5f5f5;
    }

    .splash-text {
      font-size: 1rem;
      line-height: 1.6;
      margin-bottom: 2rem;
      color: #eee;
    }

    .enter-button {
      padding: 1rem 2.5rem;
      border: none;
      border-radius: 30px;
      background: linear-gradient(45deg, #ff0000, #ff4b4b);
      color: white;
      font-size: 1.2rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .enter-button:hover {
      transform: scale(1.05);
      background: linear-gradient(45deg, #ff4b4b, #ff0000);
    }

    @media (max-width: 768px) {
      .splash-wrapper {
        flex-direction: column;
        text-align: center;
      }

      .animation-scene {
        max-width: 300px;
      }

      .splash-title {
        font-size: 2.2rem;
      }
    }
  </style>
</head>
<body>

  <!-- Video Background -->
  <video id="bg-video" autoplay muted loop playsinline>
    <source src="../../assets/video.mp4" type="video/mp4">
    Browser Anda tidak mendukung video HTML5.
  </video>
  <div class="overlay"></div>
  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
  <dotlottie-player src="https://lottie.host/1d6e33fa-ecd1-4b1e-959b-788ae769525a/tmzgQSg0YL.lottie" background="transparent" speed="1" style="width: 500px; height: 500px" loop autoplay></dotlottie-player>
  <div class="splash-wrapper" id="splash-screen">
    <div class="left-column">
      <h1 class="splash-title">Sedalam</h1>
      <div class="animation-scene">
        <div id="doctor-patient-animation"></div>
      </div>
    </div>
    <div class="right-column">
      <p class="splash-subtitle">"Setetes Darah Menyelamatkan"</p>
      <p class="splash-text">
        Donor darah adalah tindakan mulia yang dapat menyelamatkan nyawa. 
        Sebagai pendonor, Anda memberikan kesempatan hidup baru bagi yang membutuhkan. 
        Dengan Sedalam, kami mempermudah proses donor darah secara online dan terorganisir.
      </p>
      <button class="enter-button" id="enter-button">Mulai Sekarang</button>
    </div>
  </div>

<script>
      const enterButton = document.getElementById('enter-button');
      const splashScreen = document.getElementById('splash-screen');

      enterButton.addEventListener('click', function () {
        gsap.to(splashScreen, {
          y: 200,
          opacity: 0,
          duration: 1,
          ease: "power2.inOut",
          onComplete: function () {
            window.location.href = "home.php";
          }
        });
      });
  </script>

</body>
</html>
