<?php
require_once("/../includes/init.php");

checkSession();

$user_data = getUserData($_SESSION['gebruiker_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checken als er gegevens ingevoerd zijn
    if (isset($_POST['wijzigen'])) {
        $match = password_verify($_POST["huidig"], $user_data["wachtwoord"]);
        if ($match === FALSE) {
            $_SESSION["message"] = "Wachtwoord onjuist";
        } else {
            $nieuw = $_POST["nieuw"];
            $nieuwheraal = $_POST["nieuwheraal"];
            if (passTest($nieuw, $nieuwheraal) === TRUE) {
                $user_id = $_SESSION['gebruiker_id'];
                $nieuw = password_hash($nieuw, PASSWORD_BCRYPT);
                updatePassword($nieuw, $user_id);
                $_SESSION['message-success'] = 'Uw wachtwoord is gewijzigd!';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>
    <body>
        <?php include(ROOT_PATH . "includes/templates/header.php"); ?>
        <?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
        <div class="wrapper">
            <?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
            <div class="page-wrapper">
                <div class="container-fluid">
                    <ul>
                        <li><b>Voornaam: </b><?php echo $voornaam = $user_data['voornaam']; ?></li>
                        <li><b>Tussenvoegsel: </b><?php echo $tussenvoegsel = $user_data['tussenvoegsel']; ?></li>
                        <li><b>Achternaam: </b><?php echo $achternaam = $user_data['achternaam']; ?></li>
                        <li><b>Emailadres: </b><?php echo $emailadres = $user_data['emailadres']; ?></li>
                    </ul>

                    <div class="contentblock">
                        <!-- Laat de popup zien als je op de knop klikt -->
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#wachtwoordwijzigen">Wachtwoord Wijzigen</button>
                        <!-- Popup -->
                        <div class="modal fade" id="wachtwoordwijzigen" role="dialog">
                            <div class="modal-dialog">
                                <!-- Popup content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Wachtwoord wijzigen</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            Huidig wachtwoord <input type="text" name="huidig"><br>
                                            Nieuw wachtwoord <input type="text" name="nieuw"><br>
                                            Nieuw wachtwoord herhalen <input type="text" name="nieuwheraal"><br>
                                            <input type="submit" name="wijzigen">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>