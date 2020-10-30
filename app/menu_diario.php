<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu_diario extends Model
{
    protected $fillable = [
        'id_bar',
        'id_producto',
        'precio',
        'fecha'
    ];
}
