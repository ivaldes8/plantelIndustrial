<?php

namespace App\Exports;

use App\Models\producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InformacionExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'indicador',
            'producto',
            'entidad',
            'date1->31-01-2022',
            'date2->28-02-2022',
            'date3->31-03-2022'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $aux = [0 => ['2/Kg', '32131.0100', '5469', '40', '500', '320']];
        return collect($aux);
    }
}
