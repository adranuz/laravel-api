<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinador';

    protected $fillable = [
        'nombre', 'configuracion',"candidato_id"
    ];

    //relacion uno a muchos polimorfica


    public function assigns(){
        return $this->morphMany('App\SimpatizanteCandidato','assign');
    }

    public function owners(){
        return $this->morphMany('App\Team','owner');
    }

    public function demarcacion(){
        $registro = json_decode($this->configuracion, true)['registros'];
        return explode(':',$registro)[1];
    }

    public function secciones(){
        $registro = json_decode($this->configuracion, true)['registros'];
        return explode('-',$registro);
    }
}
