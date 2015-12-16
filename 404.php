<?php
require_once("/includes/init.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Examen Analyse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="theme-color" content="#1BBC9B">
        <link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css" media="all">
        <link rel="stylesheet" href="/assets/css/style.css" type="text/css" media="all">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body class="alternative-body">
        <?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
        <div class="container loginmargin">
            <div class="row loginmargin">
                <h1 style="width:100% !important;     text-align: center; color: white;">Helaas... </h1>
                <h3 style="width:100% !important;     text-align: center; color: white; "  >De pagina die je zocht is niet gevonden...</h3>
                <div style="width:100% !important;     text-align: center;"class="contact-form">
                    <object type="application/x-shockwave-flash" name="name" data="/images/pacman.swf" width="977" height="500" id="flash-404" style="visibility: visible;" title="Adobe Flash Player"><param name="quality" value="high"><param name="wmode" value="transparent"></object>
                </div>
            </div>
        </div>

        <div class="copyrightelement">
            <center>Copyright &copy; 2015. All Rights Reserved | Design by KBS ICTM1a KPM05</center>
        </div>


        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/alert_message.js"></script>
    </body>
</html>