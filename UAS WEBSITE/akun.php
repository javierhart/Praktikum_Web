<?php
session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['user_name']) && !isset($_SESSION['admin_name'])) {
    header('Location: login.php');
    exit();
}

$isAdmin = isset($_SESSION['admin_name']);
$username = $isAdmin ? $_SESSION['admin_name'] : $_SESSION['user_name'];
$email = $isAdmin ? $_SESSION['admin_email'] : $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    
    <style>
           .account-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #FFFFFF; 
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
       
        .account-header {
            text-align: center;
            font-size: 2rem;
            color: #1a237e;
            margin-bottom: 2rem;
        }

        .account-details {
            line-height: 1.8;
            font-size: 1rem;
            color: #555;
        }

        .logout-btn {
            display: block;
            margin: 2rem auto 0;
            background-color: #d32f2f;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="account-container">
        <h1 class="account-header">Akun Saya</h1>
        <div class="account-details">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Role:</strong> <?php echo $isAdmin ? 'Admin' : 'User'; ?></p>
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
