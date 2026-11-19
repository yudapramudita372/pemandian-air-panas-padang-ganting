<?php
require_once "../config/auth.php";
require_once "../config/database.php";
$pageTitle = "Lokasi & Kontak";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vals = [];
    foreach (['alamat', 'telepon', 'email', 'link_maps'] as $key) $vals[] = trim($_POST[$key] ?? "");
    $stmt = $conn->prepare("INSERT INTO kontak (`alamat`, `telepon`, `email`, `link_maps`) VALUES (?,?,?,?)");
    $types = "ssss";
    $stmt->bind_param($types, ...$vals);
    if ($stmt->execute()) $msg = "Data berhasil ditambahkan.";
    else $msg = "Gagal menyimpan data.";
}
if (isset($_GET["hapus"])) {
    $id = (int)$_GET["hapus"];
    $stmt = $conn->prepare("DELETE FROM kontak WHERE id=?");
    $stmt->bind_param("i", $id); $stmt->execute();
    header("Location: lokasi.php"); exit;
}
$result = $conn->query("SELECT * FROM kontak ORDER BY id DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Lokasi & Kontak</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><div class="layout"><?php include "../includes/sidebar.php"; ?><main class="main"><?php include "../includes/header.php"; ?><section class="content">
<div class="form-card"><h2>Tambah Lokasi & Kontak</h2><?php if($msg): ?><div class="success"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="post"><label>Alamat</label><textarea name="alamat"></textarea>\n<label>Nomor telepon</label><input type="text" name="telepon" required>\n<label>Email</label><input type="text" name="email" required>\n<label>Link Google Maps</label><input type="text" name="link_maps" required>\n<button class="btn" type="submit">Simpan</button></form></div>
<div class="panel"><h2>Daftar Lokasi & Kontak</h2><table><thead><tr><th>ID</th><th>Alamat</th><th>Telepon</th><th>Email</th><th>Aksi</th></tr></thead><tbody><?php while($row=$result->fetch_assoc()): ?><tr><td><?= (int)$row["id"] ?></td><td><?= htmlspecialchars($row['alamat'] ?? '') ?></td><td><?= htmlspecialchars($row['telepon'] ?? '') ?></td><td><?= htmlspecialchars($row['email'] ?? '') ?></td><td><a class="btn btn-danger" onclick="return confirm('Hapus data ini?')" href="?hapus=<?= (int)$row['id'] ?>">Hapus</a></td></tr><?php endwhile; ?></tbody></table></div>
</section></main></div></body></html>