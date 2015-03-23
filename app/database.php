<?php
/* 
 * app/database.php
 * Descipriton : Sert à instancier la base de données et l'ORM Eloquent
 * @author Thomas Ricci
 */
if (session_status() == PHP_SESSION_NONE) { //démmare la session
    session_start();
}


use Illuminate\Database\Capsule\Manager as Capsule;
//instantiate the capsule
$capsule = new Capsule;
//create connection
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'sicmi3a01_Banane',
    'username' => 'sicmi3a01',
    'password' => 'EBATRIGLR',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
// Set le dispatcher d'événemnt pour Eloquent
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

$capsule->setAsGlobal();//rend eloquent utilisable partout
$capsule->bootEloquent();//démmare eloquent