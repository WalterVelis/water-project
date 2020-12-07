<?php

namespace App\Http\Controllers;

use App\TechFormat;
use App\Material;
use App\AccesoryUrban;
use App\CostsCenter;
use App\Entity;
use App\Format;
use App\Mail\TechFormatNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class TechFormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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


    public function genPdf($id)
    {
        $entities[0] = Entity::where(['project_id' => $id, 'entity_type' => 0])->get();
        $entities[1] = Entity::where(['project_id' => $id, 'entity_type' => 1])->get();
        $format = Format::with(['user', 'country'])->find($id);
        $tech = TechFormat::with('format.user')->where('format_id', $id)->first();
        // return view('layouts.pdf.tech', compact('format', 'entities', 'tech'));
        $pdf =  PDF::loadView('layouts.pdf.tech', compact('format', 'entities', 'tech'));
        $name = Carbon::now()->toDateTimeString().'.pdf';
        return $pdf->setPaper('letter')->download($name);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TechFormat  $techFormat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $format = Format::find($id);
        $costs = CostsCenter::all();
        $materials = Material::all();
        $accesories = AccesoryUrban::all();
        $techFormat = TechFormat::where('format_id', $id)->first();
        return view('techformat.edit', compact('format', 'techFormat', 'costs', 'materials', 'accesories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TechFormat  $techFormat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->status);

        $water_quality = implode(",",$request->water_quality);
        $roof_type = implode(",",$request->roof_type);
        $rooftop = implode(",",$request->rooftop);
        $techFormat = TechFormat::find($id);
        $techFormat->water_quality = $water_quality;
        $techFormat->roof_type = $roof_type;
        $techFormat->obtaining_water = $request->obtaining_water;
        $techFormat->rooftop = $rooftop;
        $techFormat->rainwater_area = $request->rainwater_area;
        $techFormat->gutter = $request->gutter;
        $techFormat->anual_precipitation = $request->anual_precipitation;
        $techFormat->water_tank = $request->water_tank;
        $techFormat->distance = $request->distance;
        $techFormat->cleanliness = $request->cleanliness;
        $techFormat->roof_slope = $request->roof_slope;
        $techFormat->tube = $request->tube;
        $techFormat->diameter = $request->diameter;
        $techFormat->pump = $request->pump;
        $techFormat->diameter_inch = $request->diameter_inch;
        $techFormat->pump_below_tank = $request->pump_below_tank;
        $techFormat->pump_inundation = $request->pump_inundation;
        $techFormat->filter_stall = $request->filter_stall;
        $techFormat->notes = $request->notes;
        $techFormat->excavation = $request->excavation;
        $techFormat->d_float = $request->d_float;
        $techFormat->control = $request->control;
        $techFormat->require_connection = $request->require_connection;
        $techFormat->electro = $request->electro;
        $techFormat->subnotes = $request->subnotes;
        $techFormat->description = $request->description;

        $techFormat->save();

        $internalStatus = 0;
        if($request->status) {
            $internalStatus = 2;
            $data = Format::with(['user', 'vendor', 'tech', 'admin'])->find($id);
            // dd($data->vendor->email);
            Mail::to([$data->vendor->email, $data->admin->email])->send(new TechFormatNotification($data));
        }

        $format = Format::find($id);
        if($format->internal_status >= 2)
            $internalStatus = $format->internal_status;
        $format->internal_status = $internalStatus;
        $format->save();

        return redirect()->route('techformat.edit', $id)->with('success', 'Project Deleted');
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
