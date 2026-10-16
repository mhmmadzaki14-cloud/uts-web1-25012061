<?php
// File ini dipanggil setelah fungsi.php dan data/menu.php.
$judulHalaman = $judulHalaman ?? 'Kantin Kampus';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judulHalaman) ?> - Kantin Kampus</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <h1>Pemesanan Kantin Kampus</h1>
    <nav>
        <a href="index.php">Daftar Menu</a>
        <a href="keranjang.php">Keranjang (<?= array_sum($_SESSION['keranjang']) ?>)</a>
    </nav>
</header>
<main class="container">
<?php if ($flash = ambilFlash()): ?>
    <div class="alert <?= e($flash['tipe']) ?>"><?= e($flash['pesan']) ?></div>
<?php endif; ?>
