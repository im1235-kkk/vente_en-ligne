<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost"; 
    $user = "root"; 
    $password = ""; 
    $dbname = "gestionStock"; 
    $conn = mysqli_connect($host, $user, $password, $dbname);
    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_details = mysqli_real_escape_string($conn, $_POST['product_details']);
    $product_fournisseur = intval($_POST['product_Fournisseur']); 

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_data = addslashes(file_get_contents($image_tmp)); 
    } else {
        die("Erreur lors du téléchargement de l'image.");
    }

    $sql_check_fournisseur = "SELECT id FROM fournisseurs WHERE id = '$product_fournisseur'";
    $result = mysqli_query($conn, $sql_check_fournisseur);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>
            alert('Erreur : Le fournisseur n\\'existe pas.');
            window.location.href = '../admin.php';
        </script>";
        exit(); 
    }

    $sql_check_product = "SELECT nom FROM product WHERE nom = '$product_name'";
    $result = mysqli_query($conn, $sql_check_product);

    if (mysqli_num_rows($result) == 0) {
        $sql_insert = "INSERT INTO product (nom, prix, image, details, fournisseur_id) 
                   VALUES ('$product_name', $product_price, '$image_data', '$product_details', $product_fournisseur)";
        if (mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Produit ajouté avec succès.');
            window.location.href='../admin.php';</script>";
        }
    }else {
        $sql_update = "UPDATE product SET prix = $product_price, image = '$image_data', details = '$product_details' WHERE nom = '$product_name'";
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('produit modifié avec succès.');
            window.location.href='../admin.php';</script>";
        }
    }
    mysqli_close($conn);
}
?>

