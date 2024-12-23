<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commander'])) {
        if (!isset($_SESSION['cart'])) {
            echo "<script>
                alert('Panier vide !');
                window.location.href = 'product.php';
            </script>";
        }else {
            echo "<script>
                alert('Merci pour votre commande ! Vous serez redirigé vers la page des produits.');
                window.location.href = 'product.php';
            </script>";
            unset($_SESSION['cart']);
            exit(); 
        }        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="CSS/panier.css">
</head>
<body>
    <header class="header">
        <img src="images/banner.jpg" alt="banner">
        <div class="container">
            <h1>Mon Panier</h1>
            <nav>
                <ul class="menu">
                    <li><a href="product.php">Accueil</a></li>
                    <li><a href="panier.php">Panier</a></li>
                    <li><a href="about.php">À propos</a></li>
                    <li><a href="login.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="cart">
            <h2>Produits dans votre panier</h2>
            <?php
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $item) {
                    $subtotal = $item['prix'] * $item['quantity'];
                    $total += $subtotal;

                    echo '<div class="cart-item">';
                    echo '<p><strong>' . htmlspecialchars($item['nom']) . '</strong></p>';
                    echo '<p>Quantité : ' . $item['quantity'] . '</p>';
                    echo '<p>Prix total : ' . number_format($subtotal, 2, ',', ' ') . ' DT</p>';
                    echo '<form method="post" action="actions/remove_from_cart.php" style="display:inline;">';
                    echo '<input type="hidden" name="product_id" value="' . $item['id'] . '">';
                    echo '<button type="submit" class="btn delete-btn">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }

                echo '<div class="total">';
                echo '<p><strong>Total : ' . number_format($total, 2, ',', ' ') . ' DT</strong></p>';
                echo '</div>';
            } else {
                echo '<p>Votre panier est vide.</p>';
            }
            ?>
            <form action="" method="post">
                <button type="submit" name="commander" class="btn">Commander</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 TechStore. Tous droits réservés.</p>
    </footer>
</body>
</html>
