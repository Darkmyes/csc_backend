<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lista_productos extends Model
{
    protected $fillable = [
        'id_bar',
        'id_producto',
        'precio',
	'img'
    ];
}
