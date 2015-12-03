<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");

//uitloggen
session_start();
session_destroy();
session_start();
$_SESSION['message-success'] = 'Je bent nu uitgelogd.';
header("Location: " . BASE_URL);