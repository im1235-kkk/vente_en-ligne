<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <header class="header">
    <img src="images/banner.jpg" alt="banner">
        <div class="container">
            <h1>Page Administration</h1>
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
        <form method="POST" action="
            <?php
                session_start();
                if (!isset($_SESSION['username'])) {
                    header("Location: login.php");
                    exit();
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    header("Location: login.php");
                    session_destroy(); 
                    exit();
                }
            ?>
        ">
            <input type="submit" id="Logout" name="Logout" value="Logout">
        </form>

        <section class="add-product">
            <h2>Ajouter un Produit</h2>
            <form action="actions/add_product.php" method="post" enctype="multipart/form-data">
                <label for="product-name">Nom du produit :</label>
                <input type="text" id="product-name" name="product_name" required>

                <label for="product-price">Prix :</label>
                <input type="number" id="product-price" name="product_price" min="0" step="0.01" required>

                <label for="product-image">Image :</label>
                <input type="file" id="product-image" name="product_image" required>

                <label for="product-name">Détails :</label>
                <input type="text" id="product-details" name="product_details" required>

                <label for="product-name">Identificateur du Fournisseur :</label>
                <input type="text" id="product-Fournisseur" name="product_Fournisseur" required>

                <button type="submit" class="btn">Ajouter Produit</button>
            </form>
        </section>

        <section class="add-product">
            <h2>Ajouter un Fournisseur</h2>
            <form action="actions/add_fournisseur.php" method="post" enctype="multipart/form-data">
                <label for="fournisseur-name">Nom du fournisseur :</label>
                <input type="text" name="fournisseur_name" required>

                <label for="fournisseur-id">Identificateur du Fournisseur :</label>
                <input type="number" name="fournisseur_id" required>

                <label for="fournisseur-tel">N° de téléphone :</label>
                <input type="text" name="fournisseur_tel" required>

                <button type="submit" class="btn">Ajouter Fournisseur</button>
            </form>
        </section>


        <?php
        $host = "localhost"; 
        $user = "root"; 
        $password = ""; 
        $dbname = "gestionStock"; 
        $conn = mysqli_connect($host, $user, $password, $dbname);
        if (!$conn) {
            die("Erreur de connexion : " . mysqli_connect_error());
        }

        $sql = "SELECT id, nom, prix FROM product";
        $result = mysqli_query($conn, $sql);
        ?>

        <section class="product-list">
            <h2>Produits Actuels</h2>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-item">';
                    echo '<p><strong>' . htmlspecialchars($row['nom']) . '</strong> - ' . number_format($row['prix'], 2, ',', ' ') . ' DT</p>';
                    echo '<form method="post" action="actions/delete_product.php" style="display:inline;">';
                    echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<button class="btn delete-btn" type="submit">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun produit trouvé.</p>';
            }
            mysqli_free_result($result);
            ?>
        </section>

        <?php
        $host = "localhost"; 
        $user = "root"; 
        $password = ""; 
        $dbname = "gestionStock"; 
        $conn = mysqli_connect($host, $user, $password, $dbname);
        if (!$conn) {
            die("Erreur de connexion : " . mysqli_connect_error());
        }
        $sql = "SELECT id, nom,num_tel FROM fournisseurs";
        $result = mysqli_query($conn, $sql);
        ?>

        <section class="product-list">
            <h2>Fournisseurs Actuels</h2>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-item">';
                    echo '<p><strong>' .htmlspecialchars($row['id']).' - '. htmlspecialchars($row['nom']) . '</strong> - ' . htmlspecialchars($row['num_tel']) . '</p>';
                    echo '<form method="post" action="actions/delete_fournisseur.php" style="display:inline;">';
                    echo '<input type="hidden" name="fournisseur_id" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<button class="btn delete-btn" type="submit">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun fournisseur trouvé.</p>';
            }
            mysqli_free_result($result);
            ?>
        </section>
        <?php
        mysqli_close($conn);
        ?>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2024 TechStore. Tous droits réservés.</p>
    </footer>
</body>
</html>
