<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'name',
        'qty',
        'type',
        'cost',
        'provider_id',
    ];

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
