<?php
/* 
 * app/view.php
 * Descipriton : Classe permettant d'utiliser Twig sans instanciement récurent de celui-ci dans chaque page
 * @author Thomas Ricci
 */

namespace MAC;

class View{
    
    protected $twig;
    protected static $instance;    
    /*
     * method magic permettant de créer dynamiquent tout les appels de fonction a l'environnement Twig
     * @return function fonction
    */
    public function __call($method,$args)
    {
        
        $instance = self::instance();//s'instancie
        
        switch (count($args))
        {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }
    /*
     * method magic permettant de créer dynamiquent tout les appels de fonction de manière static a l'environnement Twig
     * @return function
     */
    public static function __callStatic($method,$args)
    {
        $instance = self::instance();//s'instancie

        switch (count($args))
        {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }
    /*
     * Retourne l'instance cournate de twig
     * @return Twig_Environment $twig
     * @author : Thomas Ricci
    */
    public static function instance()
    {
        if ( ! static::$instance)//si aucune instance n'est prséente
        {            
            static::$instance = self::instanciate(); //instancie Twig
        }
        return static::$instance;
    }
    /*
     * Instantie twig pour être utilisable dans la classe actuel
     * @return Twig_Environment $twig
    */
    public static function instanciate() 
    {
        
        //instanciate twig class loader avec le chemin jusqu'au vue
        $loader= new \Twig_Loader_Filesystem(__DIR__.'/views/');
        
        $twig = new \Twig_Environment($loader, [
                'cache' => __DIR__."/views/cache/",
                'debug'=>true
            ]);//définit les paramètre de l'environnement
        $twig->addFilter('var_dump', new \Twig_Filter_Function('var_dump'));//rajoute var_dump comme fonctionnalité pour twig
        $twig->addExtension(new \Twig_Extension_Debug());//authorize les commande de débug avec les fichier Twig
        if (session_status() == PHP_SESSION_NONE) { //démmarre la session
            session_start();
        }
        
        $twig->addGlobal('session',$_SESSION);//rajoute a twig la superglobal SESSION
        $twig->addGlobal('post',$_POST);//rajoute a twig la superglobal POST
        $twig->addGlobal('get',$_GET);//rajoute a twig la superglobal GET
        $profil_actuel=null;
        if(isset($_SESSION['userid']))//si l'utilisateur est logé, nous mettons dans l'environnement twig son profil pour permettre d'être utilisable directement dans twig
            $profil_actuel=  Models\Profil::find($_SESSION['userid']);
        $twig->addGlobal('this',$profil_actuel);
        return $twig;
    }
}