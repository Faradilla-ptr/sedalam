<footer class="footer">
    <style>
        /* Footer Styles */
:root {
    --primary-color: #e05765;
    --secondary-color: #a71d2a;
    --light-bg: #f8f9fa;
    --shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
.footer {
    background-color: var(--primary-color);
    color: white;
    padding: 30px 0;
    text-align: center;
    font-family: 'Arial', sans-serif;
    box-shadow: var(--shadow);
}

        .footer-content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
            margin: 10px 0;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .footer-section p {
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .footer-section a:hover {
            color: #FFD700; /* Warna emas saat hover */
        }

        .contact-us {
            margin-top: 10px;
        }

        .contact-icon {
            font-size: 24px;
            margin: 0 10px;
            color: white;
            transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .contact-icon:hover {
            transform: scale(1.2);
        }

        /* Warna ikon spesifik */
        .whatsapp-link:hover {
            color: #25D366;
        }

        .instagram-link:hover {
            color: #E4405F;
        }

        .email-link:hover {
            color: #FFD700;
        }

        .facebook-link:hover {
            color: #1877F2;
        }

        .footer-bottom {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    <div class="footer-content">
        <div class="footer-section">
            <h3>Jam Operasional</h3>
            <p>Senin - Jumat: 08:00 - 20:00</p>
            <p>Sabtu - Minggu: 09:00 - 18:00</p>
        </div>
        <div class="footer-section">
            <h3>Tautan Cepat</h3>
            <p><a href="about.php">Tentang Kami</a></p>
            <p><a href="donate.php">Donor Sekarang</a></p>
            <p><a href="contact.php">Kontak</a></p>
            <p><a href="index.php">Beranda</a></p>
        </div>
        <div class="footer-section">
            <h3>Hubungi Kami</h3>
            <div class="contact-us">
                <a class="contact-icon whatsapp-link" href="https://wa.me/+6285257619706?text=Halo%2C%20saya%20ingin%20bertanya%20mengenai%20donor%20darah.%20Bisa%20dibantu%3F" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a class="contact-icon instagram-link" href="https://www.instagram.com/faradtyp_?igsh=MTF3cjBkcDF0Z2duMg==" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="contact-icon email-link" href="mailto:faradillaanastasya.ptr@gmail.com">
                    <i class="fas fa-envelope"></i>
                </a>
                <a class="contact-icon facebook-link" href="https://www.facebook.com/yourprofile" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2024 Sedalam. Semua Hak Dilindungi.</p>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
