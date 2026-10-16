
<?php
session_start();

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$products = array(
    1 => array('nama' => 'Nasi Goreng', 'kategori' => 'Makanan', 'harga' => 15000),
    2 => array('nama' => 'Mie Goreng', 'kategori' => 'Makanan', 'harga' => 12000),
    3 => array('nama' => 'Ayam Geprek', 'kategori' => 'Makanan', 'harga' => 18000),
    4 => array('nama' => 'Roti Cokelat', 'kategori' => 'Makanan', 'harga' => 10000),
    5 => array('nama' => 'Teh Lemon', 'kategori' => 'Minuman', 'harga' => 8000),
    6 => array('nama' => 'Kopi Susu', 'kategori' => 'Minuman', 'harga' => 12000),
    7 => array('nama' => 'Jus Jeruk', 'kategori' => 'Minuman', 'harga' => 10000),
    8 => array('nama' => 'Air Mineral', 'kategori' => 'Minuman', 'harga' => 5000)
);

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka) {
    return 'Rp' . number_format($angka, 0, ',', '.');
}

/* Tema terang dan gelap */
if (isset($_GET['tema'])) {
    $pilihanTema = $_GET['tema'];

    if ($pilihanTema === 'light' || $pilihanTema === 'dark') {
        setcookie('theme', $pilihanTema, time() + (30 * 86400), '/');
        $_COOKIE['theme'] = $pilihanTema;
    }
}

$tema = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

if ($tema !== 'light' && $tema !== 'dark') {
    $tema = 'light';
}

/* Pencarian dan kategori */
$kategoriList = array('Makanan', 'Minuman');
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$kategoriDipilih = '';

if (isset($_GET['kategori'])) {
    if (in_array($_GET['kategori'], $kategoriList, true)) {
        $kategoriDipilih = $_GET['kategori'];
    }
} elseif (isset($_COOKIE['kategori_favorit'])) {
    if (in_array($_COOKIE['kategori_favorit'], $kategoriList, true)) {
        $kategoriDipilih = $_COOKIE['kategori_favorit'];
    }
}

if (isset($_GET['simpan_kategori'])) {
    if ($kategoriDipilih !== '') {
        setcookie('kategori_favorit', $kategoriDipilih, time() + (30 * 86400), '/');
        $_COOKIE['kategori_favorit'] = $kategoriDipilih;
    }
}

/* Filter menu */
$hasil = array();

foreach ($products as $id => $produk) {
    $cocokNama = ($q === '' || stripos($produk['nama'], $q) !== false);
    $cocokKategori = ($kategoriDipilih === '' ||
        $produk['kategori'] === $kategoriDipilih);

    if ($cocokNama && $cocokKategori) {
        $hasil[$id] = $produk;
    }
}

/* Hitung keranjang */
$jumlahKeranjang = 0;
$subtotal = 0;

foreach ($_SESSION['cart'] as $id => $jumlah) {
    if (isset($products[$id]) && is_numeric($jumlah) && (int)$jumlah > 0) {
        $jumlah = (int)$jumlah;
        $jumlahKeranjang += $jumlah;
        $subtotal += $products[$id]['harga'] * $jumlah;
    }
}

