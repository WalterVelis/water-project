<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class User_csv implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function collection()
    {
        return DB::table('users as us')
            ->where('status', '1')
            ->join('roles as r','r.id','=','us.role_id')
            ->select('us.name','us.email','r.name as rol','us.created_at')
            ->orderby('us.name', 'asc')->get();
 
    }

    public function headings(): array
    {
        return [
            __('Name'),
            __('Email'),
            __('Role'),
            __('Creation Date'),
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
