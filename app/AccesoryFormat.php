<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccesoryFormat extends Model
{
    protected $table = "accesory_project";

    protected $fillable = [
        'qty',
        'accesory_id',
        'format_id',
    ];

    public $timestamps = false;

    public function accesory()
    {
        return $this->belongsTo('App\AccesoryUrban', 'accesory_id', 'id');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }
}
