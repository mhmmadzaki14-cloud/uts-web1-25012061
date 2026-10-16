<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';
$judulHalaman = 'Keranjang';
$subtotal = hitungSubtotalKeranjang($_SESSION['keranjang'], $menu);
$diskon = hitungDiskon($subtotal);
$totalAkhir = hitungTotalAkhir($subtotal);
require __DIR__ . '/includes/header.php';
?>
<h2>Keranjang Pesanan</h2>
<?php if (empty($_SESSION['keranjang'])): ?>
    <p class="alert warning">Keranjang masih kosong. Silakan pilih menu terlebih dahulu.</p>
<?php else: ?>
<div class="table-wrap"><table>
    <thead><tr><th>Nama Menu</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($_SESSION['keranjang'] as $kode => $jumlah): if (!isset($menu[$kode])) continue; $item = $menu[$kode]; ?>
        <tr><td><?= e($item['nama']) ?></td><td><?= rupiah($item['harga']) ?></td><td><?= (int)$jumlah ?></td><td><?= rupiah(hitungSubtotalItem((int)$item['harga'], (int)$jumlah)) ?></td>
        <td><form method="post" action="proses.php"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="kode" value="<?= e($kode) ?>"><button class="danger" type="submit">Hapus</button></form></td></tr>
    <?php endforeach; ?>
    </tbody>
</table></div>
<section class="summary">
    <p>Subtotal seluruh pesanan: <strong><?= rupiah($subtotal) ?></strong></p>
    <p>Diskon: <strong><?= rupiah($diskon) ?></strong></p>
    <p class="grand-total">Total akhir: <?= rupiah($totalAkhir) ?></p>
    <form method="post" action="proses.php" onsubmit="return confirm('Kosongkan seluruh keranjang?')"><input type="hidden" name="aksi" value="kosongkan"><button class="danger" type="submit">Kosongkan Keranjang</button></form>
</section>
<?php endif; ?>
<p><a class="button" href="index.php">Kembali ke Daftar Menu</a></p>
<?php require __DIR__ . '/includes/footer.php'; ?>
