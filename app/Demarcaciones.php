<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demarcaciones extends Model
{
    protected $table = 'demarcaciones';

    protected $fillable = [
        'municipio_id', 'demarcacion',"secciones","indigena"
    ];
}
