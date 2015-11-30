<?php
require_once("includes/init.php"); ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>test form</title>
    </head>
    <body>
        <form method="get" action="testform.php">
            <table>
                <tr>
                    <td><input type="text" name="emailadres" size="4"></td>
                    <td><input type="text" name="leerling_id"></td>
                    <td><input type="text" name="klas_id"></td>
                    <td><input type="submit" name="toevoegen" value="Toevoegen"></td>
                </tr>
            </table>
        </form>
    </body>
</html>