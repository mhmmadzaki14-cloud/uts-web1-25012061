# UTS Web I — Pemesanan Kantin Kampus

- Nama: Muhmmad zaki
- NIM: 25012061
- Kelas: 25M31
- Mata kuliah: Web I

## Deskripsi
Aplikasi pemesanan kantin kampus menggunakan PHP Native. Menu disimpan dalam array PHP, keranjang memakai session, pencarian menggunakan GET, pemesanan menggunakan POST, diskon dihitung melalui fungsi, dan kategori favorit disimpan dalam cookie selama 7 hari. Aplikasi tidak menggunakan framework atau database.

## Kebutuhan
- PHP 8.x (XAMPP disarankan untuk server lokal)
- Browser
- Git dan akun GitHub

## Cara menjalankan
1. Salin folder project ke `C:\xampp\htdocs\uts-web1-NIM`.
2. Jalankan Apache dari XAMPP.
3. Buka `http://localhost/uts-web1-NIM/`.
4. Uji daftar menu, pencarian, pemesanan, keranjang, diskon, dan cookie sesuai `dokumentasi/pengujian/README.md`.

## Struktur
- `index.php`: daftar, pencarian, filter kategori, dan form pemesanan.
- `keranjang.php`: isi keranjang dan perhitungan pembayaran.
- `proses.php`: pemrosesan POST, validasi, session, redirect, flash, dan cookie.
- `data/menu.php`: array data menu.
- `includes/fungsi.php`: escaping, format rupiah, fungsi perhitungan, dan flash.
- `includes/header.php`, `includes/footer.php`: layout bersama.
- `assets/style.css`: tampilan sederhana.
- `dokumentasi/pengujian/`: screenshot dan catatan pengujian.

## Catatan
Pastikan identitas di atas diganti sebelum pengumpulan. Simpan screenshot asli hasil pengujian sendiri. Jangan menandai pengujian lulus sebelum benar-benar dijalankan.
