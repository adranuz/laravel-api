<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinador';

    protected $fillable = [
        'nombre', 'configuracion',"candidato_id"
    ];
}
