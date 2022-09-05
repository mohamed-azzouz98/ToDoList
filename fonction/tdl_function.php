<?php
/**
 * @param PDO $db
 * @param int $id_user
 * @param string $title
 * @param string $description
 * @param date $dateBegin
 * @param date $dateEnd
 * @param string $status
 * @param string $categorie
 */
function addTodo($db, $id_user, $title, $description, $dateBegin, $dateEnd, $status, $categorie)
{
    
    
    
    $requeteSQL = "INSERT INTO todo(id_user, titre, description, cree_le, date_limite, status, categorie) VALUES (:id_user, :titre, :description, :cree_le, :date_limite, :status, :categorie)";

    $requetePreparee = $db->prepare($requeteSQL);
    $requetePreparee->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $requetePreparee->bindValue(':titre', $title, PDO::PARAM_STR);
    $requetePreparee->bindParam(":description", $description, PDO::PARAM_STR);
    $requetePreparee->bindValue(':cree_le', $dateBegin, PDO::PARAM_STR);
    $requetePreparee->bindValue(':date_limite', $dateEnd, PDO::PARAM_STR);
    $requetePreparee->bindParam(":status", $status, PDO::PARAM_STR);
    $requetePreparee->bindParam(":categorie", $categorie, PDO::PARAM_STR);

    $requetePreparee->execute();

}

/**
 * @param PDO $db
 * @param int $id_user
 */
function showTodo($db, $id_user)
{
    $sql = "SELECT * FROM todo WHERE id_user = :id_user";
    $prepareSql = $db->prepare($sql);

    $prepareSql->bindParam(":id_user", $id_user, PDO::PARAM_INT);
    $prepareSql->execute();
    return $prepareSql->fetchAll(PDO::FETCH_ASSOC);
    
    
}


/**
 * @param PDO $db
 * @param int $id_todo
 * @param array $datas
 */


function updateTodo($db, $id_todo, $datas)
{
    
    // $sql = "UPDATE to(titre, description, cree_le, data_limite, status, categorie) SET (:title, :description, :dateBegin, :dateEnd, :status, :categorie) WHERE id_todo = :id_todo";
    // $sql = "UPDATE todo SET titre = :title, description = :description, cree_le = :dateBegin, date_limite = :dateEnd, status = :status, categorie = :categorie WHERE id_todo = :id_todo";
    
    $sql = "UPDATE todo SET ";

     // column = :value
   $updated_fields = [];

   foreach ($datas as $column => $value) {
       $key_value_pair = "{$column} = :{$column}";
       array_push($updated_fields, $key_value_pair);
   }

   $sql .= implode(',', $updated_fields);

   // echo $sql;
   $sql .= " WHERE id_todo = :id_todo";
   
   // on prépare la requête
   $requetePreparee = $db->prepare($sql);

   // On associe les valeurs aux paramètres correspondant 
   foreach($datas as $key => $value) {
       $requetePreparee->bindValue(":{$key}", $value, PDO::PARAM_STR);
   }

   $requetePreparee->bindValue(':id_todo', $id_todo, PDO::PARAM_INT);

;  

   // on exécute la requête 
   return $requetePreparee->execute();


   
}



/**
 * @param PDO $db
 * @param int $id_todo
 */

function deleteTodo($db, $id_todo)
{
    $sql = "DELETE FROM todo WHERE id_todo = :id_todo";
    $requetePreparee = $db->prepare($sql);

    $requetePreparee->bindValue(":id_todo", $id_todo, PDO::PARAM_STR);

    $requetePreparee->execute();

}



?>