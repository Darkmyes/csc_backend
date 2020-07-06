<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comentarios extends Model
{
    protected $fillable = [
        'id_negocio',
        'producto',
        'descripcion',
        'img'
    ];
}
