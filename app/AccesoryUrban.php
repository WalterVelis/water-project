<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccesoryUrban extends Model
{
    protected $table = 'accesory';

    protected $fillable = [
        'name',
        'unit_cost',
        'qty',
        'discount'
    ];
}
