<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="light-mode">
    <div class="login-container">
        <h2>Register</h2>
        <form action="dashboard.html" method="POST" class="login-form">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="login-submit-button">Login</button>
        </form>
        <p class="register-link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
