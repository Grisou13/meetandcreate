<?php
namespace MAC\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Profil extends Eloquent
{
    protected $table="profil";
    protected $fillable =["email","prenom","nom","telephone","adresse","cp","pays","description","username","password","password_temp"];
    protected $guarded =["id"];
    protected $hidden=["password","password_temp"];
    protected $appends=['competences'];

    public function candidatures(){
        return $this->hasMany('MAC\Models\Candidature')->where('profil_id',$this->id);
    }
    public function projet(){
        return $this->hasMany('MAC\Models\Projet','createur_id');
    }
    public function membreProjet(){
        return $this->candidatures()->where('etat_proposition',true)->where('etat_candidature',true)->join('projet','projet.id','=','candidat_projet.projet_id')->select('projet.*')->select('projet.*','candidat_projet.*','projet.id as idprojet');
    }
    public function candidatureProjet(){
        $args=  func_get_args();
        
        $action=(isset($args[0])&&!empty($args[0]))?$args[0]:'';
        switch ($action){
            case 'accepter'://donne toute les candidature accepter
                return $this->membreProjet();
            case 'refuser'://donne teoute les candidature refuser
                return $this->candidatures()->where('etat_candidature',false)->where('etat_proposition',true)->join('projet','projet.id','=','candidat_projet.projet_id')->select('projet.*')->select('projet.*','candidat_projet.*','projet.id as idprojet');
            default: //donne toute les candidature ouverte
                return $this->candidatures()->where('etat_candidature',null)->where('suggereur_id',null)->where('etat_proposition',true)->join('projet','projet.id','=','candidat_projet.projet_id')->select('projet.*')->select('projet.*','candidat_projet.*','projet.id as idprojet');

        }
    }
    public function propositionProjet(){
        return $this->candidatures()->where('etat_proposition',null)->join('projet','projet.id','=','candidat_projet.projet_id')->select('projet.*')->select('projet.*','candidat_projet.*','projet.id as idprojet');
    }
    public function candidatureProjetRefuser(){
        
        return $this->candidatures()->where('etat_candidature',null)->where('suggereur_id',null)->where('etat_proposition',true)->join('projet','projet.id','=','candidat_projet.projet_id')->select('projet.*')->select('projet.*','candidat_projet.*','projet.id as idprojet');
    }
    public function profilFavori()
    {        
        return $this->belongsToMany('MAC\Models\Profil', 'profil_favori','profile_id','favori_id')/*->where('profile_id',$this->id)*/;
    }
    public function competences(){
        return $this->belongsToMany("MAC\Models\Competence", "profil_competence")->withPivot('niveau');
    }
    
    public function getCompetencesAttribute(){
        return $this->attributes['competences']=$this->competences()->get();
    }
    
    
    

}
