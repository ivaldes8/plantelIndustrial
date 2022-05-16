<?php

namespace App\Exports;

use App\Models\saclap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SACLAPExport implements FromCollection, WithHeadings
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
        return saclap::select('codigo', 'desc' )->get();
    }
}
