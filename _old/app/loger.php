<?php

/* 
 * Logger de data pour loger l'accès à notre site web, cela permetant de générer par après des graphique d'utilisation
 */
if(session_status()==PHP_SESSION_NONE)
    session_start();
$r = array();
// Date & Time
$r['datetime'] = date('Y-m-d H:i:s');
// IP
$r['ip'] = $_SERVER['REMOTE_ADDR'];
// Hostname
//$r['hostname'] = gethostbyaddr($r['ip']);
// URI
$r['uri'] = $_SERVER['REQUEST_URI'];
// Browser
$r['agent'] = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "";
// Referer
$r['referer'] = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "";
// Domain
$r['domain'] = $_SERVER["HTTP_HOST"];
// Script file name
$r['filename'] = $_SERVER["SCRIPT_FILENAME"];
// Method
$r['method'] = $_SERVER["REQUEST_METHOD"];
// Query (GET data)
/*$r['query'] = $_SERVER["QUERY_STRING"];
// POST data
$r['post'] = file_get_contents("php://input");*/
// data
$r['data'] = trim( $_SERVER["QUERY_STRING"] . " " . file_get_contents("php://input") );

$r['session'] = $_SESSION;

//var_dump($r);

