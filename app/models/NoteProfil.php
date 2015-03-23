<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MAC\Models;

/**
 * Description of NoteProfil
 *
 * @author thomas
 */
use Illuminate\Database\Eloquent\Model as Eloquent;

class NoteProfil extends Eloquent{
    protected $table="note_profil";
    protected $fillable =["evalueur_id","profil_id","note","projet_id"];
    protected $guarded =["id"];
    public function profil(){
        $this->belongsToMany('MAC\Models\Profil');
    }
    public $timestamps = false;
}
