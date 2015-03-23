<?php
/*
 * App/Models/Profil.php
 * Description : Model Eloquent permetant d'accéder/cére/m'être a jour le profil d'une personne
 * @author : Thomas Ricci
 */
namespace MAC\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Profil extends Eloquent
{
    protected $table="profil";
    protected $fillable =["email","prenom","nom","telephone","adresse","cp","pays","description","username","password","password_temp",'fbid','gid'];
    protected $guarded =["id"];
    protected $hidden=["password","password_temp"];
    protected $appends=['competences'];
    
    
    /*
     *  retourne la moyenne générale de la personne sur tous les projets
     *  @return string note
     */
    public function note(){
        return $this->belongsToMany('MAC\Models\Profil','note_profil')->avg('note');
    }
    
    
    /*
     *  retourne toutes les note de la personne
     *  @return Illuminate\Database\Eloquent\Relations\HasMany notes
     */ 
    public function notes(){
        return $this->hasMany('MAC\Models\NoteProfil','profil_id');
    }
    
    
    /*
     *  retourne la moyenne de la note du profil sur un projet
     *  @var int $id id du projet
     *  @return string note
     */  
    public function noteProjet($id){//
        return $this->notes()->where('projet_id',$id)->avg('note');
    }
    
    
    /*
     *  retourne la note que la personne actuellement connecté a attribuer au rpofil pour un projet
     *  @var int $idprofil
     *  @var int $idprojet
     *  @return string note
     */
    public function noteProfilProjet($idprofil,$idprojet){
        $note=$this->hasMany('MAC\Models\NoteProfil','evalueur_id')->where('projet_id',$idprojet)->where('profil_id',$idprofil)->get();
        return !$note->isEmpty()?$note->first()->note:null;
    }
    
    
    /*
     *  retourne tous les messages de la personne
     *  @return Illuminate\Database\Eloquent\Relations\HasMany messages
     */
    public function messages(){
        return $this->hasMany('MAC\Models\Message','profil_dest');
    }
    
    
    /*
     *  retourne tous les messages non lu de la personne de la personne
     *  @return Illuminate\Database\Eloquent\Relations\HasMany messages
     */ 
    public function messageNonLu(){
        return $this->messages()->where('vue',null);
    }
    
    
    /*
     *  retourne toute les candidature appartennant à la personne
     *  @return Illuminate\Database\Eloquent\Relations\HasMany candidatures
     */ 
    public function candidatures(){
        return $this->hasMany('MAC\Models\Candidature');
    }
    
    
    /*
     *  retourne tous projets dont la personne en est le créateur
     *  @return Illuminate\Database\Eloquent\Relations\HasMany projets
     */ 
    public function projet(){
        return $this->hasMany('MAC\Models\Projet','createur_id');
    }
    
    
    /*
     *  retourne tous les projet avec la candidature de la personne
     *  @return Illuminate\Database\Eloquent\Relations\HasMany projet
     */ 
    public function membreProjet(){
        return $this->belongsToMany('MAC\Models\Projet','candidat_projet')->wherePivot('etat_proposition',true)->wherePivot('etat_candidature',true)->wherePivot("deleted_at",null);
    }
    
    
    /*
     *  Determine si la personne est membre d'un certain projet
     *  @var int $idprojet id du projet a valider
     *  @return boolean 
     */ 
    public function isMembre($idprojet){
        return $this->candidatures()->where('projet_id',$idprojet)->where('etat_proposition',true)->where('etat_candidature',true)->get()->count()?true:false;
    }
    
    
    /*
     *  Determine si la personne est candidate d'un certain projet
     *  @var int $idprojet id du projet a valider
     *  @return boolean 
     */
    public function isCandidat($idprojet){
        return $this->candidatures()->where('projet_id',$idprojet)->where('etat_candidature',null)->where('suggereur_id',null)->where('etat_proposition',true)->get()->count()?true:false;
    }
    
    
    /*
     *  Retourne toute les candidature de la personne ne attente, refusé, ou accepter(la personne est donc membre du projet)
     *  @return Illuminate\Database\Eloquent\Relations\HasMany projets
     */
    public function candidatureProjet(){
        $args=  func_get_args();
        
        $action=(isset($args[0])&&!empty($args[0]))?$args[0]:'';
        switch ($action){
            case 'accepter'://donne toute les candidature accepter
                return $this->membreProjet();
            case 'refuser'://donne teoute les candidature refuser
                return $this->belongsToMany('MAC\Models\Projet','candidat_projet')->wherePivot('etat_candidature',false)->wherePivot('etat_proposition',true)->wherePivot("deleted_at",null)->withPivot('id');
            default: //donne toute les candidature ouverte
                return $this->belongsToMany('MAC\Models\Projet','candidat_projet')->wherePivot('etat_candidature',null)->wherePivot('etat_proposition',true)->wherePivot("deleted_at",null)->withPivot('id');

        }
    }
    
    
    /*
     *  Retourne toutes les soggestion dans lesquelle la personne est
     *  
     *  @return Illuminate\Database\Eloquent\Relations\HasMany projets
     */
    public function propositionProjet(){
        return $this->belongsToMany('MAC\Models\Projet','candidat_projet')->wherePivot('etat_proposition',null)->wherePivot("deleted_at",null)->withPivot('id');
    }
    
    
    /*
     *  Retourne tous les projets favori de la personne
     *  
     *  @return Illuminate\Database\Eloquent\Relations\BelongsToMany projets
     */
    public function projetFavori(){
        return $this->belongsToMany('MAC\Models\Projet', 'projet_favori','profile_id','projet_id');
    }
    
    
    /*
     * Determine si le projet est dnas les favoris de la personne
     * @var $id id du projet a valider
     * @return boolean
     */
    public function isProjetFavori($id){
        return $this->projetFavori()->wherePivot('projet_id',$id)->get()->count()?true:false;
    }
    
    
    /*
     *  Retourne tous les profils favori de la personne
     *  
     *  @return Illuminate\Database\Eloquent\Relations\BelongsToMany profils
     */    
    public function profilFavori()
    {        
        return $this->belongsToMany('MAC\Models\Profil', 'profil_favori','profil_id','favori_id');
    }
    
    
    /*
     * Determine si le profil est dans les favoris de la personne
     * @var $id id du profil a valider
     * @return boolean
     */
    public function isProfilFavori($id){
        return $this->profilFavori()->wherePivot('favori_id',$id)->get()->count()?true:false;
    }
    
    
    /*
     *  Retourne toutes les compétence du profil
     *  
     *  @return Illuminate\Database\Eloquent\Relations\BelongsToMany competences
     */
    public function competences(){
        return $this->belongsToMany("MAC\Models\Competence", "profil_competence")->withPivot('niveau');
    }
    /*
     *  Retourne sous une forme textuel le niveau d'une personne
     *  Peut être améliorer en créans une table supplémenatire
     *  @var int $niveau niveau en chiffre entier permettant de ressortir une chaine de caractère pour le niveau de la personne
     *  @return string niveau
     */
    public function niveauCompetence($niveau){
        switch($niveau){
            case '1':
                return 'Utilisateur Débutant';
            case '2':
                return 'Utilisateur Intermediaire';
            case '3':
                return "Utilisateur Confirmé";
            case '4':
                return "Utilisateur Avancé";
            case '5':
                return "Utilisateur Expert";
            
        }
        return null;
    }
    /*
     *  Rajoute dans les attribut d'un profil, ces comptéences
     *  
     *  @return Illuminate\Database\Eloquent\Collection competences
     */
    public function getCompetencesAttribute(){
        return $this->attributes['competences']=$this->competences()->get();
    }
    
    
    

}
