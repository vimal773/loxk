<?php
session_start();
$admin_password = "CHIPERLOCKADMINKI"; // change to your desired admin password

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["admin_pass"] === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Incorrect admin password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
</head>
<body>
  <h2>Admin Login</h2>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    <input type="password" name="admin_pass" placeholder="Admin Password" required>
    <button type="submit">Login</button>
  </form>
</body>
</html>
