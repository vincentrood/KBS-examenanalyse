<?php

//model wil zeggen: alles wat betrekking heeft tot bepaalde informatie ophalen uit de database en wat de verbanden zijn tussen die gegevens.
// Hier komen dus alle functies te staan die die informatie ophalen uit de database of juist wat in de database zetten/updaten.
//Hieronder een voorbeeldje:
// checken of examen bestaat
function checkIfExamExists($examenvak, $examenjaar, $tijdvak) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM examen
            WHERE examenvak = ? AND examenjaar = ? AND tijdvak = ?");
        $results->bindParam(1, $examenvak);
        $results->bindParam(2, $examenjaar);
        $results->bindParam(3, $tijdvak);
        $results->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetch(PDO::FETCH_ASSOC);

    if ($match == "") {

        return false;
    } else {
        return $match;
    }
}

//examen toevoegen
function addExam($gegevens) {
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
    } catch (Exception $e) {
        $_SESSION['message'] = "Examen kon niet worden toegevoegd.";
        exit;
    }
}

function checkCategorie() {
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM categorie");
        $results->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetchAll();
    return $match;
}

function checkCategorie_id($categorie_omschrijving) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $results = $db->prepare("
            SELECT categorie_id
            FROM categorie
            WHERE categorieomschrijving = ?");
        $results->bindParam(1, $categorie_omschrijving);
        $results->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Data could not be retrieved from the database.";
        exit;
    }

    $match = $results->fetchAll();
    return $match;
}

function addExamQuestion($vraag, $maxscore, $categorie_id, $examen_id) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {

        $stmt = $db->prepare("INSERT INTO examenvraag (examen_id, examenvraag, maxscore, categorie_id ) VALUES (?, ?, ?, ?); ");
        $stmt->bindParam(1, $examen_id);
        $stmt->bindParam(2, $vraag);
        $stmt->bindParam(3, $maxscore);
        $stmt->bindParam(4, $categorie_id);
        $stmt->execute();
        $_SESSION['message-success'] = "Examenvragen toegevoegd";
    } catch (Exception $e) {
        $_SESSION['message'] = "Examenvraag kon niet worden toegevoegd.";
        exit;
    }
}

//checken of examenvraag bestaat
function checkIfExamQuestionExists($vraag, $examen_id) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {

        $match = $db->prepare("SELECT * FROM examenvraag WHERE examen_id = ? AND examenvraag = ?");
        $match->bindParam(1, $examen_id);
        $match->bindParam(2, $vraag);
        $match->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Geen gegevens uit de database ontvangen.";
        exit;
    }
    $match = $match->fetch(PDO::FETCH_ASSOC);

    if ($match == "") {

        return false;
    } else {
        return $match;
    }
}

function getAllExams() {
    require(ROOT_PATH . "includes/database_connect.php");
    try {

        $match = $db->prepare("SELECT * FROM examen");
        $match->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Geen gegevens uit de database ontvangen.";
        exit;
    }
    $match = $match->fetchAll();
    return $match;
}

function deleteExam($examen) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {

        $stmt = $db->prepare("
            DELETE FROM examen WHERE examen_id = ?");
        $stmt2 = $db->prepare("
            SELECT examenvraag_id FROM examenvraag WHERE examen_id = ?");
        $stmt2->bindParam(1, $examen);
        $stmt2->execute();
        $stmt2 = $stmt2->fetchAll();

        foreach ($stmt2 as $t) {
            $t = $t['examenvraag_id'];
            $stmt3 = $db->prepare("
            DELETE FROM examenvraag WHERE examenvraag_id = ?");
            $stmt3->bindParam(1, $t);
            $stmt3->execute();
        }

        $stmt->bindParam(1, $examen);
        $stmt->execute();
        $_SESSION['message-success'] = 'Examen en alle bijbehorende vragen verwijdert.';
    } catch (Exception $e) {
        $_SESSION['message'] = "Geen gegevens uit de database ontvangen.";
        exit;
    }
}

function updateNterm($nterm, $examen_id) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $stmt = $db->prepare("
                        UPDATE examen SET nterm = ? WHERE examen_id = ?");
        $stmt->bindParam(1, $nterm);
        $stmt->bindParam(2, $examen_id);
        $stmt->execute();
        $_SESSION['message-success'] = "Nterm geüpdatet!";
    } catch (Exception $e) {
        $_SESSION['message'] = "Update mislukt.";
        exit;
    }
}

function updateExamQuestion($maxscore, $categorie, $examenvraag_id) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $update = $db->prepare("UPDATE examenvraag SET maxscore = ?, categorie_id = ? WHERE examenvraag_id = ?");
        $update->bindParam(1, $maxscore);
        $update->bindParam(2, $categorie);
        $update->bindParam(3, $examenvraag_id);
        $update->execute();
        $_SESSION['message-success'] = "Examenvraag geüpdatet!";
    } catch (Exception $e) {
        $_SESSION['message'] = "Update mislukt";
        exit;
    }
}

function selectExamQuestions($examen_id) {
    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $match = $db->prepare("SELECT EV.examenvraag, EV.maxscore, C.categorieomschrijving FROM examenvraag EV JOIN categorie C ON C.categorie_id = EV.categorie_id WHERE examen_id = ?");
        $match->bindParam(1, $examen_id);
        $match->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Geen gegevens uit de database ontvangen.";
        exit;
    }
    $match = $match->fetchAll();
    return $match;
}
