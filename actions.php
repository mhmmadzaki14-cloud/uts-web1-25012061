
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

function kembali($halaman) {
    header('Location: ' . $halaman);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    kembali('index.php');
}

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'add') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if (!isset($products[$id])) {
        $_SESSION['flash'] = 'Menu tidak ditemukan.';
    } else {
        $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '1';

        if (filter_var($jumlah, FILTER_VALIDATE_INT) === false
            || (int)$jumlah < 1) {
            $_SESSION['flash'] = 'Jumlah harus berupa bilangan bulat minimal 1.';
        } else {
            $jumlah = (int)$jumlah;

            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = 0;
            }

            $_SESSION['cart'][$id] += $jumlah;
            $_SESSION['flash'] = 'Menu berhasil ditambahkan ke keranjang.';
        }
    }

    kembali('index.php');
}

if ($action === 'update') {
    $daftarJumlah = isset($_POST['jumlah']) && is_array($_POST['jumlah'])
        ? $_POST['jumlah'] : array();

    /* Validasi seluruh jumlah sebelum mengubah keranjang */
    foreach ($daftarJumlah as $id => $jumlah) {
        $id = (int)$id;

        if (!isset($products[$id]) ||
            !array_key_exists($id, $_SESSION['cart'])) {
            $_SESSION['flash'] = 'Data menu tidak valid.';
            kembali('cart.php');
        }

        if (filter_var($jumlah, FILTER_VALIDATE_INT) === false
            || (int)$jumlah < 1) {
            $_SESSION['flash'] =
                'Jumlah tidak valid. Keranjang tetap seperti semula.';
            kembali('cart.php');
        }
    }

    foreach ($daftarJumlah as $id => $jumlah) {
        $_SESSION['cart'][(int)$id] = (int)$jumlah;
    }

    $_SESSION['flash'] = 'Keranjang berhasil diperbarui.';
    kembali('cart.php');
}

if ($action === 'remove') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    unset($_SESSION['cart'][$id]);

    $_SESSION['flash'] = 'Menu berhasil dihapus.';
    kembali('cart.php');
}

if ($action === 'clear') {
    $_SESSION['cart'] = array();
    $_SESSION['flash'] = 'Keranjang berhasil dikosongkan.';
    kembali('cart.php');
}

$_SESSION['flash'] = 'Aksi tidak dikenal.';
kembali('index.php');
