-- le fichier permettant la création de la base de donnée, et des tables (et d'un utilisateur MySQL)

-- Création de la base  (si elle n'existe pas déjà)
CREATE DATABASE IF NOT EXISTS tdl; 

-- Créer un utlisateur MySQL pour cette application 
CREATE USER IF NOT EXISTS 'adminTDL'@localhost IDENTIFIED BY 'tdl123'; 

-- Pour modifier le mot de passe d'un utilisateur MySQL (si on l'a perdu par exemple). A faire depuis le compte root. 
-- ALTER USER admin@localhost IDENTIFIED BY 'NewPassword'; 

-- Gestion des droits : 
-- On accorde tous les droits à l'utilisateur admin sur la base tdl 

GRANT ALL PRIVILEGES ON adminTDL.* TO 'adminTDL'@localhost;

USE tdl; -- On se positionne sur la base 'tdl'

-- Création de la table utilisateur 

CREATE TABLE user ( 
    id INT AUTO_INCREMENT, 
    pseudo VARCHAR(30),
    email VARCHAR(100) NOT NULL, -- email est une chaîne de caractère de longueur variable (jusqu'à 100 caractères max)
    password VARCHAR(255) NOT NULL,  -- la valeur de cetexitte colonne doit être renseignée  
    -- On indique quelle est la clé primaire : 
    PRIMARY KEY (id)
); 

-- On rajoute une contrainte d'unicité sur la colonne email & pseudo
ALTER TABLE user ADD CONSTRAINT UNIQUE(email);
ALTER TABLE user ADD CONSTRAINT UNIQUE(pseudo);


-- Création de la table todo

CREATE or REPLACE TABLE todo (
    id_todo INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    cree_le DATE NOT NULL,
    date_limite DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    categorie VARCHAR(50)
    
);