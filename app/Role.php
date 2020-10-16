<?php
/*

=========================================================
* Argon Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = 
    ['id', 'name', 'description', 'created_by', 'updated_by'];
    
    /**
     * Get the users for the role
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getRoles(){
        return Role::orderBy('name')->get();
    }

    public function rolePermission(){
        return $this->hasMany(RolePermission::class);
    }
}