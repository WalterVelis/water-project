<?php

namespace App\Http\Controllers;

use App\MaterialFormat;
use App\MaterialProvider;
use App\MaterialProviderFormat;
use Illuminate\Http\Request;

class MaterialFormatController extends Controller
{
    public function getMaterials($projectId)
    {
        // Proveedores que tengan X material
        // En la vista, un ajax que recorra cada foreach
        $materialId = 9;
        $project_materials = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $projectId)->get();
        // dd($project_materials);
        foreach($project_materials as $pm) {
            $materialProvider[$pm->material_id] = MaterialProvider::with('provider')->with('materialProvider')->where('material_id', $pm->material_id)->get();
        }
        // dd($materialProvider);
        // $mp = MaterialProvider::with('provider')->where('material_id', $materialId)->get();
        // dd($mp);
        // $project_materials = MaterialProvider::whereHas('materialProvider', function($query) use ($projectId) {
        //     $query->where('format_id', $projectId);
        // })->get();
        // dd($project_materials);
        // $project_materials = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $projectId)->get();
        // $project_materials = MaterialFormat::whereHas('materials.providers.materialProvider', function($query) use ($projectId) { $query->where('format_id', $projectId);})->get();
        // dd($project_materials);
        // $pj = MaterialProviderFormat::whereHas('providers', function($query) use ($projectId) { $query->where('provider_id', $projectId);})->with('providers.material')->with('providers.provider')->where('format_id', $projectId)->get();
        // dd($pj);
        return view('techformat._materials', compact('project_materials', 'materialProvider'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function setMaterialProviderFormatQty(Request $request, $id, $formatId)
    {
        $materialProviderFormat = MaterialProviderFormat::find($id);
        // dd($materialProviderFormat);
        $materialProviderFormat->qty = $request->qty;
        $materialProviderFormat->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return MaterialFormat::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialFormat  $materialFormat
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialFormat $materialFormat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialFormat  $materialFormat
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialFormat $materialFormat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialFormat  $materialFormat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialFormat $materialFormat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialFormat  $materialFormat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MaterialFormat::find($id)->delete();
    }
}
