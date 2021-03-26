<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'url',
        'state',
        'message',
        'type',
        'total',
        'candidato_id',
        'created_by'
    ];
}
