<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialProvider extends Model
{
    protected $table = 'materials_providers';

    public function provider()
    {
        return $this->hasOne('App\Provider', 'id', 'provider_id');
    }

    public function material()
    {
        return $this->hasOne('App\Material', 'id', 'material_id');
    }

    public function materialProvider()
    {
        return $this->belongsTo('App\MaterialProviderFormat', 'id','materialprovider_id');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }
}
