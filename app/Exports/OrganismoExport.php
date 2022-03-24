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
            'id',
            'nombre',
            'siglas',
            'codigo',
            'creando en',
            'última actualización'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return organismo::all();
    }
}
