<?php

namespace App\Http\Controllers;

use App\TechFormat;
use Illuminate\Http\Request;

class TechFormatController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TechFormat  $techFormat
     * @return \Illuminate\Http\Response
     */
    public function show(TechFormat $techFormat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TechFormat  $techFormat
     * @return \Illuminate\Http\Response
     */
    public function edit(TechFormat $techFormat)
    {
        return view('techformat.edit', compact('techFormat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TechFormat  $techFormat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TechFormat $techFormat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TechFormat  $techFormat
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechFormat $techFormat)
    {
        //
    }
}
