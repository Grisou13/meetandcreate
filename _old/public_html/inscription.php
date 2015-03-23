<?php

// Charge tous les fichiers de configuration
require_once '../vendor/autoload.php';

if (isset($_SESSION))
{
   if (isset($_SESSION['connecte'])&&$_SESSION["connecte"] == true)  // Si l'utilisateur est déjà connecté
    {
        header("Location: index.php"); //On le renvoi à l'acceuil
    }
}

if (isset($_POST) && (!empty($_POST))) //Vérifie si on a reçu un post (formulaire de d'inscription)
{
    //unset($_SESSION["error"]);
    
    $pseudo = $_POST["pseudo"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $user = new MAC\Models\Profil; //Instencie un nouveau profil
    $bon = array //Variabiable de vérification "si tous les champs sont valides"
    (
        "pseudo" => false,
        "email" => false,
        "password" => false,
    );
    
    $check = MAC\Models\Profil::where('username',$pseudo)->orWhere('email',$email)->get()->count(); //Permet de savoir si les données qu'à envoyer l'utilisateur n'existe pass dans la bdd
    if($check<=0)
    {
        
        if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pseudo) && ($pseudo != "")) // VERIFICATION PSEUDO
        {
                $user-> username="$pseudo"; //Modifie les données
                $bon["pseudo"] = true;
        }
        else 
        {
            $_SESSION['error'].='Le champ pseudonyme n\'est pas valable ! ';
            
        }

        if(filter_var("$email", FILTER_VALIDATE_EMAIL) && ($email != "")) // VERIFICATION EMAIL
        {
            $user-> email="$email"; //Enregistre l'email
            $bon["email"] = true;
        }
        else 
        {
            $_SESSION["error"] .= "Le champ email n'est pas valable ! "; //Affiche un message d'erreur
        }

        if (isset($password) && ($password != "")) //VERIFICATION MOT DE PASSE
        {
            if ($password == $password2) //Vérifie si les deux mots de passes correspondent
            {
                $user-> password="$password"; //Enregistre le mot de passe
                $bon["password"] = true;
            }
            else
            {
                $_SESSION["error"] .= "Le mot de passe ne correspond pas ! "; //Affiche un message d'erreur
            }
        }
        else
        {
            $_SESSION["error"] .= "Aucun mot de passe ! ";
        }
        
        if ($bon["pseudo"] == true && $bon["email"] == true && $bon["password"] == true) //Si tous les éléments du formulaires sont bons
        {
            $user->save(); //enregistre le nouveau profil
        }
            

        if (isset($_SESSION["error"])) //Refraichi la page pour afficher le message d'erreur
        {
            header ("Location: inscription.php");
        }
        else 
        {
            header ("Location: index.php");
        }
    }
    else 
    {
        $_SESSION["error"] = "L'utilisateur existe déjà!"; //Affiche un message d'erreur
    }
    
    if (!isset($_SESSION["error"]))
    {
        $_SESSION["message"] = "Utilisateur créé !";
    }
    
    die(); //Arrête l'exécution de php
    
}
else // Si nous ne recevons pas de données 
{
    //Affiche la page connexion.twig, en donnant le nom de l'utilisateur
    echo MAC\View::render('inscription.twig');
}

if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
?>