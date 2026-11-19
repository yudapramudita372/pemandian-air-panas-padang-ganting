<?php
require_once "../config/auth.php";
require_once "../config/database.php";
$pageTitle = "Dashboard";
function total($conn,$table){$allowed=["profil_wisata","fasilitas","galeri","sejarah"];if
(!in_array($table,$allowed))return 0;$r=$conn->query("SELECT COUNT(*) AS n FROM `$table`");return (int)$r->fetch_assoc()["n"];}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard Admin</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><div class="layout">
    <?php include "../includes/sidebar.php"; ?><main class="main"><?php include "../includes/header.php"; ?><section class="content"><h2>Ringkasan Konten</h2><div class="cards">
<div class="card"><h3>Profil Wisata</h3><strong><?= total($conn,"profil_wisata") ?></strong><span class="muted">Data profil</span></div>
<div class="card"><h3>Fasilitas</h3><strong><?= total($conn,"fasilitas") ?></strong><span class="muted">Data fasilitas</span></div>
<div class="card"><h3>Galeri</h3><strong><?= total($conn,"galeri") ?></strong><span class="muted">Foto dan video</span></div>
</div><div class="panel"><h2>Selamat Datang!</h2><p>Kelola profil, sejarah, fasilitas, galeri, harga tiket, jam operasional, 
    serta informasi lokasi Pemandian Air Panas Padang Gantiang melalui dashboard ini.</p></div></section></main></div></body></html>