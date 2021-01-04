<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $table = 'notify';

    protected $fillable = [
        "user_id",
        "msg"
    ];

    public $timestamps = false;
}