/* Diskon tetap Rp5.000 */
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
<title>Kantin Kampus</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: <?php echo $tema === 'dark' ? '#111827' : '#f3f6fa'; ?>;
    color: <?php echo $tema === 'dark' ? '#f9fafb' : '#1f2937'; ?>;
    font-family: Arial, sans-serif;
}
.navbar { background: #166534; }
.navbar-brand, .navbar a { color: white; }
.menu-card, .panel {
    background: <?php echo $tema === 'dark' ? '#1f2937' : '#ffffff'; ?>;
    color: inherit;
    border: 0;
    border-radius: 15px;
    box-shadow: 0 4px 14px rgba(0,0,0,.08);
}
.menu-card { height: 100%; }
.panel { padding: 20px; }
.menu-icon { font-size: 42px; }
.price { color: #16a34a; font-weight: bold; }
.form-control, .form-select {
    background-color: <?php echo $tema === 'dark' ? '#374151' : '#ffffff'; ?>;
    color: <?php echo $tema === 'dark' ? '#ffffff' : '#111827'; ?>;
}
.form-control::placeholder { color: #9ca3af; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="index.php">
            🍽 Kantin Kampus
        </a>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-outline-light btn-sm" href="index.php?tema=light">Terang</a>
            <a class="btn btn-outline-light btn-sm" href="index.php?tema=dark">Gelap</a>
            <a class="btn btn-warning btn-sm text-dark" href="cart.php">
                🛒 Keranjang (<?php echo $jumlahKeranjang; ?>)
            </a>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="p-4 mb-4 rounded-4 text-white"
         style="background:linear-gradient(120deg,#14532d,#22c55e)">
        <h1 class="fw-bold">Selamat Datang di Kantin Kampus</h1>
        <p class="mb-0">Pilih makanan dan minuman favoritmu dengan mudah.</p>
    </div>

    <?php if ($pesan !== '') { ?>
        <div class="alert alert-info"><?php echo h($pesan); ?></div>
    <?php } ?>

    <div class="panel mb-4">
        <h4 class="mb-3">Cari Menu</h4>
        <form method="get" action="index.php" class="row g-3">
            <input type="hidden" name="tema" value="<?php echo h($tema); ?>">
            <div class="col-md-5">
                <input type="text" name="q" class="form-control"
                       placeholder="Cari nama menu..." value="<?php echo h($q); ?>">
            </div>
            <div class="col-md-4">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategoriList as $kat) { ?>
                        <option value="<?php echo h($kat); ?>"
                            <?php echo $kategoriDipilih === $kat ? 'selected' : ''; ?>>
                            <?php echo h($kat); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-success">Cari</button>
                <a href="index.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <form method="get" action="index.php" class="mt-3">
            <input type="hidden" name="kategori" value="<?php echo h($kategoriDipilih); ?>">
            <input type="hidden" name="simpan_kategori" value="1">
            <button type="submit" class="btn btn-outline-success btn-sm">
                Simpan Kategori Favorit
            </button>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Daftar Menu</h3>
        <span class="badge bg-success"><?php echo count($hasil); ?> menu ditemukan</span>
    </div>

    <div class="row g-4">
    <?php if (count($hasil) > 0) { ?>
        <?php foreach ($hasil as $id => $produk) { ?>
        <div class="col-sm-6 col-lg-3">
            <div class="menu-card p-3">
                <div class="menu-icon mb-3">
                    <?php echo $produk['kategori'] === 'Makanan' ? '🍛' : '🥤'; ?>
                </div>
                <span class="badge bg-secondary"><?php echo h($produk['kategori']); ?></span>
                <h5 class="mt-3 fw-bold"><?php echo h($produk['nama']); ?></h5>
                <p class="price"><?php echo rupiah($produk['harga']); ?></p>

                <form method="post" action="actions.php">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
                    <button type="submit" class="btn btn-success w-100">
                        + Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
        <?php } ?>
    <?php } else { ?>
        <div class="col-12">
            <div class="alert alert-warning">Menu tidak ditemukan.</div>
        </div>
    <?php } ?>
    </div>

    <div class="panel mt-4">
        <h4>Ringkasan Keranjang</h4>
        <div class="d-flex justify-content-between">
            <span>Jumlah barang</span><strong><?php echo $jumlahKeranjang; ?></strong>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <span>Subtotal</span><strong><?php echo rupiah($subtotal); ?></strong>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <span>Diskon (Rp5.000 jika subtotal minimal Rp50.000)</span>
            <strong class="text-success"><?php echo rupiah($diskon); ?></strong>
        </div>
        <hr>
        <div class="d-flex justify-content-between fs-5">
            <strong>Total</strong><strong><?php echo rupiah($total); ?></strong>
        </div>
        <a href="cart.php" class="btn btn-success mt-3">Lihat Keranjang</a>
    </div>
</main>

<footer class="text-center py-4 text-secondary">
    Kantin Kampus &copy; <?php echo date('Y'); ?>
</footer>
</body>
</html>
