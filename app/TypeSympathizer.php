<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeSympathizer extends Model
{
    protected $table = 'type_sympathizer';
    protected $fillable = [
        'name', 
        'description',
    ];
}
