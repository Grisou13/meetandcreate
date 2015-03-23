<?php
require '../vendor/autoload.php';
use Carbon\Carbon;
/* 
 * Public_html/projet.php
 * Gère toute les inscription/candidature/proposition aux projets
 * Thomas : pour la partie des candidature/inscription
 * Guillaume : pour l'affichage des différents projets et des controle
 * @author Thomas Ricci
 * @author Guillaume Laubscher
 */
$projet;
if(!isset($_SESSION['userid'])){ //vérifie si la erpsonne est membre et connecté avant de pouvoir faire une candidature
    $_SESSION['error']='Vous devez être connecté pour acceder à cet zone du site web';
    header('Location: connexion.php');
    die();
}

if($_SERVER['REQUEST_METHOD']=='POST'){ //détermiine si nous somme en POST, ou GET
    $action=$_POST['action']; //permet de determiner ce que nous devons faire avec les données d'une candidature/projet
    switch($action){
        case 'enlever_tag':           
            if(isset($_POST['projet_id'])&&  is_numeric($_POST['projet_id'])&&isset($_POST['tag_id'])&&  is_numeric($_POST['tag_id'])){
                $projet = MAC\Models\Projet::find($_POST['projet_id']);
                if($projet->createur_id==$_SESSION['userid']){ //détermine si la personne est bien le créateur du projet
                    if($projet->tags()->detach($_POST["tag_id"]))
                    {
                        $_SESSION["message"] = "Le tag a été enlevée!";
                    }
                    else
                    {
                        $_SESSION['error'] = "erreur lors de la supression de competence ! ";
                    } 
                }
                else{
                    $_SESSION['error']='Vous n\'êtes pas le créateur du projet!';
                }
                
            }
            else{
                 $_SESSION['error']='Aucun projet n\'a été donné';
            }
                   
        break;
        case 'ajout_tag':
            if(isset($_POST['projet_id'])&&  is_numeric($_POST['projet_id'])&&isset($_POST['tag_id'])&&!empty($_POST['tag_id'])){//vérifie que nous avons des données
            
                $projet=MAC\Models\Projet::find($_POST['projet_id']);
                if($projet->createur_id==$_SESSION['userid']){ //vérifie si la personne est bien le créateur du projet
                    try
                    {
                        if($projet->tags()->attach($_POST["tag_id"]))//rajoute au tags les ids de tag demandé
                        {
                            $_SESSION['error'] = "erreur lors de l'ajout de/des competence(s) ! ";
                        }
                        else
                        {     
                            $_SESSION["message"] = "Tag(s) ajouté";
                        }
                    }
                    catch(\Exception $e)//le tag existerait déjà
                    {
                        $_SESSION['error'] = "le Tag existe déjà ! ";
                    }
                }
                else{
                    $_SESSION['error']='Vous n\'êtes pas le créateur du projet!';
                }
                
            }
            else{
                 $_SESSION['error']='Aucun projet n\'a été donné';
             }
        break;
        
        case'evaluation_membre': // note d'un utilisateur
            if(isset($_POST['evalue_id'])&&is_numeric($_POST['evalue_id'])&&isset($_POST['projet_id'])&&is_numeric($_POST['projet_id'])&&isset($_POST['niveau'])&&is_numeric($_POST['niveau']))
            {
                $note= MAC\Models\NoteProfil::firstOrNew(["profil_id"=>$_POST['evalue_id'],"evalueur_id"=>$_SESSION['userid'],"projet_id"=>$_POST['projet_id']]);//crée une note ou la met a jour avec l'évaluation
                $note->note=$_POST['niveau'];                
                if ($note->save())
                {
                    $_SESSION["message"] = "La note a été changé ! ";
                }
                else
                {
                    $_SESSION['error'] = "erreur lors de la sauvegarde de la note ! ";
                }
                
            }         
        break;
        case'inscription':/*création d'une candidature demandé par l'utilisateur*/
                if(isset($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    
                    $projet_id=$_POST['projet_id'];
                    
                    $projet= MAC\Models\Projet::find($projet_id);
                    
                    if(!$projet->isMembre($_SESSION['userid'])){//si le profil n'est pas déjà dans les membres
                        $candidature=MAC\Models\Candidature::where('projet_id',$projet_id)->where('profil_id',$_SESSION['userid'])->get();
                        if($candidature->count()){// s'il y a une candidature déjà dans les propositions de la personne, on l'a met a jours
                            $candidature=$candidature->first();
                            $candidature->etat_proposition=true;
                            if($candidature->save()){
                                $_SESSION['message']='Vous êtes actuellement membre du projet, il était dans vos suggestions';
                            }
                            else{
                                $_SESSION['error']='Il y a eu un erreur lors de la sauvegarde de votre candidature, veuillez réessayer plus tard';
                            }
                        }
                        else{//sinon nous créaons une candidature de 0
                            $candidature_data=[];
                            $candidature_data['suggereur_id']=null;//il n'y a pas de suggerreur, cela nous eprmet de diffrencier les candidature des propositions
                            $candidature_data['etat_candidature']=null; //on met la candidature a null car nous savons pas si le chef de projet va accpeter ou refuser la personne        
                            $candidature_data['etat_proposition']=true; //on fait une propositions d'inscription que le chef de projet doit accepter
                            $candidature_data['profil_id']=$_SESSION['userid'];
                            $candidature_data['projet_id']=$projet_id;
                            $candidature= MAC\Models\Candidature::firstOrNew($candidature_data);//par sécurité, permettre de vérifié si nous ouvons sauvegardé le model
                            if($candidature->save()){
                                $_SESSION['message']='Vous êtes actuellement dans les liste de candidat du projet';
                            }
                            else{
                                $_SESSION['error']='Il y a eu un eerreur lors de la sauvegarde de votre candidature, veuillez réessayer plus tard';
                            }
                        }
                    }
                    else{
                        $_SESSION['error']='Vous êtes déjà membre du projet';
                    }                    
                }
                else{
                    $_SESSION['error']="Vous n'avez pas spécifier de projet";
                }                
            break;
        case 'proposition':/*création d'une proposition*/
            if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])&&isset($_POST['profil_id'])&&!empty($_POST['profil_id'])){
                
                $projet_id = $_POST['projet_id'];
                $profil_id = $_POST['profil_id']; //est un tableau contenant les id des profils suggérer
                $projet = MAC\Models\Projet::find($projet_id);
                $suggerreur_id=$_SESSION['userid'];//le suggerreur est la personne actuellement connecté
                
                if($suggerreur_id!=$profil_id){//détermine si la personne faisans la proposition n'est pas elle meme
                    if($suggerreur_id==$projet->createur_id){//ici c'est le chef de projet qui demande quelqun au projet
                        $candidature_data['etat_candidature']=true;//on peut donc poréumé que la candidature de la personne est faite
                        $candidature_data['etat_proposition']=null;
                        $candidature_data['suggerreur_id']=$suggerreur_id;
                        $candidature_data['projet_id']=$projet_id;     
                    }
                    else{//sinon c'est une personne normal, nous verifions donc qu'elle existe dans les candidats du projets
                        $membre_projet=$projet->isMembre($suggerreur_id);//détermine si la personne qui suggere est dans le projet
                        
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
                    if(!isset($_SESSION['error'])){//si nous n'avons pas d'erreur nous pouvons continuer l'inscription
                        foreach ($_POST['profil_id'] as $pid){
                            $candidature_data['profil_id']=$pid;

                            $cand = MAC\Models\Candidature::firstOrNew(["projet_id"=>$candidature_data['projet_id'],"profil_id"=>$candidature_data['profil_id']]); //crée ou non une candidature avec le numero du seggerreur ainsi que la paersonne
                            
                            if($cand->etat_candidature){//vérifie si nous ne créons pas de doublons
                                $_SESSION['error'].='Le profil est déjà dans les membres !';
                                continue;//passe au tour de boucle suivant
                            }
                            else{
                                $cand->etat_candidature=$candidature_data['etat_candidature'];
                                $cand->etat_proposition=$candidature_data['etat_proposition'];
                                $cand->suggereur_id=$candidature_data['suggereur_id'];
                                if($cand->save())//sauvegarde la candidature
                                    $_SESSION['message']='La proposition a été prise en compte dans le projet';
                                else
                                    $_SESSION['error'].='Il y a eu une erreur lors de la création de la proposition, veuillez réessayer plus tard ';
                                
                            }                            
                        }
                    }
                }
                else{
                    $_SESSION['error']="Vous venez de vous suggerer";
                }
            }
            else{
                    $_SESSION['error']="Vous n'avez pas spécifiez de candidats et/ou de projet";
                }
            break;
        case 'validation_candidat':
            if(isset($_POST['candidat_id'])&&!empty($_POST['candidat_id'])&&is_numeric($_POST['candidat_id'])){
                $id=$_POST['candidat_id'];
                $candidat=  MAC\Models\Candidature::find($id);//trouve la candiature
                $etat=(isset($_POST['etat'])&&$_POST['etat']=='accepter')?true:false;//met a jour suivant le bouton submit qui a été appuyer par l'utilisateur
                $candidat->etat_candidature=$etat;
                if($candidat->save()){ //sauvegarde de la candidature
                    $titre="Vous avez été pris dans le projet {$candidat->projet()->titre}";
                    $corp="Le projet {$candidat->projet()->titre} vous a officielement rajouté dans sa liste de membre";
                    MAC\Models\Message::create(["profil_dest"=>$candidat->profil()->id,"profil_source"=>$candidat->projet()->createur_id,"titre"=>$titre,"text"=>$corp]); //crée un message à l'utilisateur pour le notifier qu'il a été validé dans les candidatures

                    if($etat)
                        $_SESSION['message']='Le membre a été ajouté dans les membre de votre projet';
                    else
                        $_SESSION['message']='Vous venez de refusé un candidat';
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
                if($candidat->profil()->id==$_SESSION['userid']){//vérifie que la candidature est addresser a la personne connecté
                    $etat=(isset($_POST['etat'])&&$_POST['etat']=='accepter')?true:false;//met a jour suivant le bouton submit qui a été appuyer par l'utilisateur
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
                else{
                    $_SESSION['error']='Cet candidature ne vous appartien pas';
                }

            }
            break;
        case 'quitter_projet':
                if(isset($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    //Quitter un projet
                    $projet=  MAC\Models\Projet::find($_POST['projet_id']);
                    $candidat = MAC\Models\Candidature::where([
                        "projet_id"=>$_POST['projet_id'],
                        "profil_id"=>$_SESSION['userid']
                    ])->get()->first();//récupère la candidature
                   if(isset($candidat)){
                        $candidat->etat_candidature=false;//met la candidature a false comme pour exclure quelquun du projet
                        if($projet->createur_id!=$_SESSION['userid']){
                            if($candidat->delete()){//supprime la candiature
                                $_SESSION['message']='Vous avez quitter le projet';
                            }
                            else{
                                $_SESSION['error']='Une erreur est survenue lorsque vous avez souhaiter quitter le projet'; 
                            }
                        }
                   }
                   else{
                       $_SESSION['error']='Une erreur c\'est produit lors de la suppression de votre candidature';
                   }
                }
                
            break;
        case 'suppression':
                if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    //Suppression d'un projet
                    $projet = MAC\Models\Projet::find($_POST['projet_id']);
                    if($projet->createur_id==$_SESSION['userid']){
                        $candidature=  MAC\Models\Candidature::where('projet_id',$projet->id)->get();
                        $candidature->each(function($item) use ($projet){//supprime chaque candidature de projet
                            if($item->profil_id!=$projet->createur_id){//crée un message pour notifier les candidatures du projet, sauf le créateur du projet
                                $titre="Projet {$projet->titre} supprimé";
                                $corp="Le projet {$projet->titre} a été supprimé, nous somme désolé";
                                MAC\Models\Message::create(["profil_dest"=>$item->profil_id,"profil_source"=>$projet->createur_id,"titre"=>$titre,"text"=>$corp]); //crée un message pour notifier la personne que le projet a été supprimé
                            }
                            $item->delete();//supprime la candidature
                            
                        });
                        if($projet->delete()){//supprime le projet
                            $_SESSION['message']='Le projet a bien été supprimer';
                        }
                        else{
                            $_SESSION['error']='Une erreur est survenue lors de la suppression du projet';
                        }                    
                    }
                }
            break;
        case 'suppression_membre':
                if(isset($_POST['candidat_id'])&&!empty($_POST['candidat_id'])&&is_numeric($_POST['candidat_id'])&&isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&  is_numeric($_POST['projet_id'])){
                    //Suppression d'un membre du projet
                    $projet=MAC\Models\Projet::findOrFail($_POST['projet_id']);
                    if($projet->createur_id==$_SESSION['userid']){//vérifie que la personne qui supprime est le créateur du projet
                        $candidature = MAC\Models\Candidature::find($_POST['candidat_id']);
                        $candidature->etat_candidature=false;

                        if($candidature->delete()){//supprime la candidature
                            $_SESSION['message']='L\'utilisateur a bien été supprimer de votre projet';
                        }
                        else{
                            $_SESSION['error']='Une erreur est survenue lors de la suppression de l\'utilisateur dans votre projet';
                        }
                    }
                }
            break;
        case 'publication':
            //modification de projet
            if(isset($_POST['titre'])&&!empty($_POST['titre'])&&isset($_POST['description'])&&!empty($_POST['description'])&&isset($_POST['projet_datefin'])&&!empty($_POST['projet_datefin'])&&isset($_POST['projet_datedebut'])&&!empty($_POST['projet_datedebut'])){
                $now=Carbon::now();
                $debut=Carbon::createFromFormat('d/m/Y', $_POST['projet_datedebut']);
                $fin=Carbon::createFromFormat('d/m/Y', $_POST['projet_datefin']);
                if($fin->gt($debut)&&$fin->gt($now)){//si la date de fin est plus grande que la date de début & la fin est plus grande que maintenant
                    if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                        //Mise à jour du projet
                        $projet = MAC\Models\Projet::find($_POST['projet_id']);//récupère le projet 
                        $projet->titre=$_POST['titre'];
                        $projet->description=$_POST['description'];
                        $projet->publier=true;
                        $projet->debut=$debut->toDateString();
                        $projet->fin=$fin->toDateString();
                        if($projet->save()){
                            $_SESSION['message']='Votre projet a bien été modifié';
                        }
                        else{
                            $_SESSION['error']='Une erreur est survenue lors de la modification de votre projet';
                        }             
                    }
                    else{//Création du projet
                        $projet= MAC\Models\Projet::create([
                            "titre"=>$_POST['titre'],
                            "description"=>$_POST['description'],
                            "createur_id"=>$_SESSION['userid'],
                            "publier"=>true,
                            "debut"=>Carbon::now()->toDateString(),
                            "fin"=>Carbon::createFromFormat('d/m/Y', $_POST['projet_datefin'])->toDateString()
                        ]);                        
                        $candidature= MAC\Models\Candidature::create([
                            "etat_proposition"=>true,
                            "etat_candidature"=>true,
                            "profil_id"=>$_SESSION['userid'],
                            "projet_id"=>$projet->id
                        ]);//crée automatiquement une candidature pour le chef de projet, comme cela celui-ci est visible dans les membres du projet
                        $_SESSION['message']='Votre projet a bien été créé.';
                    }
                }
                else{
                    $_SESSION['error']='La date de début est après la date de fin!';
                }
            }
            else{ //change l'téat de publicaiton
                if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    //publication du projet du projet
                    $projet = MAC\Models\Projet::find($_POST['projet_id']);     
                    $projet->publier=true;
                    if($projet->save()){
                        $_SESSION['message']='Votre projet a bien été modifié';
                    }
                    else{
                        $_SESSION['error']='Une erreur est survenue lors de la modification de votre projet';
                    }
                }
                else{
                    $_SESSION['error']='Il y a un problème dans le titre, la description ou la date de fin de votre projet !';
                }
                }
                
            break;
        case 'depublication':
            //modification du projet
            if(isset($_POST['titre'])&&!empty($_POST['titre'])&&isset($_POST['description'])&&!empty($_POST['description'])&&isset($_POST['projet_datefin'])&&!empty($_POST['projet_datefin'])&&isset($_POST['projet_datedebut'])&&!empty($_POST['projet_datedebut'])){
                $now=Carbon::now();
                $debut=Carbon::createFromFormat('d/m/Y', $_POST['projet_datedebut']);
                $fin=Carbon::createFromFormat('d/m/Y', $_POST['projet_datefin']);
                if($fin->gt($debut)&&$fin->gt($now)){
                    if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                        //Mise à jour du projet
                        $projet = MAC\Models\Projet::find($_POST['projet_id']);     
                        $projet->titre=$_POST['titre'];
                        $projet->description=$_POST['description'];
                        $projet->publier=false;
                        $projet->debut=$debut->toDateString();
                        $projet->fin=$fin->toDateString();
                        if($projet->save()){
                            $_SESSION['message']='Votre projet a bien été modifié';
                        }
                        else{
                            $_SESSION['error']='Une erreur est survenue lors de la modification de votre projet';
                        }             
                    }
                    else{//Création du projet
                        $projet= MAC\Models\Projet::create([
                            "titre"=>$_POST['titre'],
                            "description"=>$_POST['description'],
                            "createur_id"=>$_SESSION['userid'],
                            "publier"=>false,
                            "debut"=>Carbon::now()->toDateString(),
                            "fin"=>Carbon::createFromFormat('d/m/Y', $_POST['projet_datefin'])->toDateString()
                        ]);                        
                        $candidature= MAC\Models\Candidature::create([
                            "etat_proposition"=>true,
                            "etat_candidature"=>true,
                            "profil_id"=>$_SESSION['userid'],
                            "projet_id"=>$projet->id
                        ]);//crée automatiquement une candidature pour le chef de projet, comme cela celui-ci est visible dans les membres du projet
                        $_SESSION['message']='Votre projet a bien été créé.';
                    }
                }
                else{
                    $_SESSION['error']='La date de début est après la date de fin!';
                }
            }
            else{ //changement de l'état de publicaiton
                if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    //depublication du projet du projet
                    $projet = MAC\Models\Projet::find($_POST['projet_id']);     
                    $projet->publier=false;
                    if($projet->save()){
                        $_SESSION['message']='Votre projet a bien été modifié';
                    }
                    else{
                        $_SESSION['error']='Une erreur est survenue lors de la modification de votre projet';
                    }
                }
                else{
                    $_SESSION['error']='Il y a un problème dans le titre ou la description de votre projet !';
                }
            }
            break;
        case 'ajout_projet_favoris':
                if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    //Ajoute un projet dans les favoris
                    $user = MAC\Models\Profil::find($_SESSION['userid']);
                    $favori = MAC\Models\Projet::find($_POST["projet_id"]);
                    $favori = $user->projetFavori()->save($favori);//rajoute dans les favori le projet
                    if (isset($favori)){
                        $_SESSION["message"] = "Le projet a été ajouté à vos favoris !";
                    }
                    else{
                        $_SESSION["error"] = "Un problème est survenu lors de l'ajout du projet à vos favoris !";
                    }
                }
                
            break;
        case 'suppression_projet_favoris':
                if(isset($_POST['projet_id'])&&!empty($_POST['projet_id'])&&is_numeric($_POST['projet_id'])){
                    //Supprime un projet des favoris
                    $user = MAC\Models\Profil::find($_SESSION['userid']);
                    $favori = MAC\Models\Projet::find($_POST["projet_id"]);
                    $favori = $user->projetFavori()->detach($favori->id);//enleve le projet des favoris
                    if (isset($favori)){
                        $_SESSION["message"] = "Le projet a été supprimé de vos favoris !";
                    }
                    else{
                        $_SESSION["error"] = "Un problème est survenu lors de la suppression du projet de vos favoris !";
                    }                  
                }
                
            break;
    }
    header('Location: '.$_SESSION['retourner_a']);//redirige l'utilsiateur a la page précédente
    die(); //on ne veut pas afficher la page car l'on fait que traiter les données, on termine l'execution de PHP
}
if($_SERVER['REQUEST_METHOD']=='GET'){
        $_SESSION['retourner_a']=$_SERVER['REQUEST_URI'];
        $action=(isset($_GET['action']) && !empty($_GET['action']))?$_GET['action']:null;
        switch($action){
            case 'modifier':
                if(isset($_GET['projet_id'])&&!empty($_GET['projet_id'])&&is_numeric($_GET['projet_id'])){
                    $projet_id = $_GET['projet_id'];
                    $projet = MAC\Models\Projet::find($projet_id);
                    if($projet['createur_id']==$_SESSION['userid']){
                        echo MAC\View::render("modif_projet.twig", ["data"=>["projet"=>$projet]]);
                    }
                    else{
                        $_SESSION['error'] = "Vous n'êtes pas le créateur de ce projet";
                        header('Location: connexion.php');
                    }
                }
            break;
            case 'ajout':
                if(isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){
                    echo MAC\View::render("modif_projet.twig");
                }
                else{
                    $_SESSION['error'] = "Vous n'êtes pas connecté";
                }
            break;
            
            default:
                if(isset($_GET['id'])&&is_numeric($_GET['id'])){ //affichage d'un projet particiulié
                    $projet_id = $_GET['id'];
                    $projet = MAC\Models\Projet::find($projet_id);
                    echo MAC\View::render('affichage_projet.twig',["projet"=>$projet]);
                }
                else{
                    //affichaage de la gestion des projet/candidature/inscription etc....
                    $profil_id=$_SESSION['userid'];                    
                    $projet=  MAC\Models\Profil::find($profil_id)->projet()->get();//retourne tous les projet dont la personne est le créateur
                    $candidature=  MAC\Models\Profil::find($profil_id)->candidatureProjet()->get(); //retourne tous les projet dans lequel il est candidat
                    $membres= MAC\Models\Profil::find($profil_id)->membreProjet()->get();//retourne teous les projet dans lequel il est membre
                    $suggestions=MAC\Models\Profil::find($profil_id)->propositionProjet()->get(); //retourne toutes les propositions
                    $candidatureRefuser= MAC\Models\Profil::find($profil_id)->candidatureProjet('refuser')->get(); //retourne toute les candidature refusé
                    echo MAC\View::render('projet.twig',["data"=>["candidatures"=>$candidature,'membres'=>$membres,'suggestions'=>$suggestions,'candidaturesRefuser'=>$candidatureRefuser,'user_project'=>$projet]]);
                }
                
                break;
        }
    if (isset($_SESSION["message"]))
    {
       unset($_SESSION["message"]);
    }
    if (isset($_SESSION["error"]))
    {
        unset($_SESSION["error"]);
    } 
    die();
}

/* Formulaire utilisé pour les différentes action dans la page

 * inscirpition a un projet
  <form method="POST">
   <input type="submit"     name="submit"       value="s'inscrire"                      >
   <input type="hidden"     name="action"       value="inscription"                     >
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
