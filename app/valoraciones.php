<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class valoraciones extends Model
{
    protected $fillable = [
        'id_negocio',
        'producto',
        'descripcion',
        'img'
    ];
}
