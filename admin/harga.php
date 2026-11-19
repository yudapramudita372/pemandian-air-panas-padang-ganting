<?php
require_once "../config/auth.php";
require_once "../config/database.php";
$pageTitle = "Harga & Operasional";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vals = [];
    foreach (['harga_tiket_dewasa', 'harga_tiket_anak', 'jam_buka', 'jam_tutup'] as $key) $vals[] = trim($_POST[$key] ?? "");
    $stmt = $conn->prepare("INSERT INTO operasional (`harga_tiket_dewasa`, `harga_tiket_anak`, `jam_buka`, `jam_tutup`) VALUES (?,?,?,?)");
    $types = "ssss";
    $stmt->bind_param($types, ...$vals);
    if ($stmt->execute()) $msg = "Data berhasil ditambahkan.";
    else $msg = "Gagal menyimpan data.";
}
if (isset($_GET["hapus"])) {
    $id = (int)$_GET["hapus"];
    $stmt = $conn->prepare("DELETE FROM operasional WHERE id=?");
    $stmt->bind_param("i", $id); $stmt->execute();
    header("Location: harga.php"); exit;
}
$result = $conn->query("SELECT * FROM operasional ORDER BY id DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Harga & Operasional</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><div class="layout"><?php include "../includes/sidebar.php"; ?><main class="main"><?php include "../includes/header.php"; ?><section class="content">
<div class="form-card"><h2>Tambah Harga & Operasional</h2><?php if($msg): ?><div class="success"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="post"><label>Harga tiket dewasa</label><input type="number" name="harga_tiket_dewasa" required>\n<label>Harga tiket anak</label><input type="number" name="harga_tiket_anak" required>\n<label>Jam buka (HH:MM:SS)</label><input type="text" name="jam_buka" required>\n<label>Jam tutup (HH:MM:SS)</label><input type="text" name="jam_tutup" required>\n<button class="btn" type="submit">Simpan</button></form></div>
<div class="panel"><h2>Daftar Harga & Operasional</h2><table><thead><tr><th>ID</th><th>Tiket dewasa</th><th>Tiket anak</th><th>Jam buka</th><th>Jam tutup</th><th>Aksi</th></tr></thead><tbody><?php while($row=$result->fetch_assoc()): ?><tr><td><?= (int)$row["id"] ?></td><td><?= htmlspecialchars($row['harga_tiket_dewasa'] ?? '') ?></td><td><?= htmlspecialchars($row['harga_tiket_anak'] ?? '') ?></td><td><?= htmlspecialchars($row['jam_buka'] ?? '') ?></td><td><?= htmlspecialchars($row['jam_tutup'] ?? '') ?></td><td><a class="btn btn-danger" onclick="return confirm('Hapus data ini?')" href="?hapus=<?= (int)$row['id'] ?>">Hapus</a></td></tr><?php endwhile; ?></tbody></table></div>
</section></main></div></body></html>