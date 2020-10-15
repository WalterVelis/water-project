<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class PermissionController extends Controller
{
    //
    public function searchNamePermissions($text){        
        $permissions = Permission::where('description','like', '%'.strtoupper($text).'%')->orderBy('description','asc')->get();
        if($permissions!=null){
          return Response::json($permissions);
        }else{
          return null;
        }
    }

    public function searchAllPermissions(){        
      $permissions = DB::table('permissions')->orderBy('description','asc')->get();
      if($permissions!=null){
        return Response::json($permissions);
      }else{
        return null;
      }
    } 

}
