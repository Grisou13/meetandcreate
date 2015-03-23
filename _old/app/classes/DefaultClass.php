<?php
namespace MAC\Classes;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultClass
 *
 * @author thomas.ricci
 */
abstract class DefaultClass{
    abstract protected function instanciate();
    protected static $instance;  
    //protected static $instance;    
    /*
     * Magic method for calling dynamicly functions of 
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
        if ( ! self::$instance)
        {            
            self::$instance = self::instanciate();
        }
        return self::$instance;
    }
    /*
     * Instanciates the current class with the Twig_Environnement for calling views
     * @return Twig_Environment $twig
     * @author : Thomas Ricci
    */
//    public static function instanciate() 
//    {
//        //instanciate the twig class loader with the path to views directory
//        $loader= new \Twig_Loader_Filesystem(__DIR__.'/views/');
//        
//        $twig = new \Twig_Environment($loader, [
//                'cache' => __DIR__."/views/cache/",
//                'debug'=>true
//            ]);
//        if (session_status() == PHP_SESSION_NONE) {
//            session_start();
//        }
//        
//        $twig->addGlobal('session',$_SESSION);
//        return $twig;
//    }
//    public function __construct()
//    {
//        self::instanciate();
//    }

}
