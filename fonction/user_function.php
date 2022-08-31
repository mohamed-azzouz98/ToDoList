<?php

/**
 * @param PDO $db
 * @param string $email
 */
function getUserEmail($db, $email)
{

    $getAllUsers = "SELECT count(*) FROM user WHERE email =:email";
    $prepareAllUsers = $db->prepare($getAllUsers);

    $prepareAllUsers->bindParam(":email", $email);
    $prepareAllUsers->execute();
    return $prepareAllUsers->fetch(PDO::FETCH_BOTH);
}

/**
 * Insert un nouvel utilisateur dans la base de donnée
 *
 * @param PDO $db
 * @param string $email
 * @param string $pseudo
 * @param string $password
 * @return boolean|int faux si l'insertion a échouée, l'id créé sinon
 */
function createUser($db, $email, $pseudo, $password)
{

    try {
        $requeteSQL = "INSERT INTO user(email, pseudo, password) VALUES (:mail, :nom, :password)";
        $requetePreparee = $db->prepare($requeteSQL);
        $requetePreparee->bindValue(':nom', $pseudo, PDO::PARAM_STR);
        $requetePreparee->bindValue(':password', $password, PDO::PARAM_STR);
        $requetePreparee->bindParam(":mail", $email, PDO::PARAM_STR);

        $requetePreparee->execute();
        // renvoi l'id créé lors de l'insertion 
        return $db->lastInsertId();
    } catch (Exception $e) {
        if ($e->errorInfo[1] == 1062) {
            return false;
        }
    }
}


/**
 * 
 * @param PDO $db
 * @param string $pseudo
 */
function connectUser($db, $pseudo)
{
    $getUser = "SELECT * FROM user WHERE pseudo = :pseudo";
    $prepareGetUser = $db->prepare($getUser);
    $prepareGetUser->bindParam(":pseudo", $pseudo);
    $prepareGetUser->execute();
    return $prepareGetUser->fetch(PDO::FETCH_BOTH);
}

/**
 * 
 * 
 * 
 * 
 */

function updateUSer()
{
}



/**
 * 
 * 
 * 
 * 
 */


function deleteUser()
{

}

/**
 * 
 * 
 */
function deconnectUser()
{
    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    }
  
    session_unset(); 
  
    session_destroy();
   
    setcookie(session_name(), '', strtotime('-1 day'));
    header('Location: index.php');
    
}
