<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostsCenter extends Model
{

    protected $table = "costs";

    protected $fillable = [
        'name',
        'unit_cost',
    ];
}
