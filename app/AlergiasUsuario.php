<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlergiasUsuario extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_alergia'
    ];
}
