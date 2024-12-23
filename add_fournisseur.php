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

    $fournisseur_name = mysqli_real_escape_string($conn, $_POST['fournisseur_name']);
    $fournisseur_id = intval($_POST['fournisseur_id']);
    $fournisseur_tel = mysqli_real_escape_string($conn,$_POST['fournisseur_tel']); 

    $sql_check_fournisseur = "SELECT id FROM fournisseurs WHERE id = '$fournisseur_id'";
    $result = mysqli_query($conn, $sql_check_fournisseur);

    if (mysqli_num_rows($result) == 0) {
        $sql_insert = "INSERT INTO fournisseurs (id, nom, num_tel) VALUES ($fournisseur_id, '$fournisseur_name', '$fournisseur_tel')";
        if (mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('fournisseur ajouté avec succès.');
            window.location.href='../admin.php';</script>";
        }
    }else {
        $sql_update = "UPDATE fournisseurs SET nom = '$fournisseur_name', num_tel = '$fournisseur_tel' WHERE id = '$fournisseur_id'";
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('fournisseur modifié avec succès.');
            window.location.href='../admin.php';</script>";
        }
    }
    mysqli_close($conn);
}
?>

