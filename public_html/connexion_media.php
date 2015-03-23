<?php
require_once '../vendor/autoload.php';
/* 
 * public_html/connexion_media.php
 * Description : Permet de se connceter au site par différent média, tel que facebook, google ou d'autre a implementé plus tard
 * @author Thomas Ricci
 */

if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] == true && isset($_SESSION['userid'])) // Si l'utilisateur est déjà connecté
{
    header("Location: ".$_SESSION['retourner_a']); //On le renvoi à l'acceuil
    die();
}
if(isset($_GET['media'])&&!empty($_GET['media'])&&  is_string($_GET['media'])){
    switch($_GET['media']){
        case 'facebook':           
            $session=Facebook\FacebookSession::setDefaultApplication('779285952166138', '7b9842670cc14d2f7410d0658fa9d657'); //parametre la session facebook
            $helper = new Facebook\FacebookRedirectLoginHelper('http://sicmi3a01.cpnv-es.ch/connexion_media.php?media=facebook'); //crée l'utilisatire de login facebook
            $auth= new MAC\Classes\FacebookAuth($helper);
            $location="index.php";//url de redirection
            
            if($auth->checkRedirectSession()){
               $location="index.php";
            }
            else{
                 $location=$auth->getAuthUrl();
            }
            
            header('Location: '.$location);
            die();            
            break;
        case 'google':            
            $client= new Google_Client();//crée l'utilsiatire de connexion google
            $plus=new Google_Service_Plus($client);//crée l'utilsiatire google+            
            $auth= new MAC\Classes\GoogleAuth($client,$plus);
            $location="index.php";//url de redirection
            
            if($auth->checkRedirectCode()){                
                $location="index.php";
            }
            else{          
                $location=$auth->getAuthUrl();
            }
            
            header('Location: '.$location);
            die();
            break;
        
    }
    
}
//nous laissons une redirection au cas ou le script n'est pas executé pour faire un login par facebook ou google
header('Location: '.$_SESSION['retourner_a']);

die();