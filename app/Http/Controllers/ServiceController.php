<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(User::hasPermissions("Service Index")){
            $services = Service::where('is_active', true)->orderBy('name', 'asc')->get();
            return view('services.index',compact('services'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(User::hasPermissions("Service Create")){
            $categories = Category::where('is_active', true)->orderBy('name', 'asc')->get();
            return view('services.create', compact('categories'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        //
        try{
            $service = new Service();
            $service->name = $request->name;
            $service->category_id = $request->category_id;
            $service->save();
            return redirect()->route('service.index')->withStatus(__('Service successfully created.'));
        } catch(\Exception $e){
            return redirect()->route('service.index')->withError(__('There was an error in making your request'));            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
        if(User::hasPermissions("Service Edit")){
            $categories = Category::where('is_active', true)->orderBy('name', 'asc')->get();
            return view('services.edit', compact('categories', 'service'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        //
        try{
            $service = Service::findorFail($id);
            $service->name = $request->name;
            $service->category_id = $request->category_id;
            $service->update();
            return redirect()->route('service.index')->withStatus(__('Service was successfully edited.'));
        } catch(\Exception $e){
            return redirect()->route('service.index')->withError(__('There was an error in making your request'));            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $service = Service::findorFail($id);
            $service->is_active = false;
            $service->update();
            return redirect()->route('service.index')->withStatus(__('Service successfully removed.'));
        } catch(\Exception $e){
            return redirect()->route('service.index')->withError(__('There was an error in making your request'));            
        }
    }
}
