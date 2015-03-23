<?php
namespace MAC\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tag
 *
 * @author thomas
 */
class Tag extends Eloquent{
    protected $table = "tag";
    protected $fillable=["nom","description"];
    protected $guarded=["id"];
    public $timestamps = false;
    public function projets(){
        return $this->belongsToMany('MAC\Models\Projet', 'tag_projet');
    }
}
