<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\Format;
use App\MaterialFormat;
use App\MaterialProviderFormat;
use PDF;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function index($id) {
        //  $id = formatid
        // Listar todos los proveedores que tengan materiales que esten en una orden de compra (material_project).
        // Suma de costos de materiales dentro de (materialprovider_project) que sean del mismo proveedor GROUPBY

        $format = Format::find($id);

        $providers = \DB::select("
            SELECT * FROM providers WHERE providers.id IN (
            SELECT provider_id FROM materialprovider_project
            JOIN materials_providers
            ON materialprovider_project.materialprovider_id = materials_providers.id
            WHERE format_id = $id
        )");
        $totals = [];
        foreach($providers as $p) {
            $pId = $p->id;
            $tmp = MaterialProviderFormat::whereHas('providers', function($query) use ($pId) { $query->where('provider_id', $pId);})->with('providers.material')->with('providers.provider')->where('format_id', $id)->get();
            $totals[$p->id] = 0.00;
            foreach($tmp as $t) {
                $totals[$p->id] += $t->qty * $t->cost;
            }

        }
        // $providers = MaterialFormat::whereHas('materials.providers', function($query) use ($id) { $query->groupBy('provider_id');})->where('format_id', $id)->toSql();
        // dd($providers);
        // $providers = MaterialProviderFormat::whereHas('providers', function($query) use ($id) { $query->groupBy('provider_id');})->with('providers.provider')->where('format_id', $id)->get();
        // dd($providers);
        return view('orders.index', compact('format', 'providers', 'id', 'totals'));
    }

    public function genPdf($id, $formatId, $oderId) {
        // $providers = MaterialProviderFormat::with(['providers' => function ($query) { $query->where('provider_id', 2); }])->with('providers.material')->get();
        $providers = MaterialProviderFormat::whereHas('providers', function($query) use ($id) { $query->where('provider_id', $id);})->with('providers.material')->with('providers.provider')->where('format_id', $formatId)->get();
        // dd($providers);
        $format = Format::with('user')->whereId($formatId)->first();
        // return view('layouts.pdf.order', compact('providers', 'format', 'oderId'));
        $pdf =  PDF::loadView('layouts.pdf.order', compact('providers', 'format', 'oderId'));
        $name = Carbon::now()->toDateTimeString().'.pdf';
        return $pdf->download($name);
    }
}

