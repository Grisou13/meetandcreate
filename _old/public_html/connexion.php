<?php
// Charge tous les fichiers de configuration
require_once '../vendor/autoload.php';

// se souvenir de moi, méthode : http://stackoverflow.com/questions/244882/what-is-the-best-way-to-implement-remember-me-for-a-website

if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] == true) // Si l'utilisateur est déjà connecté
{
    header("Location: index.php"); //On le renvoi à l'acceuil
}

    
if (isset($_POST) && (!empty($_POST))) //Vérifie si on a reçu un post (formulaire de connexion)
{
    $user = MAC\Models\Profil::where //Si on vérifie si le mail et le mot de passe sont dans la BD
        ([
            "email"=>$_POST["email"],
            "password"=>$_POST["password"]
            
        ])->first();
    
    if (isset($user))
    {
        if (isset($_SESSION["error"]))
        {
            unset($_SESSION["error"]);
        }
        $_SESSION["message"]="Vous êtes connectés !";
        $_SESSION["connecte"]=true;
        $_SESSION["userid"] = $user->id;
        $_SESSION["username"] = $user->username; 
        header ("Location: index.php");
        die();
    }
    else
    {
        $user = MAC\Models\Profil::where
        ([
            "email"=>$_POST["email"],
            "password_temp"=>$_POST["password"]
            
        ])->first();
         if (isset($user))
        {
            if (isset($_SESSION["error"]))
            {
                unset($_SESSION["error"]);
            }
            $_SESSION["message"]="Vous êtes connectés !";
            $_SESSION["connecte"]=true;
            $_SESSION["userid"] = $user->id;
            $_SESSION["username"] = $user->username; 
            header ("Location: profil.php?recup_mdp=1");
            $_SESSION["error"] = "Veuillez changer votre mot de passe";
            die();
        }
        $_SESSION["error"]="Email ou mot de passe invalide";
        header ("Location: connexion.php");
        die();
    }
}
else //Sinon on récupère les informations de connexion.twig
{
    //Affiche la page connexion.twig, en donnant le nom de l'utilisateur
    echo MAC\View::render('connexion.twig');
}

//Exmple BD
/*
 *Pour créer :
 * $profil = MAC\Models\Profil::firstOrNew(["username"=>"test]); Instensie la classe
 * $profil-> name="SAJHdlisahd"; Modifie les données
 * $profil->save(); Sauvegarde dans la base
 * $profil = MAC\Models\Profil::firstOrCreate(["username"=>"test]); Enregistre dans la base sans pouvoir modifier données
 */ 


        
if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
?>