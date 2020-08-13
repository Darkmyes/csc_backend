<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calificacion extends Model
{
    protected $fillable = [
        'id_bar',
        'id_usuario',
        'calificacion'
    ];
}
