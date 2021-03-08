<?php

namespace App\Http\Controllers;

use App\AccesoryFormat;
use App\TechFormat;
use App\Material;
use App\AccesoryUrban;
use App\CostFormat;
use App\CostsCenter;
use App\Entity;
use App\Exports\Accesory_Format_csv;
use App\Exports\Accesory_Format_xlsx;
use App\Exports\Cost_Format_csv;
use App\Exports\Cost_Format_xlsx;
use App\Exports\Material_Format_csv;
use App\Exports\Material_Format_xlsx;
use Maatwebsite\Excel\Facades\Excel;


use App\Format;
use App\Mail\TechFormatNotification;
use App\MaterialFormat;
use App\MaterialProvider;
use App\Notify;
use App\User;
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


    public function getMatPdf($id) {

        $project_materials = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $id)->get();
        // dd($project_materials);
        foreach($project_materials as $pm) {
            // dump($pm->material_id );
            $materialProvider[$pm->material_id] = MaterialProvider::with('provider')->with('materialProvider')->where('material_id', $pm->material_id)->get();
        }
        // return view('techformat._materials', compact('project_materials', 'materialProvider'));

        $pdf =  PDF::loadView('layouts.pdf.techMat', compact('project_materials', 'materialProvider'));
        $name = 'Materiales Tecnico.pdf';
        return $pdf->setPaper('letter', 'landscape')->download($name);
    }

    public function getMatAdminPdf($projectId)
    {
        $project_materials = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $projectId)->get();

        foreach($project_materials as $pm) {
            $materialProvider[$pm->material_id] = MaterialProvider::with('provider')->with(['materialProvider' => function ($query) use ($projectId) { $query->where("format_id", $projectId); }])->where('material_id', $pm->material_id)->get();
        }

        $pdf =  PDF::loadView('layouts.pdf.techMatAdmin', compact('project_materials', 'materialProvider'));
        $name = 'Materiales Tecnico.pdf';
        return $pdf->setPaper('letter', 'landscape')->download($name);
    }


    public function getKitPdf($id) {

        $kit = AccesoryFormat::with('accesory')->where('format_id', $id)->get();
        $pdf =  PDF::loadView('layouts.pdf.techKit', compact('kit'));
        $name = 'Accesorios Tecnico.pdf';
        return $pdf->setPaper('letter', 'landscape')->download($name);
    }

    public function genPdf($id)
    {
        $entities[0] = Entity::where(['project_id' => $id, 'entity_type' => 0])->get();
        $entities[1] = Entity::where(['project_id' => $id, 'entity_type' => 1])->get();
        $format = Format::with(['user', 'country'])->find($id);
        $tech = TechFormat::with('format.user')->where('format_id', $id)->first();
        // return view('layouts.pdf.tech', compact('format', 'entities', 'tech'));
        $pdf =  PDF::loadView('layouts.pdf.tech', compact('format', 'entities', 'tech'));
        $name = 'Formato Tecnico.pdf';
        return $pdf->setPaper('letter', 'landscape')->download($name);
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
        $materials = Material::with('providers.materialProvider')->get();
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

        $water_quality = "";
        $filter_type = "";
        $roof_type = "";
        $rooftop = "";

        if($request->water_quality != null)
            $water_quality = implode(",",$request->water_quality);

            if($request->filter_type != null)
            $filter_type = implode(",",$request->filter_type);

        if($request->roof_type != null)
            $roof_type = implode(",",$request->roof_type);

        if($request->rooftop != null)
            $rooftop = implode(",",$request->rooftop);

        $techFormat = TechFormat::find($id);
        $techFormat->water_quality = $water_quality;
        $techFormat->filter_type = $filter_type;
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
        $format = Format::find($id);
        $internalStatus = 3;
        if($request->status) {
            $internalStatus = 3;
            $data = Format::with(['user', 'vendor', 'tech', 'admin'])->find($id);
            // dd($data, $data->vendor->id, $data->admin->id);
            Mail::to([$data->vendor->email, $data->admin->email])->send(new TechFormatNotification($data));

            Notify::create(["user_id" => $data->vendor->id, "msg" => "<a href='/projects/".$format->id."/edit'><div class='c-not'>".$data->tech->name." finalizó el registro de levantamiento técnico del proyecto .". $format->page."</a></div>"]);
            Notify::create(["user_id" => $data->admin->id, "msg" => "<a href='/projects/".$format->id."/edit'><div class='c-not'>".$data->tech->name." finalizó el registro de levantamiento técnico del proyecto .". $format->page."</a></div>"]);


            // Update qty on IU and ME

            //Update ME
            $project_materials = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $id)->get();

            foreach($project_materials as $pm) {
                $materialProvider[$pm->material_id] = MaterialProvider::with('provider')->with(['materialProvider' => function ($query) use ($id) { $query->where("format_id", $id); }])->where('material_id', $pm->material_id)->get();
            }

            foreach($project_materials as $item) {
                foreach($materialProvider[$item->material_id] as $mpp) {
                    // dump($materialProvider[$item->material_id]);
                    // dump($mpp->provider->denomination);
                    $provider_id = $mpp->provider->id;
                    $material_id = $item->material_id;
                    $tmSum = @$mpp->materialProvider->qty;

                    if($mpp->materialProvider) {

                        // dump("r", $provider_id, $material_id);

                        // dump($provider_id, $material_id);
                        $prevQty = MaterialProvider::select("qty")->where('provider_id', $provider_id)->where('material_id', $material_id)->limit(1)->pluck("qty");
                        // dump($prevQty);
                        // dump("prevQty");
                        if(!$prevQty->isEmpty()){
                            $nqt = $prevQty[0] - $tmSum;
                            $willUpdate = MaterialProvider::where('provider_id', $provider_id)->where('material_id', $material_id)->update(['qty' => $nqt]);
                        }

                    }
                }
            }


            // Update IU

            if(User::hasPermissions("Admin")){
                $accesoryFormat = AccesoryFormat::with('accesory')->where('format_id', $id)->get();

                foreach($accesoryFormat as $af) {
                    $accesory = AccesoryUrban::find($af->accesory_id);
                    $nqty = $accesory->qty - $af->qty;
                    AccesoryUrban::find($af->accesory_id)->update(["qty" => $nqty]);
                }
            }


            // dd("as");

        }


        $status = 1;
        if($request->factible) {
            $status = 2;
        } else if($request->factible === "0") {
            $status = 3;
        }

        $format = Format::find($id);
        $format->status = $status;
        $format->why_not_feasible = $request->why_not_feasible;
        // dd($format);
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


    public function export_materials($project_id)
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Material_Format_xlsx($project_id), ''.$fecha.'.xlsx');
    }

    public function export_costs($project_id)
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Cost_Format_xlsx($project_id), ''.$fecha.'.xlsx');
    }

    public function export_accesories($project_id)
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Accesory_Format_xlsx($project_id), ''.$fecha.'.xlsx');
    }


    public function export_materials_csv($project_id)
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Material_Format_csv($project_id), ''.$fecha.'.csv');
    }

    public function export_costs_csv($project_id)
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Cost_Format_csv($project_id), ''.$fecha.'.csv');
    }

    public function export_accesories_csv($project_id)
    {
        $date=new Carbon();
        $fecha = $date->format('d-m-Y');
        return Excel::download(new Accesory_Format_csv($project_id), ''.$fecha.'.csv');
    }
}
