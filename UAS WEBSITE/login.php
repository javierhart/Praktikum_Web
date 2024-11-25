<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass)); // Hash password

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('Query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['username'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('Location: admin_page.php');
            exit();
        } else {
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('Location: index.php');
            exit();
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaltim Fun - Login</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            background-color: hsl(0, 0%, 100%);
}
        
.login-content {
    display: flex;
    gap: 2rem;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin-top: -15rem;
}


        .login-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding-top: 10rem;
        }

      .login-header {
    text-align: center;
    color: #1a237e;
    font-size: 2rem;
    margin-bottom: 6rem;
}

        .login-content {
            display: flex;
            gap: 2rem;
            align-items: center;
            justify-content: center;
            
        }

        .logo-container {
            flex: 1;
            text-align: center;
        }

        .logo-container img {
            max-width: 300px;
            background-color: #f5f5f5;
            padding: 2rem;
            border-radius: 8px;
        }

        .form-container {
            flex: 1;
            padding: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: black;
}

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .login-button {
            background-color: #1a237e;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
        }

        .create-account {
            text-align: center;
            margin-top: 1rem;
        }

        .create-account a {
            color: #007bff;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message" style="color: red; text-align: center;"><span>' . htmlspecialchars($msg) . '</span></div>';
        }
    }
    ?>


<form action="" method="post">
        <div class="login-container">
        <h1 class="login-header">LOGIN</h1>
            <div class="login-content">
                <div class="logo-container">
                    <img src="WEB US ASET/Logo 2.png" alt="Kaltim Fun Logo Large">
                </div>
                <div class="form-container" style="border: 1px solid #F5F5F5; padding: 1rem; border-radius: 8px;">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Type Here..." required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="pass" placeholder="Type Here..." required>
                    </div>
                    <button type="submit" class="login-button" name="submit">Login</button>
                    <div class="create-account">
                        <a href="register.php">Don't have an account? Create now</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php include 'footer.php'; ?>
    <script>
        
    </script>
</body>
</html>