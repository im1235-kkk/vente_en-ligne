<?php
    session_start(); 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);

        $host = "localhost"; 
        $user = "root"; 
        $password = ""; 
        $dbname = "gestionStock"; 
        $conn = mysqli_connect($host, $user, $password, $dbname);
        if (!$conn) {
            die("Erreur de connexion : " . mysqli_connect_error());
        }

        $sql = "SELECT id, nom, prix FROM product WHERE id = $product_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $product['id']) {
                    $item['quantity']++;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id' => $product['id'],
                    'nom' => $product['nom'],
                    'prix' => $product['prix'],
                    'quantity' => 1,
                ];
            }
        }

        $conn->close();
        header("Location: ../product.php");
        exit();
    }
?>
