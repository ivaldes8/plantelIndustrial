<?php

namespace App\Imports;

use App\Models\entidad;
use App\Models\organismo;
use App\Models\osde;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class EntidadImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $collection = LazyCollection::make($rows);

        Validator::make($collection->toArray(), [
            '*.codreu' => 'required|unique:entidads',
            '*.nombre' => 'required',
            '*.codorganismo' => 'required|exists:organismos,codigo',
            '*.codosde' => 'required|exists:osdes,codigo',
            '*.dpa' => 'required',

        ],
        [
            '*.codreu.required' => 'Hay códigos REU vacíos cerca de: :attribute',
            '*.codreu.unique' => 'El código reu :input ya se encuentra en la base de datos',
            '*.nombre.required' => 'Hay nombres vacíos cerca de: :attribute',
            '*.codorganismo.required' => 'Hay organismos vacíos cerca de: :attribute',
            '*.codorganismo.exists' => 'No existen organismos con el código: :input cerca de: :attribute ',
            '*.codosde.required' => 'Hay osdes vacías cerca de: :attribute',
            '*.codosde.exists' => 'No existen osdes con el código: :input cerca de: :attribute ',
            '*.dpa.required' => 'Hay dpa vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            entidad::create([
                'codREU' => $row['codreu'],
                'name' => $row['nombre'],
                'dpa' => $row['dpa'],
                'org_id' => organismo::where('codigo', $row['codorganismo'])->get()[0]->id,
                'osde_id' => osde::where('codigo', $row['codosde'])->get()[0]->id
            ]);
        }
    }

}
