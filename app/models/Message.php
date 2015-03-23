<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MAC\Models;

/**
 * Description of Message
 *
 * @author thomas.ricci
 */
use Illuminate\Database\Eloquent\Model as Eloquent;
class Message extends Eloquent{
    protected $table = "message";
    protected $fillable=["titre","profil_dest","profil_source","text"];
    protected $guarded=["id"];
    protected $appends=['source','dest'];
    public function profilSource(){
        return $this->belongsTo('MAC\Models\Profil','profil_source');
    }
    public function profilDest(){
        return $this->belongsTo('MAC\Models\Profil','profil_dest');
    }
    public function getDestAttribute(){
        return $this->attributes['dest']=$this->profilDest()->get()->first();
    }
    public function getSourceAttribute(){
        return $this->attributes['source']=$this->profilSource()->get()->first();
    }
}
