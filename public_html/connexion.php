<?php
// Charge tous les fichiers de configuration
require_once '../vendor/autoload.php';

// se souvenir de moi, méthode : http://stackoverflow.com/questions/244882/what-is-the-best-way-to-implement-remember-me-for-a-website

if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] == true && isset($_SESSION['userid'])) // Si l'utilisateur est déjà connecté
{
    header("Location: index.php"); //On le renvoi à l'acceuil
}
function login($email,$password){ //vérifie le login de l'utilisateur
    return MAC\Models\Profil::where //Si on vérifie si le mail et le mot de passe sont dans la BD
        ([
            "email"=>$email,
            "password"=>$password
            
        ])->first();
}
function login_temp($email,$password){ //vérifie le login de l'utilsiateur par mot de passe temporaire
    return MAC\Models\Profil::where //Si on vérifie si le mail et le mot de passe sont dans la BD
        ([
            "email"=>$email,
            "password_temp"=>$password
            
        ])->first();
}
if (isset($_POST) && (!empty($_POST))) //Vérifie si on a reçu un post (formulaire de connexion)
{
    $user = login($_POST['email'],$_POST['password']);
    
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
        header ("Location: ".$_SESSION['retourner_a']);
        die();
    }
    else
    {
        $user = login_temp($_POST['email'],$_POST['password']);
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
    //$_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    //Affiche la page connexion.twig, en donnant le nom de l'utilisateur
    echo MAC\View::render('connexion.twig');
}
        
if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
