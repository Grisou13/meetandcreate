<?php
require "../vendor/autoload.php";

 
$query=(isset($_GET['q'])&&!empty($_GET['q']))?urldecode($_GET['q']):null;
$ajax=isset($_GET["ajax"])?true:false;//check si la requete est ajax

$action=isset($_GET['action'])?$_GET['action']:null;//détzermine l'action a effectué, renvoyer des tags, compétence ou une query sur les profiles et projets
$data=null;
$filtre=[];//variable tampon pour les filtres

$tags=(isset($_GET['tag'])&&!empty($_GET['tag']))?($_GET['tag']):null; /*a refaire*/
$competences=(isset($_GET['competence'])&&!empty($_GET['competence']))?($_GET['competence']):null; /*a refaire*/

if($ajax){/*request est une requete utilisant typeahead*/
    switch($action)
    {
        case 'competence':
            $data=MAC\Models\Competence::where('competence','LIKE',"{$query}%")->get()->toJson();
            break;
        case 'tag':
            $data=MAC\Models\Tag::where('nom','LIKE',"{$query}%")->get()->toJson();
            break;
        case 'profil':            
            $data=MAC\Models\Profil::where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->orWhere("email","LIKE","%{$query}%")->get()->each(function(&$profil){
                $profil->description= Illuminate\Support\Str::limit($profil->description, '70','....'); //limite la description 1 70 caractère pour la recherche par ajax, sinon celle-ci devient trop grande et prends trop de place
            })->toJson();
            break;
        case 'projet':
             $data=MAC\Models\Projet::where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"%{$query}%")->get()->each(function(&$projet){
                $projet->description= Illuminate\Support\Str::limit($projet->description, '70','....');//limite la description 1 70 caractère pour la recherche par ajax, sinon celle-ci devient trop grande et prends trop de place
            })->toJson(); //->andWhere('publier', (isset($_SESSION['userid'])?true:false) )
            break;
        default: /*Query basic, renvoi tout*/ /*a refaire avec une nouvelle implémentation plus rapide*/
            $profils=MAC\Models\Profil::where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->orWhere("email","LIKE","%{$query}%")->get()->toJson();
            $projets=MAC\Models\Projet::where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"%{$query}%")->get()->toJson(); //->andWhere('publier', (isset($_SESSION['userid'])?true:false) )
            
            $data=  "{ \"profiles\":{$profils},\"projets\":{$projets} }";
            break;
    }

}
else{ /*Regular query page, output the data to the user*/

    switch($action)
    {
        case 'competence':                
            $data[]=MAC\Models\Competence::where('competence','LIKE',"{$query}%")->get();
            break;
        case 'tag':
            $data[]=MAC\Models\Tag::where('nom','LIKE',"{$query}%")->get();
            break;
        default: /*a refaire avec une nouvelle implémentation plus rapide*/
            /*recherche sans filtre*/
            $profils= Illuminate\Database\Eloquent\Collection::make([]); //création dûne collection eloquent vide pour les profils
            $projets= Illuminate\Database\Eloquent\Collection::make([]); //création dûne collection eloquent vide pour les projets
            if(isset($query)){ //affiche seulement les profiles et projets suivant la query demandé
                MAC\Models\Profil::where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->get()->each(function($profil) use(&$profils){
                    $profils->add($profil);
                });//rajoute le profil dans la collection de profil
                MAC\Models\Projet::where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"%{$query}%")->get()->each(function($projet) use (&$projets){
                    $projets->add($projet);
                });
            }
            
            /*recherche avec filtre*/
            /* peut etre changé grace à ::find([tableau d'id])*/
            if(isset($tags)){ //si nous avons une liste de tags, nous devons rechercher les projet avec les tags
                $a=$tags;
                $b=  array_filter($a, 'is_numeric');
                if($a===$b){//test pour savoir si nous avons reçu des id numerics
                    $tags= MAC\Models\Tag::find($a);//reconstruction des filtre utilisé avec le nom et l'id pourt l'affichage à l'utilisteur
                    if (isset($query)){//si nous avons une query, nous devons la reprendre pour permettre de savoir si les projets avec les tag demandé contienne les critères de la query
                        MAC\Models\Tag::find($a)->each(function($projet) use (&$projets,$query){
                                $projet->projets()->where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"{$query}%")->get()->each(function($proj) use($projets) {
                                    $projets->add($proj);
                                });
                        });
                    }
                    else{//sinon, nous affichons tout les projets seulement avec les tags demandé
                        MAC\Models\Tag::find($a)->each(function($tag)use(&$projets){
                                $tag->projets->each(function($proj) use ($projets){
                                    $projets->add($proj);
                                });
                        });
                    }
                }
            }
            if(isset($competences)){ //si nous avons une liste de compétence a rechercher, nous devons les inclure dans la recherche
                $a=$competences;
                $b=  array_filter($a, 'is_numeric');
                if($a===$b){//test pour savoir si nous avons reçu des id numerics
                    $competences =  MAC\Models\Competence::find($a);//reconstruction des filtre utilisé avec le nom et l'id pourt l'affichage à l'utilisteur
                   
                    if (isset($query)){//si nous avons une query, nous devons la reprendre pour permettre de savoir si les profil avec les tag demandé contienne les critères de la query
                        MAC\Models\Competence::find($a)->each(function($comp) use ($query,&$profils){
                            $comp->profils()->where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->get()->each(function($profil)use($profils){
                                $profils->add($profil);
                            });
                        });
                    }
                    else{ //sinon, nous affichons tout les profil seulement avec les tags demandé
                        MAC\Models\Competence::find($a)->each(function($comp)use(&$profils){
                            $comp->profils->each(function($profil) use ($profils){
                                $profils->add($profil);
                            });
                        });                      
                        
                    }
                }
            }
            
            if(isset($query)){//inscrit les logs de la recherche si nous avons une recherche, en format JSON
                
                $historique= MAC\Models\Recherche::create([
                    "query"=>$query,
                    "profil_id"=>isset($_SESSION['userid'])?$_SESSION['userid']:null,
                    "tags"=>isset($tags)?json_encode($tags->lists('id')):null,
                    "competences"=>isset($competences)?json_encode($competences->lists('id')):null,
                    "profil_id"=>isset($_SESSION['userid'])?$_SESSION['userid']:null
                ]);
            }
            /*permet de savoir si nous arrivons sur la page pour la première fois*/
            $data['first']=empty($_SERVER['QUERY_STRING'])?true:null;
            /*remet la query pour l'afficher a l'utilisateur denouveau*/
            $data['query']=$query;
            /*remet les filtres pour l'afficher a l'utilisateur denouveau*/
            $data['filtre']['tags']=$tags;
            $data['filtre']['competences']=$competences;
            /*met les données des profiles que l'ont a obtenu*/
            $data["profiles"]=$profils->unique();
            $data["projets"]= $projets->unique();
            break;
    }  
}


if(!$ajax){ //renvoi le resultat sur la page de recherche
    $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
    echo MAC\View::render('recherche.twig',["data"=>$data]);
}
else{//renvoi les données en format JSON si nous faisons une requete ajax
    header('Content-Type: application/json');
    echo $data;
    die();
}

if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 