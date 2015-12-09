<?php
//voorbeeld
//functies met betrekking tot gebruikers

function passTest($pass, $pass_confirm) {
    if (!empty($pass)) { //checkt of de string empty is
        if (7 < strlen($pass)){ //checkt of het wachtwoord wel 8 of meer karakters is
            if (strcspn($pass, '0123456789') != strlen($pass)){ //checkt of het wachtwoord nummers bevat
                if (strcspn($pass, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') != strlen($pass)) { //checkt of het wachtwoord een hoofdletter heeft
                	if($pass_confirm == $pass) {
                    return TRUE;
                	}
                	else {
                		$_SESSION['message'] = "Wachtwoorden komen niet overeen";
                	}
                }
                else {
                    $_SESSION['message'] = "Wachtwoord moet een hoofdletter bevatten";
                }
            }
            else {
                $_SESSION['message'] = "Wachtwoorden moet een cijfer bevatten";                    
            }
        }
        else {
            $_SESSION['message'] = "Wachtwoord moet minimaal 8 of meer karakters bevatten";
        }
    }
    else {
        $_SESSION['message'] = "Wachtwoord veld is leeg";
    }
}

function checkSession() {

    session_start();
    if (!isset($_SESSION['gebruiker_id'])) {
        $_SESSION['message'] = 'Toegang geweigerd.';
        header('Location: ' . BASE_URL);
        exit;
    }

    //checken of sessie verlopen is           
    if (isset($_SESSION['timeout']) && $_SESSION['timeout'] + SESSION_TIME < time()) {
        // sessie destroyen als sessie verlopen is.
        session_destroy();
        session_start();
        $_SESSION['message'] = 'Sessie is verlopen.';
        $_SESSION['lastpage'] = $_SERVER['REQUEST_URI'];
        header('Location: ' . BASE_URL);
        exit;
    } else {
        //als sessie niet verlopen is sessie verlengen
        $_SESSION['timeout'] = time();
        if(isset($_SESSION['lastpage'])){
            header('Location: ' . $_SESSION['lastpage']);
            unset($_SESSION['lastpage']);
            exit;
        }
    }
}

function checkIfAdmin() {
    if(checkRole($_SESSION['gebruiker_id']) != 3) {
        header('Location: '  . BASE_URL . 'dashboard/');
        exit;
    }
}

