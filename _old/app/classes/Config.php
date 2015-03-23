<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author thomas.ricci
 */
namespace MAC\Classes;

class Config {
    protected static $instance;
    protected $path="../config/";
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
     * Instanciates the current class
     * @return Twig_Environment $twig
     * @author : Thomas Ricci
    */
    public static function instanciate() 
    {
        return new MAC\Classes\Config();
    }
}
