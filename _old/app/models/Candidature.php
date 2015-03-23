<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MAC\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Description of Candidature
 *
 * @author thomas
 */
class Candidature extends Eloquent{
    protected $table="candidat_projet";
    protected $fillable=["profil_id","projet_id","suggereur_id","etat_candidature","etat_proposition"];
    protected $guarded =["id"];
    public function projet(){
        return $this->belongsTo('MAC\Models\Projet')->get()->first();
    }
    public function profil(){
        return $this->belongsTo('MAC\Models\Profil')->get()->first();
    }

}
