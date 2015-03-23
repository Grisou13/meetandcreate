<?php
/*
 * public_html/deconnexion.php
 * Description : Code permettant de se déconnecter.
 * Auteur : Eric Bousbaa
 */ 
require_once '../vendor/autoload.php'; //On commence par charger tous les fichiers de configurations

unset($_SESSION["userid"]); //On enlève les informations contenues dans la SESSION
unset($_SESSION['username']);
if(isset($_SESSION['g_access_token'])){
    MAC\Classes\GoogleAuth::logout();
}

$_SESSION["connecte"] = false;
$_SESSION["message"] = "Vous êtes déconnectés !"; //On lui affiche un petit message pour lui dire qu'il a été déconnecté
$_SESSION['retouner_a']='index.php';
header("location: ".$_SESSION['retourner_a']); //Et on le redirige à la page d'acceuil
