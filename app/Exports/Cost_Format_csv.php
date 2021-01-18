<?php

namespace App\Exports;

use App\CostFormat;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Cost_Format_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{

    protected $project_id;

    function __construct($project_id) {
            $this->project_id = $project_id;
    }

    public function collection()    // Function containing the query to get the data.
    {
        $data = CostFormat::with('costs')->where('format_id', $this->project_id)->get();
        return $data;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('Días'),
            __('Especialidad'),
            __('Costo Unitario'),
            __('Total'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->day,
            $data->costs->name,
            $data->cost,
            "$".$data->cost * $data->day,
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'use_bom'  => true,
        ];
    }
}
