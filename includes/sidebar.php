<aside class="sidebar">
 <div class="brand"><div class="brand-mark">PG</div><div><b>Pemandian Air Panas</b><small>Padang Gantiang</small></div></div>
 <nav>
 <?php
 $menus = [
  "dashboard.php"=>"Dashboard", "profil.php"=>"Profil Wisata",
  "sejarah.php"=>"Sejarah", "fasilitas.php"=>"Fasilitas",
  "galeri.php"=>"Galeri", "harga.php"=>"Harga & Operasional",
  "lokasi.php"=>"Lokasi & Kontak"
 ];
 foreach($menus as $file=>$label):
 ?>
 <a class="<?= basename($_SERVER['PHP_SELF'])===$file?'active':'' ?>" href="<?= $file ?>"><?= $label ?></a>
 <?php endforeach; ?>
 </nav>
 <a class="logout" href="../logout.php">Logout</a>
</aside>
