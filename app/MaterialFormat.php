<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialFormat extends Model
{
    protected $table = "material_project";

    protected $fillable = [
        'qty',
        'cost',
        'material_id',
        'format_id',
    ];

    public $timestamps = false;

    public function materials()
    {
        return $this->belongsTo('App\Material', 'material_id', 'id');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }
}
