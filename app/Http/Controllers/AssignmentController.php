<?php

namespace App\Http\Controllers;

use App\Format;
use App\User;
use Illuminate\Http\Request;
use App\Mail\TechNotification;
use App\Mail\VendorNotification;
use App\Notify;
use Illuminate\Support\Facades\Mail;

class AssignmentController extends Controller
{
    public function edit($id)
    {
        $users = User::whereStatus(1)->get();
        $assignmentData = Format::with('user')->find($id);
        return view('assignment.edit', compact('assignmentData', 'users'));
    }

    public function update(Request $request, $id)
    {
        $format = Format::find($id);
        $format->vendor_assigned = $request->vendor_assigned;
        $format->tech_assigned = $request->tech_assigned;
        $format->admin_assigned = $request->admin_assigned;
        $format->internal_status = $request->status;
        $format->save();

        $data = Format::with(['vendor', 'user', 'admin'])->find($id);
        Mail::to($data->vendor->email)->send(new VendorNotification($data));

        Notify::create(["user_id" => $data->vendor->id, "msg" => "<a href='/projects/".$format->id."/edit'><div class='c-not'>".$data->admin->name. "asignó un técnico al proyecto ".$data->page." para realizar un levantamiento técnico.". $format->page."</a></div>"]);

        $data = Format::with(['tech', 'user', 'admin'])->find($id);
        Mail::to($data->tech->email)->send(new TechNotification($data));

        Notify::create(["user_id" => $data->tech->id, "msg" => "<a href='/projects/".$format->id."/edit'><div class='c-not'>".$data->admin->name. "asignó un técnico al proyecto ".$data->page." para realizar un levantamiento técnico.". $format->page."</a></div>"]);
        return back();
    }
}
