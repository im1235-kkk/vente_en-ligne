<?php
    session_start();
    if (isset($_SESSION['username'])) {
        header("Location: admin.php"); 
        exit();
    }

    $host = 'localhost';
    $db_username = 'root';  
    $db_password = '';      
    $db_name = 'gestionStock';  
    $conn = mysqli_connect($host, $db_username, $db_password, $db_name);
    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];

        $query = "SELECT username, password FROM admins WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);    
            if ($password == $row['password']) {
                $_SESSION['username'] = $username;
                header("Location: admin.php"); 
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
    mysqli_close($conn);      
?>
        
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion Admin</h2>
        <form action="login.php" method="post">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="submit">Se connecter</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
