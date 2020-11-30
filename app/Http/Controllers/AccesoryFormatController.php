<?php

namespace App\Http\Controllers;

use App\AccesoryFormat;
use Illuminate\Http\Request;

class AccesoryFormatController extends Controller
{

    public function getAccesories($projectId)
    {
        $project_materials = AccesoryFormat::with('accesory')->where('format_id', $projectId)->get();
        // dd($project_materials);
        return view('techformat._accesory', compact('project_materials'));
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
        return AccesoryFormat::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccesoryFormat  $accesoryFormat
     * @return \Illuminate\Http\Response
     */
    public function show(AccesoryFormat $accesoryFormat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccesoryFormat  $accesoryFormat
     * @return \Illuminate\Http\Response
     */
    public function edit(AccesoryFormat $accesoryFormat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccesoryFormat  $accesoryFormat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccesoryFormat $accesoryFormat)
    {
        //
    }

    public function updateCost(Request $request, $id, $projectId)
    {
        $data = AccesoryFormat::where(['id' => $id, 'format_id' => $projectId])->first();
        $data->cost = $request->cost;
        $data->save();
    }

    public function updateDiscount(Request $request, $id, $projectId)
    {
        $data = AccesoryFormat::where(['id' => $id, 'format_id' => $projectId])->first();
        $data->discount = $request->discount;
        $data->save();
    }

    public function updateDetails(Request $request, $id, $projectId)
    {
        $data = AccesoryFormat::where(['id' => $id, 'format_id' => $projectId])->first();
        $data->details = $request->details;
        $data->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccesoryFormat  $accesoryFormat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return AccesoryFormat::find($id)->delete();
    }
}
