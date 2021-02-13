<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = 'goals';
    protected $fillable = [
        'municipios_id', 
        'demarcaciones_id',
        "seccion_id",
        "desired_quantity",
        "accomplished",
        "type_sympathizer_id",
        "name",
        "created_by",
        "candidato_id"
    ];
}
