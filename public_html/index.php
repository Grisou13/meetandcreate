<?php
/*
 * public_html/index.php
 * Description : Page d'acceuil du site.
 * Auteur : Thomas Ricci
 */ 
//paginator : http://stackoverflow.com/questions/19214481/pagination-with-slim-framework-and-laravels-eloquent-orm

require_once '../vendor/autoload.php'; //Charge tous les fichiers de configuration
if($_SERVER['REQUEST_METHOD']=='GET'){
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    if(!isset($_SESSION['userid']))//si l'utilsiateur n'est connecté nous prennons tous les projets publier
        $projets=MAC\Models\Projet::where('publier',true)->orderBy('created_at','DESC')->take(10)->get();
    else//sinon on prend tout les projets
        $projets=MAC\Models\Projet::orderBy('created_at','DESC')->take(10)->get();
    echo MAC\View::render('index.twig',["projets"=>$projets]);//affichage de la page d'acceuil
}
else{
    header('Location: index.php');
}
if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
}


