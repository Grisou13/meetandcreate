<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MAC\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Description of Projet
 *
 * @author thomas.ricci
 */
class Projet extends Eloquent{
    protected $table = "projet";
    protected $fillable=["publier","description","titre","debut","fin","createur_id"];
    protected $guarded=["id"];
    protected $appends=["membres"];
    public function tags(){
        return $this->belongsToMany('MAC\Models\Tag', 'tag_projet');
    }
    public function candidats(){
        return $this->belongsToMany('MAC\Models\Profil', 'candidat_projet')->where('etat_candidature',null);
    }
    public function membres(){
        return $this->belongsToMany('MAC\Models\Profil', 'candidat_projet')->where("etat_candidature",true)->where('etat_proposition',true);
    }
    public function chefprojet(){
        return $this->belongsTo("MAC\Models\Profil","createur_id","id");
    }
    public function getMembresAttribute()
    {
        return $this->attributes['membres']=$this->membres()->get();
    } 
}
