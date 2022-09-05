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

$sql = "DELETE FROM todo WHERE id_todo = :id_todo";
$requetePreparee = $db->prepare($sql);

$requetePreparee->bindValue(":id_todo", $id_todo, PDO::PARAM_STR);

$requetePreparee->execute();

header('Location: showTodo.php');

?>
