<?php
session_start();

$valid_passwords = file(__DIR__ . "/123/pass/yoyo/u.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"] ?? "";

    if (in_array($password, $valid_passwords)) {
        $_SESSION["loggedin"] = true;
        header("Location: home.php");
        exit();
    } else {
        $error = "Incorrect password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CipherLock Login</title>
<style>
  body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #121E3E;
    padding: 40px 20px;
    overflow: hidden;
  }

  .logo-icon {
    width: 100px;
    height: 100px;
    margin-bottom: 40px;
  }

  .logo-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .input-container {
    display: flex;
    align-items: center;
    border: 1px solid #3A4A60;
    border-radius: 25px;
    padding: 5px 10px;
    max-width: 90%;
    width: 100%;
    background-color: #1E2A48;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  }

  input[type="password"] {
    flex: 1;
    border: none;
    outline: none;
    padding: 10px 15px;
    border-radius: 20px;
    font-size: 14px;
    background-color: #2D3A55;
    color: #FFFFFF;
  }

  input[type="password"]::placeholder {
    color: #7F8C9A;
  }

  button {
    background-color: #2ECC71;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin-left: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: background-color 0.3s;
  }

  button:hover {
    background-color: #27AE60;
  }

  button svg {
    fill: #FFFFFF;
    width: 40px;
    height: 40px;
  }

  .error-message {
    color: #ff4d4f;
    font-size: 14px;
    margin-top: 12px;
    text-align: center;
  }

  @media(max-width: 600px) {
    .input-container {
      padding: 10px;
    }
    button {
      width: 45px;
      height: 45px;
    }
  }
</style>
</head>
<body>

<div class="logo-icon">
  <img src="https://uploads.onecompiler.io/43btugq7w/43nr9t7vy/Screenshot%202025-06-24%20173628-Photoroom.png" alt="Logo" />
</div>

<form method="POST" style="width: 100%; max-width: 400px;">
  <div class="input-container">
    <input type="password" name="password" placeholder="Enter Your Password" required />
    <button type="submit" aria-label="Login">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 17l5-5-5-5v10z" />
      </svg>
    </button>
  </div>

  <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($error)): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
</form>

</body>
</html>
