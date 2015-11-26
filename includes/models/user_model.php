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
 
function checkIfUserExists($email){
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM gebruiker
            WHERE emailadres = ?");
        $results->bindParam(1,$email);
        $results->execute();
    } catch (Exception $e) {
        echo $error_message = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetch(PDO::FETCH_ASSOC);
    if($match == ""){
        return true;
    } else {
        return false;
    }
}

function addTeacher($voornaam, $tussenvoegsel, $achternaam, $afkorting, $emailadres, $wachtwoord, $role){
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $statement = $db->prepare("
           INSERT INTO gebruiker (voornaam, tussenvoegsel, achternaam, emailadres, wachtwoord, account_activated,role) VALUES
           (?, ?, ?, ?, ?, ?, ?)");
        $statement->bindParam(1,$voornaam);
        $statement->bindParam(2,$tussenvoegsel);
        $statement->bindParam(3,$achternaam);
        $statement->bindParam(4,$emailadres);
        $statement->bindParam(5,$wachtwoord);
        $statement->bindParam(6,$wachtwoord);
        $statement->bindParam(7,$role);
        //check gebruiker_id voor het toevoegen van afkortin in tabel docent. 
        $statement->execute();
        $checkGebruikerId = $db->prepare("
            SELECT gebruiker_id
            FROM gebruiker
            WHERE emailadres = ?");
        $checkGebruikerId->bindParam(1,$emailadres);
        $checkGebruikerId->execute();
        $checkGebruikerId = $checkGebruikerId->fetch(PDO::FETCH_ASSOC);
        $gebruiker_id = $checkGebruikerId['gebruiker_id']; 
        // $gebruiker_id bevat id van de leraar zodat de afkorting kan worden toegevoegd.
        $addafkorting = $db->prepare("
            INSERT INTO docent (gebruiker_id, docent_afk) VALUES (?, ?)");
        $addafkorting->bindParam(1,$gebruiker_id);
        $addafkorting->bindParam(2,$afkorting);
        $addafkorting->execute();
        echo "Docent is toegevoegd!";
    } catch (Exception $e) {
        echo $error_message = "Docent kon niet worden toegevoegd aan de database.";
        exit;
    }
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


