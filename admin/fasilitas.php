<?php
require_once "../config/auth.php";
require_once "../config/database.php";
$pageTitle = "Fasilitas";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vals = [];
    foreach (['nama_fasilitas', 'deskripsi', 'foto'] as $key) $vals[] = trim($_POST[$key] ?? "");
    $stmt = $conn->prepare("INSERT INTO fasilitas (`nama_fasilitas`, `deskripsi`, `foto`) VALUES (?,?,?)");
    $types = "sss";
    $stmt->bind_param($types, ...$vals);
    if ($stmt->execute()) $msg = "Data berhasil ditambahkan.";
    else $msg = "Gagal menyimpan data.";
}
if (isset($_GET["hapus"])) {
    $id = (int)$_GET["hapus"];
    $stmt = $conn->prepare("DELETE FROM fasilitas WHERE id=?");
    $stmt->bind_param("i", $id); $stmt->execute();
    header("Location: fasilitas.php"); exit;
}
$result = $conn->query("SELECT * FROM fasilitas ORDER BY id DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Fasilitas</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><div class="layout"><?php include "../includes/sidebar.php"; ?><main class="main"><?php include "../includes/header.php"; ?><section class="content">
<div class="form-card"><h2>Tambah Fasilitas</h2><?php if($msg): ?><div class="success"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="post"><label>Nama fasilitas</label><input type="text" name="nama_fasilitas" required>\n<label>Deskripsi</label><textarea name="deskripsi"></textarea>\n<label>Nama file foto (opsional)</label><input type="text" name="foto" required>\n<button class="btn" type="submit">Simpan</button></form></div>
<div class="panel"><h2>Daftar Fasilitas</h2><table><thead><tr><th>ID</th><th>Nama fasilitas</th><th>Deskripsi</th><th>Foto</th><th>Aksi</th></tr></thead><tbody><?php while($row=$result->fetch_assoc()): ?><tr><td><?= (int)$row["id"] ?></td><td><?= htmlspecialchars($row['nama_fasilitas'] ?? '') ?></td><td><?= htmlspecialchars($row['deskripsi'] ?? '') ?></td><td><?= htmlspecialchars($row['foto'] ?? '') ?></td><td><a class="btn btn-danger" onclick="return confirm('Hapus data ini?')" href="?hapus=<?= (int)$row['id'] ?>">Hapus</a></td></tr><?php endwhile; ?></tbody></table></div>
</section></main></div></body></html>