PANDUAN INSTALASI
1. Ekstrak folder wisata_padang_gantiang ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka http://localhost/phpmyadmin
4. Pilih tab Import, pilih file database.sql dari folder project, lalu klik Import/Go.
5. Buka http://localhost/wisata_padang_gantiang/setup_admin.php satu kali untuk membuat akun admin.
   Username: admin
   Password: Admin123!
6. HAPUS setup_admin.php setelah akun berhasil dibuat.
7. Login melalui http://localhost/wisata_padang_gantiang/login.php
8. Dashboard: http://localhost/wisata_padang_gantiang/admin/dashboard.php

CATATAN:
- Ini starter project pembelajaran. CRUD dasar sudah tersedia untuk profil, sejarah, fasilitas, galeri, harga-operasional, dan kontak.
- Kolom foto/media saat ini menerima nama file atau URL sebagai teks; fitur upload file belum dibuat.
- Halaman pengaturan akun dan fitur edit belum termasuk pada starter ini.
- Ganti password contoh setelah login dan jangan unggah konfigurasi lokal ke hosting publik.
