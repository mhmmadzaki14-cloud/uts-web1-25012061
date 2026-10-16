<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

function e($nilai): string {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka): string {
    return 'Rp' . number_format((float)$angka, 0, ',', '.');
}

function hitungSubtotalItem(int $harga, int $jumlah): int {
    return $harga * $jumlah;
}

function hitungSubtotalKeranjang(array $keranjang, array $menu): int {
    $subtotal = 0;
    foreach ($keranjang as $kode => $jumlah) {
        if (isset($menu[$kode]) && is_int($jumlah) && $jumlah > 0) {
            $subtotal += hitungSubtotalItem((int)$menu[$kode]['harga'], $jumlah);
        }
    }
    return $subtotal;
}

function hitungDiskon(int $subtotal): int {
    return $subtotal >= 50000 ? (int) round($subtotal * 0.10) : 0;
}

function hitungTotalAkhir(int $subtotal): int {
    return $subtotal - hitungDiskon($subtotal);
}

function setFlash(string $tipe, string $pesan): void {
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function ambilFlash(): ?array {
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function kategoriTersedia(array $menu): array {
    $kategori = [];
    foreach ($menu as $item) {
        $kategori[] = $item['kategori'];
    }
    return array_values(array_unique($kategori));
}
