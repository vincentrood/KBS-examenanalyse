<?php

//model wil zeggen: alles wat betrekking heeft tot bepaalde informatie ophalen uit de database en wat de verbanden zijn tussen die gegevens.
// Hier komen dus alle functies te staan die die informatie ophalen uit de database of juist wat in de database zetten/updaten.


// checken of naam overeenkomt met een naam uit database
function addUser($gegevens) {

    require(ROOT_PATH . "includes/database_connect.php");

    //checkt of tussenvoegsel leeg is gelaten, zoja dan wordt NULL ingevoerd.
    if($gegevens[1] == ""){
        $gegevens[1] = NULL;
    }

    try {
        $stmt = $db->prepare("
            INSERT 
            INTO gebruiker (
                voornaam, 
                tussenvoegsel, 
                achternaam, 
                emailadres, 
                email_code,
                wachtwoord, 
                account_activated, 
                role
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
        $stmt->execute($gegevens);
    } catch (Exception $e){
        $_SESSION['message'] = "Gebruiker kon niet worden toegevoegd.";
        exit;
    }   
}

//leraar toevoegen
function addTeacher($emailadres, $docent_afkorting) {

    require(ROOT_PATH . "includes/database_connect.php");

    //check gebruiker_id voor het toevoegen van afkorting in tabel docent.
    try {   
        $checkGebruikerId = $db->prepare("
            SELECT gebruiker_id
            FROM gebruiker
            WHERE emailadres = ?");
        $checkGebruikerId->bindParam(1,$emailadres);
        $checkGebruikerId->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Email adres kon niet worden gecontroleerd.";
        exit;
    }

    $checkGebruikerId = $checkGebruikerId->fetch(PDO::FETCH_ASSOC);
    $gebruiker_id = $checkGebruikerId['gebruiker_id']; 
    // $gebruiker_id bevat id van de leraar zodat de afkorting kan worden toegevoegd.
        
    try{
        $addAfkorting = $db->prepare("
            INSERT INTO docent (
                gebruiker_id, 
                docent_afk
            ) 
            VALUES (?, ?) ");
        $addAfkorting->bindParam(1,$gebruiker_id);
        $addAfkorting->bindParam(2,$docent_afkorting);
        $addAfkorting->execute();
        $_SESSION['message-success'] = "Docent is toegevoegd!";
    } catch (Exception $e) {
        $_SESSION['message'] = "Docent kon niet worden toegevoegd aan de database.";
        exit;
    }
}

function Authenticate($user) {

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
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetch(PDO::FETCH_ASSOC);
    return $match;
}


//checken of emailadres in gebruik is
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
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetch(PDO::FETCH_ASSOC);
    
    if($match == ""){
 
        return false;
    } else {
        return $match;
    }
}


 
//student toevoegen
function addStudent(){

}

//admin toevoegen
function addAdmin(){

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
        $_SESSION['message'] = "Data could not be retrieved from the database.";
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
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }
}
function checkEmailCode($user,$email_code) {

    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM gebruiker
            WHERE gebruiker_id = ? AND email_code = ?");
        $results->bindParam(1,$user);
        $results->bindParam(2,$email_code);
        $results->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->rowCount();
    
    if ($match < 1) {
        return FALSE;
    }
    else{
        return $match;
    }
}

function update_email_code($user,$email_code) {

    require(ROOT_PATH . "includes/database_connect.php");

    try {
        $stmt = $db->prepare("
            UPDATE gebruiker
            SET email_code = ?
            WHERE gebruiker_id = ?");
        $stmt->bindParam(1,$email_code);
       $stmt->bindParam(2,$user);
        $stmt->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }
    $_SESSION['message'] = "gelukt";
} 

function checkRole($userid){
    require(ROOT_PATH . "includes/database_connect.php");
    try {   
        $checkRole = $db->prepare("
            SELECT role
            FROM gebruiker
            WHERE gebruiker_id = ?");
        $checkRole->bindParam(1,$userid);
        $checkRole->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Rol niet gevonden.";
        exit;
    }
    $checkRole = $checkRole->fetch(PDO::FETCH_ASSOC);
    $checkRole = $checkRole["role"];
    return $checkRole;
}


