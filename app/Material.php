<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'name',
        'type',
        'unit',
    ];

    public function providers()
    {
        return $this->hasMany('App\MaterialProvider');
    }
}
