<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Jakarta Movin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="light-mode">
    <header>
        <div class="logo-title">
            <h1>HEY JAVIER</h1>
        </div>
        <div class="nav-container">
            <nav>
                <button class="hamburger" onclick="toggleMenu('menu1')">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </button>
                <div class="menu" id="menu1">
                    <ul>
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#about">Tentang Saya</a></li>
                    </ul>
                </div>
                <div class="login-container">
                    <a href="login.php" class="login-button">Login</a>
                </div>
            </nav>
        </div>
    </header>

    <main id="home">
        <section class="theater-section">
            <button class="mode-toggle" onclick="toggleDarkMode()">Theme</button>
            <h2>PERTUNJUKAN TEATER MUSIKAL</h2>
            <section class="slideshow-container">
                <div class="mySlides fade">
                    <img src="1.jpeg" alt="foto">
                </div>
                <div class="mySlides fade">
                    <img src="2.jpeg" alt="foto">
                </div>
                <div class="mySlides fade">
                    <img src="3.jpeg" alt="foto">
                </div>
            </section>
            <p>
                Selamat datang di Website Posttest 3
            </p>
            <button class="ticket-button">
                <a href="pesan.php" class="button-link">Pesan Tiket</a>
            </button>  
        </section>
    </main>

    <section id="about" class="about-section">
        <h2>Tentang Saya</h2>
        <p><span>Nama:</span> Adithya Javier Hartono</p>
        <p><span>NIM:</span> 2309106131</p>
        <p><span>Email:</span> vier.not404@gmail.com</p>
    </section>
    
    <footer>
        <p>&copy; Adithya Javier Hartono (2309106131)</p>
        <div class="ikon_sosmed">
            <a href="https://www.instagram.com/literally.javier/profilecard/?igsh=Z3EyZnl0bzY1c2M=" target="_blank">
                <i class="fab fa-instagram">Instagram</i>
            </a>
        </div>
    </footer>

    <script src="script.js" defer></script>
</body>
</html>
