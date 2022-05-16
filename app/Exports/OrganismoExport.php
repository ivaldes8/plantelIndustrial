<?php

namespace App\Exports;

use App\Models\organismo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrganismoExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'nombre',
            'siglas',
            'codigo'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return organismo::select('name', 'siglas', 'codigo')->get();
    }
}
