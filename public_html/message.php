<?php
/*
 * public_html/message.php
 * Description : permet d'envoyer les message au utilisateurs et de voir les messages qui nous sont addressé
 * Auteur : Eric Bousbaa
 */ 

require_once '../vendor/autoload.php';
if(!isset($_SESSION['userid']) && isset($_SESSION['connecte'])){ //Vérifie si on est connecté
    $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web';
    header('Location: connexion.php');
    die();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $a=$_POST['profil_id'];
    $b=  array_filter($a, 'is_numeric');
    if(isset($_POST['profil_id'])&&!empty($_POST['profil_id'])&&$a===$b //test les profil_id qu'ils soit numeric
        &&isset($_POST['titre'])&&!empty($_POST['titre'])&&is_string($_POST['titre']) && //vérifie que le titre est présent
        isset($_POST['message'])&&!empty($_POST['message'])&&  is_string($_POST['message'])){ //vérifie si le message est présent
        foreach ($_POST['profil_id']as $profilId){
            if($profilId!=$_SESSION['userid']){
                $message=  MAC\Models\Message::create([
                    "titre"=>$_POST['titre'],
                    "text"=>$_POST['message'],
                    "profil_dest"=>$profilId,
                    "profil_source"=>$_SESSION['userid']
                ]);
                if(isset($message))
                    $_SESSION['message']='Le message a bien été envoyé';
                else
                    $_SESSION['error']='Il y a eu un problème lors de l\'envoi du message';
            }
        }
    }
    else{
        $_SESSION['error']='Il y a une erreur dans votre message, pas de titre? ou pas de message? le message est addressé a vous même?';
    }
    header('Location: message.php');
    die();
}else{
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    $profil= MAC\Models\Profil::find($_SESSION['userid']);
    $profil->messages()->update(["vue"=>true]);//met que tout les message non-lue de la personne sont maintenant lu
    echo MAC\View::render('message.twig',["messages"=>$profil->messages()->get()]);
}


if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 