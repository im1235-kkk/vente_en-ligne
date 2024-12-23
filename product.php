<?php
    $host = "localhost"; 
    $user = "root"; 
    $password = ""; 
    $dbname = "gestionStock"; 
    $conn = mysqli_connect($host, $user, $password, $dbname);

    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $search = '';
    $sort_by = 'nom'; 
    $sort_order = 'ASC'; 

    if (isset($_POST['search'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']);
    }
    if (isset($_POST['sort_by'])) {
        $sort_by = mysqli_real_escape_string($conn, $_POST['sort_by']);
    }
    if (isset($_POST['sort_order'])) {
        $sort_order = mysqli_real_escape_string($conn, $_POST['sort_order']);
    }

    if ($sort_by == 'nom') {
        $sql = "SELECT id, nom, prix, image, details 
                FROM product 
                WHERE nom LIKE '%$search%' 
                ORDER BY LEFT(nom, 1) $sort_order";
    } else {
        $sql = "SELECT id, nom, prix, image, details 
                FROM product 
                WHERE nom LIKE '%$search%' 
                ORDER BY prix $sort_order";
    }

    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="CSS/product.css">
</head>
<body>
    <header class="header">
        <img src="images/banner.jpg" alt="banner">
        <div class="container">
            <h1>Nos Produits</h1>
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

            <form method="POST" action="">
            <input type="text" name="search" placeholder="Rechercher un produit par nom" value="<?php echo htmlspecialchars($search); ?>">

            <select name="sort_by">
                <option value="nom" <?php echo $sort_by == 'nom' ? 'selected' : ''; ?>>Nom</option>
                <option value="prix" <?php echo $sort_by == 'prix' ? 'selected' : ''; ?>>Prix</option>
            </select>

            <select name="sort_order">
                <option value="ASC" <?php echo $sort_order == 'ASC' ? 'selected' : ''; ?>>Croissant</option>
                <option value="DESC" <?php echo $sort_order == 'DESC' ? 'selected' : ''; ?>>Décroissant</option>
            </select>

            <button type="submit">Appliquer</button>
        </form>

        <section class="product-list">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-card">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
                    echo '<h2>' . htmlspecialchars($row['nom']) . '</h2>';
                    echo '<p>' . htmlspecialchars($row['details']) . '</p>';
                    echo '<div class="product-price">Prix : ' . number_format($row['prix'], 2, ',', ' ') . ' DT</div>';
                    echo '<form method="post" action="actions/add_to_cart.php">';
                    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" class="btn add-to-cart">Ajouter au panier</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun produit trouvé.</p>';
            }
            ?>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 TechStore. Tous droits réservés.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
