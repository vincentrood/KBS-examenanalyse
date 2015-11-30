<?php 
require_once("includes/init.php");
session_start();

if (isset($_SESSION['gebruiker_id'])) {
	header('Location: '  . BASE_URL . 'dashboard/');
	exit;
}