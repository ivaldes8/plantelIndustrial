<?php

namespace App\Imports;

use App\Models\actividad;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\saclap;
use App\Models\nae;
use App\Rules\RepeatCPCUProducto;
use App\Rules\ValidateSACLAPProducto;
use App\Rules\RepeatCNAEProducto;
use App\Rules\ValidateActividadesProducto;
use App\Rules\ValidateEntidadesProducto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class ProductoImport implements ToCollection, WithHeadingRow
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
            '*.descripcion' => 'required',
            '*.cpcu' => ['required','exists:cpcus,codigo',new RepeatCPCUProducto()],
            '*.saclap' => ['required',new ValidateSACLAPProducto()],
            '*.cnae' => ['required','exists:naes,codigo'],
            '*.actividadesindustriales' => [new ValidateActividadesProducto()]
        ],
        [
            '*.descripcion.required' => 'Hay descripciones vacías cerca de: :attribute',
            '*.cpcu.required' => 'Hay cpcus vacíos cerca de: :attribute',
            '*.cpcu.exists' => 'No existen cpcus con el código: :input cerca de: :attribute ',
            '*.saclap.required' => 'Hay saclaps vacíos cerca de: :attribute',
            '*.saclap.exists' => 'No existen saclaps con el código: :input cerca de: :attribute ',
            '*.cnae.required' => 'Hay cnaes vacíos cerca de: :attribute',
            '*.cnae.exists' => 'No existen cnaes con el código: :input cerca de: :attribute ',
        ])->validate();

        foreach ($collection as $row) {
            $producto = new producto();
            $producto->desc = $row['descripcion'];
            $producto->cpcu_id = cpcu::where('codigo', $row['cpcu'])->get()[0]->id;
            // $producto->saclap_id = saclap::where('codigo', $row['saclap'])->get()[0]->id;
            $producto->nae_id = nae::where('codigo', $row['cnae'])->get()[0]->id;
            $producto->save();

            if($row['saclap']){
                $saclaps = explode( ',', $row['saclap'] );
                $saclapsId = [];
                for ($i=0; $i < count($saclaps); $i++) {
                    array_push($saclapsId,saclap::where('codigo', $saclaps[$i])->get()[0]->id);
                }
                $producto->saclaps()->attach($saclapsId);
            }

            if($row['actividadesindustriales']){
                $actividades = explode( '/', $row['actividadesindustriales'] );
                $actividadesId = [];
                for ($i=0; $i < count($actividades); $i++) {
                    array_push($actividadesId,actividad::where('codigo', $actividades[$i])->get()[0]->id);
                }
                $producto->actividades()->attach($actividadesId);
            }

        }
    }

}
