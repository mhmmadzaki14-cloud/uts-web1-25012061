<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$aksi = (string) ($_POST['aksi'] ?? '');

if ($aksi === 'tambah') {
    $kode = (string) ($_POST['kode'] ?? '');
    $jumlahRaw = $_POST['jumlah'] ?? null;
    $jumlah = filter_var($jumlahRaw, FILTER_VALIDATE_INT);

    if (!isset($menu[$kode])) {
        setFlash('error', 'Kode menu tidak dikenal. Keranjang tidak berubah.');
    } elseif ($jumlah === false || $jumlah === null || $jumlah < 1 || $jumlah > 10) {
        setFlash('error', 'Jumlah harus bilangan bulat dari 1 sampai 10. Keranjang tidak berubah.');
    } else {
        $jumlahLama = (int) ($_SESSION['keranjang'][$kode] ?? 0);
        if ($jumlahLama + $jumlah > 10) {
            setFlash('error', 'Jumlah menu ini maksimal 10. Keranjang sebelumnya tetap dipertahankan.');
        } else {
            $_SESSION['keranjang'][$kode] = $jumlahLama + $jumlah;
            setFlash('success', 'Pesanan berhasil ditambahkan ke keranjang.');
        }
    }
    header('Location: index.php');
    exit;
}

if ($aksi === 'hapus') {
    $kode = (string) ($_POST['kode'] ?? '');
    if (isset($_SESSION['keranjang'][$kode])) {
        unset($_SESSION['keranjang'][$kode]);
        setFlash('success', 'Item berhasil dihapus dari keranjang.');
    } else {
        setFlash('error', 'Item tidak ditemukan di keranjang.');
    }
    header('Location: keranjang.php');
    exit;
}

if ($aksi === 'kosongkan') {
    $_SESSION['keranjang'] = [];
    setFlash('success', 'Keranjang berhasil dikosongkan.');
    header('Location: keranjang.php');
    exit;
}

if ($aksi === 'favorit') {
    $kategori = (string) ($_POST['kategori'] ?? '');
    if (in_array($kategori, kategoriTersedia($menu), true)) {
        setcookie('kategori_favorit', $kategori, [
            'expires' => time() + (7 * 24 * 60 * 60),
            'path' => '/',
            'samesite' => 'Lax',
        ]);
        $_COOKIE['kategori_favorit'] = $kategori;
        setFlash('success', 'Kategori favorit tersimpan selama 7 hari.');
    } else {
        setFlash('error', 'Kategori tidak valid.');
    }
    header('Location: index.php');
    exit;
}

setFlash('error', 'Aksi tidak dikenali.');
header('Location: index.php');
exit;
