<?php
session_start();

// Fungsi untuk menambahkan produk ke keranjang belanja
function addToCart($item, $price, $quantity)
{
    // Inisialisasi keranjang belanja jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Cek apakah produk sudah ada di keranjang belanja
    $index = -1;
    $cart = $_SESSION['cart'];
    foreach ($cart as $key => $product) {
        if ($product['name'] === $item) {
            $index = $key;
            break;
        }
    }

    // Jika produk sudah ada di keranjang belanja, tambahkan jumlahnya
    if ($index !== -1) {
        $cart[$index]['quantity'] += $quantity;
    } else {
        // Jika produk belum ada di keranjang belanja, tambahkan ke keranjang
        $product = array(
            'name' => $item,
            'price' => $price,
            'quantity' => $quantity
        );
        array_push($cart, $product);
    }

    // Simpan keranjang belanja yang diperbarui ke session
    $_SESSION['cart'] = $cart;
}

if (isset($_GET['item'], $_GET['price'], $_GET['quantity'])) {
    $item = $_GET['item'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];

    addToCart($item, $price, $quantity);
}

// Mengecek apakah permintaan add to cart telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'], $_POST['action'])) {
    $item = $_POST['item'];
    $action = $_POST['action'];

    if ($action === 'reduce') {
        // Kurangi jumlah produk dalam keranjang
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $product) {
                if ($product['name'] === $item) {
                    $_SESSION['cart'][$key]['quantity']--;
                    if ($_SESSION['cart'][$key]['quantity'] === 0) {
                        // Jika jumlah produk menjadi 0, hapus produk dari keranjang
                        unset($_SESSION['cart'][$key]);
                    }
                    break;
                }
            }
        }
    } elseif ($action === 'add') {
        // Tambahkan jumlah produk dalam keranjang
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $product) {
                if ($product['name'] === $item) {
                    $_SESSION['cart'][$key]['quantity']++;
                    break;
                }
            }
        }
    } elseif ($action === 'remove') {
        // Hapus produk dari keranjang
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $product) {
                if ($product['name'] === $item) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clothing Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />

    <style>
        h2 {
            color: #004a45;
            margin-top: 5px;
            padding: 10px 50px;
        }
        
        h3 {
            font-weight: 800;
            font-size: 30px;
            padding: 30px 50px 10px 50px;
            color: #f5a524;
        }

        h4 {
            font-weight: 700;
            font-size: 40px;
            padding-left: 50px;
            color: #33767a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            padding-left: 30px;
            border-bottom: #004a45 15px;
            border-radius: 15px;
        }

        td {
            padding: 15px;
            text-align: left;
            color: #004a45;
            font-weight: 600;
            font-size: 20px;
        }

        th {
            background-color: #004a45;
            text-align: center;
            padding: 15px;
            font-size: 25px;
            font-weight: 700;
            color: #E3F4F4;
        }

        .styled-table table tr {
            border-bottom: 1px solid #dddddd;
        }

        form {
            display: block;
        }

        button {
            margin-left: 5px;
            border-radius: 50px;
            background-color: #f5a524;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #33767a;
        }

        .lanjut {
            margin: 35px 50px;
        }

        button .lanjut {
            font-size: 40px;
            font-weight: 600;
            padding: 10px;
        }

    </style>
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" height="40" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php"><i class="fa-solid fa-house" style="color: #204c3d;"></i></a></li>
                <li><a href="index.php#kemeja-polos">Kemeja Polos</a></li>
                <li><a href="index.php#kemeja-motif">Kemeja Motif</a></li>
                <li><a href="index.php#t-shirt">T-Shirt</a></li>
                <li><a href="index.php#polo-shirt">Polo Shirt</a></li>
                <li><a href="addToCart.php"><i class="fa-solid fa-bag-shopping" style="color: #004a45;"></i></a></li>
            </ul>
        </div>
    </section>

    <?php
    // Tampilkan isi keranjang belanjaan
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        echo '<h2><i class="fa-solid fa-bag-shopping" style="color: #f5a524;"></i>   Keranjang Belanja</h2>';

        echo '<table>';
        echo '<tr>';
        echo '<th>Nama Produk</th>';
        echo '<th>Harga</th>';
        echo '<th>Jumlah</th>';
        echo '</tr>';

        $totalPrice = 0;

        foreach ($_SESSION['cart'] as $item) {
            $itemName = $item['name'];
            $itemPrice = $item['price'];
            $itemQuantity = $item['quantity'];

            echo '<tr>';
            echo '<input type="hidden" name="item" value="' . $itemName . '">';
            echo '<td>' . $itemName . '</td>';
            echo '<td>Rp' . $itemPrice . '</td>';
            echo '<td>' . $itemQuantity . '</td>';
            echo '<td>';
            echo '<form method="POST" action="addToCart.php">';
            echo '<input type="hidden" name="item" value="' . $itemName . '">';
            echo '<button type="submit" name="action" value="reduce"><i class="fa-solid fa-minus" style="color: white;"></i></button>';
            echo '<button type="submit" name="action" value="add"><i class="fa-solid fa-plus" style="color: white;"></i></button>';
            echo '<button type="submit" name="action" value="remove"><i class="fa-solid fa-trash-can" style="color: white;"></i></button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';

            $totalPrice += $itemPrice * $itemQuantity;
            $_SESSION['total_price'] = $totalPrice;
        }

        echo '</table>';

        echo '<h3>Total Harga</h3>';
        echo '<h4>Rp' . $totalPrice . '</h4>';

        echo '<div class="checkout-button">';
        echo '<form method="POST" action="checkout.php">';
        echo '<input type="hidden" name="total_price" value="' . $totalPrice . '">';
        echo '<button type="submit" class="lanjut">Lanjut</button>';
        echo '</form>';

        echo '</div>';
    } else {
        echo '<h2>Keranjang Belanja Kosong</h2>';
    }
    ?>


</body>

</html>