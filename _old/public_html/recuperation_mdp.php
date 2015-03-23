<?php
// Charge tous les fichiers de configuration
require_once '../vendor/autoload.php';

if (isset($_SESSION["connecte"]))
{
   if ($_SESSION["connecte"] == true) // Si l'utilisateur est déjà connecté
    {
        header("Location: index.php"); //On le renvoi à l'acceuil
    } 
}

if (isset($_POST) && (!empty($_POST))) //Vérifie si on a reçu un post (formulaire de d'inscription)
{
    if (isset($_POST["email_recup"]))
    {
        $email_recup = $_POST["email_recup"]; //Récupération email du formulaire
        $_SESSION["error"] = "";
        
        
        
        if(filter_var("$email_recup", FILTER_VALIDATE_EMAIL) && strlen($email_recup) <= 255) //Vérification email
        {
            
            try
            {
               $user = MAC\Models\Profil::where("email",$email_recup)->firstOrFail(); //Intensie l'utilisateur 
            }
            catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) 
            {
                
                $_SESSION["error"] = "Utilisateur non trouvable !";
                
            }
            
            if (isset($user)) //Vérification si l'email existe
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
                
                if ($user->save())
                {
                    $_SESSION["message"] = "Le mot de passe temporaire a été changé ";
                    if(!$mail->send()) 
                    {
                        $_SESSSION["error"] = "Le message n'a pas pu être envoyé $mail->ErrorInfo";
                     
                    }
                    else 
                    {
                    $_SESSION["message"] = "Nous venons de vous envoyer un email !";
                    }
                }
                else
                {
                    $_SESSION["error"] = "Le mot de passe n'a pas pu être sauvegardé ";
                }
            }
            
            else
            {
                $_SESSION["error"] = "Email inexistant !";
                header("Location: index.php");
            }
            
        }
        else 
        {
            $_SESSION["error"] .= "Email invalide !  "; 
        }
        
    }
}

//Affichage du formulaire (fichier twig)
echo MAC\View::render('recuperation_mdp.twig'); 
?>
