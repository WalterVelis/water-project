<?php

namespace App\Http\Controllers;

use App\Exports\Cost_COST_csv;
use App\Material;
use App\MaterialFormat;
use App\MaterialProvider;
use App\MaterialProviderFormat;
use App\Exports\Material_COST_xlsx;
use App\Exports\Material_COST_csv;
use App\Provider;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function queryPdf()
    {
        $materials = MaterialProvider::with(['material', 'provider'])->get();

        $name = __("Materiales Extra");
        $pdf = PDF::loadView('materials.pdf', compact('materials'));
        $pdf->setPaper("letter", "Portrait");
        return $pdf->download($name.'.pdf');
    }

    public function queryXlsx()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Material_COST_xlsx, ''.$fecha.'.xlsx');
    }

    public function queryCsv()
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Material_COST_csv, ''.$fecha.'.csv');
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
        // dd($request->all());
        $materials = MaterialProvider::with(['material', 'provider'])->get();
        return view('materials.index',compact('materials'));
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
        // dd($request->provider_id);
        MaterialProvider::where('provider_id', );
        $request->validate([
            'name' => ['required'],
            'unit' => ['required'],
            'type' => ['required'],
            // 'cost' => ['required'],
            // 'provider_id' => ['required'],
        ]);
        // eliminar todos los materials_providers que tengan material_id que le mando
        $mat = MaterialProvider::where('material_id', $material->id)->get();

        // * Eliminar de materials_providers si no tiene nada en material_project
        //* if material_id in


        $idsThatWillBeIgnored = [];

        // Ignorar las que se están usando en levantamiento técnico
        foreach($mat as $m) {
            $check = MaterialFormat::whereIn('material_id', [$m->material_id])->get();
            // dump($check);
            if(!$check->isEmpty()) {
                array_push($idsThatWillBeIgnored, $m->provider_id);
                continue;
            } else {
                $deleted = MaterialProvider::whereId($m->id)->delete();
                // dump('deleted', $deleted);
            }
        }
        // dump("idsThatWillBeIgnored", $idsThatWillBeIgnored);

        // Actualiza el nombre de los materiales
        // $m = MaterialProvider::where('material_id', $material->id)->delete();
        $materialUpdate = $material->update($request->all());
        // $materialUpdate = Material::whereId($material->id)->update($request->all());
        // dump("updated", $materialUpdate);
        // Crea una nueva relación entre proveedor y material, ignorar las que ya existan
        foreach($request->provider_id as $k => $v) {
            if(in_array($v, $idsThatWillBeIgnored))
                continue;
            $materialProvider = new MaterialProvider;
            $materialProvider->provider_id = $v;
            $materialProvider->qty = $request->qty[$k];
            $materialProvider->unit_cost = $request->unit_cost[$k];
            $materialProvider->material_id = $material->id;
            $materialProvider->save();
            // dump("inserted", $materialProvider);
        }
        // dd($m);
        // MaterialProvider::where('material_id', $material->id)->delete();
        // de los eliminados, eliminar todos los que tengan el id del eliminado en materialprovider_project

        //eliminar todos, recrear todos
        // $mp = MaterialProvider::with('materialProvider')->where('provider_id', )->get();

        //Obtener todos
        // foreach($request->provider_id as $k => $provider_id) {
        //     $mp = MaterialProvider::with('materialProvider')->where('provider_id', $provider_id)->get();
        //     dump($mp);
        // }
        // dd("done");


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
