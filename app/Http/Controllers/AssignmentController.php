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

    public function update(Request $request, $id)
    {
        $format = Format::find($id);
        $format->vendor_assigned = $request->vendor_assigned;
        $format->tech_assigned = $request->tech_assigned;
        $format->admin_assigned = $request->admin_assigned;
        $format->status = $request->status;
        $format->save();
        // $assignmentData = Format::find($id);
        return back();
    }
}
