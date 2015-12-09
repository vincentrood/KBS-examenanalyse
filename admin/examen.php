<?php
require_once("/../includes/init.php");
require_once('/../includes/admin_functions.php');
$pagename = "examens";
session_start();

checkSession();
checkIfAdmin();

if (isset($_GET['verwijderexamen'])) {
    $verwijder = $_GET['verwijderexamen'];
    deleteExam($verwijder);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_examen'])) {
        //voor als er een examen toegevoegd word
        if (isset($_POST['vak'], $_POST['jaar'], $_POST['tijdvak'], $_POST['nterm'], $_POST['niveau'])) {
            //checken of er geen lege waarden zijn ingevoerd
            if ($_POST['vak'] == "" OR $_POST['jaar'] == "" OR $_POST['tijdvak'] == "" OR $_POST['nterm'] == "" OR $_POST['niveau'] == "") {
                $_SESSION['message'] = 'Je moet alle gegevens invullen!';
            } else {
                // overbodige ingevoerde spaties weghalen met functie trim
                $vak = filter_var(trim($_POST['vak']), FILTER_SANITIZE_STRING);
                $jaar = filter_var(trim($_POST['jaar']), FILTER_SANITIZE_STRING);
                $tijdvak = filter_var(trim($_POST['tijdvak']), FILTER_SANITIZE_STRING); //tussenvoegsel mag spatie bevatten
                $nterm = filter_var(trim($_POST['nterm']), FILTER_SANITIZE_STRING);
                $niveau = filter_var(trim($_POST['niveau']), FILTER_SANITIZE_STRING);
                $gegevens = [
                    $vak,
                    $jaar,
                    $tijdvak,
                    $nterm,
                    $niveau
                ];
                unset($_POST['submit_examen']);
                unset($_POST['vak']);
                unset($_POST['jaar']);
                unset($_POST['tijdvak']);
                unset($_POST['nterm']);
                unset($_POST['niveau']);
                $vragen = $_POST;


                $temp_array = array_values($vragen);

                $count = count($temp_array[0]);
                for ($j = 0; $j < $count; $j++) {
                    $i = 0;
                    foreach ($vragen as $key => $waarde) {
                        $vragen[$key] = $temp_array[$i];
                        $i++;
                    }

                    $gegevens_vragen[] = $vragen;
                }

                $controleer_of_alle_vragen_ingevoerd_zijn = true;
                foreach ($gegevens_vragen as $e) {
                    if (in_array("...", $e) OR in_array("", $e)) {
                        $controleer_of_alle_vragen_ingevoerd_zijn = false;
                    }
                }
                //checken of email en afkorting uniek zijn
                if (checkIfExamExists($vak, $jaar, $tijdvak) === FALSE) {
                    //examen bestaat niet en kan dus worden toegevoegd
                    //checken als alle vragen ingevoerd zijn
                    if ($controleer_of_alle_vragen_ingevoerd_zijn == true) {
                        // gegevens inserten
                        addExam($gegevens);
                        //ingevoerde examenvragen invoeren

                        $examen_gegevens = checkIfExamExists($vak, $jaar, $tijdvak);


                        foreach ($gegevens_vragen as $gegeven) {

                            $r = count($gegeven) / 3;

                            for ($t = 0; $t < $r; $t++) {
                                $vraag = $gegeven['vraag' . $t];
                                $maxscore = $gegeven['maxscore' . $t];
                                $categorie = $gegeven['categorie' . $t];


                                $examen_id = $examen_gegevens['examen_id'];

                                if ($maxscore == "" OR $categorie == "...") {
                                    $_SESSION['message'] = 'Je moet alle gegevens invullen.';
                                }

                                // categorie_id bepalen.....!
                                $check_categorie_id = checkCategorie_id($categorie);
                                foreach ($check_categorie_id as $q) {
                                    $categorie_id = $q['categorie_id'];

                                    addExamQuestion($vraag, $maxscore, $categorie_id, $examen_id);
                                }
                            }
                        }
                    } else {
                        $_SESSION['message'] = 'Je moet alle gegevens correct invullen!';
                    }
                } else {
                    //examen bestaat al.
                    $_SESSION['message'] = 'Dit examen bestaat al.';
                }
            }
        }
    } else {
    // voor als een examen bewerkt wordt
    $vak = filter_var(trim($_POST['vak']), FILTER_SANITIZE_STRING);
    $jaar = filter_var(trim($_POST['jaar']), FILTER_SANITIZE_STRING);
    $tijdvak = filter_var(trim($_POST['tijdvak']), FILTER_SANITIZE_STRING);
    $nterm = filter_var(trim($_POST['nterm']), FILTER_SANITIZE_STRING);
    $niveau = filter_var(trim($_POST['niveau']), FILTER_SANITIZE_STRING);
    $gegevens = [
        $vak,
        $jaar,
        $tijdvak,
        $nterm,
        $niveau
    ];
    //examengegevens opvragen
    $examengegevens = checkIfExamExists($vak, $jaar, $tijdvak);

    //nterm updaten als veranderd is
    if ($nterm != $examengegevens['nterm']) {
        updateNterm($nterm, $examengegevens['examen_id']);
    }

    unset($_POST['submit_examen']);
    unset($_POST['vak']);
    unset($_POST['jaar']);
    unset($_POST['tijdvak']);
    unset($_POST['nterm']);
    unset($_POST['niveau']);

    $vragen = $_POST;
    if (in_array("", $vragen)) {
        $_SESSION['message'] = "Voer alle gegevens in!";
    } else {
        $vragenarray = array();
        $r = count($vragen) / 3;
        $examen_id = $examengegevens['examen_id'];
        for ($t = 0; $t < $r; $t++) {
            $vraag = $vragen['vraag' . $t];
            $maxscore = $vragen['maxscore' . $t];
            $categorie = $vragen['categorie' . $t];
            $categorie_id = checkCategorie_id($categorie);
            $categorie_id = $categorie_id['0'];
            $categorie_id = $categorie_id['categorie_id'];
            $vragenarray[$t]['vraag'] = $vraag;
            $vragenarray[$t]['maxscore'] = $maxscore;
            $vragenarray[$t]['categorie_id'] = $categorie_id;
        }
        //gegevens inserten
        foreach ($vragenarray as $examenvraag) {
            $v = $examenvraag['vraag'];
            $ms = $examenvraag['maxscore'];
            $c_id = $examenvraag['categorie_id'];
            //checken of vraag bestaat
            $check = checkIfExamQuestionExists($v, $examen_id);
            if ($check) {
                //vraag bestaat, dus updaten
                $check = $check['examenvraag_id'];
                updateExamQuestion($ms, $c_id, $check);
            } else {
                //vraag bestaat niet, dus toevoegen
                addExamQuestion($v, $ms, $c_id, $examen_id);
            }
        }
    }
}
}
?>
<!DOCTYPE html>
<html>
    <body>
        <?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
        <?php include(ROOT_PATH . "includes/templates/header.php");?>
        <div class="wrapper">
            <?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
            <div class="page-wrapper">
                <div class="container-fluid">
                    <div class="contentblock">
                        <div class="content">
                            <h1>Alle exames</h1>
                            <p>Dit is een pagina met alle examens. Er is hier de mogelijkheid om examens te bewerken, verwijderen en toe te voegen.</p>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#examentoevoegen">Examen toevoegen</button>
                            <br><br>
                            <?php
                            $t = 0;
                            $examengegevens = getAllExams();

                            $x = count($examengegevens);
                            foreach ($examengegevens as $examengegeven) {
                                if ($t == 0) {
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>Examenvak</td>
                                                <td>Examenjaar</td>
                                                <td>Tijdvak</td>
                                                <td>nTerm</td>
                                                <td>Niveau</td>
                                                <td></td>
                                            </tr>
                                            <?php
                                        }
                                        $t++;
                                        ?>
                                        <tr>
                                            <td><?php echo $examengegeven['examenvak']; ?></td>
                                            <td><?php echo $examengegeven['examenjaar']; ?></td>
                                            <td><?php echo $examengegeven['tijdvak']; ?></td>
                                            <td><?php echo $examengegeven['nterm']; ?></td>
                                            <td><?php echo $examengegeven['niveau']; ?></td>
                                            <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $examengegeven['examen_id']; ?>">Bewerken</button></td>
                                        </tr>
                                        <?php
                                        if ($t == $x) {
                                            ?>
                                        </table>
                                    </div>
                                    <?php
                                }
                            }
                            foreach ($examengegevens as $examengegeven) {
                                ?>
                                <div class="modal fade" id="<?php echo $examengegeven['examen_id']; ?>" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Examen bewerken/weergeven-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Bewerk examen  <?php echo $examengegeven['niveau'] . " " . $examengegeven['examenvak'] . " " . $examengegeven['examenjaar'] . " tijdvak " . $examengegeven['tijdvak']; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <form action="" method="POST">
                                                        <table class="table">
                                                            <tbody id="vraagtoevoegen<?php echo $examengegeven['examen_id']; ?>">
                                                                Vak:
                                                            <select name="vak" readonly>
                                                                <option  value="<?php echo $examengegeven['examenvak']; ?>"><?php echo $examengegeven['examenvak']; ?></option>
                                                            </select>

                                                            Jaar:
                                                            <input type="number" size="4" name="jaar" value="<?php echo $examengegeven['examenjaar']; ?>" readonly>


                                                            Tijdvak:
                                                            <select name="tijdvak" readonly>
                                                                <option  value="<?php echo $examengegeven['tijdvak']; ?>"><?php echo $examengegeven['tijdvak']; ?></option>
                                                            </select>

                                                            Niveau:
                                                            <select name="niveau" readonly>
                                                                <option selected value="<?php echo $examengegeven['niveau']; ?>"><?php echo $examengegeven['niveau']; ?></option>
                                                            </select>
                                                            <br><br>
                                                            nTerm:
                                                            <select name="nterm">
                                                                <?php
                                                                $nterm = $examengegeven['nterm'];
                                                                for ($q = 0; $q <= 20.1; $q++) {
                                                                    $n = $q / 10;
                                                                    if ($nterm == $n) {
                                                                        echo'<option selected value="' . $n . '">' . $n . '</option>';
                                                                    } else {
                                                                        echo'<option value="' . $n . '">' . $n . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <br><br>

                                                            <tr><td>Vraag</td><td>Maximale score</td><td>Categorie omschrijving</td></tr>
                                                            <?php
                                                            $examenvragen = selectExamQuestions($examengegeven['examen_id']);
                                                            $getal = 0;

                                                            foreach ($examenvragen as $a) {
                                                                ?>
                                                                <tr>
                                                                    <td><input value="<?php echo$a['examenvraag']; ?>"  type="text" name="vraag<?php echo $getal; ?>"readonly></td>
                                                                    <td><input value="<?php echo$a['maxscore']; ?>"  type="text" name="maxscore<?php echo $getal; ?>"></td>
                                                                    <td>
                                                                        <select name="categorie<?php echo $getal; ?>">
                                                                            <option><?php echo $a['categorieomschrijving']; ?></option>
                                                                            <?php
                                                                            $test = checkCategorie();
                                                                            foreach ($test as $t) {
                                                                                $t = $t['categorieomschrijving'];
                                                                                echo "<option>" . $t . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $getal++;
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default" >Opslaan</button></form>
                                                <input type="button" class="btn btn-default" id="addmorePOIbutton" value="Voeg rij toe" onclick="insRow(<?php echo $examengegeven['examen_id'] ?>)"/>
                                                <input type="button" class="btn btn-default" id="delPOIbutton" value="Verwijder rij" onclick="deleteRow(<?php echo $examengegeven['examen_id'] ?>)"/>
                                                <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#verwijder<?php echo $examengegeven['examen_id']; ?>">Verwijder examen</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="verwijder<?php echo $examengegeven['examen_id']; ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Examen verwijderen-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Verwijder  <?php echo $examengegeven['niveau'] . " " . $examengegeven['examenvak'] . " " . $examengegeven['examenjaar'] . " tijdvak " . $examengegeven['tijdvak']; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Weet u het zeker?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="?verwijderexamen=<?php echo $examengegeven['examen_id'] ?>"><button style="float:left;" type="submit" class="btn btn-default">Ja</button></a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- examentoevoegen -->
                    <div class="modal fade" id="examentoevoegen" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Voeg een examen toe</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="POItablediv">
                                        <form method="post" action="">
                                            <table class="table">
                                                <tbody id="vraagtoevoegen">
                                                    Vak:
                                                <select name="vak">
                                                    <option  value="Nederlands">Nederlands</option>
                                                </select>

                                                Jaar:
                                                <input type="number" size="4" name="jaar" value="<?php echo date("Y"); ?>">


                                                Tijdvak:
                                                <select name="tijdvak">
                                                    <option  value="1">1</option>
                                                    <option  value="2">2</option>
                                                </select>

                                                Niveau:
                                                <select name="niveau">
                                                    <option  value="Havo">Havo</option>
                                                    <option  value="Vwo">Vwo</option>
                                                </select>
                                                <br><br>
                                                nTerm:
                                                <select name="nterm">
                                                    <?php
                                                    $nterm = $examengegeven['nterm'];
                                                    for ($q = 0; $q <= 20.1; $q++) {
                                                        $n = $q / 10;
                                                        if ($n == 1) {
                                                            echo'<option selected value="' . $n . '">' . $n . '</option>';
                                                        } else {
                                                            echo'<option value="' . $n . '">' . $n . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <br><br>
                                                <tr>
                                                    <td>Vraag:</td>
                                                    <td>Maximale score:</td>
                                                    <td>Categorie:</td>
                                                </tr>
                                                <tr>

                                                    <td><input value="1" size=1 type="text" name="vraag0"readonly></td>
                                                    <td><input size=25 type="number" name="maxscore0"/></td>
                                                    <td>
                                                        <select  name="categorie0" >
                                                            <option>...</option>
                                                            <?php
                                                            $test = checkCategorie();
                                                            foreach ($test as $t) {
                                                                $t = $t['categorieomschrijving'];
                                                                echo "<option>" . $t . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>


                                                </tr>
                                                </tbody>
                                            </table>

                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-default" name="submit_examen" value="Opslaan en verzenden"></form>
                                    <input  type="button" class="btn btn-default" id="addmorePOIbutton" value="Voeg rij toe" onclick="insRow('')"/>
                                    <input type="button" class="btn btn-default" id="delPOIbutton" value="Verwijder rij" onclick="deleteRow('')"/>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
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

