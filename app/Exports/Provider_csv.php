<?php

namespace App\Exports;

use App\AccesoryFormat;
use App\AccesoryUrban;
use App\CostFormat;
use App\MaterialFormat;
use App\Provider;
use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;

class Provider_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{
    public function collection()    // Function containing the query to get the data.
    {
        return Provider::all();
    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('Razón social'),
            __('Contacto'),
            __('Correo'),
            __('Teléfono'),
            __('Tipo de producto'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->denomination,
            $data->contact_name,
            $data->email,
            $data->phone,
            $data->productTypeLabels(),
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
