<?php
  
namespace App\Imports;

use App\Models\cpcu;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
  
class CPCUImport implements ToCollection, WithHeadingRow
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
            '*.codigo' => 'required|unique:cpcus',
            '*.desc' => 'required'
        ],
        [
            '*.codigo.unique' => 'El código :input ya se encuentra en la base de datos',
            '*.codigo.required' => 'El códigos vacíos en el excel cerca de: :attribute',
            '*.desc.required' => 'Hay descripciones vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            cpcu::create([
                'codigo' => $row['codigo'],
                'desc' => $row['desc']
            ]);
        }

        


  
          

        //     Validator::make($row, [
        //         'codigo' => 'required|unique:cpcus,codigo|numeric',
        //         'desc' => 'required'
        //     ],[
        //        'codigo.required' => 'Hay códigos vacíos en el excel',
        //        'codigo.unique' => 'El código :input ya existe en la base de datos',
        //        'codigo.numeric' => 'El código :input no debe contener letras',
        //        'desc.required' => 'Hay descripciones :input  :attribute :size :values :codigo vacías en el excel'
        //    ])->validate();
        
    }
  
}