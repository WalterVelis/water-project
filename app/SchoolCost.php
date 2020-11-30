<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCost extends Model
{
    protected $table = 'school_costs';

    protected $guarded = ['id'];

    public $timestamps = false;
}
