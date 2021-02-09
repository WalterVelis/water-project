<?php

namespace App\Http\Controllers;

use App\CostFormat;
use App\CostsCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class CostFormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dump($request->cost_id);
        $cost = CostsCenter::where('id', $request->cost_id)->first();
        // dd($cost);
        // $request->cost = $cost->unit_cost;
        $costFormat = new CostFormat;
        $costFormat->day = $request->day;
        $costFormat->cost = $cost->unit_cost;
        $costFormat->format_id = $request->format_id;
        $costFormat->cost_id = $request->cost_id;
        $costFormat->save();
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CostFormat  $costFormat
     * @return \Illuminate\Http\Response
     */
    public function show(CostFormat $costFormat)
    {
        //
    }

    public function getCosts($projectId)
    {
        $project_costs = CostFormat::with('costs')->where('format_id', $projectId)->get();
        // dd($project_costs);
        return view('techformat._costs', compact('project_costs'));
    }

    public function getCostsPdf($projectId)
    {
        $project_costs = CostFormat::with('costs')->where('format_id', $projectId)->get();
        // dd($project_costs);
        // return view('layouts.pdf.mo', compact('project_costs'));
        $pdf =  PDF::loadView('layouts.pdf.mo', compact('project_costs'));
        $name = 'Costos.pdf';
        return $pdf->setPaper('letter')->download($name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CostFormat  $costFormat
     * @return \Illuminate\Http\Response
     */
    public function edit(CostFormat $costFormat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CostFormat  $costFormat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostFormat $costFormat)
    {
        //
    }

    public function updateCost(Request $request, $costId, $projectId)
    {
        $data = CostFormat::where(['id' => $costId, 'format_id' => $projectId])->first();
        $data->cost = $request->cost;
        $data->save();
        dd($data);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CostFormat  $costFormat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CostFormat::find($id)->delete();
    }
}
