<?php
/*
 * public_html/afficher.php
 * Description : Permet d'afficher tous les projets ou les profils
 * Auteur : Thomas Ricci
 */ 
require_once '../vendor/autoload.php';
if($_SERVER['REQUEST_METHOD']=='GET'){
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    $action=isset($_GET['action'])?$_GET['action']:null;
    switch ($action){
        case 'profil'://affiche tous les profils
            echo MAC\View::render('profil_all.twig',["profils"=> MAC\Models\Profil::all()]);
            break;
        case 'projet': //affiche tous les projets
            if(!isset($_SESSION['userid']))//recupere les projet non-publier si l'utilsiateur n'est pas connecté
                $projets=MAC\Models\Projet::where('publier',true)->get();
            else
                $projets=MAC\Models\Projet::all();//récupère tous les projets si l'utilsiateur est connecté
            echo MAC\View::render('projet_all.twig',["projets"=> $projets]);
            break;
        default: //redirige à la page d'acceuil
            header('Locaiton: inndex.php');
            break;
    }
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
