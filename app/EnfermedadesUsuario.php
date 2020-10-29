<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnfermedadesUsuario extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_enfermedad'
    ];
}
