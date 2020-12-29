<?php

namespace App\Http\Controllers;

use App\AccesoryUrban;
use Illuminate\Http\Request;

use PDF;

class AccesoryUrbanController extends Controller
{
    public function queryPdf()
    {
        $accesories = AccesoryUrban::orderBy('name', 'asc')->get();
        $name = __("Accesorios IU");
        $pdf = PDF::loadView('accesory.options.pdfAll', compact('accesories'));
        $pdf->setPaper("letter", "Portrait");
        return $pdf->stream($name.'.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accesories = AccesoryUrban::all();
        return view('accesory.index',compact('accesories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accesory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'qty' => ['required'],
            'unit_cost' => ['required'],
            'discount' => ['required'],
        ]);
        AccesoryUrban::create($request->all());
        return redirect()->route('accesory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccesoryUrban  $accesoryUrban
     * @return \Illuminate\Http\Response
     */
    public function show(AccesoryUrban $accesoryUrban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccesoryUrban  $accesoryUrban
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accesoryUrban = AccesoryUrban::find($id);
        return view('accesory.edit', compact('accesoryUrban'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccesoryUrban  $accesoryUrban
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'qty' => ['required'],
            'unit_cost' => ['required'],
        ]);
        $accesoryUrban = accesoryUrban::find($id);
        $accesoryUrban->update($request->all());
        return redirect()->route('accesory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccesoryUrban  $accesoryUrban
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accesory = AccesoryUrban::find($id);
        $accesory->delete();
        return redirect()->route('accesory.index')->with('success', 'Accesorio eliminado');
    }
}
