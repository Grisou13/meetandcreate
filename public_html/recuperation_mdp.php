<?php
/*
 * public_html/recuperation_mdp.php
 * Description : Code pour la récupération du mot de passe. Le formulaire est contenu dans recuperation_mdp.twig
 * Auteur : Eric Bousbaa
 */ 
require_once '../vendor/autoload.php'; // Charge tous les fichiers de configuration

if (isset($_SESSION["connecte"]))
{
   if ($_SESSION["connecte"] == true) // Si l'utilisateur est déjà connecté
    {
        header("Location: ".$_SESSION['retourner_a']); //On le renvoi à l'acceuil
    } 
}

if (isset($_POST) && (!empty($_POST))) //Vérifie si on a reçu un post (formulaire de d'inscription)
{
    if (isset($_POST["email_recup"])) //Si l'email de récupération a été entrée
    {
        $email_recup = $_POST["email_recup"]; //On l'enregistre dans une variable
        $_SESSION["error"] = ""; 
        
        
        
        if(filter_var("$email_recup", FILTER_VALIDATE_EMAIL) && strlen($email_recup) <= 255) //Vérification email
        {
            
            try
            {
               $user = MAC\Models\Profil::where("email",$email_recup)->firstOrFail(); //Intensie l'utilisateur
            }
            catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) //Et on vérifie si l'email est présent dans la base de donnée
            {
                
                $_SESSION["error"] = "Utilisateur non trouvable !"; //Si ce n'est pas le cas, on affiche un message
                
            }
            
            if (isset($user)) //Si la variable "user" exite, l'email est alors présent dans la base de donnée
            {
                
                //GÉNÉRATION DU MAIL
                $mail = new PHPMailer;
                $random = (Illuminate\Support\Str::random(8));
                $mdp_temp = $random;
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'sicmi3a01.cpnv-es.ch';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'sicmi3a01';                 // SMTP username
                $mail->Password = 'EBATRIGLR';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                $mail->From = 'no-reply@sicmi3a01.cpnv-sc.ch';
                $mail->FromName = 'Site Web Banane';
                $mail->addAddress($email_recup, '');     // Add a recipient
                $mail->addReplyTo('root@sicmi3a01.cpnv-es.ch', 'Information');

                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Votre mot de passe "Banane"';
                $mail->Body    = 'Voici votre nouveau mot de passe : '.$mdp_temp.' <\br> Veuillez le changer lors de votre prochaine connexion.';
                $mail->AltBody = 'Voici votre nouveau mot de passe : '.$mdp_temp.'. Veuillez le changer lors de votre prochaine connexion.';
                
                
                $user->password_temp = $mdp_temp; //Change le mot de passe temporaire de l'utilisateur 
                
                if ($user->save()) //Enregistre le nouveau mot de passe temporaire dans la base de donneé
                {
                    $_SESSION["message"] = "Le mot de passe temporaire a été changé "; //Affiche un message d'avertissement
                    if(!$mail->send()) //Si le message n'a pas été envoyé
                    {
                        $_SESSSION["error"] = "Le message n'a pas pu être envoyé $mail->ErrorInfo"; //On affiche un petit message
                     
                    }
                    else 
                    {
                    $_SESSION["message"] = "Nous venons de vous envoyer un email !"; //Si l'email a été envoyé, on averti l'utlisateur
                    }
                }
                else
                {
                    $_SESSION["error"] = "Le mot de passe n'a pas pu être sauvegardé "; //Si l'email n'a pas pu être enregistré dans la BD, on affiche un message
                }
            }
            else
            {
                $_SESSION["error"] = "Email inexistant !"; //Si l'email n'existe pas dans la BD
                header("Location: ".$_SESSION['retourner_a']); //On affiche un  message et le redirige
            }
            
        }
        else 
        {
            $_SESSION["error"] .= "Email invalide !  ";  //Si la chaine de caractère de l'email n'est pas bonne, on affiche un message
        }
        
    }
}
else{
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    //Affichage du formulaire (fichier twig)
    echo MAC\View::render('recuperation_mdp.twig'); 
}

?>
