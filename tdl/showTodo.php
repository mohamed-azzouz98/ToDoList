<?php
require_once('../db/config_db.php');

require_once('../fonction/user_function.php');

require_once('../fonction/tdl_function.php');

if (session_status() !== PHP_SESSION_ACTIVE) { // si la session n'est pas active 
    session_start(); // on la démarre 

}



$pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

$db = new PDO(DSN, DB_USER, DB_PASS, $pdo_options); // On instancie la classe PDO 

$id_user = $_SESSION['id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tdl.css">
    <title>Show Todo</title>
</head>

<body>
    <main class="main">
        <?php

        if (!empty($_SESSION['pseudo'])) {
            echo "<h2>Bienvenue sur votre ToDoList " . $_SESSION['pseudo'] . "</h2>";
            echo "<form action='showTodo.php' method='post' id='formDisconnect'>
<input type='submit' value='Disconnect' name='disconnect' id='disconnect'>  
<a class = 'button' href=addTodo.php>Ajouter une tache</a>
</form>";

            if (isset($_POST['disconnect'])) {
                deconnectUser();
                header('Location: ../index.php');
            }
        } else {
            header('Location: index.php');
        }

        ?>

        <section id="showTodo">

            <?php

            $list = showTodo($db, $id_user);
            $nbEntry = count($list);


            ?>
            <table>
                <tr>
                    <td>Titre</td>
                    <td>Description</td>
                    <td>Cree le</td>
                    <td>Date Limite</td>
                    <td>Status</td>
                    <td>Categorie</td>
                    <td></td>
                    <td></td>
                </tr>

                <?php for ($i = 0; $i < $nbEntry; $i++) : ?>
                    <tr>
                        <td><?php echo $list[$i]['titre']; ?></td>
                        <td><?php echo $list[$i]['description']; ?></td>
                        <td><?php echo $list[$i]['cree_le']; ?></td>
                        <td><?php echo $list[$i]['date_limite']; ?></td>
                        <td><?php echo $list[$i]['status']; ?></td>
                        <td><?php echo $list[$i]['categorie']; ?></td>
                        <td class='button'><a href="updateTodo.php?id_todo=<?php echo $list[$i]['id_todo'] ?>">Update</a></td>
                        <td class='button'><a href="deleteTodo.php?id_todo=<?php echo $list[$i]['id_todo'] ?>">Delete</a></td>
                    </tr>
                <?php endfor ?>
            </table>


        </section>
    </main>


</body>

</html>