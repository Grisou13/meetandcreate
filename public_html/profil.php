<?php
/*
 * public_html/profil.php
 * Description : Code pour la gestion du profil. Va traiter les informations récupérées dans profil.twig.
 * Auteur : Eric Bousbaa
 */ 
require '../vendor/autoload.php'; //Charge tous les fichiers de configuration
$user=[];
$form='';
if(isset($_GET["id"]) && !empty($_GET['id']) && is_numeric($_GET['id'])) //Est-ce qu'il s'agit de notre profil ?
{
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    $id=$_GET['id'];                    //Si NON, on affiche les données du profil voulu
    $user = MAC\Models\Profil::find($id);
    if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] == true && $id!=$_SESSION['userid']) // Vérifie si l'utilisateur est connecté et que l'id de profil demandé n'est pas le sien
    {   
        $form = "<form action='profil.php' method='post'> ";
        $form.= "<input type='hidden' name='favori_id' value='$id' >";
        if(MAC\Models\Profil::find($_SESSION["userid"])->profilFavori()->where('favori_id',$id)->count())//vérifie si nous avons déjà un favori
        {
            $form.= "<input type='hidden' name='action' value='enlever' >"; //Bouton enlever favori
            $form .= "<input value='Enlever favori' name='submit' type='submit' class='btn btn-danger'>";
        }
        else
        {
            $form.= "<input type='hidden' name='action' value='ajouter' >"; //Bouton ajouter favori
            $form .= "<input value='Ajouter favori' name='submit' type='submit' class='btn btn-primary'>";
        }
    }
}
else //A cet endroit, il s'agit de notre propre profil
{
    
    if(!isset($_SESSION['userid'])){ //On revérifie si il est connecté
        $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web'; //Sinon un message d'erreur
        header('Location: connexion.php'); //Et on le redirige
        die();
    }
    $id=(string)$_SESSION['userid'];
    $user=MAC\Models\Profil::find($id); //Instencie le profil
    
    if (isset($_POST) && (!empty($_POST)) && $_SERVER['REQUEST_METHOD']=='POST') //On vérifie si on a reçu quelque chose du formulaire
    {
        //Si on a reçu quelque chose du formulaire
        //Modification mot de passe
        if (isset($_POST["modification_mdp"]) && !empty($_POST["modification_mdp"]) && $_POST["modification_mdp"] == 1)
        {
            $password =$_POST["password"];
            $password2 =$_POST["password2"];
            if (strlen($password) <= 45) //Vérifie la longueur du mot de passe
            {
                if ($password == $password2) //Vérifie si les deux mots de passe du formulaire correspondent
                {
                    if (isset($_POST["recup_mdp"]) && is_numeric($_POST["recup_mdp"]) && $_POST["recup_mdp"] == "1") //On vérifie la chaine de caractère
                        $user->password_temp = null;    
                    
                    $user->password=(string)$password; //Si elle est bonne, on l'enregistre
                    
                    if($user->save()) //Et on le change dans la base de donnée
                    {
                        $_SESSION['message']='Votre mot de passe a été modifié avec succès !'; //Puis on affiche un message d'avertissement
                    }
                    else //Si l'enregistrement ne c'est pas bien déroulé
                    {
                        $_SESSION['error']='Il y a eu une erreur lors de la modification du mot de passe !'; //On affiche un message d'erreur
                    }
                }
                else //Si les deux mots de passe ne correspondent pas
                {
                    $_SESSION['error'] ='Les mots de passe ne correspondent pas !'; //On affiche un message
                }
            }
            else //Si la longueur du mot de passe n'est pas correct
            {
                $_SESSION['error'] ='Le format du mot de passe est incorrect !'; //On affice un message d'erreur
            }
        } //Ajout de favori
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "ajouter") //Si le formulaire d'ajout favori a été envoyé
        {
            
            $favori =  MAC\Models\Profil::find($_POST["favori_id"]); //On récupère l'id du profil visité
            if (isset($favori))
            { 

                $favori = $user->profilFavori()->save($favori); //Et on l'ajoute dans les favoris
                if (isset($favori))
                {
                    if (isset($_POST["retourner_a"]))
                    {
                        header("Location: ".$_SESSION['retourner_a']);
                        $_SESSION["message"] = "Le profil a été ajouté à vos favoris !"; //Puis on affiche un message
                        die();
                    }
                    else
                    {
                        
                        header("Location: ".$_SESSION['retourner_a']);
                        $_SESSION["message"] = "Le profil a été ajouté à vos favoris !";
                        die();
                    }
                }
            }
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "enlever")//Si le formulaire de suppression de favori a été envoyé
        {
            $favori =  MAC\Models\Profil::find($_POST["favori_id"]); //On récupère l'id du profil visité
            if (isset($favori))
            { 

                $favori = $user->profilFavori()->detach($favori->id); //On l'enlève du favori
                if (isset($favori))
                {
                    header("Location: ".$_SESSION['retourner_a']);
                    $_SESSION["message"] = "Le profil a été enlevé de vos favoris !"; //Et on affiche un message
                    die();
                }
            }
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "changerNiveauCompetence")//Si le formulaire de changement de compétence a été envoy.
        {
            if (MAC\Models\Profil::find($_SESSION["userid"])->competences()->updateExistingPivot($_POST["competence_id"], ["niveau"=>$_POST["niveau"]])) //Si la compétence existe 
            {
                $_SESSION["message"] = "Le niveau a été changé ! "; //On affiche un message pour dire que le niveau a été changé
            }
            else
            {
                $_SESSION['error'] = "erreur lors de la sauvegarde ! "; //Sinon, on affiche un autre message pour dire que le niveau de compétence n'a pas été changé
            }
            header("location: ".$_SESSION['retourner_a']);
            die();
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "supprimer_comp")//Si le formulaire pour supprimer une compétence a été envoyé
        {

            $user = MAC\Models\Profil::find($_SESSION["userid"])->competences(); //Et que l'utilisateur possède la compétence

            if($user->detach($_POST["comp_id"])) //On l'enlève
            {
                $_SESSION["message"] = "La compétence a été enlevée!"; //Puis on affiche un message 
            }
            else
            {
                $_SESSION['error'] = "erreur lors de la supression de competence ! "; //Si elle n'a pas été enlevée, on affiche un message
            }
            header("location: ".$_SESSION['retourner_a']);
            die();
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "ajout_competence")//Si le formulaire pour ajouter une compétence a été envoyé
        {
            $competences=[];

            $user=MAC\Models\Profil::find($_SESSION["userid"]); //On instencie l'utilisateur
            try
            {
                if($user->competences()->attach($_POST["competence_id"],["niveau"=>1])) //Et on y ajoute la compétence
                {
                    $_SESSION['error'] = "erreur lors de l'ajout de/des competence(s) ! "; //Si l'ajout ne c'est pas passé correctement, on affice un message d'erreur
                }
                else
                {     
                    $_SESSION["message"] = "Compétence(s) ajouté"; //Sinon juste un message
                }
            }
            catch(\Exception $e) //Si la compétence existe déjà
            {
                $_SESSION['error'] = "La compétence existe déjà ! "; //On affiche un message
            }
            
            header("location: ".$_SESSION['retourner_a']);
            die();
            
        }
        else //Modification du profil
        {
            $pseudo = $_POST["pseudo"]; //On récupère les valeurs du formulaire
            $email = $_POST["email"];
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $description = $_POST["description"];
            $telephone = $_POST["telephone"];
            $adresse = $_POST["adresse"];
            $cp = $_POST["cp"];
            $pays = $_POST["pays"];
            $user = MAC\Models\Profil::find($id); //Instencie le profil voulu
            $error="";
            

            //Puis on vérifie les données
            if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pseudo) && strlen($pays) < 45) // VERIFICATION PSEUDO -- Vérifie si la valeur est correcte
            {
                if(MAC\Models\Profil::where('username',$pseudo)->get()->count())
                    $_SESSION['error']='Le pseudo existe déjà';
                else
                    $user->username=(string)$pseudo; //Si elle l'est, enregistre le nouveau nom d'utilisater
            }
            else 
            {
                $error .= "Pseudonyme invalide !  "; //Si elle ne l'est pas, affiche un message d'erreur
            }

            if(filter_var("$email", FILTER_VALIDATE_EMAIL) && strlen($email) <= 255) // VERIFICATION EMAIL
            {
                $user-> email=(string)$email;
            }
            else 
            {
                $error .= "Email invalide !  "; 
            }

            if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $prenom) && strlen($prenom) <= 45) // VERIFICATION PRENOM
            {
                $user-> prenom=(string)$prenom;
            }
            else 
            {
                $error .= "Prenom invalide !  ";
            }

            if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $nom) && strlen($nom) <= 45) // VERIFICATION NOM
            {
                $user-> nom=(string)$nom;
            }
            else
            {
                $error .= "Nom invalide !  ";
            }

            if (!preg_match('/[\£\$\%\&\*\}\{\#\>\<\>\|\=\_\+\¬]/m', $description)) // VERIFICATION DESCRIPTION
            {
                $user-> description=(string)$description;
            }
            else 
            {
                $error .= "Description invalide !  ";
            }

            if (preg_match('/^([0-9\(\)\/\+ \-]*)$/', $telephone) && strlen($telephone) <= 45) // VERIFICATION TELEPHONE
            {
                $user-> telephone=trim((string)$telephone);
            }
            else 
            {
                $error .= "Numéro de téléphone invalide !  ";
            }

            if (!preg_match('/[\£\$\%\&\*\}\{\#\>\<\>\|\=\_\+\¬]/', $adresse) && strlen($adresse) <= 45) // VERIFICATION ADRESSE
            {
                $user-> adresse=(string)$adresse;
            }
            else 
            {
                $error .= "Adresse invalide !  ";
            }
            if ($cp != "")
            {
                if (is_numeric($cp)&& strlen($cp) <= 10) // VERIFICATION CODE POSTAL
                {
                    $user-> cp=(string)$cp;
                }
                else 
                {
                    $error .= "Code postal invalide !  ";
                }
            }
            

            if (!preg_match('/[^a-zA-Z-]/', $pays) && strlen($pays) <= 45) // VERIFICATION PAYS
            {
                $user-> pays=(string)$pays;
            }
            else 
            {
                $error .= "Pays invalide !  ";
            }
            if (!strlen($error)) 
            {

                if($user->save()) //enregistre les modifications (et en même temps informe si l'enregistrement se fait correctement)
                {
                    $_SESSION['message']='Votre profil a été modifié avec succès'; //Si c'est bon, on affiche un message
                }
                else
                {
                    $_SESSION['error']=' Il y a eu une erreur lor de la sauvegarde de votre profil'; //Sinon, un message d'erreur
                }
            }
            else 
            {
                $_SESSION['error'] = $error; //A ce moment, on affiche les messages d'erreurs qui ont pu apparaitre dans le formulaire
            }
        }
    }
}
$_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
echo MAC\View::render("profil.twig",["profil"=>$user,"form"=>$form]); //Affichage de la page TWIG


if (isset($_SESSION["message"])) //Et on enlève tous les messages d'erreurs/avertissements qui ont pu apparaitre
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
