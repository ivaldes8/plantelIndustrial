<?php

namespace App\Exports;

use App\Models\producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductoExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'id',
            'creando en',
            'última actualización',
            'nombre',
            'codreu',
            'dpa',
            'codorganismo',
            'codosde'

        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return producto::all();
    }
}
