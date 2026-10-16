# Catatan Pengujian UTS Web I

Isi kolom hasil aktual, status, dan nama screenshot setelah setiap pengujian benar-benar dijalankan. Simpan screenshot asli di folder ini.

| ID | Langkah/input | Hasil yang diharapkan | Hasil aktual | Status | Bukti |
|---|---|---|---|---|---|
| U01 | Buka daftar menu | Minimal 5 menu menampilkan kode, nama, kategori, harga | Belum diuji | Belum diuji | `U01-daftar-menu.png` |
| U02a | Cari menu yang tersedia | Menu cocok ditampilkan | Belum diuji | Belum diuji | `U02a-cari-ada.png` |
| U02b | Cari menu yang tidak tersedia | Pesan hasil kosong tampil | Belum diuji | Belum diuji | `U02b-cari-tidak-ada.png` |
| U03a | Jumlah kosong | Ditolak, keranjang tetap | Belum diuji | Belum diuji | `U03a-jumlah-kosong.png` |
| U03b | Jumlah -1 | Ditolak, keranjang tetap | Belum diuji | Belum diuji | `U03b-jumlah-negatif.png` |
| U03c | Jumlah 1.5 | Ditolak, keranjang tetap | Belum diuji | Belum diuji | `U03c-jumlah-pecahan.png` |
| U03d | Jumlah 0 | Ditolak, keranjang tetap | Belum diuji | Belum diuji | `U03d-jumlah-nol.png` |
| U03e | Jumlah 11 | Ditolak, keranjang tetap | Belum diuji | Belum diuji | `U03e-jumlah-11.png` |
| U04 | Kode menu tidak dikenal | Ditolak, keranjang tetap | Belum diuji | Belum diuji | `U04-kode-tidak-valid.png` |
| U05a | Tambah menu sama hingga jumlah 10 | Jumlah digabung sampai 10 | Belum diuji | Belum diuji | `U05a-jumlah-10.png` |
| U05b | Tambah lagi sehingga lebih dari 10 | Ditolak, jumlah tetap 10 | Belum diuji | Belum diuji | `U05b-melebihi-10.png` |
| U06a | Isi keranjang lalu buka halaman lain | Keranjang tetap ada | Belum diuji | Belum diuji | `U06a-pindah-halaman.png` |
| U06b | Refresh halaman | Isi keranjang tetap | Belum diuji | Belum diuji | `U06b-refresh.png` |
| U07a | Tambahkan menu via POST | Redirect dan flash tampil satu kali | Belum diuji | Belum diuji | `U07a-setelah-post.png` |
| U07b | Refresh setelah penambahan | Jumlah tidak bertambah dan flash hilang | Belum diuji | Belum diuji | `U07b-setelah-refresh.png` |
| U08a | Susun subtotal Rp49.000 | Diskon Rp0, total Rp49.000 | Belum diuji | Belum diuji | `U08a-subtotal-49000.png` |
| U08b | Susun subtotal Rp50.000 | Diskon Rp5.000, total Rp45.000 | Belum diuji | Belum diuji | `U08b-subtotal-50000.png` |
| U09a | Hapus satu item | Item hilang dan total berubah | Belum diuji | Belum diuji | `U09a-hapus-item.png` |
| U09b | Kosongkan keranjang | Keranjang kosong ditampilkan | Belum diuji | Belum diuji | `U09b-kosongkan.png` |
| U10a | Simpan kategori favorit | Cookie tersimpan 7 hari | Belum diuji | Belum diuji | `U10a-cookie-7-hari.png` |
| U10b | Buka tanpa kategori GET | Kategori mengikuti cookie | Belum diuji | Belum diuji | `U10b-kategori-cookie.png` |
| U10c | Kirim kategori GET berbeda | GET mengalahkan cookie | Belum diuji | Belum diuji | `U10c-prioritas-get.png` |
| U11 | Cari teks `<b>uji</b>` | Ditampilkan sebagai teks biasa | Belum diuji | Belum diuji | `U11-escaping-html.png` |

Catatan: nama file screenshot di atas adalah target nama file. Pastikan screenshot asli sudah dibuat dan baru ubah hasil/status setelah pengujian nyata dilakukan.
