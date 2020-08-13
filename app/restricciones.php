<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class restricciones extends Model
{
    protected $fillable = [
        'id_causante',
        'id_restriccion',
        'tipo',
        'por',
        'de'
    ];
}
