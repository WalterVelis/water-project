<?php

namespace App\Http\Controllers;

use App\Format;
use App\User;
use Illuminate\Http\Request;
use App\Mail\TechNotification;
use App\Mail\VendorNotification;
use Illuminate\Support\Facades\Mail;

class AssignmentController extends Controller
{
    public function edit($id)
    {
        $users = User::all();
        $assignmentData = Format::with('user')->find($id);
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

        $data = Format::with(['user', 'admin'])->find($id);
        Mail::to($data->user->email)->send(new VendorNotification($data));

        $data = Format::with(['user', 'admin'])->find($format->tech_assigned);
        Mail::to($data->user->email)->send(new TechNotification($data));
        return back();
    }
}
