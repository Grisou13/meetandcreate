<?php

require '../vendor/autoload.php';
$user=[];
$form='';
if(isset($_GET["id"]) && !empty($_GET['id']) && is_numeric($_GET['id'])) //Est-ce qu'il s'agit de notre profil ?
{
    $id=$_GET['id']; //Si NON, on affiche les données du profil voulu
    $user = MAC\Models\Profil::find($id);
    if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] == true && $id!=$_SESSION['userid']) // Vérifie si l'utilisateur est connecté et que l'id de profil demandé n'est pas le sien
    {   
        $form = "<form action='profil.php' method='post'> ";
        $form.= "<input type='hidden' name='favori_id' value='$id' >";
        $form.= "<input type='hidden' name='action' value='enlever|ajouter' >";
        if(MAC\Models\Profil::find($_SESSION["userid"])->profilFavori()->where('favori_id',$id)->count())//vérifie si nous avons déjà un favori
        {
            $form.= "<input type='hidden' name='action' value='enlever' >";
            $form .= "<input value='Enlever favori' name='submit' type='submit' class='btn btn-danger'>";
        }
        else
        {
            $form.= "<input type='hidden' name='action' value='ajouter' >";
            $form .= "<input value='Ajouter favori' name='submit' type='submit' class='btn btn-primary'>";
        }
            
        
    
    }
}
else //Si OUI, on affiche le formulaire pour modifier son propore profil
{
    if(!isset($_SESSION['userid'])){ //vérifie si la erpsonne est membre et connecté avant de pouvoir faire une candidature
        $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web';
        header('Location: connexion.php');
        die();
    }
    $id=(string)$_SESSION['userid'];
    $user=MAC\Models\Profil::find($id); //Instencie le profil voulu
    
    if (isset($_POST) && (!empty($_POST)) && $_SERVER['REQUEST_METHOD']=='POST')
    {
        //Modification mot de passe
        if (isset($_POST["modification_mdp"]) && !empty($_POST["modification_mdp"]) && $_POST["modification_mdp"] == 1)
        {
            //var_dump($_POST);
            $password =$_POST["password"];
            $password2 =$_POST["password2"];
            if (strlen($password) <= 45)
            {
                if ($password == $password2)
                {
                    if (isset($_POST["recup_mdp"]) && is_numeric($_POST["recup_mdp"]) && $_POST["recup_mdp"] == "1")
                        $user->password_temp = null;    
                    
                    $user->password=(string)$password;
                    
                    if($user->save())
                    {
                        $_SESSION['message']='Votre mot de passe a été modifié avec succès !';
                    }
                    else
                    {
                        $_SESSION['error']='Il y a eu une erreur lors de la modification du mot de passe !';
                    }
                }
                else
                {
                    $_SESSION['error'] ='Les mots de passe ne correspondent pas !';
                }
            }
            else
            {
                $_SESSION['error'] ='Le format du mot de passe est incorrect !';
            }
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "ajouter")//ajout au favori
        {
            var_dump($_POST["favori_id"]);
            $favori =  MAC\Models\Profil::find($_POST["favori_id"]);
            if (isset($favori))
            { 

                $favori = $user->profilFavori()->save($favori);
                if (isset($favori))
                {
                    //header("Location: profil.php?id=".$favori->id);
                    header("Location: profil.php?id=".$favori->id);
                    $_SESSION["message"] = "Le profil a été ajouté à vos favoris !";
                    die();
                }
            }
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "enlever")//enlever des favoris
        {
            var_dump($_POST["favori_id"]);

            $favori =  MAC\Models\Profil::find($_POST["favori_id"]);
            if (isset($favori))
            { 

                $favori = $user->profilFavori()->detach($favori->id);
                if (isset($favori))
                {
                    header("Location: profil.php?id=".$_POST["favori_id"]);
                    $_SESSION["message"] = "Le profil a été enlevé de vos favoris !";
                    
                    die();
                }
            }
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "changerNiveauCompetence")//change le niveau de la compétence
        {
            if (MAC\Models\Profil::find($_SESSION["userid"])->first()->competences()->updateExistingPivot($_POST["competence_id"], ["niveau"=>$_POST["niveau"]]))
            {
                $_SESSION["message"] = "Le niveau a été changé ! ";
            }
            else
            {
                $_SESSION['error'] = "erreur lors de la sauvegarde ! ";
            }
            header("location: profil.php");
            die();
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "supprimer_comp")//enlever une compétence
        {
            //var_dump($_POST);
            $user = MAC\Models\Profil::find($_SESSION["userid"])->first()->competences();
            //var_dump($user->get()->toArray());
            
            //var_dump($user->get()->toArray());
            if($user->detach($_POST["comp_id"]))
            {
                $_SESSION["message"] = "La compétence a été enlevée!";
            }
            else
            {
                $_SESSION['error'] = "erreur lors de la supression de competence ! ";
            }
            header("location: profil.php");
            die();
        }
        elseif(isset($_POST["action"]) && !empty($_POST["action"]) && is_string($_POST["action"]) && $_POST["action"] == "ajout_competence")//ajoute une comptétence
        {
            //var_dump($_POST);
            $competences=[];
            /*foreach($_POST["competence_id"] as $id)
            {
                var_dump($id);
                $competences[] = MAC\Models\Competence::find('id'=>$id);
            }*/
                    
            //var_dump($competences);
            $user=MAC\Models\Profil::find($_SESSION["userid"]);
            try
            {
                if($user->competences()->attach($_POST["competence_id"],["niveau"=>1]))
                {
                    $_SESSION['error'] = "erreur lors de l'ajout de/des competence(s) ! ";
                }
                else
                {     
                    $_SESSION["message"] = "Compétence(s) ajouté";
                }
            }
            catch(\Exception $e)
            {
                $_SESSION['error'] = "La compétence existe déjà ! ";
            }
            
            header("location: profil.php");
            die();
            
        }
        else
        { //Modification du profil
            $pseudo = $_POST["pseudo"];
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
            

            //VERIFICATION DONNÉES
            if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pseudo) && strlen($pays) < 45) // VERIFICATION PSEUDO -- Vérifie si la valeur est correcte
            {
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

                if($user->save()) //enregistre les modifications
                {
                    $_SESSION['message']='Votre profil a été modifié avec succès';
                }
                else
                {
                    $_SESSION['error']=' Il y a eu une erreur lor de la sauvegarde de votre profil';
                }
            }
            else 
            {
                $_SESSION['error'] = $error;
            }
        }
        
        
    } 
}
//COMPETENCES





echo MAC\View::render("profil.twig",["profil"=>$user,"form"=>$form]); //Affichage de la page TWIG


if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
