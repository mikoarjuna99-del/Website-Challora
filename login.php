<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['hr_logged_in'] = true;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login HR Challora</title>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
    }
    body {
      margin: 0;
      background: linear-gradient(135deg, #3a7bd5, #8e44ad);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-box {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    .login-box h2 {
      margin-bottom: 30px;
      color: #2c3e50;
      font-weight: 600;
    }
    .input-group {
      margin-bottom: 20px;
      text-align: left;
    }
    .input-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #34495e;
    }
    .input-group input {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #ecf0f1;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    .input-group input:focus {
      border-color: #f1c40f;
      outline: none;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #f1c40f;
      color: #2c3e50;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #f39c12;
    }
    .error {
      background-color: #e74c3c;
      color: white;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Login HR Challora</h2>
    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="input-group">
        <label for="username">Username HR</label>
        <input type="text" id="username" name="username" placeholder="Masukkan username" required />
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
