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
namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Mail\EmailInformation;
use App\Mail\EmailResendData;
use App\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\User_xlsx;
use App\Exports\User_csv;
use App\Exports\User_xlsx2;
use App\Exports\User_csv2;
use Carbon\Carbon;
use PDF;

class UserController extends Controller
{
    public function __construct()
    {
        true;
    }

    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if(User::hasPermissions("User Index")){
            $status=$request->status;
            if($status == null){$status = 1;}
            $users=User::search($status);

            return view('users.index',compact('users','status'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new user
     *
     * @param  \App\Role  $model
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(User::hasPermissions("User Create")){
            $roles = Role::where('name', '!=', 'Vendor')->orderBy('name')->get();
            return view('users.create', ['roles' => $roles]);
        }else{
            return redirect('/');
        }
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        if(User::hasPermissions("User Create")){
            $password2 = Str::random(10);
            $emailSend = $request->email;
            $userInformation= new User;
            $userInformation->name = $request->name;
            $userInformation->password = $password2;
            $userInformation->email = $request->email;
            $userInformation->role_id = $request->role_id;
            $flagSendEmail = true;
            try{
                Mail::to($emailSend)->send(new EmailInformation($userInformation));
            } catch(\Exception $e){
                $flagSendEmail = false;
                echo($e);
            }

            if($flagSendEmail){
                $model->create($request->merge([
                    'picture' => $request->photo ? $request->photo->store('profile', 'public') : null,
                    'password' => Hash::make($password2)
                ])->all());

                if($request->get('rol-text')== 'Vendor'){
                    //
                    $userNew = User::where('email', $request->email)->get()->first();
                    $vendor = new Vendor();
                    $vendor->user_id = $userNew->id;
                    $vendor->name = $userNew->name;
                    $vendor->is_external = $request->get('is_external');
                    //0 interno 1 externo
                    $vendor->is_status_complete = '0';
                    $vendor->save();

                }
                return redirect()->route('user.index')->withStatus(__('User successfully created.'));
            }else{
                //return back()->withError(__('A conflict occurred when sending the email.'));
            }
        }else{
            return redirect('/');
        }

    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @param  \App\Role  $model
     * @return \Illuminate\View\View
     */
    public function edit(User $user, Role $model)
    {
        if(User::hasPermissions("User Update")){
            // $vendorStatus = Vendor::where('user_id', $user->id)->get()->first();
            $vendorStatus = 0;
            $classVendor = 'd-none';
            $roles = Role::where('name', '!=', 'Vendor')->orderBy('name')->get();
            if( $user->role->name == 'Vendor' ){
                $roles = Role::orderBy('name')->get();
            }
            $isVendor = '';
            if($user->role->name == 'Vendor'){

                $isVendor = 'disabled';

            }

            // if($vendorStatus == null){
            //     $vendorStatus = new Vendor();
            //     $vendorStatus->is_status_approved = "0";
            //     $vendorStatus->is_external = "2";
            //     $classVendor= 'd-none';
            // }else{
            //     if($vendorStatus->is_status_approved == '1'){
            //         $classVendor = 'd-none';
            //     }
            // }
            return view('users.edit', ['user' => $user->load('role'), 'roles' => $roles, 'vendorStatus' => $vendorStatus, 'classVendor' => $classVendor, 'isVendor' => $isVendor]);
        }else{
            return redirect('/');
        }
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if(User::hasPermissions("User Update")){
        #$hasPassword = $request->get('password');
        if($user->role->name == 'Vendor'){
            if($user->role->name != $request->get('rol-text')){
                $vendor = Vendor::where('user_id', $user->id)->get()->first();
                $vendor->delete();
            }
        }

        if($user->role->name != 'Vendor'){
            if($request->get('rol-text')== 'Vendor'){
                //
                    $userNew = User::where('email', $request->email)->get()->first();
                    $vendor = new Vendor();
                    $vendor->user_id = $userNew->id;
                    $vendor->name = $userNew->name;
                    $vendor->is_external = $request->get('is_external');
                    //0 interno 1 externo
                    $vendor->is_status_complete = '0';


                    $password2 = Str::random(10);
                    $user->password = bcrypt($password2);
                    $user->email = $request->email;
                    $user->role_id = $request->role_id;




                    $userInformation= new User;
                    $userInformation->name = $request->name;
                    $userInformation->password = $password2;
                    $userInformation->email = $request->email;
                    $userInformation->role_id = $request->role_id;
                    $emailSend = $request->email;

                    $flagSendEmail = true;
                    try{
                        Mail::to($emailSend)->send(new EmailInformation($userInformation));
                    } catch(\Exception $e){
                        $flagSendEmail = false;
                    }

                    if($flagSendEmail){
                        $vendor->save();
                        $user->update();
                    }else{
                        return back()->withError(__('A conflict occurred when sending the email.'));
                    }
                }
            }
            $flagSendEmail = true;
            if($user->email != $request->email){
                $flag = True;
                $password2 = Str::random(10);
                $user->password = bcrypt($password2);
                $user->email = $request->email;
                $user->role_id = $request->role_id;
                $user->change_password = 0;

                $userInformation= new User;
                $userInformation->name = $request->name;
                $userInformation->password = $password2;
                $userInformation->email = $request->email;
                $userInformation->role_id = $request->role_id;
                $emailSend = $request->email;
                try{
                    Mail::to($emailSend)->send(new EmailInformation($userInformation));
                } catch(\Exception $e){
                    $flagSendEmail = false;
                }
            }

            if($flagSendEmail){

            $user->update(
                $request->merge([
                    'picture' => $request->photo ? $request->photo->store('profile', 'public') : $user->picture,
                ])->all()
            );
            return redirect()->route('user.index')->withStatus(__('User successfully updated.'));

            }else{
                return back()->withError(__('A conflict occurred when sending the email.'));
            }
        }else{
            return redirect('/');
        }
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }

    public function change($user_id){
        $user=User::find($user_id);
        if(($user->status && User::hasPermissions("User Deactivate")) || (!$user->status && User::hasPermissions("User Activate"))){
            $user->status=!$user->status;
            $user->save();

            return redirect('user?status='.(int)!$user->status)->withStatus(__('Status successfully changed.'));
        }else{
            return redirect('/');
        }
    }

    public function email2Reset($userId){

        $user=User::findorFail($userId);

        $password2 = Str::random(10);
        $user->password=bcrypt($password2);
        $user->activate_2fa = "0";
        $user->activate_2fa_google = "0";
        $user->email_2fa = null;
        $user->token_login = null;
        $user->token_login_google = null;
        $user->change_password=0;
        $user->update();

        $userInformation= new User;
        $userInformation->name = $user->name;
        $userInformation->password = $password2;
        $userInformation->email = $user->email;

        $emailSend = $user->email;

        $flagSendEmail = true;
        try{
            Mail::to($emailSend)->send(new EmailResendData($userInformation));
        } catch(\Exception $e){
            $flagSendEmail = false;
        }

        if($flagSendEmail){
            return redirect()->route('user.index')->withStatus(__('Resend Successfully.'));
        }else{
            return back()->withError(__('A conflict occurred when sending the email.'));
        }






    }

    public function userVendorModal(Request $request){

        try{
            $password2 = Str::random(10);
            $userInformation= new User;
            $userInformation->role_id = '2';
            $userInformation->name = $request->name;
            $userInformation->password = $password2;
            $userInformation->email = $request->email;
            $userInformation->role_id = $request->role_id;

            $userVendor= new User;
            $userVendor->role_id = '2';
            $userVendor->name = $request->name;
            $userVendor->password = bcrypt($password2);
            $userVendor->email = $request->email;
            $userVendor->created_by = auth()->user()->id;

            $flagSendEmail = true;
            try{
                Mail::to($userInformation->email)->send(new EmailInformation($userInformation));
            } catch(\Exception $e){
                $flagSendEmail = false;
            }

            if($flagSendEmail){
                $userVendor->save();
                $vendor = new Vendor();
                $vendor->user_id = $userVendor->id;
                $vendor->name = $userVendor->name;
                $vendor->created_by = auth()->user()->id;
                $vendor->is_external = $request->get('is_external');
                //0 interno 1 externo
                $vendor->is_status_complete = '0';
                $vendor->save();
                return ['save_vendor' => true, 'id_vendor' => $vendor->id, 'name_vendor' =>$vendor->name];
            }else{
                $erro_message = __("A conflict occurred when sending the email.");
                return ['save_vendor' => false, 'error_message' => $erro_message ];
            }

            return ['save_vendor' => true, 'id_vendor' => $vendor->id, 'name_vendor' =>$vendor->name];
        } catch(\Exception $e){

            $userUnique = User::where('email', $request->email)->count();

            if($userUnique == 0){
                $erro_message = __("Sorry, it couldn't be added.");
            }else{
                $erro_message = __("This email already exists");
            }

            return ['save_vendor' => false, 'error_message' => $erro_message ];
        }





    }


    public function emailUniqueUser($text){
        $users = DB::table('users')->where('email', $text)->get();
        if($users!=null){
          return Response::json($users);
        }else{
          return null;
        }
    }


    public function emailUniqueUserEdit($text, $text2){
        $users = DB::table('users')->where('email', $text)->where('email', '!=', $text2)->get();
        if($users!=null){
          return Response::json($users);
        }else{
          return null;
        }
    }

 /*    public function nameUniqueUpdateRol($text, $text2){
        $roles = DB::table('roles')->where('name', $text)->where('name', '!=',$text2)->get();
        if($roles!=null){
          return Response::json($roles);
        }else{
          return null;
        }
    } */

    public function excelExport_xlsx()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new User_xlsx, __('Users').' '.$fecha.'.xlsx');
    }

    public function excelExport_csv()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new  User_csv, __('Users').' '.$fecha.'.csv');
    }

    public function excelExport_xlsx2()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new User_xlsx2, __('Inactive Users').' '.$fecha.'.xlsx');
    }

    public function excelExport_csv2()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new  User_csv2, __('Inactive Users').' '.$fecha.'.csv');
    }


    public function query1PdfUser($all)
    {
        $query1 = User::where('status', '1')->orderBy('name', 'asc')->get();
        $date = Carbon::now();
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if($lang == 'es'){
            $fecha=$date->locale('es')->isoFormat('dddd, DD MMMM YYYY');
            $idioma = "1";
        }else{
            $fecha=$date->locale('en')->isoFormat('dddd, DD MMMM YYYY');
            $idioma = "0";
        }
        $hora=$date->locale('es')->isoFormat('H:mm:ss');
        $fechaC = $date->format('Y');
        $name= __("Users");
        $pdf = PDF::loadView('users.options.pdfAll', compact('name', 'query1', 'fecha', 'hora', 'idioma'));
        $pdf->setPaper("letter", "Portrait");
        return $pdf->stream($name.'.pdf');
    }


    public function query2PdfUser($all)
    {
        $query1 = User::where('status', '0')->orderBy('name', 'asc')->get();

        $date = Carbon::now();

        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        //Spanish=es    English=en
        if($lang == 'es'){
            $fecha=$date->locale('es')->isoFormat('dddd, DD MMMM YYYY');
            $idioma = "1";
        }else{
            $fecha=$date->locale('en')->isoFormat('dddd, DD MMMM YYYY');
            $idioma = "0";
        }
        $hora=$date->locale('es')->isoFormat('H:mm:ss');
        $fechaC = $date->format('Y');
        //log logica
        $name= __("Inactive Users");


        $pdf = PDF::loadView('users.options.pdfAll', compact('name', 'query1', 'fecha', 'hora', 'idioma'));

        $pdf->setPaper("letter", "Portrait");

        return $pdf->stream($name.'.pdf');
        //return $pdf->download($name.'.pdf');

        //

    }



}
