<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialProvider;
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
        $providers = Provider::all();
        return view('materials.edit', compact('material', 'providers'));
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
        $request->validate([
            'name' => ['required'],
            'qty' => ['required'],
            'type' => ['required'],
            'cost' => ['required'],
            'provider_id' => ['required'],
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
