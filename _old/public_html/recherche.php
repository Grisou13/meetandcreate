<?php
require "../vendor/autoload.php";

function multi_unique($array) {
    for($i=count($array)-1;$i>=0;$i--){
        if($i>0){
            if($array[$i]['id']==$array[$i-1]['id']){
                unset($array[$i]);
            }
        }
    }
    return $array;
    
}
function remove_level($array) {
      $result = array();
      foreach ($array as $key => $value) {
        if (is_array($value)) {
          $result = array_merge($result, $value);
        }
      }
      return $result;
}
    
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
            
            $data=MAC\Models\Profil::where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->get()->each(function(&$profil){
                $profil->description= Illuminate\Support\Str::limit($profil->description, '70','....'); //limite la description 1 70 caractère pour la recherche par ajax, sinon celle-ci devient trop grande et prends trop de place
            })->toJson();
            break;
        case 'projet':
             $data=MAC\Models\Projet::where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"%{$query}%")->get()->each(function(&$projet){
                $projet->description= Illuminate\Support\Str::limit($projet->description, '70','....');//limite la description 1 70 caractère pour la recherche par ajax, sinon celle-ci devient trop grande et prends trop de place
            })->toJson(); //->andWhere('publier', (isset($_SESSION['userid'])?true:false) )
            break;
        default: /*Query basic, renvoi tout*/ /*a refaire avec une nouvelle implémentation plus rapide*/
            $profils=MAC\Models\Profil::where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->get()->toJson();
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
            $profils=[];
            $projets=[];
            if(isset($query)){ //affiche seulement les profiles et projets suivant la query demandé
                $profils=MAC\Models\Profil::where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->get();
                $projets=MAC\Models\Projet::where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"%{$query}%")->get(); //->andWhere('publier', (isset($_SESSION['userid'])?true:false) )
            }
            
            /*recherche avec filtre*/
            /* peut etre changé grace à ::find([tableau d'id])*/
            if(isset($tags)){ //si nous avons une liste de tags, nous devons rechercher les projet avec les tags
                $a=$tags;
                $b=  array_filter($a, 'is_numeric');
                if($a===$b){//test pour savoir si nous avons reçu des id numerics
                    $tags= MAC\Models\Tag::find($a)->toArray();//reconstruction des filtre utilisé avec le nom et l'id pourt l'affichage à l'utilisteur
                    if (isset($query))//si nous avons une query, nous devons la reprendre pour permettre de savoir si les projets avec les tag demandé contienne les critères de la query
                            $projets=MAC\Models\Tag::find($a)->each(function($proj){
                                    return $proj->projets()->where('titre','LIKE',"{$query}%")->orWhere('description' ,'LIKE',"{$query}%")->get();
                            });
                    else{//sinon, nous affichons tout les projets seulement avec les tags demandé
                            MAC\Models\Tag::find($a)->each(function($tag)use(&$projets){
                                    $projets[] = $tag->projets->toArray();
                            });
                    }
                }
                $projets=remove_level(array_merge($projets));
            }
            if(isset($competences)){ //si nous avons une liste de compétence a rechercher, nous devons les inclure dans la recherche
                $a=$competences;
                $b=  array_filter($a, 'is_numeric');
                if($a===$b){//test pour savoir si nous avons reçu des id numerics
                    $competences =  MAC\Models\Competence::find($a)->toArray();//reconstruction des filtre utilisé avec le nom et l'id pourt l'affichage à l'utilisteur
                    $temp=[];//variable temporaire pour contenir tous les profils par compétences
                    if (isset($query)){//si nous avons une query, nous devons la reprendre pour permettre de savoir si les profil avec les tag demandé contienne les critères de la query
                        MAC\Models\Competence::find($a)->each(function($comp) use ($query,&$temp){
                            $temp= $comp->profils()->where('username','LIKE',"{$query}%")->orWhere('nom' ,'LIKE',"{$query}%")->orWhere('prenom' ,'LIKE',"{$query}%")->get();
                        });
                    }
                    else{ //sinon, nous affichons tout les profil seulement avec les tags demandé
                        MAC\Models\Competence::find($a)->each(function($comp)use(&$temp){
                            $temp = $comp->profils;
                        });
                        
                        
                    }
                    $temp=  ($temp->unique());
                    //var_dump($temp);
                    //($profils);
                    $test= Illuminate\Database\Eloquent\Collection::make([$temp,$profils]);
                    var_dump($test);
                    //$temp->add($profils);
                    var_dump($temp);
                }
                
            }
            /*permet de savoir si nous arrivons sur la page pour la première fois*/
            $data['first']=empty($_SERVER['QUERY_STRING'])?true:null;
            /*remet la query pour l'afficher a l'utilisateur denouveau*/
            $data['query']=$query;
            /*remet les filtres pour l'afficher a l'utilisateur denouveau*/
            $data['filtre']['tags']=$tags;
            $data['filtre']['competences']=$competences;
            /*met les données des profiles que l'ont a obtenu*/
            $data["profiles"]=$profils; // http://php.net/manual/fr/function.array-unique.php#70786
            $data["projets"]= $projets;
            break;
    }  
}


if(!$ajax){ //renvoi le resultat sur la page de recherche
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