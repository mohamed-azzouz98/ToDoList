<?php
require_once('../db/config_db.php');

require_once('../fonction/user_function.php');

require_once('../fonction/tdl_function.php');

if (session_status() !== PHP_SESSION_ACTIVE) { // si la session n'est pas active 
    session_start(); // on la démarre 

}
if (empty($_SESSION['pseudo'])) {
    header('Location: index.php');
}

$pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

$db = new PDO(DSN, DB_USER, DB_PASS, $pdo_options); // On instancie la classe PDO 

$id_user = $_SESSION['id'];

$title = $_POST['title'];
$description = $_POST['description'];
$status = $_POST['status'];
$dateBegin = $_POST['dateBegin'];
$dateEnd = $_POST['dateEnd'];
$categorie = $_POST['categorie'];
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tdl.css">
    <title>TodoList</title>
</head>

<body>
    <main class="main">
        <h2>Nouvelle Tache</h2>
        <section id="addToDO">


            <form action="" method="post" class = "addUpdateForm">
                <label for="title">Titre : </label>
                <br>
                <input type="text" name="title" id="title" minlength="5">
                
                <br>

                <label for="description">Description : </label>
                <br>
                <textarea name="description" id="description" cols="30" rows="7" minlength="5"></textarea>

                <br>

                <label for="status">Status : </label>
                <br>
                <select name="status" id="status" >
                    <option value="A Faire">A Faire</option>
                    <option value="En cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                </select>

                <br>

                <label for="dateBegin">Date de début : </label>
                <br>
                <input type="date" name="dateBegin" id="dateBegin">

                <br>

                <label for="dateEnd">Date de Fin : </label>
                <br>
                <input type="date" name="dateEnd" id="dateEnd">

                <br>

                <label for="categorie">Categorie : </label>
                <br>
                <input type="text" name="categorie" id="categorie">

                <br>

                <input type="submit" value="Add" name="newToDo">
            </form>

            <?php

            if (isset($_POST['newToDo'])) {

                addTodo($db, $id_user, $title, $description, $dateBegin, $dateEnd, $status, $categorie);
                header('Location: showTodo.php');
            }

            ?>
        </section>
    </main>





</body>

</html>