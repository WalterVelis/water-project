<?php

use App\Permission;
use App\RolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // USER PERMISSIONS
        $model = "User";
        
        $permission = new Permission();
        $permission->name = "User Index";
        $permission->module= $model;
        $permission->description = "User Index";
        $permission->save();

        $permission = new Permission();
        $permission->name = "User Create";
        $permission->module= $model;
        $permission->description = "User Create";
        $permission->save();

        $permission = new Permission();
        $permission->name = "User Update";
        $permission->module= $model;
        $permission->description = "User Update";
        $permission->save();

        $permission = new Permission();
        $permission->name = "User Deactivate";
        $permission->module= $model;
        $permission->description = "User Deactivate";
        $permission->save();

        $permission = new Permission();
        $permission->name = "User Activate";
        $permission->module= $model;
        $permission->description = "User Activate";
        $permission->save();

        // Role Permission
        $model = "Role";

        $permission = new Permission();
        $permission->name = "Role Index";
        $permission->module= $model;
        $permission->description = "Role Index";
        $permission->save();

        $permission = new Permission();
        $permission->name = "Role Create";
        $permission->module= $model;
        $permission->description = "Role Create";
        $permission->save();

        $permission = new Permission();
        $permission->name = "Role Update";
        $permission->module= $model;
        $permission->description = "Role Update";
        $permission->save();

        $permission = new Permission();
        $permission->name = "Role Delete";
        $permission->module= $model;
        $permission->description = "Role Delete";
        $permission->save();

        $permission = new Permission();
        $permission->name = "Role Show";
        $permission->module= $model;
        $permission->description = "Role Show";
        $permission->save();


        //assign all existing permissions to the administrator
        $permissionAll = DB::table('permissions')->get();
        foreach($permissionAll as $key){
            $rolPermissionNew = new RolePermission();
            $rolPermissionNew->role_id = 1;
            $rolPermissionNew->permission_id = (int)$key->id;
            $rolPermissionNew->created_by = 1;
            $rolPermissionNew->save();

        }

    }
}