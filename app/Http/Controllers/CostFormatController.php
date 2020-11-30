<?php

namespace App\Http\Controllers;

use App\CostFormat;
use App\CostsCenter;
use Illuminate\Http\Request;

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
        $cost = CostsCenter::find($request->cost_id)->pluck('unit_cost')->first();
        $request->cost = $cost;
        $costFormat = new CostFormat;
        $costFormat->day = $request->day;
        $costFormat->cost = $cost;
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
