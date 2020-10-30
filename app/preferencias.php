<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class preferencias extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_categoria_alimento',
        'valor'
    ];
}
