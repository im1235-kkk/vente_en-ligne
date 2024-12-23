<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "gestionStock"; 
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']); 
    $query = "DELETE FROM product WHERE id = $product_id";
    if (mysqli_query($conn, $query)) {
        mysqli_close($conn);
        echo "<script>alert('produit supprimé avec succès.');
            window.location.href='../admin.php';</script>";
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($conn);
    }
} else {
    echo "ID de produit non valide.";
}
mysqli_close($conn);
?>
