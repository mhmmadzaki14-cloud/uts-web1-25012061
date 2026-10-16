
<?php
session_start();

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$products = array(
    1 => array('nama' => 'Nasi Goreng', 'harga' => 15000),
    2 => array('nama' => 'Mie Goreng', 'harga' => 12000),
    3 => array('nama' => 'Ayam Geprek', 'harga' => 18000),
    4 => array('nama' => 'Roti Cokelat', 'harga' => 10000),
    5 => array('nama' => 'Teh Lemon', 'harga' => 8000),
    6 => array('nama' => 'Kopi Susu', 'harga' => 12000),
    7 => array('nama' => 'Jus Jeruk', 'harga' => 10000),
    8 => array('nama' => 'Air Mineral', 'harga' => 5000)
);

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka) {
    return 'Rp' . number_format($angka, 0, ',', '.');
}

$subtotal = 0;
$jumlahBarang = 0;

foreach ($_SESSION['cart'] as $id => $jumlah) {
    if (isset($products[$id]) && is_numeric($jumlah) && (int)$jumlah > 0) {
        $jumlah = (int)$jumlah;
        $subtotal += $products[$id]['harga'] * $jumlah;
        $jumlahBarang += $jumlah;
    }
}

$diskon = ($subtotal >= 50000) ? 5000 : 0;
$total = $subtotal - $diskon;

$pesan = isset($_SESSION['flash']) ? $_SESSION['flash'] : '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Keranjang - Kantin Kampus</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #f3f6fa;
    color: #1f2937;
}
.navbar { background: #166534; }
.navbar a { color: white; }
.card { border: 0; }
</style>
</head>
<body>

<nav class="navbar">
    <div class="container py-2">
        <a href="index.php" class="navbar-brand fw-bold">🍽 Kantin Kampus</a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Kembali Belanja</a>
    </div>
</nav>

<main class="container py-4">
    <h2 class="fw-bold mb-4">🛒 Keranjang Belanja</h2>

    <?php if ($pesan !== '') { ?>
        <div class="alert alert-info"><?php echo h($pesan); ?></div>
    <?php } ?>

    <?php if (empty($_SESSION['cart'])) { ?>
        <div class="alert alert-warning">Keranjang masih kosong.</div>
        <a href="index.php" class="btn btn-success">Pilih Menu</a>
    <?php } else { ?>

        <form method="post" action="actions.php">
            <input type="hidden" name="action" value="update">

            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th style="width:130px">Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $jumlah) {
                            if (!isset($products[$id])) continue;
                            $jumlah = (int)$jumlah;
                        ?>
                            <tr>
                                <td><?php echo h($products[$id]['nama']); ?></td>
                                <td><?php echo rupiah($products[$id]['harga']); ?></td>
                                <td>
                                    <input type="number"
                                        class="form-control"
                                        name="jumlah[<?php echo (int)$id; ?>]"
                                        value="<?php echo $jumlah; ?>"
                                        min="1" step="1" required>
                                </td>
                                <td><?php echo rupiah($products[$id]['harga'] * $jumlah); ?></td>
                                <td>
                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        formaction="actions.php"
                                        formmethod="post"
                                        formnovalidate
                                        name="id"
                                        value="<?php echo (int)$id; ?>"
                                        onclick="this.form.querySelector('[name=action]').value='remove';">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                Perbarui Jumlah
            </button>
        </form>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Ringkasan Pembayaran</h4>
                <div class="d-flex justify-content-between mb-2">
                    <span>Jumlah barang</span>
                    <strong><?php echo $jumlahBarang; ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <strong><?php echo rupiah($subtotal); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Diskon (Rp5.000 jika subtotal minimal Rp50.000)</span>
                    <strong class="text-success"><?php echo rupiah($diskon); ?></strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-4">
                    <strong>Total Bayar</strong>
                    <strong class="text-success"><?php echo rupiah($total); ?></strong>
                </div>
            </div>
        </div>

        <form method="post" action="actions.php" class="mt-3"
              onsubmit="return confirm('Yakin ingin mengosongkan keranjang?');">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="btn btn-outline-danger">
                Kosongkan Keranjang
            </button>
        </form>

        <a href="index.php" class="btn btn-success mt-3">Tambah Menu Lain</a>
    <?php } ?>
</main>
</body>
</html>
