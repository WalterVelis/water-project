<?php

namespace App\Exports;

use App\AccesoryFormat;
use App\CostFormat;
use App\MaterialFormat;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Accesory_Format_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{
    protected $project_id;

    function __construct($project_id) {
            $this->project_id = $project_id;
    }

	 public function collection()    // Function containing the query to get the data.
    {
        $data = AccesoryFormat::with('accesory')->where('format_id', $this->project_id)->get();
        return $data;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('ID'),
            __('Material'),
            __('Piezas'),
            __('Costo Unitario'),
            __('Costo (sin IVA'),
            __('Descuento (%)'),
            __('Costo con descuento'),
            __('Total'),
            __('Observaciones'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->accesory->name,
            $data->qty,
            "$".$data->cost,
            "$".($data->cost - ($data->cost * 0.16)),
            $data->discount,
            "$".($data->cost - ($data->discount / 100) * $data->cost),
            "$".($data->cost - ($data->discount / 100) * $data->cost) * $data->qty,
            $data->details,
         ];
     }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'use_bom'  => true,
        ];
    }
}
