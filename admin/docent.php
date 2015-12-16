<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");

$pagename = "Docent";
checkSession();
checkIfAdmin();

if (isset($_GET['verwijderdocent'])) {
    $verwijder = $_GET['verwijderdocent'];
    deleteTeacher($verwijder);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //****************  DOCENT TOEVOEGEN ******************//

    if (isset($_POST['submit_docent'])) {
        if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['afkorting'], $_POST['emailadres'])) {
            //checken of er geen lege waarden zijn ingevoerd
            if ($_POST['voornaam'] == "" OR $_POST['achternaam'] == "" OR $_POST['afkorting'] == "" OR $_POST['emailadres'] == "") {
                $_SESSION['message'] = "Je moet alle gegevens invullen!";
            } else {
                // overbodige ingevoerde spaties weghalen met functie trim
                $voornaam = filter_var(trim($_POST['voornaam']), FILTER_SANITIZE_STRING);

                $achternaam = filter_var(trim($_POST['achternaam']), FILTER_SANITIZE_STRING);
                $tussenvoegsel = filter_var($_POST['tussenvoegsel'], FILTER_SANITIZE_STRING); //tussenvoegsel mag spatie bevatten
                $docent_afkorting = filter_var(trim($_POST['afkorting']), FILTER_SANITIZE_STRING);
                $emailadres = filter_var(trim($_POST['emailadres']), FILTER_VALIDATE_EMAIL);
                if (!$emailadres) {
                    $_SESSION['message'] = 'Voer een geldig e-mailadres in.';
                } else {
                    $role = 2; // is leraar
                    $account_activated = 0; //account is nog niet geactiveerd, dit wordt pas gedaan als gebruiker eerste keer inlogt.
                    $generated_password = generate_random_password();
                    $wachtwoord = password_hash($generated_password, PASSWORD_BCRYPT);
                    $email_code = md5($voornaam + microtime());

                    //returned $generated_password

                    $gegevens = [
                        "voornaam" => $voornaam,
                        "tussenvoegsel" => $tussenvoegsel,
                        "achternaam" => $achternaam,
                        "emailadres" => $emailadres,
                        "email_code" => $email_code,
                        "generated_password" => $generated_password,
                        "wachtwoord" => $wachtwoord,
                        "account_activated" => $account_activated,
                        "role" => $role,
                        "docent_afkorting" => $docent_afkorting,
                    ];

                    //checken of email en afkorting uniek zijn
                    if (checkIfUserExists($gegevens["emailadres"]) === FALSE) {
                        //email adres niet in gebruik, dus gebruiker kan worden toegevoegd.
                        // gegevens inserten
                        addUser($gegevens);
                        addTeacher($gegevens["emailadres"], $gegevens["docent_afkorting"]);
                        //nog niet af!!
                        //wachtwoord mailen naar gebruiker
                        $mail_content = createTempPasswordMail($gegevens);
                        sendMail($mail_content);
                    } else {
                        //email adres in gebruik gebruiker wordt op de hoogte gesteld dat dit email adres bezet is.
                        $_SESSION['message'] = "Email adres is al in gebruik";
                    }
                }
            }
        }
    } else {
        // voor als een docent bewerkt wordt
        $gebruiker_id = filter_var(trim($_POST['gebruiker_id']), FILTER_SANITIZE_STRING);
        $voornaam = filter_var(trim($_POST['voornaam']), FILTER_SANITIZE_STRING);
        $achternaam = filter_var(trim($_POST['achternaam']), FILTER_SANITIZE_STRING);
        $tussenvoegsel = filter_var($_POST['tussenvoegsel'], FILTER_SANITIZE_STRING); //tussenvoegsel mag spatie bevatten
        $docent_afkorting = filter_var(trim($_POST['afkorting']), FILTER_SANITIZE_STRING);
        $emailadres = filter_var(trim($_POST['emailadres']), FILTER_VALIDATE_EMAIL);
        if (!$emailadres) {
            $_SESSION['message'] = 'Voer een geldig e-mailadres in.';
        } else {
            $role = 2; // is leraar
            $account_activated = 0; //account is nog niet geactiveerd, dit wordt pas gedaan als gebruiker eerste keer inlogt.
            $generated_password = generate_random_password();
            $wachtwoord = password_hash($generated_password, PASSWORD_BCRYPT);
            $email_code = md5($voornaam + microtime());

            //returned $generated_password

            $gegevens = [
                "gebruiker_id" => $gebruiker_id,
                "voornaam" => $voornaam,
                "tussenvoegsel" => $tussenvoegsel,
                "achternaam" => $achternaam,
                "emailadres" => $emailadres,
                "docent_afkorting" => $docent_afkorting
            ];
            //gegevens updaten:
            updateTeacher($gegevens["gebruiker_id"], $gegevens["voornaam"], $gegevens["tussenvoegsel"], $gegevens["achternaam"], $gegevens["emailadres"], $gegevens["docent_afkorting"]);
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <body>
        <?php include(ROOT_PATH . "includes/templates/header.php"); ?>
        <div class="wrapper">
            <?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
            <div class="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Welkom op de docentenpagina!</h3>
                                </div>
                                <div class="panel-body">
                                    Op deze pagina vindt u de mogelijkheid om docenten toe te voegen, te bewerken en te verwijderen.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <?php
                                $leraargegevens = viewTeacher();
                                if (empty($leraargegevens)) {
                                    echo"Het lijkt er op dat er nog geen docenten bestaan, klik op \"Docent toevoegen\" om een docent toe te voegen<br>";
                                }
                                ?>
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#docenttoevoegen">Docent toevoegen</button>
                                <?php
                                $t = 0;
                                $x = count($leraargegevens);
                                foreach ($leraargegevens as $leraargegeven) {
                                    if ($t == 0) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td>Voornaam</td>
                                                    <td>Tussenvoegsel</td>
                                                    <td>Achternaam</td>
                                                    <td>Afkorting</td>
                                                    <td>Email adres</td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }
                                            $t++;
                                            ?>
                                            <tr>
                                                <td><?php echo $leraargegeven['voornaam']; ?></td>
                                                <td><?php
                                                    $tussenvoegsel = $leraargegeven['tussenvoegsel'];
                                                    if ($tussenvoegsel != NULL) {
                                                        echo $tussenvoegsel;
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?></td>
                                                <td><?php echo $leraargegeven['achternaam']; ?></td>
                                                <td><?php echo $leraargegeven['docent_afk']; ?></td>
                                                <td><?php echo $leraargegeven['emailadres']; ?></td>
                                                <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $leraargegeven['gebruiker_id'];
                                                    ?>">Bewerken</button></td>
                                            </tr>
                                            <?php
                                            if ($t == $x) {
                                                ?>
                                            </table>
                                        </div>
                                        <?php
                                    }
                                }
                                foreach ($leraargegevens as $leraargegeven) {
                                    ?>
                                    <div class="modal fade" id="<?php echo $leraargegeven['gebruiker_id']; ?>" role="dialog">
                                        <div class="modal-dialog">a

                                            <!-- Examen bewerken/weergeven-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Bewerk <?php echo $leraargegeven['voornaam'] . " " . $leraargegeven['tussenvoegsel'] . " " . $leraargegeven['achternaam']; ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <form id="form<?php echo $leraargegeven['gebruiker_id']; ?>" action="" method="POST">
                                                            <table class="table">
                                                                <tbody>
                                                                <input style="display:none;" type="text" name="gebruiker_id" value="<?php echo $leraargegeven['gebruiker_id']; ?>">
                                                                <tr>
                                                                    <td>
                                                                        Voornaam:
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="voornaam" value="<?php echo $leraargegeven['voornaam']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Tussenvoegsel:
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="tussenvoegsel" value="<?php echo $leraargegeven['tussenvoegsel']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Achternaam:
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="achternaam" value="<?php echo $leraargegeven['achternaam']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Afkorting:
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="afkorting" value="<?php echo $leraargegeven['docent_afk']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Email adres:
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="emailadres" value="<?php echo $leraargegeven['emailadres']; ?>">
                                                                    </td>
                                                                </tr>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button form="form<?php echo $leraargegeven['gebruiker_id']; ?>" type="submit" class="btn btn-default" >Opslaan</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#verwijder<?php echo $leraargegeven['gebruiker_id']; ?>">Verwijder docent</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="verwijder<?php echo $leraargegeven['gebruiker_id']; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Examen verwijderen-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Verwijder <?php echo $leraargegeven['voornaam'] . " " . $leraargegeven['tussenvoegsel'] . " " . $leraargegeven['achternaam']; ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Weet u het zeker?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="?verwijderdocent=<?php echo $leraargegeven['gebruiker_id'] ?>"><button style="float:left;" type="submit" class="btn btn-default">Ja</button></a>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="modal fade" id="docenttoevoegen" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Voeg een examen toe</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="POItablediv">
                                                    <form id="examentoevoegen" method="post" action="">
                                                        <table class="table">
                                                            <tr><td>Voornaam</td> <td><input type="text" name="voornaam"></td></tr>
                                                            <tr><td>Tussenvoegsel</td> <td><input type="text" name="tussenvoegsel"></td></tr>
                                                            <tr><td>Achternaam</td> <td><input type="text" name="achternaam"></td></tr>
                                                            <tr><td>Afkorting</td> <td><input type="text" name="afkorting"></td></tr>
                                                            <tr><td>Emailadres</td> <td><input type="text" name="emailadres"></td></tr>
                                                        </table>
                                                    </form>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <input form="examentoevoegen" type="submit" class="btn btn-default" name="submit_docent" value="Opslaan en verzenden">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include(ROOT_PATH . "includes/templates/footer.php");?>
    </body>
</html>