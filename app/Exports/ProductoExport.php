<?php

namespace App\Exports;

use App\Models\producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ProductoExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
{

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function headings(): array
    {
        return [
            'cpcu',
            'saclap',
            'cnae',
            'descripcion',
            'actividadesIndustriales'

        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $productos = producto::all();
        $aux = [];
        foreach ($productos as $key => $producto) {
            if (count($producto->actividades) === 0) {
                $actArr = [];
                foreach ($producto->saclaps as $key => $saclap) {
                    array_push($actArr, $saclap->codigo);
                }
                $imploded = implode(",", $actArr);
                array_push($aux, [$producto->cpcu->codigo, $imploded, $producto->cnae->codigo, $producto->desc]);
            }
            if (count($producto->actividades) > 0) {
                $saclapArr = [];
                foreach ($producto->saclaps as $key => $saclap) {
                    array_push($saclapArr, $saclap->codigo);
                }
                $implodedSaclap = implode(",", $saclapArr);

                $actArr = [];
                foreach ($producto->actividades as $key => $actividad) {
                    array_push($actArr, $actividad->codigo);
                }
                $imploded = implode("/", $actArr);
                array_push($aux, [$producto->cpcu->codigo, $implodedSaclap, $producto->cnae->codigo, $producto->desc, $imploded]);
            }
        }
        return collect($aux);
    }
}
