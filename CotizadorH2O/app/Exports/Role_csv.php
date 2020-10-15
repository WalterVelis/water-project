<?php

namespace App\Exports;

use App\Role;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class Role_csv implements FromCollection, WithCustomCsvSettings, WithHeadings
{
	public function collection()
    {
        return DB::table('roles')
            ->select('name','description','created_at')
            ->orderby('name', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            __('Name'),
            __('Description'),
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
