<?php
/*
 * App/Classes/FacebookAuth.php
 * Description : Classes permettant de connecter un utilisateur avec l'interface facebook, celle-ci a été basé sur fb : http://metah.ch/blog/2014/05/facebook-sdk-4-0-0-for-php-a-working-sample-to-get-started/
 * @author : Thomas Ricci
 */
namespace MAC\Classes;

/*
 * inclusion des librarie facebook 
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
class FacebookAuth {
    protected $session;
    protected $helper;
    protected $scope = ["scope"=>"email"];
    /*
     *  fonction de construction de la classe
     *  @var Facebook\FacebookRedirectLoginHelper $helper client facebook permettant de géré l'authentification
     */
    public function __construct(\Facebook\FacebookRedirectLoginHelper $helper = null){
        $this->helper=$helper;
    }
    /*
     *  désynscrit l'utilisateur logé par le bief de facebook
     *  En supprimant son token d'accès qui est enrigistré dans la session
     */
    public static function logout(){
        unset($_SESSION['f_session']);
    }
    /*
     *  Détermine si l'utilisateur est connecté par facebook
     *  @return bool
     */
    public function isLoggedIn(){
        return isset($_SESSION['f_session']);
    }
    /*
     * Vérifie le code d'accès rendue par l'url d'authentification facebook
     * @return bool
     */
    public function checkRedirectSession(){
        if($session=$this->helper->getSessionFromRedirect()){
            $this->storeUser($this->getUser($session)); //enregistre l'utilsiateur
            $this->session=$session;//enregistre la session dans la classes            
            $_SESSION['f_session']=$session->getToken();//enregistre dans la session le token d'accès facebook            
            return true;
        }
        return false;
    }
    /*
     * Retourne l'utilisateur actuellement connecté par facebook
     * @var Facebook\FacebookSession $session donnée utilisateur
     */
    public function getUser($session){
        if(isset($session)){
            return (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(GraphUser::className());
        }
        return null;
    }
    /*
     * Enregistre l'utilisateur dans la base de données et le log dans notre application
     * @var Facebook\GraphUser $payload donnée utilisateur
     */    
    public function storeUser($payload){
        
        if(isset($payload)){
             $profil=\MAC\Models\Profil::firstOrNew([                
                "email"=>$payload->getProperty('email'),
                "username"=>$payload->getProperty('name'),               
            ]);
            if(!isset($profil->updated_at)){ //si le champ updated_at est null sela signifit que nous créons un model
                $faker = \Faker\Factory::create();
                
                $profil->fbid=$payload->getProperty('id');
                $profil->password=$faker->password; //génère un mot de passe aléatoire, comme cela on ne peut pas brute force le compte
                
                $profil->prenom=$payload->getProperty('first_name');
                $profil->nom=$payload->getProperty('last_name');
                
                if($profil->save()){
                    $_SESSION['message']='merci de vous être connecté';
                }
                else{
                    $_SESSION['error']='Il y a eu une erreur lors de la sauvegarde de votre profil';
                }
            }
            $_SESSION['username'] = $profil->username;
            $_SESSION['userid'] = $profil->id;
            $_SESSION['connecte'] = true;
            
        }
        else{
            $_SESSION['error']='Impossible de vous loger avec Facebook, veuillez réessayer plus tard';
        }
    }
    /*
     *  permet d'avoir accès a l'url d'inscription facebook
     *  @return string url
     */
    public function getAuthUrl(){
        return $this->helper->getLoginUrl($this->scope);
    }
}
