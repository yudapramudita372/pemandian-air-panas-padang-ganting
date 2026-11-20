<?php
    require_once "../config/auth.php";
    require_once "../config/database.php";
    $pageTitle = "Galeri";
    $msg = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $vals = [];
        foreach (['judul', 'jenis', 'file_media'] as $key) $vals[] = trim($_POST[$key] ?? "");
        $stmt = $conn->prepare("INSERT INTO galeri (`judul`, `jenis`, `file_media`) VALUES (?,?,?)");
        $types = "sss";
        $stmt->bind_param($types, ...$vals);
        if ($stmt->execute()) $msg = "Data berhasil ditambahkan.";
        else $msg = "Gagal menyimpan data.";
    }
    if (isset($_GET["hapus"])) {
        $id = (int)$_GET["hapus"];
        $stmt = $conn->prepare("DELETE FROM galeri WHERE id=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        header("Location: galeri.php"); exit;
    }
    $result = $conn->query("SELECT * FROM galeri ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Galeri</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="layout"><?php include "../includes/sidebar.php"; ?>
        <main class="main"><?php include "../includes/header.php"; ?>
        <section class="content">
            <div class="form-card">
                <h2>Tambah Galeri</h2>
                <?php if($msg): ?>
                    <div class="success">
                        <?= htmlspecialchars($msg) ?>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <label>Judul</label>
                    <input type="text" name="judul" required>
                    <label>Jenis (foto/video)</label>
                    <input type="text" name="jenis" required>
                    <label>Nama file atau URL media</label>
                    <input type="text" name="file_media" required>
                    <button class="btn" type="submit">Simpan</button>
                </form>
            </div>
            <div class="panel">
                <h2>Daftar Galeri</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>File media</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row=$result->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$row["id"] ?></td>
                                <td><?= htmlspecialchars($row['judul'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['jenis'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['file_media'] ?? '') ?></td>
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