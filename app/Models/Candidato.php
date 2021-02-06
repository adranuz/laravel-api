<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{

    
    protected $table = 'candidato';
    
    protected $fillable = [
        'nombre', 'configuacion', 'created_at', 'updated_at'
    ];
}
