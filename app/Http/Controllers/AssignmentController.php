<?php

namespace App\Http\Controllers;

use App\Format;
use App\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function edit($id)
    {
        $users = User::all();
        $assignmentData = Format::find($id);
        return view('assignment.edit', compact('assignmentData', 'users'));
    }
}
