<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class negocio_categoria extends Model
{
    protected $fillable = [
        'id_negocio',
        'id_categoria'
    ];
}
