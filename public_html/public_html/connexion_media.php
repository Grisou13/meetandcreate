<?php
require_once '../vendor/autoload.php';
/* 
 * Permet de se connceter au site par différent média, tel que facebook, google ou linkdin
 * tuto login avec fb : http://metah.ch/blog/2014/05/facebook-sdk-4-0-0-for-php-a-working-sample-to-get-started/
 */
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] == true && isset($_SESSION['userid'])) // Si l'utilisateur est déjà connecté
{
    header("Location: ".$_SESSION['retourner_a']); //On le renvoi à l'acceuil
    die();
}
if(isset($_GET['media'])&&!empty($_GET['media'])&&  is_string($_GET['media'])){
    switch($_GET['media']){
        case 'facebook':           
            $session=Facebook\FacebookSession::setDefaultApplication('779285952166138', '7b9842670cc14d2f7410d0658fa9d657');
            $helper = new Facebook\FacebookRedirectLoginHelper('http://sicmi3a01.cpnv-es.ch/connexion_media.php?media=facebook');
            
            try {
                $fbsession = $helper->getSessionFromRedirect();
            } 
            catch( FacebookRequestException $ex ) {
                // When Facebook returns an error
            } 
            catch( Exception $ex ) {
                // When validation fails or other local issues
            }

            // see if we have a session
            if ( isset( $fbsession ) ) {
                try {//essaye d'obtenir les info de la personne
                    $fbprofil = (new FacebookRequest(
                        $fbsession, 'GET', '/me'
                    ))->execute()->getGraphObject(GraphUser::className());

                    $profil=MAC\Models\Profil::firstOrNew(["fbid"=>$fbprofil->getProperty('id'),"email"=>$fbprofil->getProperty('email')]);
                    
                    $profil->prenom=$fbprofil->getProperty('first_name');
                    $profil->nom=$fbprofil->getProperty('last_name');
                    $profil->username=$fbprofil->getProperty('name');
                    $profil->email=$fbprofil->getProperty('email'); //comme cela on interagis paas avec l'authentification de eric
                    $profil->fbid=$fbprofil->getProperty('id');
                    $profil->password= Illuminate\Support\Str::random(60);//crée un mot de passe aléatoire a chaque connexion (impossibilité a l'utilsiatue rde se connceter avec son adress email
                        
                    if($profil->save()){
                        $_SESSION['connecte']=true;
                        $_SESSION['userid']=$profil->id;
                        $_SESSION['username']=$profil->username;
                    }
                } 
                catch(FacebookRequestException $e) {
                    //Il y a eu un probleme avec facebook                    
                    $_SESSION['error']=$e->getMessage();
                }                
            } else {
                // Redirige la personne sur le login facebook
                header('Location: '.$helper->getLoginUrl(['scope'=>'email']));
                die();
            }
            
            
            break;
        case 'google':
            $client= new Google_Client();
            $auth= new MAC\Classes\GoogleAuth($client);         
            
            if($auth->checkRedirectCode()){
                
                header('Location: index.php');
            }
            else{
                
                header('Location: '.$auth->getAuthUrl());
            }
            die();
            break;
        default:
            echo'mais quesque tu fous la toi';
            break;
    }
    
}
header('Location: '.$_SESSION['retourner_a']);

die();