<?php

namespace App\Imports;

use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\indicador;
use App\Models\indicadorEntidadPlanProducto;
use App\Models\unidad;
use App\Rules\ValidateIndicadorCodigo;
use App\Rules\ValidateIndicadorEntidad;
use App\Rules\ValidateIndicadorProducto;
use App\Rules\ValidateIndicadorUnidad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class IndicadorEntidadPlanProductoImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $collection = LazyCollection::make($rows);

        //VALIDATION

        Validator::make(
            $collection->toArray(),
            [
                '0.indicador' => ['required', new ValidateIndicadorUnidad(), new ValidateIndicadorCodigo()],
                '*.producto' => [new ValidateIndicadorProducto()],
                '*.entidad' => new ValidateIndicadorEntidad(),
            ],
            [
                '*.indicador.required' => 'Tiene que especificar un indicador.',
                '*.producto.required' => 'Hay productos vacíos cerca de: :attribute.',
            ]
        )->validate();

        //VALIDATION

        $datesArray = [];
        foreach ($collection as $key => $row) {
            $datesArray = $row->keys();
            $rowInExecel = $key + 2;
            if (!$row['producto'] && !$row['entidad']) {
                return back()->withErrors(['msg' => 'Existen valores que no tienen asignados productos ni entidades en la fila: ' . $rowInExecel]);
            }
            if($row['entidad'] && !$row['producto']){
                return back()->withErrors(['msg' => 'Existen entidades que no tienen asignado un producto en la fila: ' . $rowInExecel]);
            }
        }

        //FORMAT DATES COLUMNS

        $auxArray = [];
        foreach ($datesArray as $key => $date) {
            if (str_contains($date, 'date')) {
                array_push($auxArray, $date);
            }
        }
        $datesArray = $auxArray;

        if (count($datesArray) === 0) {
            return back()->withErrors(['msg' => 'No existen columnas dates en el excel']);
        }

        //STORAGE INDICATORS

        foreach ($collection as  $key => $row) {
            foreach ($datesArray as $date) {
                if ($row[$date]) {
                    $dateFormat = explode('_', $date);
                    if ($key == 0) {
                        $aux = explode('/', $row['indicador']);
                        $indicador = count($aux) > 0 ? $aux[0] : null;
                        $unidad = count($aux) > 1 ? $aux[1] : null;
                    }
                    $cpcu =  cpcu::where('codigo', $row['producto'])->get();
                    $dateOfValues = Carbon::createFromFormat('d-m-Y',  $dateFormat[1] . '-' . $dateFormat[2] . '-' . $dateFormat[3])->format('Y-m-d H:i:s');

                    $data = new indicadorEntidadPlanProducto();
                    $data->value = $row[$date];
                    $data->date = $dateOfValues;
                    $data->unidad_id = $unidad ? unidad::where('desc', $unidad)->get()[0]->id : null;
                    $data->indicador_id = $indicador ? indicador::where('codigo', $indicador)->get()[0]->id : null;
                    $data->producto_id = count($cpcu) > 0 ? producto::where('cpcu_id', $cpcu[0]->id)->get()[0]->id : null;
                    $data->entidad_id = $row['entidad'] ? entidad::where('codREU', $row['entidad'])->get()[0]->id : null;
                    $data->save();
                }
            }
        }
    }
}
