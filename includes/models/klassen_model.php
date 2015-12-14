<?php

function getAantalLeerlingenKlas($klas) {

    require(ROOT_PATH . "includes/database_connect.php");
    try {   
        $stmt = $db->prepare("
            SELECT klas_id
            FROM klas
            WHERE klas = ?
            ");
        $stmt->bindParam(1,$klas);
        $stmt->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Er ging wat fout.";
        exit;
    }
    $klas = $stmt->fetch(PDO::FETCH_ASSOC);

    try {   
        $stmt = $db->prepare("
            SELECT leerling_id
            FROM leerling
            WHERE klas_id = ?
            ");
        $stmt->bindParam(1,$klas["klas_id"]);
        $stmt->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Er ging wat fout.";
        exit;
    }    
    $results = $stmt->rowCount();
    
    return $results;
}

function getKlassen() {

    require(ROOT_PATH . "includes/database_connect.php");
    try {   
        $stmt = $db->prepare("
            SELECT *
            FROM klas
            ");
        $stmt->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Er ging wat fout.";
        exit;
    }
    $results = $stmt->fetchall(PDO::FETCH_ASSOC);
    
    return $results;
}

function addKlas($klas) {

    require(ROOT_PATH . "includes/database_connect.php");
    try {
        $stmt = $db->prepare("
            INSERT INTO klas (
                klas,
                examenjaar,
                docent_afk
            )
            VALUES(?,?,?) ");
        $stmt->bindParam(1,$klas["klas"]);
        $stmt->bindParam(2,$klas["examenjaar"]);
        $stmt->bindParam(3,$klas["docent_afk"]);
        $stmt->execute();
    } catch (Exception $e) {
        $_SESSION['message'] = "Er ging wat fout.";
        header('Location: '.$_SERVER['REQUEST_URI']);       
        exit;
    }
}

function updateKlas($klas, $klas_id) {

    require(ROOT_PATH . "includes/database_connect.php");

    try {   
        $stmt = $db->prepare("
            UPDATE klas
            SET klas = ?, examenjaar = ?, docent_afk = ?
            WHERE klas_id = ?
            ");
        $stmt->bindParam(1,$klas["klas"]);
        $stmt->bindParam(2,$klas["examenjaar"]);
        $stmt->bindParam(3,$klas["docent_afk"]);
        $stmt->bindParam(4,$klas_id);
        $stmt->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Er ging wat fout.";
        header('Location: '.$_SERVER['REQUEST_URI']);
        exit;
    }
    $_SESSION["message-success"] = "Klas gegevens zijn geupdate";
}

function deleteKlas($klas_id) {

    require(ROOT_PATH . "includes/database_connect.php");

    $db->beginTransaction();

    try {   
        $stmt = $db->prepare("
            SELECT gebruiker_id 
            FROM leerling
            WHERE klas_id = ?
            ");
        $stmt->bindParam(1,$klas_id);
        $stmt->execute();
    } catch (Exception $e){
        $_SESSION['message'] = "Er ging wat fout.";
        $db->rollBack();
        header('Location: '.$_SERVER['REQUEST_URI']);
        exit;
    }

    $gebruikers = $stmt->fetchall(PDO::FETCH_ASSOC);

    //************ ALLE LEERLINGEN VAN DEZE KLAS VERWIJDEREN **********//
    foreach($gebruikers as $gebruiker) {

        try {   
            $stmt = $db->prepare("
                DELETE FROM gebruiker
                WHERE gebruiker_id = ?
                ");
            $stmt->bindParam(1,$gebruiker["gebruiker_id"]);
            $stmt->execute();
        } catch (Exception $e){
            $_SESSION['message'] = "Er ging wat fout.";
            $db->rollBack();
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit;
        }

        try {   
            $stmt = $db->prepare("
                DELETE FROM leerling
                WHERE gebruiker_id = ?
                ");
            $stmt->bindParam(1,$gebruiker["gebruiker_id"]);
            $stmt->execute();
        } catch (Exception $e){
            $_SESSION['message'] = "Er ging wat fout.";
            $db->rollBack();
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit;
        }
    }

    try {   
    $stmt = $db->prepare("
        DELETE FROM klas
        WHERE klas_id = ?
        ");
    $stmt->bindParam(1,$klas_id);
    $stmt->execute();
} catch (Exception $e){
    $_SESSION['message'] = "Er ging wat fout.";
    $db->rollBack();
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit;
}

    $db->commit();
    $_SESSION["message-success"] = "Klas verwijdert";
}