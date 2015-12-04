<?php
require_once("/../includes/init.php");
require_once('/../includes/admin_functions.php');
session_start();

if (!isset($_SESSION['gebruiker_id'])) {
    $_SESSION['message'] = 'Je bent niet ingelogd.';
    header('Location: ' . BASE_URL);
}
//checken of gebruiker misschien admin in 
if(checkRole($_SESSION['gebruiker_id']) != 3){
                        header('Location: '  . BASE_URL . 'dashboard/');
                        exit;
                    }
//checken of sessie verlopen is           
if (isset($_SESSION['timeout']) && $_SESSION['timeout'] + SESSION_TIME < time()) {
    // sessie destroyen als sessie verlopen is.
    session_destroy();
    session_start();
    $_SESSION['message'] = 'Sessie is verlopen.';
    header('Location: ' . BASE_URL);
} else {
    //als sessie niet verlopen is sessie verlengen
    $_SESSION['timeout'] = time();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //****************  EXAMEN + EXAMENVRAGEN TOEVOEGEN ******************//

    if (isset($_POST['submit_examen'])) {
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
                            $vragen[$key] = $temp_array[$i][$j];
                            $i++;
                        }
                        $gegevens_vragen[] = $vragen;
                    }
                    $controleer_of_alle_vragen_ingevoerd_zijn = true;

                    foreach($gegevens_vragen as $e){
                        if(in_array("...", $e) OR in_array("", $e)){
                            $controleer_of_alle_vragen_ingevoerd_zijn = false;
                        } 
                        
                        
                    }


                //checken of email en afkorting uniek zijn
                if (checkIfExamExists($vak, $jaar, $tijdvak) === FALSE) {
                    //examen bestaat niet en kan dus worden toegevoegd
                    //checken als alle vragen ingevoerd zijn
                    if($controleer_of_alle_vragen_ingevoerd_zijn == true){
                    // gegevens inserten
                    addExam($gegevens);
                    //ingevoerde examenvragen invoeren
                    
                    $examen_gegevens = checkIfExamExists($vak, $jaar, $tijdvak);
                    foreach ($gegevens_vragen as $gegeven) {
                        $vraag = $gegeven['vraag'];
                        $maxscore = $gegeven['maxscore'];
                        $categorie = $gegeven['categorie'];
                        $examen_id = $examen_gegevens['examen_id'];
                        if($maxscore == "" OR $categorie == "..."){
                            $_SESSION['message'] = 'Je moet alle gegevens invullen.';
                        }
                        // categorie_id bepalen.....!
                        $check_categorie_id = checkCategorie_id($categorie);
                        foreach ($check_categorie_id as $q) {
                            $categorie_id = $q['categorie_id'];
                            addExamQuestion($vraag, $maxscore, $categorie_id, $examen_id);
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
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Examen Analyse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="theme-color" content="#1BBC9B">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->

        <link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all">
        <link rel="stylesheet" href="../assets/css/dashboard.css" type="text/css" media="all">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>
<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
        <div class="stickymenu">
            <div class="titlemenu">
                <div class="logoimg">
                    <img src="../images/dashboard/logo_fruytier.png" alt="logo_fruytier">
                    <img src="../images/dashboard/logo.png" alt="logo">
                </div>
                <div class="apptitle">
                    <h1>EXAMENANALYSE</h1>
                </div>
            </div>
            <div class="usermenu">
                <div class="headicon">
                    <img src="../images/dashboard/maleicon.png" alt="headicon">
                </div>
                <div class="username">
                    <h3><?php $data = getUserData($_SESSION['gebruiker_id']);
echo $data['voornaam'] . " " . $data['tussenvoegsel'] . " " . $data['achternaam']; ?></h3>
                </div>
                <div class="settings">
                    <img src="../images/dashboard/settings.png" alt="settings">
                    <ul class="submenu">
                        <li>
                            <a href="#" class="submenuitem">Settings</a>
                        </li>
                        <li>
                            <a href="../includes/logout.php" class="submenuitem">Uitloggen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidemenu">
            <ul>
                <a href="/" class="menulink">
                    <li class="menuheading">
                        Dashboard
                    </li>
                </a>
                <a href="#" class="menulink">
                    <li class="menuitem">
                        Examen
                    </li>
                </a>
                <a href="#" class="menulink">
                    <li class="menuitem">
                        Resultaten
                    </li>
                </a>
                <a href="#" class="menulink">
                    <li class="menuitem">
                        Score
                    </li>
                </a>
                <a href="#" class="menulink itembottom">
                    <li class="menuitem">
                        Settings
                    </li>
                </a>
                <a href="#" class="menulink itembottom">
                    <li class="menuitem">
                        Uitloggen
                    </li>
                </a>
            </ul>
        </div>
        <div class="contentblock">
            <div class="content">
                <div class="formulier">
                    <div id="POItablediv">
                        <form method="post" action="">
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

                            nTerm:
                            <select name="nterm">
                                <option  value="2.0">2.0</option>
                                <option  value="1.9">1.9</option>
                                <option  value="1.8">1.8</option>
                                <option  value="1.7">1.7</option>
                                <option  value="1.6">1.6</option>
                                <option  value="1.5">1.5</option>
                                <option  value="1.4">1.4</option>
                                <option  value="1.3">1.3</option>
                                <option  value="1.2">1.2</option>
                                <option  value="1.1">1.1</option>
                                <option selected value="1.0">1.0</option>
                                <option  value="0.9">0.9</option>
                                <option  value="0.8">0.8</option>
                                <option  value="0.7">0.7</option>
                                <option  value="0.6">0.6</option>
                                <option  value="0.5">0.5</option>
                                <option  value="0.4">0.4</option>
                                <option  value="0.3">0.3</option>
                                <option  value="0.2">0.2</option>
                                <option  value="0.1">0.1</option>
                                <option  value="0.0">0.0</option>
                            </select>

                            Niveau:
                            <select name="niveau">
                                <option  value="Havo">Havo</option>
                                <option  value="Vwo">Vwo</option>
                            </select>
                            <table id="vraagtoevoegen" border="1">
                                <tr>
                                    <td>Vraag:</td>
                                    <td>Maximale score:</td>
                                    <td>Categorie:</td>
                                </tr>
                                <tr>

                                    <td><input value="1" size=1 type="text" name="vraag[0]"readonly></td>
                                    <td><input size=25 type="number" name="maxscore[0]"/></td>
                                    <td>	
                                        <select  name="categorie[0]" >
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
                            </table>

                            <input type="submit" name="submit_examen" value="Opslaan en verzenden">
                            <input  type="button" id="addmorePOIbutton" value="Voeg rij toe" onclick="insRow()"/>
                            <input type="button" id="delPOIbutton" value="Verwijder rij" onclick="deleteRow(this)"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/alert_message.js"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/table_insert.js"></script>
    </body>
</html>

