
<nav class="navbar">
    <!-- Logo -->
    <div class="logo1" style="margin-left: 45px;">
        <img src="WEB US ASET/Logo 1.png" alt="Kaltim Fun">
    </div>

    <!-- Menu Toggle Button (Hamburger Icon for small screens) -->
    <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <!-- Menu Navigasi -->
    <ul class="nav-links" style="text-align: left; margin-left: 300px;">
        <li><a href="index.php">Home</a></li>
        <li><a href="introduction.php">Introduction</a></li>
        <li><a href="Things_To_Do.php">Things To Do</a></li>
        <li><a href="purchase_tickets.php">Ticket</a></li>

        <!-- Cek apakah user sudah login -->
        <?php if (isset($_SESSION['user_email']) || isset($_SESSION['admin_email'])): ?>
            <!-- Jika user sudah login, tampilkan ikon profil -->
            <a href="akun.php">
                <div class="logo" style="position: absolute; top: 40px; right: 160px;">
                    <img src="WEB US ASET/profile.svg" alt="User Profile" style="width: 40px; height: 40px; border-radius: 50%; cursor: pointer;">
                </div>
            </a>
        <?php else: ?>
            <!-- Jika user belum login, tampilkan tombol login -->
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
