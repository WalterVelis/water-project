<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(User::hasPermissions("Provider Index")){
            $providers = Provider::all();
            return view('provider.index',compact('providers'));
        // }else{
            return redirect('/');
        // }
        return view('provider.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'denomination' => ['required'],
            'contact_name' => ['required'],
            'job_title' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'rfc' => ['required'],
            'direccion' => ['required'],
            'product_type' => ['required'],
        ]);
        Provider::create($request->all());
        return redirect()->route('providers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        //
    }

    public function queryPdf(Provider $provider)
    {
        $providers = Provider::orderBy('denomination', 'asc')->get();
        $name = __("Proveedores");
        $pdf = PDF::loadView('provider.options.pdfAll', compact('providers'));
        $pdf->setPaper("letter", "Portrait");
        return $pdf->stream($name.'.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        return view('provider.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $request->validate([
            'denomination' => ['required'],
            'contact_name' => ['required'],
            'job_title' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'rfc' => ['required'],
            'direccion' => ['required'],
            'product_type' => ['required'],
        ]);
        $provider->update($request->all());
        return redirect()->route('providers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        try {
        $provider->delete();
        } catch (Throwable $e) {
            report($e);
            if($e->getCode() == "23000")
            return back()->with( ['error' => 'Aún existen materiales relacionados a este proveedor']);
        }
        return redirect()->route('providers.index')->with('success', 'Proveedor eliminado');
    }
}
