<?php

namespace App\Exports;

use App\CostFormat;
use App\Format;
use App\Role;
use App\User;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use DB;
use Illuminate\Support\Facades\Auth;

class Project_csv implements FromCollection, WithCustomCsvSettings, WithHeadings, WithMapping
{

    public function collection()    // Function containing the query to get the data.
    {
        $projects = null;
        if(User::hasPermissions("Vendor")){
            $projects = Format::where('created_by', Auth::id())->get();
        }

        if(User::hasPermissions("Tech")){
            $projects = Format::where('tech_assigned', Auth::id())->orWhere('created_by', Auth::id())->get();
        }

        if(User::hasPermissions("Admin")){
            $projects = Format::with("tech", "vendor")->get();
        }

        return $projects;
    }

    public function headings(): array   // Function where the headers are specified.
    {
        if(User::hasPermissions("Admin")) {
            return [
                __('Folio'),
                __('Cliente'),
                __('Contacto principal'),
                __('Lugar'),
                __('Fecha primer contacto'),
                __('Vendedor asignado'),
                __('Técnico asignado'),
                __('Fecha cotización'),
                __('Estado'),
            ];
        }

        if(User::hasPermissions("Vendor")) {
            return [
                __('Folio'),
                __('Cliente'),
                __('Contacto principal'),
                __('Lugar'),
                __('Fecha primer contacto'),
                __('Técnico asignado'),
                __('Fecha cotización'),
                __('Estado'),
            ];
        }

        if(User::hasPermissions("Tech")) {
            return [
                __('Folio'),
                __('Cliente'),
                __('Contacto principal'),
                __('Lugar'),
                __('Fecha primer contacto'),
                __('Vendedor asignado'),
                __('Fecha cotización'),
                __('Estado'),
            ];
        }

    }

    public function map($data): array
    {
        if(User::hasPermissions("Admin")) {
            return [
                $data->page,
                $data->client,
                $data->main_contact,
                $data->state." ".$data->municipality,
                $data->date,
                $data->vendor->name,
                $data->tech->name,
                $data->created_at->format('Y-m-d'),
                $data->status == 2 ? "No factible" : $data->statusLabel(),
            ];
        }

        if(User::hasPermissions("Vendor")) {
            return [
                $data->page,
                $data->client,
                $data->main_contact,
                $data->state." ".$data->municipality,
                $data->date,
                $data->tech->name,
                $data->created_at->format('Y-m-d'),
                $data->status == 2 ? "No factible" : $data->statusLabel(),
            ];
        }

        if(User::hasPermissions("Tech")) {
            return [
                $data->page,
                $data->client,
                $data->main_contact,
                $data->state." ".$data->municipality,
                $data->date,
                $data->vendor->name,
                $data->created_at->format('Y-m-d'),
                $data->status == 2 ? "No factible" : $data->statusLabel(),
            ];
        }
     }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'use_bom'  => true,
        ];
    }
}
