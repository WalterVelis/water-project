<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialProviderFormat extends Model
{
    public $table = "materialprovider_project";

    protected $guarded = ['id'];

    public $timestamps = false;

    public function providers()
    {
        return $this->belongsTo('App\MaterialProvider', 'materialprovider_id');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }

}
