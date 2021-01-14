<?php

namespace App\Http\Controllers;

use App\MaterialFormat;
use App\MaterialProvider;
use App\MaterialProviderFormat;
use Illuminate\Http\Request;

class MaterialFormatController extends Controller
{
    public function getMaterials($projectId, $materialId = 16)
    {

        // $mp = MaterialProvider::where('material_id', $materialId)->get();

        // $mpf = \DB::select("
        // SELECT * FROM materialprovider_project WHERE format_id = $projectId AND materialprovider_project.materialprovider_id IN (
        //     SELECT id FROM materials_providers WHERE material_id = $materialId
        // )
        // ");


        // Proveedores que tengan X material
        // En la vista, un ajax que recorra cada foreach
        $project_materials = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $projectId)->get();

        foreach($project_materials as $pm) {
            // dump($pm->material_id );
            $materialProvider[$pm->material_id] = MaterialProvider::with('provider')->with(['materialProvider' => function ($query) use ($projectId) { $query->where("format_id", $projectId); }])->where('material_id', $pm->material_id)->get();
            // $materialProvider[$pm->material_id] = MaterialProvider::with('provider')->whereHas('materialProvider', function($query) use ($projectId) { $query->where("format_id", $projectId); })->where('material_id', $pm->material_id)->get();
        }
        // dd($materialProvider);
        return view('techformat._materials', compact('project_materials', 'materialProvider'));
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

    public function setMaterialProviderFormatQty(Request $request, $mpId, $formatId)
    {


        if($request->qty <= 0) {
            $materialProviderFormat = MaterialProviderFormat::where(['materialprovider_id' => $mpId, 'format_id' => $formatId])->delete();
            return;
        }

        $exist = MaterialProviderFormat::where(['materialprovider_id' => $mpId, 'format_id' => $formatId])->get();

        if($exist->isEmpty()) {
            // $cost = MaterialProviderFormat::with('providers')->where('materialprovider_id', $mpId)->get();
            $cost = MaterialProvider::where('id', $mpId)->first();
            // dd($cost->unit_cost);
            // si no hay registro, lo creamos
            $materialProviderFormat = new MaterialProviderFormat();
            $materialProviderFormat->qty = $request->qty;
            $materialProviderFormat->cost = $cost->unit_cost;
            $materialProviderFormat->materialprovider_id = $mpId;
            $materialProviderFormat->format_id = $formatId;
            $materialProviderFormat->save();


        }
        else {
            $materialProviderFormat = MaterialProviderFormat::where(['materialprovider_id' => $mpId, 'format_id' => $formatId])->update(['qty' => $request->qty]);
        }
        // dd($materialProviderFormat);
        // dd($materialProviderFormat);
        // $materialProviderFormat->qty = $request->qty;
        // $materialProviderFormat->save();
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
