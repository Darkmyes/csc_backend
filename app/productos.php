<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $fillable = [
        'id_negocio',
        'producto',
        'descripcion',
        'img'
    ];
}
