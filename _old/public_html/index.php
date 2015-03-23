<?php



require_once '../vendor/autoload.php';

$projets=MAC\Models\Projet::where('publier',true)->orderBy('created_at','DESC')->take(10)->get();

echo MAC\View::render('index.twig',["projets"=>$projets]);

if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 

?>
