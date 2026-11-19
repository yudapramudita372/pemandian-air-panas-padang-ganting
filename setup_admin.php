<?php
// Jalankan SEKALI melalui http://localhost/wisata_padang_gantiang/setup_admin.php
require_once __DIR__ . "/config/database.php";
$username = "admin";
$password = password_hash("Admin123!", PASSWORD_DEFAULT);
$nama = "Administrator";

$stmt = $conn->prepare("INSERT INTO admin (username, password, nama_admin) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE password=VALUES(password), nama_admin=VALUES(nama_admin)");
$stmt->bind_param("sss", $username, $password, $nama);
$stmt->execute();
echo "Admin berhasil dibuat. Username: admin | Password: Admin123!<br>";
echo "Setelah berhasil, HAPUS file setup_admin.php demi keamanan.";
