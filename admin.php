<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}

$password_file = "passwords.txt";
$passwords = file($password_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Add
if (isset($_POST['add'])) {
    $new = trim($_POST['new_password']);
    if (!in_array($new, $passwords) && $new !== "") {
        file_put_contents($password_file, $new . PHP_EOL, FILE_APPEND);
        header("Location: admin.php");
        exit();
    }
}

// Edit
if (isset($_POST['edit'], $_POST['index'], $_POST['edited_password'])) {
    $index = (int)$_POST['index'];
    $passwords[$index] = trim($_POST['edited_password']);
    file_put_contents($password_file, implode(PHP_EOL, $passwords) . PHP_EOL);
    header("Location: admin.php");
    exit();
}

// Delete
if (isset($_POST['delete'], $_POST['index'])) {
    unset($passwords[(int)$_POST['index']]);
    file_put_contents($password_file, implode(PHP_EOL, $passwords) . PHP_EOL);
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background-color: #121E3E;
      color: white;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 100%;
      margin: auto;
      background: #1E2A48;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    h2 {
      margin-top: 0;
      font-size: 22px;
      text-align: center;
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    li {
      background: #2D3A55;
      margin-bottom: 15px;
      padding: 14px;
      border-radius: 12px;
    }

    .inline-form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 10px;
    }

    input[type="text"] {
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: #3A4A60;
      color: white;
      font-size: 15px;
    }

    button {
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      font-size: 15px;
      transition: background 0.3s;
      width: 100%;
    }

    .btn-edit {
      background-color: #3498db;
      color: white;
    }

    .btn-delete {
      background-color: #e74c3c;
      color: white;
    }

    .btn-add {
      background-color: #2ecc71;
      color: white;
      margin-top: 10px;
    }

    form.add-form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 20px;
    }

    .footer-link {
      margin-top: 25px;
      text-align: center;
    }

    .footer-link a {
      color: #7F8C9A;
      font-size: 14px;
      text-decoration: none;
    }

    .footer-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>🔐 CipherLock Admin</h2>

  <ul>
    <?php foreach ($passwords as $i => $pw): ?>
      <li>
        <strong><?= htmlspecialchars($pw) ?></strong>
        <form method="POST" class="inline-form">
          <input type="hidden" name="index" value="<?= $i ?>">
          <input type="text" name="edited_password" value="<?= htmlspecialchars($pw) ?>" required>
          <button name="edit" class="btn-edit">Edit</button>
          <button name="delete" class="btn-delete" onclick="return confirm('Delete this password?')">Delete</button>
        </form>
      </li>
    <?php endforeach; ?>
  </ul>

  <form method="POST" class="add-form">
    <input type="text" name="new_password" placeholder="New password..." required>
    <button name="add" class="btn-add">Add Password</button>
  </form>

  <div class="footer-link">
    <a href="logout.php">Logout Admin</a>
  </div>
</div>

</body>
</html>
