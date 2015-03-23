<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MAC\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Description of Competence
 *
 * @author thomas
 */
class Competence extends Eloquent{
    protected $table = "competence";
    protected $fillable=["competence","description"];
    protected $guarded=["id"];
    public $timestamps = false;
    public function profils()
    {
        return $this->belongsToMany('MAC\Models\Profil','profil_competence');
    }
}
