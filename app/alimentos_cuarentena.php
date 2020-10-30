<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alimentos_cuarentena extends Model
{
    protected $fillable = [
        'nombre',
        'id_usuario'
    ];
}
