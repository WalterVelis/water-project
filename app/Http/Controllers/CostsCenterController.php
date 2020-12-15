<?php

namespace App\Http\Controllers;

use App\CostsCenter;
use Illuminate\Http\Request;

use PDF;

class CostsCenterController extends Controller
{
    public function queryPdf()
    {
        $manoDeObra = CostsCenter::orderBy('name', 'asc')->get();
        $name = __("Mano de obra");
        $pdf = PDF::loadView('costs.options.pdfAll', compact('manoDeObra'));
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
        // if(User::hasPermissions("Provider Index")){
            $costs = CostsCenter::all();
            return view('costs.index',compact('costs'));
        // }else{
            return redirect('/');
        // }
        return view('costs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('costs.create');
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
            'unit_cost' => ['required'],
        ]);
        CostsCenter::create($request->all());
        return redirect()->route('costs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CostsCenter  $costsCenter
     * @return \Illuminate\Http\Response
     */
    public function show(CostsCenter $costsCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CostsCenter  $costsCenter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $costsCenter = CostsCenter::find($id);
        return view('costs.edit', compact('costsCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CostsCenter  $costsCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'unit_cost' => ['required'],
        ]);
        $costsCenter = CostsCenter::find($id);
        $costsCenter->update($request->all());
        return redirect()->route('costs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CostsCenter  $costsCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $costsCenter = CostsCenter::find($id);
        $costsCenter->delete();
        return redirect()->route('costs.index')->with('success', 'Costo eliminado');
    }
}
