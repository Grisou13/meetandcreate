<?php
/*
 * public_html/profil_favori.php
 * Description : Gères les informations du profil favori.
 * Auteur : Eric Bousbaa
 */ 
require '../vendor/autoload.php'; //On charge les fichiers de configuration

if(!isset($_SESSION['userid']) && isset($_SESSION['connecte'])){ //Vérifie si on est connecté
    $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web'; //Si il ne l'est pas, on le redirige
    header('Location: connexion.php');
    die();
}
$_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
$id=(string)$_SESSION['userid'];
$user=MAC\Models\Profil::find($id); //Instencie le profil voulu
$form='';

echo MAC\View::render("profil_favori.twig",["favori"=> $user->profilFavori()->get()]); //Affiche le contenu (profil_favori.twig)


?>