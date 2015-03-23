<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 30.11.2014
 * Time: 16:00
 */

namespace MAC;

class View{
    
    protected $twig;
    protected static $instance;    
    /*
     * Magic method for calling dymicly functions of Twig_Environnement
     * @author : Thomas Ricci
    */
    public function __call($method,$args)
    {
        
        $instance = self::instance();
        
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
     * Magic method for calling dymicly static functions of Twig_Environnement
     * @author : Thomas Ricci
     */
    public static function __callStatic($method,$args)
    {
        $instance = self::instance();

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
     * Returns the current instance
     * @return Twig_Environment $twig
     * @author : Thomas Ricci
    */
    public static function instance()
    {
        if ( ! static::$instance)
        {            
            static::$instance = self::instanciate();
        }
        return static::$instance;
    }
    /*
     * Instanciates the current class with the Twig_Environnement for calling views
     * @return Twig_Environment $twig
     * @author : Thomas Ricci
    */
    public static function instanciate() 
    {
        //instanciate the twig class loader with the path to views directory
        $loader= new \Twig_Loader_Filesystem(__DIR__.'/views/');
        
        $twig = new \Twig_Environment($loader, [
                'cache' => __DIR__."/views/cache/",
                'debug'=>true
            ]);
        $twig->addFilter('var_dump', new \Twig_Filter_Function('var_dump'));
        $twig->addExtension(new \Twig_Extension_Debug());
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $twig->addGlobal('session',$_SESSION);
        $twig->addGlobal('post',$_POST);
        $twig->addGlobal('get',$_GET);
        return $twig;
    }
}