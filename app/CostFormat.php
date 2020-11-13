<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostFormat extends Model
{
    protected $table = "cost_project";

    protected $fillable = [
        'day',
        'format_id',
        'cost_id',
    ];

    public $timestamps = false;

    public function costs()
    {
        return $this->belongsTo('App\CostsCenter', 'cost_id', 'id');
        // return $this->hasOne('App\Format', 'id', 'format_id');
    }
}
