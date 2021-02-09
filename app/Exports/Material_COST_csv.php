<?php

namespace App\Exports;

use App\AccesoryFormat;
use App\AccesoryUrban;
use App\CostFormat;
use App\MaterialFormat;
use App\MaterialProvider;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Material_COST_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{
    public function collection()    // Function containing the query to get the data.
    {
        $data = MaterialProvider::with(['material', 'provider'])->get();
        return $data;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('ID'),
            __('Existencia'),
            __('Nombre material'),
            __('Tipo material'),
            __('Costo Unitario'),
            __('Fecha actualización'),
            __('Proveedor'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->qty,
            $data->material->name,
            $data->material->type,
            "$".$data->unit_cost,
            $data->updated_at,
            $data->provider->denomination,
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
