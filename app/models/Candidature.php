<?php

/*
 * App/Models/Candidature.php
 * Description : Model Eloquent permetant d'acceder aux candidatures de projet
 * @author : Thomas Ricci
 */

namespace MAC\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Candidature extends Eloquent{
    use \Illuminate\Database\Eloquent\SoftDeletingTrait;
    protected $table="candidat_projet";
    protected $fillable=["profil_id","projet_id","suggereur_id","etat_candidature","etat_proposition"];
    protected $guarded =["id"];
    protected $softDelete = true;
    /*
     *  retourne les projets auquels la candidature appartien
     *  @return Illuminate\Database\Eloquent\Relations\belongsTo projet
     */
    public function projet(){
        return $this->belongsTo('MAC\Models\Projet')->get()->first();
    }
    /*
     *  retourne les profils auquels appartien la candidature
     *  @return Illuminate\Database\Eloquent\Relations\belongsTo profil
     */
    public function profil(){
        return $this->belongsTo('MAC\Models\Profil')->get()->first();
    }

}
