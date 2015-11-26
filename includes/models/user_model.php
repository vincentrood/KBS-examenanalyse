<?php

//model wil zeggen: alles wat betrekking heeft tot bepaalde informatie ophalen uit de database en wat de verbanden zijn tussen die gegevens.
// Hier komen dus alle functies te staan die die informatie ophalen uit de database of juist wat in de database zetten/updaten.
//Hieronder een voorbeeldje:

// checken of naam overeenkomt met een naam uit database
function Authenticate($user, $password) {

    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM gebruiker
            WHERE gebruiker_id = ? OR emailadres = ?");
        $results->bindParam(1,$user);
        $results->bindParam(2,$user);
        $results->execute();
    } catch (Exception $e) {
        echo $error_message = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetch(PDO::FETCH_ASSOC);
    return $match;
}

//nog niet af
function getUserData($user) {

    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM gebruiker
            WHERE gebruiker_id = ?");
        $results->bindParam(1,$user);
        $results->execute();
    } catch (Exception $e) {
        echo $error_message = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetch(PDO::FETCH_ASSOC);
    return $match;
}

function updatePassword($password, $user) {

    require(ROOT_PATH . "includes/database_connect.php");
    $activate = 1;
    try {
        $results = $db->prepare("
            UPDATE gebruiker
            SET wachtwoord = ?,account_activated = ?
            WHERE gebruiker_id = ?");
        $results->bindParam(1,$password);
        $results->bindValue(2,$activate);
        $results->bindParam(3,$user);
        $results->execute();
    } catch (Exception $e) {
        echo $error_message = "Data could not be retrieved from the database.";
        exit;
    }
}


