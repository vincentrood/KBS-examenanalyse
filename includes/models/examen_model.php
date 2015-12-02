<?php

//model wil zeggen: alles wat betrekking heeft tot bepaalde informatie ophalen uit de database en wat de verbanden zijn tussen die gegevens.
// Hier komen dus alle functies te staan die die informatie ophalen uit de database of juist wat in de database zetten/updaten.
//Hieronder een voorbeeldje:


// checken of examen bestaat
function checkIfExamExists($examenvak, $examenjaar, $tijdvak){
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM examen
            WHERE examenvak = ? AND examenjaar = ? AND tijdvak = ?");
        $results->bindParam(1,$examenvak);
        $results->bindParam(2,$examenjaar);
        $results->bindParam(3,$tijdvak);
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

//examen toevoegen
function addExam($gegevens){
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $stmt = $db->prepare("
            INSERT 
            INTO examen (
                examenvak, 
                examenjaar, 
                tijdvak, 
                nterm, 
                niveau
            ) 
            VALUES (?, ?, ?, ?, ?) ");
        $stmt->execute($gegevens);
        $_SESSION['message-success'] = "Examen toegevoegd";
    } catch (Exception $e){
        $_SESSION['message'] = "Examen kon niet worden toegevoegd.";
        exit;
    }   
}

//checken of examenvraag bestaat
function checkIfExamQuestionExists(){

}

//examenvraag toevoegen
function addExamQuestion(){

}