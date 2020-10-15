<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class ProjectController extends Controller
{
    public function index()
    {
        if(User::hasPermissions("User Index")){
    
            return view('projects.index');
        }else{
            return redirect('/');
        }
    }

    public function create()
    {
        if(User::hasPermissions("User Index")){

            return view('projects.create');
        }else{
            return redirect('/');
        }
    }
}
