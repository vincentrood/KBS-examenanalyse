<html> 
<body>
<?php 
session_start();
require_once("../includes/init.php");


$leerling = $_SESSION['gebruiker_id'];

$user_data = getUserData($leerling); 
//nog niet af
?>

<table border='1px;'>

    <?php foreach($user_data as $key=>$value): ?>
    <tr>
        <td><?php echo $key . " "; ?></td>
        <td><?php echo $value; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

