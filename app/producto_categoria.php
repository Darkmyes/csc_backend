<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class producto_categoria extends Model
{
    protected $fillable = [
        'id_producto',
        'id_categoria'
    ];
}
