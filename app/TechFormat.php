<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechFormat extends Model
{
    protected $table = 'tech_formats';

    protected $guarded = [];
    public function format()
    {
        return $this->belongsTo('App\Format');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }
}
