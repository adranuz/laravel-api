<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimpatizanteCandidato extends Model
{
    protected $table = 'simpatizantes_candidatos';

    public function assign(){
        return $this->morphTo();
    }

    public function people(){
        return $this->belongsTo('App\PadronElectoral','padronelectoral_id');
    }
}
