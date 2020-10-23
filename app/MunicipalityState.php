<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MunicipalityState extends Model
{
    protected $table = 'estados_municipios';

    public function municipio()
    {
        return $this->hasOne('App\Municipality', 'id', 'municipios_id');
    }
}
