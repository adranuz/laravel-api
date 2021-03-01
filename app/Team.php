<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'candidato_id',
        'name',
        'owner_type',
        'owner_id'
    ];

    public function owner(){
        return $this->morphTo();
    }

    public function simpatizantes(){
        return $this->hasMany('App\PadronElectoral');
    }
    public function coordinadores(){
        return $this->hasMany('App\Coordinador');
    }
}
