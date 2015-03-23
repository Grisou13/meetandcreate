<?php
require '../vendor/autoload.php';
/*
 * public_html/profil_favori.php
 * Description : Gères les informations des projets favori.
 * Auteur : Guillauem Laubscher
 */ 
if(!isset($_SESSION['userid']) && isset($_SESSION['connecte'])){ //Vérifie si on est connecté
    $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web';
    header('Location: connexion.php');
    die();
}
$_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
$id=(string)$_SESSION['userid'];
$user=MAC\Models\Profil::find($id); //Instencie le profil voulu

echo MAC\View::render('projet_favori.twig',["favoris"=>$user->projetFavori()->get()]);

