<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    /* protected $fillable = [
        'id_negocio',
        'producto',
        'descripcion',
        'img'
    ];
    protected $guarded = []; */

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
}
