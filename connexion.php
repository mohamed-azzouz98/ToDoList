<?php
require_once('db/config_db.php');

require_once('fonction/user_function.php');


if (session_status() !== PHP_SESSION_ACTIVE) { // si la session n'est pas active 
    session_start(); // on la démarre 
}
if (!empty($_SESSION["id"])) {
    // Si c'est le cas on le redirige vers la page 2
    header('Location: tdl.php');
}


$pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

$db = new PDO(DSN, DB_USER, DB_PASS, $pdo_options); // On instancie la classe PDO 

$pseudo = $_POST['pseudoLogin'];
$password = $_POST['passwordLogin'];
$pseudo = filter_input(INPUT_POST, 'pseudoLogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
    <section id="containerFormLogin">

        <form action="connexion.php" method="post">

            <label for="pseudoLogin">Pseudo</label>
            <input type="text" name="pseudoLogin" id="pseudoLogin">

            <label for="passwordLogin">Password</label>
            <input type="password" name="passwordLogin" id="passwordLogin">

            <input type="submit" value="Login" name="login">

        </form>
        <?php

        if (isset($_POST['login'])) {
            
            if (!empty($pseudo) and !empty($password)) {
                
                $connect = connectUser($db, $pseudo);

                


                if ($connect['pseudo']) {
                   
                    if (password_verify($password, $connect['password'])) {
                       
                        $_SESSION['id'] = $connect['id'];
                        $_SESSION['pseudo'] = $connect['pseudo'];
                        header('Location: tdl.php');
                    } else {
                        echo "Mot de passe ou pseudo incorrect";
                    }
                } else {
                    echo "Mot de passe ou pseudo incorrect";
                }
            }
        }

       
        ?>

    </section>

</body>

</html>