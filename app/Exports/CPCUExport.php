<?php

namespace App\Exports;

use App\Models\cpcu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CPCUExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'codigo',
            'desc',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return cpcu::select('codigo', 'desc' )->get();
    }
}
