<?php
class FormBox {
    protected $name;
    protected $address;
    protected $paymentMethod;
    protected $totalPrice;
    
    public function __construct($name, $address, $paymentMethod, $totalPrice) {
        $this->name = $name;
        $this->address = $address;
        $this->paymentMethod = $paymentMethod;
        $this->totalPrice = $totalPrice;
    }
    
    public function generateNotaContent() {
        $notaContent = "==== NOTA PEMESANAN ====\n";
        $notaContent .= "Nama: $this->name\n";
        $notaContent .= "Alamat: $this->address\n";
        $notaContent .= "Metode Pembayaran: $this->paymentMethod\n";
        $notaContent .= "Total Harga: Rp $this->totalPrice\n";
        
        return $notaContent;
    }
    
    public function saveNotaFile($notaFilePath, $notaContent) {
        file_put_contents($notaFilePath, $notaContent);
    }
}

class NotaPemesanan extends FormBox {
    protected $notaFilePath;
    protected $whatsappUrl;
    
    public function __construct($name, $address, $paymentMethod, $totalPrice, $notaFilePath) {
        parent::__construct($name, $address, $paymentMethod, $totalPrice);
        $this->notaFilePath = $notaFilePath;
    }
    
    public function generateHTML() {
        $html = <<<HTML
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
                
                
                .container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
        
                .form-box {
                    max-width: 500px;
                    padding: 30px;
                    border: 1px solid #ccc;
                    border-radius: 10px;
                    text-align: center;
                }
        
                .form-box h3 {
                    margin-bottom: 20px;
                }
        
                .form-box p {
                    text-align: left;
                }
        
                .whatsapp-button {
                    margin-top: 10px;
                    padding-left: 5px;
                }
        
                .whatsapp-button a {
                    font-weight: 500;
                    font-size: 14px;
                    padding: 8px;
                    margin-left: 5px;
                    border-radius: 50px;
                    background-color: #25D366;
                    color: white;
                    border: none;
                    text-decoration: none;
                }
        
                .whatsapp-button a:hover {
                    background-color: #128C7E;
                }
        
                .download-button {
                    margin-top: 10px;
                    padding-left: 5px;
                    padding-top: 20px;
                }
                
                .download-button a {
                    font-weight: 500;
                    font-size: 14px;
                    padding: 8px;
                    margin-left: 5px;
                    border-radius: 50px;
                    background-color: #f5a524;
                    color: white;
                    border: none;
                    text-decoration: none;
                }
        
                .download-button a:hover {
                    background-color: #33767a;
                }
            </style>
        </head>
        
        <body>
            <div class="container">
                <div class="form-box">
                    <h3>NOTA PEMESANAN</h3>
                    <p><strong>Nama:</strong> $this->name</p>
                    <p><strong>Alamat:</strong> $this->address</p>
                    <p><strong>Metode Pembayaran:</strong> $this->paymentMethod</p>
                    <p><strong>Total Harga:</strong> Rp $this->totalPrice</p>
                    <div class="download-button">
                        <a href="$this->notaFilePath" download>Unduh Nota</a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        HTML;
        
        return $html;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['address'], $_POST['payment_method'], $_POST['total_price'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method'];
    $totalPrice = $_POST['total_price'];

    // Membuat objek NotaPemesanan
    $notaFilePath = 'nota.txt';
    $formBox = new NotaPemesanan($name, $address, $paymentMethod, $totalPrice, $notaFilePath);

    // Membuat isi nota
    $notaContent = $formBox->generateNotaContent();

    // Menyimpan isi nota ke dalam file
    $formBox->saveNotaFile($notaFilePath, $notaContent);
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
</head>

<body>
    <div class="container">
        <?php if (isset($formBox)) {
            echo $formBox->generateHTML();
        } ?>
    </div>
</body>
</html>
