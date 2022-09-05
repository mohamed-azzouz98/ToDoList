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

if (isset($_GET['id_todo'])) {
    $id_todo = $_GET['id_todo'];

    $sql = "SELECT * FROM todo WHERE id_todo = :id_todo";
    $prepareSql = $db->prepare($sql);

    $prepareSql->bindParam(":id_todo", $id_todo, PDO::PARAM_STR);
    $prepareSql->execute();
    $tache = $prepareSql->fetchAll(PDO::FETCH_ASSOC);
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tdl.css">
    <title>Update</title>
</head>

<body>
    <main class="main">
        <section>
            <h2>Update Tache</h2>

            <form action="updateTodo.php?id_todo=<?php echo $tache[0]['id_todo'] ?>" method="post" class="addUpdateForm">


                <label for="title">Titre : </label>
                <br>
                <input type="text" name="title" id="title" value="<?php echo $tache[0]['titre'] ? $tache[0]['titre'] : ''; ?>">

                <br>

                <label for="description">Description : </label>
                <br>
                <textarea name="description" id="description" cols="30" rows="7"><?php echo $tache[0]['description']; ?></textarea>

                <br>

                <label for="status">Status : </label>
                <br>
                <select name="status" id="status">
                    <option value="A Faire">A Faire</option>
                    <option value="En cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                </select>

                <br>

                <label for="dateBegin">Date de début : </label>
                <br>
                <input type="date" name="dateBegin" id="dateBegin" value="<?php echo $tache[0]['cree_le']; ?>">

                <br>

                <label for="dateEnd">Date de Fin : </label>
                <br>
                <input type="date" name="dateEnd" id="dateEnd" value="<?php echo $tache[0]['date_limite']; ?>">

                <br>

                <label for="categorie">Categorie : </label>
                <br>
                <input type="text" name="categorie" id="categorie" value="<?php echo $tache[0]['categorie']; ?>">

                <br>
                
                <input type="submit" value="Update" name="updateToDo">
            </form>

            <?php

            if (isset($_POST['updateToDo'])) {

                $title = $_POST['title'];
                $description = $_POST['description'];
                $status = $_POST['status'];
                $dateBegin = $_POST['dateBegin'];
                $dateEnd = $_POST['dateEnd'];
                $categorie = $_POST['categorie'];
                $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $datas = [
                    'titre' => $title,
                    'description' => $description,
                    'cree_le' => $dateBegin,
                    'date_limite' => $dateEnd,
                    'status' => $status,
                    'categorie' => $categorie,
                ];

                updateTodo($db, $id_todo, $datas);
                header('Location: showTodo.php');

            }

            ?>
        </section>
    </main>


</body>

</html>