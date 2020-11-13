<?php

namespace App\Http\Controllers;

use App\MaterialFormat;
use Illuminate\Http\Request;

class MaterialFormatController extends Controller
{
    public function getMaterials($projectId)
    {
        $project_materials = MaterialFormat::with('materials.providers.provider')->where('format_id', $projectId)->get();
        return view('techformat._materials', compact('project_materials'));
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
