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
        $entidades = entidad::all();
        $aux = [];
        foreach ($entidades as $key => $entidad) {
            array_push($aux,[$entidad->name, $entidad->codREU, $entidad->dpa, $entidad->organismo->codigo, $entidad->osde->codigo]);
        }

        return collect($aux);
    }
}
