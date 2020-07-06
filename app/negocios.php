<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class negocios extends Model
{
    protected $fillable = [
        'id_usuario',
        'nombre',
        'img',
        'descripcion',
        'latitud',
        'longitud',
        'pais',
        'ciudad',
        'correo',
        'facebook',
        'instagram',
        'whatsapp'
    ];
}
