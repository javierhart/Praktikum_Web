<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php">Home</a>
            <a href="admin_destinations.php">Things To Do</a>
            <a href="admin_orders.php">Tickets</a>
            <a href="admin_users.php">Users</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="akun.php"><div id="user-btn" class="fas fa-user"></div></a>
        </div>
    </div>
</header>
