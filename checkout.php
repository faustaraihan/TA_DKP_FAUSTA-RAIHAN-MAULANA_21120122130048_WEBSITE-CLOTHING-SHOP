<?php
session_start();

if (isset($_SESSION['total_price'])) {
    $totalPrice = $_SESSION['total_price'];
} else {
    // Jika total harga tidak tersedia, redirect ke halaman sebelumnya atau halaman lain yang sesuai
    echo "Tidak tersedia";
    exit();
}

// Memproses form saat tombol Checkout ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['address'], $_POST['payment_method'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method'];

    // Simpan data checkout ke dalam database atau lakukan proses lain sesuai kebutuhan
    // ...

    // Hapus keranjang belanja setelah proses checkout selesai
    unset($_SESSION['cart']);

    // Redirect ke halaman sukses atau halaman lain yang sesuai
    header("Location: finalcheckout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clothing Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="style.css">

    <style>
        h2 {
            color: #004a45;
            margin-top: 5px;
            padding: 10px 50px;
        }

        h5 {
            color: #003430;
            font-weight: 600;
            font-size: 18px;
            padding-bottom: 3px;
        }

        h6 {
            font-size: 15px;
            padding: 5px 5px;
        }

        .checkout-form {
            margin: 20px 50px;
        }

        .form-field {
            margin-bottom: 20px;
        }

        .form-field label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #004a45;
        }

        .form-field2 label {
            display: block;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: 600;
            color: #004a45;
        }

        .form-field input[type="text"] {
            width: 500px;
            padding: 10px;
            font-size: 16px;
            background-color: #E3F4F4;
            font-weight: 600;
            font-size: 20px;
            color: #003430;
            border-radius: 7px;
        }

        .form-field2 input[type="text"] {
            width: 500px;
            padding: 10px;
            font-size: 16px;
            background-color: #E3F4F4;
            font-weight: 600;
            font-size: 20px;
            color: #003430;
            border-radius: 7px;
            margin-bottom: 10px;
        }

        .form-field2 select {
            width: 500px;
            padding: 10px;
            font-size: 16px;
            background-color: #E3F4F4;
            font-weight: 600;
            font-size: 20px;
            color: #003430;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .opsi-rek {
            display: flex;
            justify-content: space-between;
            
        }

        .opsirek-kiri {
            color: #f5a524;
        }

        .opsirek-kanan1 {
            margin-right: 346px;
        }

        .opsirek-kanan2 {
            margin-right: 319px;
        }

        .opsirek-kanan3 {
            margin-right: 330px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }



        .checkagree label {
            padding-left: 2px;
            font-weight: 400;
            font-size: 15px;
        }

        .back-keranjang {
            margin-top: 10px;
            padding-left: 5px;
        }

        .submit-button {
            margin-top: 10px;
            padding-right: 35px;
        }
        
        button .back-keranjang {
            background-color: #004a45;
        }

        button {
            font-weight: 500;
            font-size: 20px;
            padding: 11px;
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

        label {
            font-size: 30px;
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

    <h2>Finalisasi Pembayaran</h2>

    <div class="checkout-form">
        <form method="POST" action="finalcheckout.php">
            <div class="form-field">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-field">
                <label for="address">Alamat</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-field2">
                <label for="payment_method">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="BNI">BNI</option>
                    <option value="SeaBank">SeaBank</option>
                    <option value="Dana">Dana</option>
                    <option value="Gopay">Gopay</option>
                    <option value="Shopeepay">Shopeepay</option>
                </select>
            </div>
            <div>
                <h5>Informasi Rekening dan Nomor Pembayaran</h5>
                <div class="opsi-rek">
                    <div class="opsirek-kiri">
                    <h6>BNI</h6>
                    </div>
                    <div class="opsirek-kanan1">
                    <h6>: 1447542XXX</h6>
                    </div>
                </div>
                <div class="opsi-rek">
                    <div class="opsirek-kiri">
                    <h6>SeaBank</h6>
                    </div>
                    <div class="opsirek-kanan2">
                    <h6>: 9016 2723 2XXX</h6>
                    </div>
                </div>
                <div class="opsi-rek">
                    <div class="opsirek-kiri">
                    <h6>Dana</h6>
                    </div>
                    <div class="opsirek-kanan3">
                    <h6>: 081391209XXX</h6>
                    </div>
                </div>
                <div class="opsi-rek">
                    <div class="opsirek-kiri">
                    <h6>Gopay</h6>
                    </div>
                    <div class="opsirek-kanan3">
                    <h6>: 081391209XXX</h6>
                    </div>
                </div>
                <div class="opsi-rek">
                    <div class="opsirek-kiri">
                    <h6>Shopeepay</h6>
                    </div>
                    <div class="opsirek-kanan3">
                    <h6>: 081391209XXX</h6>
                    </div>
                </div>
            </div>
            <div class="form-field2">
                <label for="username">Nama / Username Pembayaran</label>
                <input type="text" id="userpay" name="userpay" required>
            </div>
            <div class="hartot-co">
                <h3>Total yang harus dibayarkan</h3>
                <h4>Rp <?php echo $totalPrice; ?></h4>
            </div>
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <div class="checkagree">
                <input type="checkbox" id="agree" required>
                <label for="agree">Saya menyetujui data yang diberikan sesuai dan sudah melakukan pembayaran</label>
            </div>
            <div class="button-container">
                    <div class="back-keranjang">
                        <button type="button" onclick="window.location.href='addToCart.php'">Kembali</button>
                    </div>
                    <div class="submit-button">
                    <button type="submit" id="submitBtn" disabled>Submit</button>
                    </div>
                </div>
            </form>

            <script>
        const checkbox = document.getElementById('agree');
        const submitBtn = document.getElementById('submitBtn');

        checkbox.addEventListener('change', function() {
            submitBtn.disabled = !checkbox.checked;
        });
    </script>
</body>
</html>