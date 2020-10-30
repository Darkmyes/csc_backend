<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstilosVidaUsuario extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_estilo_vida'
    ];
}
