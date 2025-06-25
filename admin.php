<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}

$password_file = "passwords.txt";
$passwords = file($password_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Add
if (isset($_POST['add']) && !empty(trim($_POST['new_password']))) {
    $new = trim($_POST['new_password']);
    if (!in_array($new, $passwords)) {
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CipherLock Admin Panel</title>
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #0e101a;
      color: #f1f1f1;
    }

    header {
      background-color: #1a1d2d;
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.5);
    }

    header h1 {
      font-size: 20px;
      color: white;
      margin: 0;
    }

    main {
      padding: 24px;
      max-width: 800px;
      margin: auto;
    }

    .card {
      background-color: #1f2235;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      margin-bottom: 24px;
    }

    .card h2 {
      font-size: 18px;
      margin-top: 0;
    }

    ul.password-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    ul.password-list li {
      background-color: #2c2f45;
      padding: 16px;
      margin-bottom: 12px;
      border-radius: 8px;
    }

    .form-row {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 10px;
    }

    input[type="text"], button {
      padding: 12px;
      border-radius: 6px;
      border: none;
      font-size: 14px;
    }

    input[type="text"] {
      background-color: #373b53;
      color: #fff;
    }

    button {
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s;
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
      width: 100%;
      margin-top: 16px;
    }

    form.add-form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .logout {
      color: #ccc;
      font-size: 14px;
      text-decoration: none;
    }

    .logout:hover {
      color: #fff;
    }

    @media (min-width: 600px) {
      .form-row {
        flex-direction: row;
      }

      input[type="text"] {
        flex: 1;
      }

      button {
        width: auto;
      }
    }
  </style>
</head>
<body>

<header>
  <h1>🔐 CipherLock Admin</h1>
  <a class="logout" href="logout.php">Logout</a>
</header>

<main>
  <div class="card">
    <h2>Current Passwords</h2>
    <ul class="password-list">
      <?php foreach ($passwords as $i => $pw): ?>
      <li>
        <strong><?= htmlspecialchars($pw) ?></strong>
        <form method="POST" class="form-row">
          <input type="hidden" name="index" value="<?= $i ?>">
          <input type="text" name="edited_password" value="<?= htmlspecialchars($pw) ?>" required>
          <button name="edit" class="btn-edit">Edit</button>
          <button name="delete" class="btn-delete" onclick="return confirm('Delete this password?')">Delete</button>
        </form>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="card">
    <h2>Add New Password</h2>
    <form method="POST" class="add-form">
      <input type="text" name="new_password" placeholder="Enter new password..." required>
      <button name="add" class="btn-add">Add Password</button>
    </form>
  </div>
</main>

</body>
</html>
