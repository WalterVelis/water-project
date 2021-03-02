<?php

namespace App\Exports;

use App\AccesoryFormat;
use App\AccesoryUrban;
use App\CostFormat;
use App\MaterialFormat;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Accesory_COST_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{
    public function collection()    // Function containing the query to get the data.
    {
        $data = AccesoryUrban::orderBy('name', 'asc')->get();
        return $data;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('ID'),
            __('Existencia'),
            __('Nombre'),
            __('Precio unitario'),
            __('Descuento (%)'),
            __('Fecha actualización'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->qty,
            $data->name,
            "$".$data->unit_cost,
            $data->discount,
            $data->updated_at,
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
