<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostsUtility extends Model
{
    protected $table = 'costs_utility';

    protected $guarded = ['id'];

    public $timestamps = false;
}
