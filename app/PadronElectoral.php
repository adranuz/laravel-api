<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PadronElectoral extends Model
{
    protected $table = "padronelectoral";

    public function assigns(){
        return $this->morphMany('App\SimpatizanteCandidato','assign');
    }
    public function owners(){
        return $this->morphMany('App\Team','owner');
    }

    public function simpatizantes(){
        return $this->hasMany('App\SimpatizanteCandidato','padronelectoral_id','id');
    }
}
