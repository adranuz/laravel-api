<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PadronElectoral extends Model
{

    const ACTIVE = 1;
    const INACTIVE = 2;
    const DELETE = 3;
    protected $table = 'padronelectoral';

    protected $fillable = [
        'id', 
        'cve_elector', 
        'paterno', 
        'materno', 
        'nombre', 
        'nacimiento', 
        'lugar_nacimiento', 
        'sexo', 
        'ocupacion', 
        'calle', 
        'num_ext', 
        'num_int', 
        'colonia', 
        'cp', 
        'seccion', 
        'tiempo_residencia', 
        'entidad', 
        'distrito', 
        'municipio', 
        'localidad', 
        'manzana', 
        'en_lista_nominal', 
        'fecha_inscripcion_padron', 
        'created_at', 
        'updated_at', 
        'created_by', 
        'status'
    ];
}
