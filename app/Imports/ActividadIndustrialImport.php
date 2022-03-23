<?php

namespace App\Imports;

use App\Models\actividad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class ActividadIndustrialImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // dd($rows);
        $collection = LazyCollection::make($rows);
        

        Validator::make($collection->toArray(), [
            '*.desc' => 'required|unique:actividads'
        ],
        [
            '*.desc.unique' => 'El código :input ya se encuentra en la base de datos',
            '*.desc.required' => 'Hay descripciones vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            actividad::create([
                'desc' => $row['desc']
            ]);
        }
    }
}
