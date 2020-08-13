<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class actividades_cuarentena extends Model
{
    protected $fillable = [
        'nombre',
        'id_usuario'
    ];
}
