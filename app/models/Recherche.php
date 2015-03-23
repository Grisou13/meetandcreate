<?php

/*
 * permet l'historisation des recherche
 */

namespace MAC\Models;

/**
 * Description of Recherche
 *
 * @author thomas.ricci
 */
use Illuminate\Database\Eloquent\Model as Eloquent;
class Recherche extends Eloquent{
    protected $table = "recherche_historique";
    protected $fillable=["date","query","tags","competences"];
    protected $guarded=["id"];
    
}
