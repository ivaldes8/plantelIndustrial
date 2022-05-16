<?php

namespace App\Exports;

use App\Models\nae;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CNAEExport implements FromCollection, WithHeadings
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
        return nae::select('codigo', 'desc' )->get();
    }
}
