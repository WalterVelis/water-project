<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Format;
use App\MaterialFormat;
use App\MaterialUtility;
use App\CostsUtility;
use App\AccesoryFormat;
use App\SchoolCost;
use App\CostFormat;
use App\MaterialProviderFormat;
use App\QuotationFormat;
use App\User;
use Carbon\Carbon;
use PDF;

class QuotationController extends Controller
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
        // saves on QuotationFormat
        $qf = QuotationFormat::create($request->all());
        return "
                <tr>
                    <td>-</td>
                    <td>$qf->description</td>
                    <td>$qf->qty</td>
                    <td>$qf->cost</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                ";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function genPdf($id)
    {
        $format = Format::with('vendor')->find($id);
        $quotation = Quotation::where('format_id', $id)->first();
        $subQuotation = QuotationFormat::where('format_id', $id)->get();
        // return view('layouts.pdf.quotation', compact('format', 'quotation', 'subQuotation'));
        $pdf =  PDF::loadView('layouts.pdf.quotation', compact('format', 'quotation', 'subQuotation'));
        $name = 'Cotizacion_'.Carbon::now()->format("Y-m-d").'.pdf';
        return $pdf->setPaper('letter', 'landscape')->download($name);

        $manoDeObra = CostFormat::with('costs')->where(['format_id' => $id])->get();
        $material = MaterialProviderFormat::whereHas('providers', function($query) use ($id) { $query->where('format_id', $id);})->where(['format_id' => $id])->get();
        $totalMaterial = 0;
        $totalIU = 0;
        $totalManoDeObra = 0;
        foreach($material as $m) {
            $totalMaterial += $m->qty * $m->cost;
        }

        // dd($manoDeObra);
        foreach($manoDeObra as $mo) {
            $totalManoDeObra += $mo->day * $mo->cost;
        }
        $materialUtility = MaterialUtility::whereFormat_id($id)->first();
        $costsUtility = CostsUtility::whereFormat_id($id)->first();
        $schoolCost = SchoolCost::where('format_id', $id)->first();
        $escuela = Format::select(['has_educational_programs', 'children'])->where('id', $id)->first();
        $costs = CostFormat::where('format_id', $id)->sum('cost');
        $accesoriesTotal = AccesoryFormat::where('format_id', $id)->get();
        foreach($accesoriesTotal as $at) {
            $totalIU += (($at->cost - ($at->cost * ($at->discount * 0.01))) * $at->qty);
        }
        // dd($totalIU);
        // $accesoryQty = AccesoryFormat::with('')
        // $materialsTotal = MaterialFormat::with('materials.providers')->where('format_id', $id)->get();
        // dd($materialsTotal);
        $quotation = QuotationFormat::where('format_id', $id)->get();
        $utility = Quotation::select('utility', 'indirect')->where('format_id', $id)->first();
        $allMaterials = $totalMaterial + $totalIU;
        // dd($quotation);

        $pdf =  PDF::loadView('layouts.pdf.quotation', compact('quotation', 'escuela', 'costs', 'allMaterials', 'schoolCost', 'utility', 'materialUtility', 'costsUtility', 'totalManoDeObra', 'totalIU', 'totalMaterial', 'manoDeObra'));
        $name = Carbon::now()->toDateTimeString().'.pdf';
        return $pdf->setPaper('letter', 'landscape')->stream($name);
        return view('quotation._table', compact('quotation', 'escuela', 'costs', 'allMaterials', 'schoolCost', 'utility', 'materialUtility', 'costsUtility', 'totalManoDeObra', 'totalIU', 'totalMaterial', 'manoDeObra'));
    }

    public function getTable($id)
    {
        $manoDeObra = CostFormat::with('costs')->where(['format_id' => $id])->get();
        $material = MaterialProviderFormat::whereHas('providers', function($query) use ($id) { $query->where('format_id', $id);})->where(['format_id' => $id])->get();
        $totalMaterial = 0;
        $totalIU = 0;
        $totalManoDeObra = 0;
        foreach($material as $m) {
            $totalMaterial += $m->qty * $m->cost;
        }

        // dd($manoDeObra);
        foreach($manoDeObra as $mo) {
            $totalManoDeObra += $mo->day * $mo->cost;
        }
        $materialUtility = MaterialUtility::whereFormat_id($id)->first();
        $costsUtility = CostsUtility::whereFormat_id($id)->first();
        $schoolCost = SchoolCost::where('format_id', $id)->first();
        $escuela = Format::select(['has_educational_programs', 'children'])->where('id', $id)->first();
        $costs = CostFormat::where('format_id', $id)->sum('cost');
        $accesoriesTotal = AccesoryFormat::where('format_id', $id)->get();
        foreach($accesoriesTotal as $at) {
            $totalIU += (($at->cost - ($at->cost * ($at->discount * 0.01))) * $at->qty);
        }
        // dd($totalIU);
        // $accesoryQty = AccesoryFormat::with('')
        // $materialsTotal = MaterialFormat::with('materials.providers')->where('format_id', $id)->get();
        // dd($materialsTotal);
        $quotation = QuotationFormat::where('format_id', $id)->get();
        $utility = Quotation::select('utility', 'indirect')->where('format_id', $id)->first();
        $allMaterials = $totalMaterial + $totalIU;
        // dd($quotation);
        if(User::hasPermissions("Admin")){
            return view('quotation._table', compact('quotation', 'escuela', 'costs', 'allMaterials', 'schoolCost', 'utility', 'materialUtility', 'costsUtility', 'totalManoDeObra', 'totalIU', 'totalMaterial', 'manoDeObra'));
        }
        return view('quotation._table-vendor', compact('quotation', 'escuela', 'costs', 'allMaterials', 'schoolCost', 'utility', 'materialUtility', 'costsUtility', 'totalManoDeObra', 'totalIU', 'totalMaterial', 'manoDeObra'));

    }

    public function applyUtility(Request $request, $id) {
        QuotationFormat::where('format_id', $id)->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        MaterialUtility::where('format_id', $id)->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        CostsUtility::where('format_id', $id)->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        SchoolCost::where('format_id', $id)->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        // $quotation->utility = $request->utility;
        // $quotation->indirect = $request->indirect;
        // $quotation->save();
    }

    public function applyIndividualUtility(Request $request) {
        // QuotationFormat::where(['format_id' => $format_id, 'id' => $id])->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        if($request->type === "0") {
            $update = CostsUtility::where(['format_id' => $request->format_id])->update(['utility' => $request->utility]);
            dump($request->utility);
        } else {
            $update = CostsUtility::where(['format_id' => $request->format_id])->update(['indirect' => $request->indirect]);
            dump($request->indirect);
        }
        // $quotation->utility = $request->utility;
        // $quotation->indirect = $request->indirect;
        // $quotation->save();
    }

    public function applyIndividualSchoolUtility(Request $request) {
        // QuotationFormat::where(['format_id' => $format_id, 'id' => $id])->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        if($request->type === "0") {
            $update = SchoolCost::where(['format_id' => $request->format_id])->update(['utility' => $request->utility]);
            dump($request->utility);
        } else {
            $update = SchoolCost::where(['format_id' => $request->format_id])->update(['indirect' => $request->indirect]);
            dump($request->indirect);
        }
        // $quotation->utility = $request->utility;
        // $quotation->indirect = $request->indirect;
        // $quotation->save();
    }
    public function applyIndividualQuotationlUtility(Request $request) {
        // QuotationFormat::where(['format_id' => $format_id, 'id' => $id])->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        dump($request->all());
        if($request->type === "0") {
            $update = QuotationFormat::where(['format_id' => $request->format_id, 'id' => $request->u_id])->update(['utility' => $request->utility]);
            dump($request->utility);
        } else {
            $update = QuotationFormat::where(['format_id' => $request->format_id, 'id' => $request->u_id])->update(['indirect' => $request->indirect]);
            dump($request->indirect);
        }
        // $quotation->utility = $request->utility;
        // $quotation->indirect = $request->indirect;
        // $quotation->save();
    }
    public function applyIndividualMaterialUtility(Request $request) {
        // QuotationFormat::where(['format_id' => $format_id, 'id' => $id])->update(['utility' => $request->utility, 'indirect' => $request->indirect]);
        if($request->type === "0") {
            $update = MaterialUtility::where(['format_id' => $request->format_id])->update(['utility' => $request->utility]);
            dump($request->utility);
        } else {
            $update = MaterialUtility::where(['format_id' => $request->format_id])->update(['indirect' => $request->indirect]);
            dump($request->indirect);
        }
        // $quotation->utility = $request->utility;
        // $quotation->indirect = $request->indirect;
        // $quotation->save();
    }

    public function updateSchool(Request $request)
    {
        $schoolCost = SchoolCost::where('format_id', $request->format_id)->first();
        $schoolCost->cost = $request->cost;
        $schoolCost->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $format = Format::find($id);
        $quotation = Quotation::where('format_id', $id)->first();
        // dd($quotation->id);
        return view('quotation.edit', compact('format', 'quotation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quotation = Quotation::where('format_id', $id);
        // dd($quotation);
        $quotation->update($request->except(['_token', '_method', 'status']));


        $internalStatus = 0;
        if($request->status)
            $internalStatus = 3;

        $format = Format::find($id);
        if($format->internal_status >= 3)
            $internalStatus = $format->internal_status;
        // dd($internalStatus);
        $format->internal_status = $internalStatus;
        $format->save();

        return redirect()->route('quotation.edit', $id)->with('success', 'Project Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = QuotationFormat::find($id)->delete();
        // dd($quote);
    }
}
