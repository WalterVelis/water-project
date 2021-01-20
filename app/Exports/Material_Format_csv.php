<?php

namespace App\Exports;

use App\CostFormat;
use App\MaterialFormat;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Material_Format_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{
    protected $project_id;

    function __construct($project_id) {
            $this->project_id = $project_id;
    }

	 public function collection()    // Function containing the query to get the data.
    {
        $material = MaterialFormat::with('materials.providers.provider')->with('materials.providers.materialProvider')->where('format_id', $this->project_id)->get();
        return $material;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('ID'),
            __('Material'),
            __('Unidad'),
            __('Tipo de material'),
            __('Cantidad'),
        ];
    }

    public function map($material): array
    {
        return [
            $material->id,
            $material->materials->name,
            $material->materials->unitLabel(),
            $material->materials->type,
            $material->qty,
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
