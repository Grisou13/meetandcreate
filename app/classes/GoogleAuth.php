<?php
/*
 * App/Classes/GoogleAuth.php
 * Description : Classes permettant de connecter un utilisateur avec l'interface google+, celle-ci a été repris et modifié de https://www.youtube.com/watch?v=tq24CY8gA4I
 * @author : Thomas Ricci
 */
namespace MAC\Classes;
class GoogleAuth {
    
    protected $client;
    protected $plus;
    protected $clientID='822362822751-rson52o3vdso9mbgfl78g4ia50s5jjih.apps.googleusercontent.com';
    protected $clientSecret='jeirmKys_11v2HZe-0rXrvRv';
    protected $redirectURI='http://sicmi3a01.cpnv-es.ch/connexion_media.php?media=google';
    protected $scope=[  
                        "https://www.googleapis.com/auth/userinfo.email",
        "https://www.googleapis.com/auth/plus.me",
                        
                        ];
    protected $token;
    protected $refresh_token;
    /*
     *  fonction de construction de la classe
     *  @var Google_Client $client client google permettant d'authentifier la personne
     *  @var Google_Service_Plus $plus service google api permettant d'avoir accès aux donnée de l'utilisateur
     */
    public function __construct(\Google_Client $google_client = null,  \Google_Service_Plus $plus = null){
        
        $this->client = $google_client;
        $this->plus=$plus;
        if(isset($this->client)&&isset($this->plus)){
            $this->client->setClientId($this->clientID);
            $this->client->setClientSecret($this->clientSecret);
            $this->client->setRedirectUri($this->redirectURI);
            $this->client->setScopes($this->scope);
        }
    }
    /*
     *  désynscrit l'utilisateur logé par le bief de google
     *  En supprimant son token d'accès qui est enrigistré dans la session
     */
    static public function logout(){
        unset($_SESSION['g_access_token']);
    }
    /*
     *  Détermine si l'utilisateur est connecté par google
     *  @return bool
     */
    public function isLoggedIn(){
        return isset($_SESSION['g_access_token']);
    }
    /*
     *  permet d'avoir accès a l'url d'inscription google
     *  @return string url
     */
    public function getAuthUrl(){
        return $this->client->createAuthUrl();
    }
    /*
     *  inscrit le token d'accès dans la session et dans le client google
     */
    protected function setToken($token){        
        $_SESSION['g_access_token']=$token;         
        $this->client->setAccessToken($token);
        $this->token=$token;        
    }
    /*
     * Permet d'accéder aux données de l'utilisateur par google+
     * @return Google_Service_Plus_Person       
     */
    protected function getUserData(){
        if($this->plus){
            return $this->plus->people->get('me');
        }
        return null;
    }
    /*
     * Permet d'accéder aux données du token d'accès   
     */
    protected function getPayload(){ //returns all information on user info
        if($this->client->getAccessToken()){
            $payload=$this->client->verifyIdToken()->getAttributes()['payload'];
            return $payload;
        }
        return null;
    }
    /*
     * Enregistre l'utilisateur dans la base de données et le log dans notre application
     * @var Google_Service_Plus_Person $payload donnée utilisateur
     */
    protected function storeUser($payload){        
        if(isset($payload)){//si nous avons des données nous pouvons crée l'utilisateur
            var_dump($payload->displayName);
            $profil= \MAC\Models\Profil::updateOrCreate([                
                "email"=>$payload->emails[0]->value,
                "username"=>$payload->displayName,
                "prenom"=>$payload->name->givenName,
                "nom"=>$payload->name->familyName    
            ]);
            if(!isset($profil->id)){ //si le champ id est null sela signifit que nous n'avons pas trouvé de profil
                $faker = \Faker\Factory::create();
                
                $profil->gid=$payload->id;
                $profil->password=$faker->password; //génère un mot de passe aléatoire, comme cela on ne peut pas brute force le compte
                
                /*$profil->prenom=$payload->name->givenName;
                $profil->nom=$payload->name->familyName;*/
                
                if($profil->save()){
                    $_SESSION['message']='merci de vous être connecté';
                }
                else{
                    $_SESSION['error']='Il y a eu une erreur lors de la sauvegarde de votre profil';
                }
            }
            $_SESSION['username'] = $profil->username;//enregistre tout les paramètre necessaire dans la session
            $_SESSION['userid'] = $profil->id;
            $_SESSION['connecte'] = true;
        }
        else{
            $_SESSION['error']='imposible d\'authenitifier par google';
        }
    }
    /*
     * Vérifie le code d'accès rendue par l'url d'authentification google
     * @return bool
     */
    public function checkRedirectCode(){
        //si nous sommes redirigé par google et que nous avons un code de retour
        if (isset($_GET['code']) && !empty($_GET['code'])){                     
            $this->client->authenticate($_GET['code']); //authentifie auprès du client google
            $this->setToken($this->client->getAccessToken()); //définit le jeton d'accès            
            $this->storeUser($this->getUserData()); //enregistre les données de l'utilisateur
            return true;
        }
        //si le token est déjà dans la session
        if (isset($_SESSION['g_access_token']) && $_SESSION['g_access_token']) {            
            $this->setToken($_SESSION['g_access_token']);//définit le jeton d'accès      
            $this->storeUser($this->getUserData()); //enregistre les données de l'utilisateur
            return true;
        }
        return false;
    }
}
