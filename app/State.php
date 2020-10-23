<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    protected $table = 'estados';
    protected $fillable = [
        'name', 'country_id'
    ];
}
