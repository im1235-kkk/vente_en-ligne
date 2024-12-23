<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestionStock";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }
    $sql = "SELECT id, nom,num_tel FROM fournisseurs";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos</title>
    <link rel="stylesheet" href="CSS/about.css">
</head>
<body>
    <header class="header">
        <img src="images/banner.jpg" alt="banner">
        <div class="container">
            <h1>À propos de Nous</h1>
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
        <section class="about">
            <h2>Nos Contacts</h2>
            <p>Email : elliliimene@gmail.com  </p>
            <p>Téléphone : +216 55702167 </p>
        </section>
        <section class="suppliers">
            <h2>Nos Fournisseurs</h2>
            <ul>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li>" . htmlspecialchars($row['nom']) ." | Contact : ". htmlspecialchars($row['num_tel']). "</li>";
                    }
                } else {
                    echo "<li>Aucun fournisseur disponible.</li>";
                }
                ?>
            </ul>
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
