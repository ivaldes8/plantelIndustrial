<?php

namespace App\Exports;

use App\Models\osde;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OSDEExport implements FromCollection, WithHeadings
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
        return osde::all();
    }
}
