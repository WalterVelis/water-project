<?php

namespace App\Exports;

use App\AccesoryFormat;
use App\AccesoryUrban;
use App\CostFormat;
use App\CostsCenter;
use App\MaterialFormat;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Cost_COST_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{
    public function collection()    // Function containing the query to get the data.
    {
        $data = CostsCenter::orderBy('name', 'asc')->get();
        return $data;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('ID'),
            __('Nombre'),
            __('Precio unitario'),
            __('Fecha actualización'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->name,
            "$".$data->unit_cost,
            $data->updated_at->format('Y-m-d'),
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
