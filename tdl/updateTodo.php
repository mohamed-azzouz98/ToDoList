<?php
require_once('../db/config_db.php');

require_once('../fonction/user_function.php');

require_once('../fonction/tdl_function.php');

$pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

$db = new PDO(DSN, DB_USER, DB_PASS, $pdo_options); // On instancie la classe PDO 

if (session_status() !== PHP_SESSION_ACTIVE) { // si la session n'est pas active 
    session_start(); // on la démarre 

}
if (empty($_SESSION['pseudo'])) {
    header('Location: ../index.php');
}
$id_todo = $_GET['id_todo'];

$sql = "SELECT * FROM todo WHERE id_todo = :id_todo";
$prepareSql = $db->prepare($sql);

$prepareSql->bindParam(":id_todo", $id_todo, PDO::PARAM_STR);
$prepareSql->execute();
$tache = $prepareSql->fetchAll(PDO::FETCH_ASSOC);

var_dump($tache);

// A FAIRE



// Faire en sorte que la bonne value du SELECT soit en selected
// Afficher la date au bon format
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>

<body>
<section>
        <h2>Update Tache</h2>

        <form action="updateTodo.php" method="post">

        
            <label for="title">Titre : </label>
            <input type="text" name="title" id="title" placeholder="<?php echo $tache[0]['titre']; ?>">

            <label for="description">Description : </label>
            <textarea name="description" id="description" cols="30" rows="7" placeholder="<?php echo $tache[0]['description']; ?>"></textarea>

            <select name="status" id="status">
                <option value="A Faire">A Faire</option>
                <option value="En cours">En cours</option>
                <option value="Terminé">Terminé</option>
            </select>

            <label for="dateBegin">Date de début : </label>
            <input type="date" name="dateBegin" id="dateBegin" >

            <label for="dateEnd">Date de Fin : </label>
            <input type="date" name="dateEnd" id="dateEnd">

            <label for="categorie">Categorie : </label>
            <input type="text" name="categorie" id="categorie" placeholder="<?php echo $tache[0]['categorie']; ?>">

            <input type="submit" value="Add" name="newToDo">
        </form>
    
        <?php

        if (isset($_POST['newToDo'])) {
            
            addTodo($db, $id_user, $title, $description, $dateBegin, $dateEnd, $status, $categorie);

        }

        ?>
   </section>

</body>

</html>