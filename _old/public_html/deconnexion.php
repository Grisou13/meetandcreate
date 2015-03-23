<?php
// Charge tous les fichiers de configuration
require_once '../vendor/autoload.php';

unset($_SESSION["userid"]);
$_SESSION["connecte"] = false;
$_SESSION["message"] = "Vous êtes déconnectés !";
header("location: index.php");
?>

