<?php
/**
 * 
 * 
 * 
 * 
 */
function addTodo($db, $id_user, $title, $description, $dateBegin, $dateEnd, $status, $categorie)
{
    $requeteSQL = "INSERT INTO todo(id_user, titre, description, cree_le, date_limite, status, categorie) VALUES (:id_user, :titre, :description, :cree_le, :date_limite, :status, :categorie)";

    $requetePreparee = $db->prepare($requeteSQL);
    $requetePreparee->bindValue(':id_user', $id_user, PDO::PARAM_STR);
    $requetePreparee->bindValue(':titre', $title, PDO::PARAM_STR);
    $requetePreparee->bindParam(":description", $description, PDO::PARAM_STR);
    $requetePreparee->bindValue(':cree_le', $dateBegin, PDO::PARAM_STR);
    $requetePreparee->bindValue(':date_limite', $dateEnd, PDO::PARAM_STR);
    $requetePreparee->bindParam(":status", $status, PDO::PARAM_STR);
    $requetePreparee->bindParam(":categorie", $categorie, PDO::PARAM_STR);

    $requetePreparee->execute();

}

/**
 * 
 * 
 * 
 */
function showTodo($db, $id_user)
{
    $sql = "SELECT * FROM todo WHERE id_user :id_user";
    $prepareSql = $db->prepare($sql);

    $prepareSql->bindParam(":id_user", $id_user);
    $prepareSql->execute();
    return $prepareSql->fetch(PDO::FETCH_BOTH);
}


/**
 * 
 * 
 * 
 * 
 */


function updateTodo(){

}



/**
 * 
 * 
 * 
 * 
 */

function deleteTodo(){

}



?>