<?php
    require_once "../config/auth.php";
    require_once "../config/database.php";
    $pageTitle = "Profil Wisata";
    $msg = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $vals = [];
        foreach (['nama_wisata', 'deskripsi', 'alamat', 'foto'] as $key) $vals[] = trim($_POST[$key] ?? "");
        $stmt = $conn->prepare("INSERT INTO profil_wisata (`nama_wisata`, `deskripsi`, `alamat`, `foto`) VALUES (?,?,?,?)");
        $types = "ssss";
        $stmt->bind_param($types, ...$vals);
        if ($stmt->execute()) $msg = "Data berhasil ditambahkan.";
        else $msg = "Gagal menyimpan data.";
    }
    if (isset($_GET["hapus"])) {
        $id = (int)$_GET["hapus"];
        $stmt = $conn->prepare("DELETE FROM profil_wisata WHERE id=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        header("Location: profil.php"); exit;
}
$result = $conn->query("SELECT * FROM profil_wisata ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Profil Wisata</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="layout">
            <?php include "../includes/sidebar.php"; ?>
            <main class="main">
                <?php include "../includes/header.php"; ?>
                <section class="content">
                    <div class="form-card">
                        <h2>Tambah Profil Wisata</h2>
                        <?php if($msg): ?>
                            <div class="success"><?= htmlspecialchars($msg) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <label>Nama wisata</label>
                            <input type="text" name="nama_wisata" required>
                            <label>Deskripsi</label>
                            <textarea name="deskripsi"></textarea>
                            <label>Alamat</label>
                            <textarea name="alamat"></textarea>
                            <label>Nama file foto (opsional)</label>
                            <input type="text" name="foto" required>
                            <button class="btn" type="submit">Simpan</button>
                        </form>
                    </div>
                    <div class="panel">
                        <h2>Daftar Profil Wisata</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama wisata</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row=$result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= (int)$row["id"] ?></td>
                                        <td><?= htmlspecialchars($row['nama_wisata'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['alamat'] ?? '') ?></td>
                                        <td><a class="btn btn-danger" onclick="return confirm('Hapus data ini?')" href="?hapus=<?= (int)$row['id'] ?>">Hapus</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>

    </body>

</html>