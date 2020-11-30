<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialUtility extends Model
{
    protected $table = 'materials_utility';

    protected $guarded = ['id'];

    public $timestamps = false;
}
