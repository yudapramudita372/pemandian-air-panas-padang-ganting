<?php
session_start();
require_once "config/database.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $stmt = $conn->prepare(
        "SELECT id, username, password, nama_admin 
        FROM admin 
        WHERE username=?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    if ($admin && password_verify($password, $admin["password"])) {
        session_regenerate_id(true);
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["nama_admin"] = $admin["nama_admin"];
        header("Location: admin/dashboard.php");
        exit;
    }
    $error = "Username atau password salah.";
}
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Login Admin</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body class="login-body">
        <form class="login-card" method="post">
            <h1>Login Admin</h1>
            <p>Pemandian Air Panas Padang Gantiang</p>
            <?php if($error): ?>
                <div class="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <label>Username</label>
            <input name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button class="btn" type="submit">Masuk</button>
        </form>
    </body>
</html>
