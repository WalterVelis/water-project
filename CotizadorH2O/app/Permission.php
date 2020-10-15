<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'id','name', 'description', 'module', 'created_by', 'updated_by'
    ];

    public function rolePermission(){
        return $this->hasMany(RolePermission::class);
    }
}