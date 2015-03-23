<?php
require '../vendor/autoload.php';
/* 
 * Gère toute les inscription/candidature/proposition aux projets
 * Thomas : pour la partie des candidature/inscription
 * Guillaume : pour l'affichage des différents projets et des controle
 * Autheur : Thomas Ricci & Guillaume Laubscher
 */
if(!isset($_SESSION['userid'])){ //vérifie si la erpsonne est membre et connecté avant de pouvoir faire une candidature
    $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web';
    header('Location: connexion.php');
    die();
}

if($_SERVER['REQUEST_METHOD']=='POST'){ //détermiine si nous somme en POST, ou GET
    var_dump($_POST);
    $action=$_POST['action']; //permet de determiner ce que nous devons faire avec les données d'une candidature/projet
    switch($action){
        case'inscription':/*création d'une candidature demandé par l'utilisateur*/ //en cours
                if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    $projet_id=$_POST['projet_id'];
                    
                    $projet= MAC\Models\Projet::find($projet_id);
                    $candidature_data=[];
                    $candidature_data['suggereur_id']=null;//il n'y a pas de suggerreur, cela nous eprmet de diffrencier les candidature des propositions
                    $candidature_data['etat_candidature']=null; //on met la candidature a null car nous savons pas si le chef de projet va accpeter ou refuser la personne        
                    $candidature_data['etat_proposition']=true; //on fait une propositions d'inscription que le chef de projet doit accepter
                    $candidature_data['profil_id']=$_SESSION['userid'];
                    $candidature_data['projet_id']=$projet_id;
                    var_dump($candidature_data);
                }
                else{
                    $_SESSION['error']="Vous n'avez pas spécifier de projet";
                }
            break;
        case 'proposition':/*création d'une proposition*/ //en cours
            if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])&&isset($_POST['profil_id'])&&!empty($_POST['profil_id'])){
                
                $projet_id = $_POST['projet_id'];
                $profil_id = $_POST['profil_id']; //est un tableau contenant les id des profils suggérer
                $projet = MAC\Models\Projet::find($projet_id);
                $suggerreur_id=$_SESSION['userid'];//le suggerreur est la personne actuellement connecté
                $candidature_data=[];
                if($suggerreur_id==$projet->createur_id){//ici c'est le chef de projet qui demande quelqun au projet
                    $candidature_data['etat_candidature']=true;//on peut donc poréumé que la candidature de la personne est faite
                    $candidature_data['etat_proposition']=null;
                    $candidature_data['suggerreur_id']=$suggerreur_id;
                    $candidature_data['projet_id']=$projet_id;
                }
                else{//sinon c'est une personne normal du projet, nous verifins donc qu'elle existe dans les candidats du projets
                    $membre_projet=false;//flag permettant de savoir si la personne qui suggere est dans le projet
                    $projet->membres->each(function($membre) use ($suggerreur_id,&$membre_projet){//on parcours tout les membre pour voir si la personne qui a fait la proposition fait partit du projet
                        if($membre->id==$suggerreur_id){
                            $membre_projet = true;
                            return $membre_projet;
                        }
                    });
                    if(!$membre_projet){ //si la personne ne fait pas partit du projet, elle ne peut pas suggerer des personne, on renvoi donc un mesage d'erreur
                        $_SESSION['error']='Vous n\'ête pas membre du projet, pour proposer quelqu\'un il faut faire parti du projet';
                    }
                    else{//la personne fait partit du projet, nous créons la candidature
                        $candidature_data['suggereur_id']=$suggerreur_id;
                        $candidature_data['etat_candidature']=null;
                        $candidature_data['etat_proposition']=null;
                        $candidature_data['projet_id']=$projet_id;
                    }
                }
				foreach($profil_id as $id){
					$candidature_data["profil_id"]=$id;
					$candidature = MAC\Models\Candidature::create($candidature_data);
					if($candidature->save())
						$_SESSION['message']='Vous venez d\'être ajouter dans les candidature du projet';
					else
						$_SESSION["error"]="Une erreur est survenu lors de la création de votre candidature, veuillez réessayer plus tard";
				}
				
            }
            else{
                $_SESSION['error']="Vous n'avez pas spécifiez de projet et/ou de candidats";
            }
            break;
        case 'validation_candidat':
            if(isset($_POST['candidat_id'])&&!empty($_POST['candidat_id'])&&is_numeric($_POST['candidat_id'])){
                $id=$_POST['candidat_id'];
                $candidat=  MAC\Models\Candidature::find($id);
                $etat=(isset($_POST['etat'])&&$_POST['etat']=='accepter')?true:false;
                $candidat->etat_candidature=$etat;
                if($candidat->save()){
                    if($etat)
                        $_SESSION['message']='Vous êtes actuellement membre du projet';
                    else
                        $_SESSION['message']='Vous venez de refusé votre insription au projet';
                }
                else{
                    $_SESSION['error']='une erreur est survenu lors de la sauvegarde de votre proposition';
                }

            }
            break;
        case 'validation_proposition':
            if(isset($_POST['candidat_id'])&&!empty($_POST['candidat_id'])&&is_numeric($_POST['candidat_id'])){
                $id=$_POST['candidat_id'];
                $candidat=  MAC\Models\Candidature::find($id);
                $etat=(isset($_POST['etat'])&&$_POST['etat']=='accepter')?true:false;
                $candidat->etat_proposition=$etat;
                if($candidat->save()){
                   if($etat){
                        if(isset($candidat->etat_candidature)&&$candidat->etat_candidature) //Vérifie si la candidature est déjà accpeter, pour afficher le bon message à l'utilisateur
                            $_SESSION['message']='Vous êtes actuellement membre du projet';
                        else
                            $_SESSION['message']='Vous êtes actuellement dans la liste des candidatures du projet';
                   }
                        
                    else
                        $_SESSION['message']='Vous venez de refusé votre insription au projet';
                }
                else{
                    $_SESSION['error']='une erreur est survenu lors de la sauvegarde de votre proposition';
                }

            }
            break;
        case 'ajout':
            
            break;
        case 'modification':
            if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                if(isset($_POST['createur_id'])&&!empty($_POST['createur_id'])&&is_numeric($_POST['createur_id'])&&$_POST['createur_id']==$_SESSION['userid']){
                    $projet_id = $_POST['projet_id'];
                    $projet = MAC\Models\Projet::find($projet_id);
                    MAC\View::render("modif_projet.twig", ["data"=>["projet"=>$projet]]);
                }
                else{
                    $_SESSION['error'] = "Vous n'êtes pas le créateur de ce projet";
                }
            }
            break;
        case 'suppression':
            
            break;
        case 'publication':
            
            break;
        case 'dépublication':
            
            break;
    }
    header('Location: projet.php');
    die(); //on ne veut pas afficher la page car l'on fait que traiter les données, on termine l'execution de PHP

}
/* Formulaire utilisé pour les différentes action dans la page

 * inscirpition a un projet
  <form method="POST">
   <input type="submit"     name="submit"       value="s'inscrire"                      >
   <input type="hidden"     name="action"       value="inscription"                     >
   <input type="hidden"     name="profil_id"    value="{{session.userid }}"             >
   <input type="hidden"     name="projet_id"    value="{{projet.id}}"                   >

  </form>

 * proposition d'inscription
  <form method="POST" >
   <input type="submit"     name="submit"       value="proposer"                      >
   <input type="hidden"     name="action"       value="proposition"                     >   
   <select name="profil_id[]" multiple   value="propositions"  class="typeahead suggestion-recherche" placeholder="rechercher un profil">
   </select>
   <input type="hidden"     name="projet_id"    value="{{projet.idprojet}}"                   >
  </form>
 <script>
        var profiles = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('username'),
            minLength:2,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: 'recherche.php?action=profil&ajax=true&q=%QUERY'
        });
        profiles.initialize();
        $(".suggestion-recherche").tagsinput({
                itemValue: 'id',
                itemText: function(item) {
                    return item.prenom+' - '+item.nom;
                },
                typeaheadjs: {
                    name: 'projets',
                    displayKey: 'nom',
                    source: profiles.ttAdapter(),
                    templates: {
                        empty: [
                            '<div class="empty-message">',
                            'Nous ne parvenons pas à trouver des filtre adéquat a votre requete',
                            '</div>'
                        ].join('\n'),
                        header: '<h4 class="filtre-header">Tags des projets</h4>',
                        suggestion: Handlebars.compile('<p><strong>{{prenom}}-{{nom}}</strong> - <small>{{username}}</small><br><small>{{description}}</small></p>')
                    }
                }
            });
    </script>
 
 * accpetation des candidature
 <form method="POST" >
   <input type="submit"     name="etat"     value="accepter"      class="btn btn-primary"                  >
   <input type="submit"     name="etat"      value="refuser"       class="btn btn-danger"                  > 

   <input type="hidden"     name="action"       value="validation_candidat"                      >
   <input type="hidden"     name="candidat_id"     value="{{candidat.id}}"                 >
  </form>
* accpetation des porpositions de projet
 <form method="POST" >
   <input type="submit"     name="etat"     value="accepter"      class="btn btn-primary                  >
   <input type="submit"     name="etat"      value="refuser"       class="btn btn-danger                  > 

   <input type="hidden"     name="action"       value="validation_proposition"                      >
   <input type="hidden"     name="candidat_id"     value="{{candidat.id}}"                 >
  </form>

 */
// INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`) VALUES ('1013', '3', '2', NULL, NULL, NULL, NULL)
if(isset($_GET['id'])&&is_numeric($_GET['id'])){ //affichage d'un projet particiulié
    $projet_id = $_GET['id'];
    $projet = MAC\Models\Projet::find($projet_id);
    echo MAC\View::render('affichage_projet.twig',["data"=>["projet"=>$projet]]);
}
else{//affichaage de la gestion des projet/candidature/inscription etc....
    $profil_id=$_SESSION['userid'];
    //$user_project = MAC\Models\Projet::find($profil_id)->userProject((int)$profil_id)->get();
    $projet=  MAC\Models\Profil::find($profil_id)->projet()->get()->toArray();
    $candidature=  MAC\Models\Profil::find($profil_id)->candidatureProjet()->get()->toArray();
    $membres= MAC\Models\Profil::find($profil_id)->membreProjet()->get()->toArray();
    $suggestions=MAC\Models\Profil::find($profil_id)->propositionProjet()->get()->toArray();
    $candidatureRefuser= MAC\Models\Profil::find($profil_id)->candidatureProjet('refuser')->get()->toArray(); //pour notifier a l'utilisatuer les candidature qui lui ont été refusé
    echo MAC\View::render('projet.twig',["data"=>["candidatures"=>$candidature,'membres'=>$membres,'suggestions'=>$suggestions,'candidaturesRefuser'=>$candidatureRefuser,'user_project'=>$projet]]);
}



if (isset($_SESSION["message"]))
{
   unset($_SESSION["message"]);
}
if (isset($_SESSION["error"]))
{
    unset($_SESSION["error"]);
} 
