<?php

/* 
 * app/loger.php
 * Ce fichier est utilisé pour géré le début de chaque page,
 * vérification de la page retourner_a,  démmare la session, et enregistre toeu les informations de connexion ( à implementé)
 */
if(session_status()==PHP_SESSION_NONE)
    session_start();
$_SESSION['retourner_a']=isset($_SESSION['retourner_a'])?$_SESSION['retourner_a']:'/index.php';
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

