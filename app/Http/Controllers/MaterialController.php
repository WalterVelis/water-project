<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialProvider;
use App\MaterialProviderFormat;
use App\Provider;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = MaterialProvider::with(['material', 'provider'])->get();
        return view('materials.index',compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = Provider::all();
        return view('materials.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => ['required'],
        //     'type' => ['required'],
        //     'unit' => ['required'],
        // ]);
        $material = Material::create($request->all());
        foreach($request->provider_id as $k => $v) {
            $materialProvider = new MaterialProvider;
            $materialProvider->provider_id = $v;
            $materialProvider->qty = $request->qty[$k];
            $materialProvider->unit_cost = $request->unit_cost[$k];
            $materialProvider->material_id = $material->id;
            $materialProvider->save();
        }
        dd($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $allProviders = Provider::all();
        $providers = MaterialProvider::with(['material','provider'])->where('material_id', $material->id)->get();
        $alreadyProvided = [];
        foreach($providers as $p){
            array_push($alreadyProvided, $p->provider_id);

        }
        // dd($alreadyProvided);
        return view('materials.edit', compact('material', 'providers', 'allProviders', 'alreadyProvided'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {

        // eliminar todos los materials_providers que tengan material_id que le mando
        $m = MaterialProvider::where('material_id', $material->id)->get();
        dd($m);
        MaterialProvider::where('material_id', $material->id)->delete();
        // de los eliminados, eliminar todos los que tengan el id del eliminado en materialprovider_project

        //eliminar todos, recrear todos
        // $mp = MaterialProvider::with('materialProvider')->where('provider_id', )->get();

        //Obtener todos
        foreach($request->provider_id as $k => $provider_id) {
            $mp = MaterialProvider::with('materialProvider')->where('provider_id', $provider_id)->get();
            dump($mp);
        }
        dd("done");
        MaterialProvider::where('provider_id', );
        $request->validate([
            'name' => ['required'],
            'unit' => ['required'],
            'type' => ['required'],
            // 'cost' => ['required'],
            // 'provider_id' => ['required'],
        ]);
        $material->update($request->all());
        return redirect()->route('materials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material eliminado');
    }
}
