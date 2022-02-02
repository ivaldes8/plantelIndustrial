<?php
  
namespace App\Imports;

use App\Models\entidad;
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
        // dd($rows);
        $collection = LazyCollection::make($rows);
        

        Validator::make($collection->toArray(), [
            '*.codREU' => 'required',
            '*.nombre' => 'required',
            '*.codOrganismo' => 'required',
            '*.codOSDE' => 'required',
            '*.dpa' => 'required',
            
        ],
        [
            '*.codREU.required' => 'Hay códigos REU vacíos cerca de: :attribute',
            '*.nombre.required' => 'Hay nombres vacíos cerca de: :attribute',
            '*.codOrganismo.required' => 'Hay organismos vacíos cerca de: :attribute',
            '*.codOSDE.required' => 'Hay osdes vacías cerca de: :attribute',
            '*.dpa.required' => 'Hay dpa vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {

            entidad::create([
                'codREU' => $row['codigo'],
                'name' => $row['nombre'],
                'siglas' => $row['siglas']
            ]);
        }
    }
  
}