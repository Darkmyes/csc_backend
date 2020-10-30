<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bar extends Model
{
    protected $fillable = [
        'nombre',
        'id_usuario',
        'celular',
	'img'
    ];
}
