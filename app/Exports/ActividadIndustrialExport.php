<?php

namespace App\Exports;

use App\Models\actividad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActividadIndustrialExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'codigo',
            'desc'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return actividad::select('codigo', 'desc' )->get();
    }
}
