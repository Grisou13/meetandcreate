<?php
/*
 * public_html/inscription.php
 * Description : Inscription d'un utilisateur. Traite les informations du formulaire d'inscription (contenu dans inscription.twig).
 * Auteur : Eric Bousbaa
 */ 
require_once '../vendor/autoload.php'; //Pour commencer, on charge les fichiers de configuration

if (isset($_SESSION)) 
{
   if (isset($_SESSION['connecte'])&&$_SESSION["connecte"] == true)  // Si l'utilisateur est déjà connecté
    {
        header("Location: index.php"); //On le renvoi à l'acceuil
    }
}

if (isset($_POST) && (!empty($_POST))) //Vérifie si on a reçu un post (formulaire de d'inscription)
{  
    $pseudo = $_POST["pseudo"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $user = new MAC\Models\Profil; //On va instencier un nouveau profil
    $bon = array // Ce tableau va nous permettre de gérer les erreurs (et vérifier si tous les champs ont été remplies correctement)
    (
        "pseudo" => false,
        "email" => false,
        "password" => false,
    );
    
    $check = MAC\Models\Profil::where('username',$pseudo)->orWhere('email',$email)->get()->count();//Vérifie si le pseudo ou l'email n'existent pas déjà
    if($check<=0)
    {
        
        if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pseudo) && ($pseudo != "")) // VERIFICATION PSEUDONYME
        {
                $user-> username="$pseudo"; //Si c'est bon, on enregistre le contenu (sans encore l'insérer dans la base de donnée)
                $bon["pseudo"] = true; //Et on check le tableau
        }
        else 
        {
            $_SESSION['error'].='Le champ pseudonyme n\'est pas valable ! '; //Si le pseudonyme n'est pas bon, on affiche un message d'erreur
            
        }

        if(filter_var("$email", FILTER_VALIDATE_EMAIL) && ($email != "")) // VERIFICATION EMAIL
        {
            $user-> email="$email"; //Enregistre l'email
            $bon["email"] = true; //Et on check le tableau
        }
        else 
        {
            $_SESSION["error"] .= "Le champ email n'est pas valable ! "; //Si c'est pas bon, un message d'erreur
        }

        if (isset($password) && ($password != "")) //VERIFICATION MOT DE PASSE
        {
            if ($password == $password2) //Vérifie si les deux mots de passes correspondent
            {
                $user-> password="$password"; //Enregistre le mot de passe
                $bon["password"] = true; //Et on check le tableau
            }
            else
            {
                $_SESSION["error"] .= "Le mot de passe ne correspond pas ! "; //Affiche un message d'erreur
            }
        }
        else
        {
            $_SESSION["error"] .= "Aucun mot de passe ! "; //Si le champ est vide, un petit avertissement s'impose
        }
        
        if ($bon["pseudo"] == true && $bon["email"] == true && $bon["password"] == true) //Si tous les éléments du formulaires sont bons
        {
            $user->save(); //A ce moment, on enregistre les données dans la base de donnée
        }
            

        if (isset($_SESSION["error"])) //Si il y a des erreurs, on rafraichi la page pour les afficher
        {
            header ("Location: inscription.php");
        }
        else 
        {
            $_SESSION['message']='Veuillez compléter les informations (nom, prénom) pour pouvoir continuer a naviquer sur le site';
            $_SESSION["message"] .= "Utilisateur créé !"; //On affiche un petit message
            $_SESSION["connecte"]=true; //On enregistre des informations dans la session
            $_SESSION["userid"] = $user->id;
            $_SESSION["username"] = $user->username; 
            header ("Location: profil.php");
        }
    }
    else //Si l'utilisateur existe déjà
    {
        $_SESSION["error"] = "L'utilisateur existe déjà!"; //On affiche un message d'erreur
        header('Location: inscription.php');
    }
    
    
    die(); //Arrête l'exécution de php
    
}
else // Si nous ne recevons pas de données 
{
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    echo MAC\View::render('inscription.twig'); //On affiche le formulaire d'inscription
}

if (isset($_SESSION["message"])) //Et on efface tous les avertissements/messages d'erreurs
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
?>