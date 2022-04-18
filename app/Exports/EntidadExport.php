<?php

namespace App\Exports;

use App\Models\entidad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntidadExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'id',
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
        $entidades = entidad::first()->organismo()->select('*')->get();
        dd($entidades);
        return entidad::all();
    }
}
