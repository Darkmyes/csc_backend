<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos_componentes extends Model
{
    protected $fillable = [
        'id_producto',
        'id_componente'
    ];
}
