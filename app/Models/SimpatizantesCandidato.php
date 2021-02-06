<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimpatizantesCandidato extends Model
{

    const ACTIVE = 1;
    const INACTIVE = 2;
    const DELETE = 3;
    protected $table = 'simpatizantes_candidatos';

    protected $fillable = [
        'id', 'candidato_id', 'padronelectoral_id', 'simpatiza', 'data', 'seccion_id', 'created_by', 'created_at', 'updated_at'
    ];
}
