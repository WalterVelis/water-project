<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $table = 'entities';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'position',
        'entity_type',
        'project_id',
    ];
}
