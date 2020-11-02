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
use App\Http\Requests\RoleRequest;
use App\RolePermission;
use Illuminate\Support\Facades\DB;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Role_xlsx;
use App\Exports\Role_csv;
use Carbon\Carbon;
use PDF;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Role::class);
        true;
    }

    /**
     * Display a listing of the roles
     *
     * @param \App\Role  $model
     * @return \Illuminate\View\View
     */
    public function index(Role $model)
    {
        if(User::hasPermissions('Role Index')){
            return view('roles.index', ['roles' => $model->all()]);
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new role
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        if(User::hasPermissions('Role Create')){
            $permissionAll = DB::table('permissions')->orderBy('description','asc')->get();
            return view('roles.create',compact('permissionAll'));
        }else{
            return redirect('/');
        }


    }

    /**
     * Store a newly created role in storage
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Role  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request, Role $model)
    {
        //$model->create($request->all());
        $rolNew = new Role();
        $rolNew->name = $request->get('name');
        $rolNew->description = $request->get('description');
        $rolNew->created_by =(int)$request->get('created_by');
        $rolNew->save();

        foreach($request->idPermission as $key){
            $rolPermissionNew = new RolePermission();
            $rolPermissionNew->role_id = $rolNew->id;
            $rolPermissionNew->permission_id = (int)$key;
            $rolPermissionNew->created_by = (int)$request->get('created_by');
            $rolPermissionNew->save();

        }

        return redirect()->route('role.index')->withStatus(__('Role successfully created.'));

        //dd($request);
    }


    /**
     * Show the form for editing the specified role
     *
     * @param  \App\Role  $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        if(User::hasPermissions('Role Update')){
            return view('roles.edit', compact('role'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Update the specified role in storage
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->updated_by =(int)$request->get('updated_by');
        $role->update();

        foreach($role->rolePermission as $item){
            $stateRemoval = false;
            foreach($request->idPermission as $key){
                if($item->permission_id == (int)$key){
                    $stateRemoval = true;
                }
            }
            if($stateRemoval == false){
                RolePermission::destroy($item->id);
            }

        }

        foreach($request->idPermission as $key){
            $stateAdd = false;
            foreach($role->rolePermission as $item){
                if($item->permission_id == (int)$key){
                    $stateAdd = true;
                }
            }
            if($stateAdd == false){
                $rolPermissionNew = new RolePermission();
                $rolPermissionNew->role_id = $role->id;
                $rolPermissionNew->permission_id = (int)$key;
                $rolPermissionNew->updated_by = (int)$request->get('updated_by');
                $rolPermissionNew->save();
            }

        }
        return redirect()->route('role.index')->withStatus(__('Role successfully updated.'));
    }

    public function show($id)
    {
        //
        if(User::hasPermissions('Role Update')){
            $rol = Role::findorFail($id);
            return view('roles.show',compact('rol'));
        }else{
            return redirect('/');
        }

    }

    public function nameUniqueRol($text){
        $roles = DB::table('roles')->where('name', $text)->get();
        if($roles!=null){
          return Response::json($roles);
        }else{
          return null;
        }
    }

    public function nameUniqueUpdateRol($text, $text2){
        $roles = DB::table('roles')->where('name', $text)->where('name', '!=',$text2)->get();
        if($roles!=null){
          return Response::json($roles);
        }else{
          return null;
        }
    }

    public function destroy($id){
        if(User::hasPermissions('Role Update')){
            DB::beginTransaction();
            try {
                $role = Role::findOrFail($id);
                foreach($role->rolePermission as $item){
                    RolePermission::destroy($item->id);
                }
                $role->delete();
                DB::commit();
                return redirect()->route('role.index')->withStatus(__('Role successfully deleted.'));

            }
            catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('role.index')->withError(__('Role cannot be deleted.'));
            }
        }else{
            return redirect('/');
        }

    }

    public function excelExport_xlsx()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Role_xlsx, 'Roles '.$fecha.'.xlsx');
    }

    public function excelExport_csv()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new  Role_csv, 'Roles '.$fecha.'.csv');
    }

    public function query1PdfRole($all)
    {
        $query1 = Role::orderBy('name', 'asc')->get();

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
        $name= __("Roles");


        $pdf = PDF::loadView('roles.options.pdfAll', compact('name', 'query1', 'fecha', 'hora', 'idioma'));

        $pdf->setPaper("letter", "Portrait");

        return $pdf->stream($name.'.pdf');
        //return $pdf->download($name.'.pdf');

        //

    }



}
