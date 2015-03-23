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
    use \Illuminate\Database\Eloquent\SoftDeletingTrait;
    protected $table = "projet";
    protected $fillable=["publier","description","titre","debut","fin","createur_id"];
    protected $guarded=["id"];
    protected $appends=["membres","candidats","tags"];
    protected $softDelete = true;
    public function tags(){
        return $this->belongsToMany('MAC\Models\Tag', 'tag_projet');
    }
    public function createur(){
        return $this->belongsTo('MAC\Models\Profil','createur_id')->first();
    }
    public function candidats(){
        return $this->belongsToMany('MAC\Models\Profil', 'candidat_projet')->where('etat_candidature',null)->wherePivot("deleted_at",null)->withPivot('id');
    }
    public function membres(){
        return $this->belongsToMany('MAC\Models\Profil', 'candidat_projet')->where("etat_candidature",true)->where('etat_proposition',true)->wherePivot("deleted_at",null)->withPivot('id');
    }
    /*
     *  Determine si la personne est membre du projet
     *  @var int $id id du profil demandé
     *  @return boolean
     */
    public function isMembre($id){
        return $this->membres()->where('profil_id',$id)->get()->count()>0?true:false;
    }
    public function chefprojet(){
        return $this->belongsTo("MAC\Models\Profil","createur_id","id");
    }
    public function getMembresAttribute()
    {
        return $this->attributes['membres']=$this->membres()->get();
    }
    public function getCandidatsAttribute()
    {
        return $this->attributes['candidats']=$this->candidats()->get();
    }
    public function getTagsAttribute(){
        return $this->attributes['tags']=$this->tags()->get();
    }

}
