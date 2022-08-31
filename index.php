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


$password = $_POST['passwordRegister'];
$confirmPassword = $_POST['confirmPasswordRegister'];
$pseudo = $_POST['pseudoRegister'];
$email = $_POST['emailRegister'];
$pseudo = filter_input(INPUT_POST, 'pseudoRegister', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$email = filter_input(INPUT_POST, 'emailRegister', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/form.js" defer></script>
    <link rel="stylesheet" href="css/index.css">
    <title>Index</title>
</head>

<body>
    <section id="containerFormRegister">

        <form action="index.php" method="post">

            <label for="pseudo">Pseudo : </label>
            <input type="text" name="pseudoRegister" id="pseudoRegister" pattern="[A-Za-z0-9]{5,20}" required>


            <label for="email">Email : </label>
            <input type="text" name="emailRegister" id="emailRegister" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>

            <label for="password">Password : </label>
            <input type="password" name="passwordRegister" id="passwordRegister" minlength="8" required>

            <label for="confirmPassword">Confirm Password : </label>
            <input type="password" name="confirmPasswordRegister" id="confirmPasswordRegister" minlength="8" required>

            <input type="submit" value="Register" name="register" id="register">

        </form>
        <?php

        if (isset($_POST['register'])) {
            // On Verifie si les champs sont bien remplie
            if (!empty($pseudo) and  !empty($email) and !empty($password) and !empty($confirmPassword)) {

                // On verifie si l'adresse mail existe déja

                $result = getUserEmail($db, $email);


                if ($result[0] == 0) {

                    //Si l'email n'existe pas on passe à l'étape suivant et on verifie si les 2mdp correspondent 
                    if ($password == $confirmPassword) {
                        //On hash le password
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);


                        //On Insert le nouveau user dans la bdd
                        $user_id = createUser($db, $email, $pseudo, $passwordHash);
                        if ($user_id) {
                            header('Location: connexion.php');
                        } else {
                            echo 'Cette Adresse est déja utilisé';
                        }
                    } else {
                        echo "Les mots de passe ne correspondent pas";
                    }
                } else {
                    echo "Cette Adresse est déja utilisé";
                }
            } else {
                echo "Veuillez entré un pseudo Valide";
            }
        }


        ?>

        <a href="connexion.php">Sign In</a>

    </section>



    
</body>

</html>