<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/*Sert à instancier la base de données et l'ORM Eloquent*/

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
// Set the event dispatcher used by Eloquent models
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

$capsule->setAsGlobal();
$capsule->bootEloquent();