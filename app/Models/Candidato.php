<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{

    
    protected $table = 'candidato';
    
    protected $fillable = [
        'nombre', 'configuacion', 'created_at', 'updated_at'
    ];

    public function municipios(){
        $registro = json_decode($this->configuacion, true)['registros'];
        return explode('-',$registro);
    }
}
