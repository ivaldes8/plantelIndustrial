<?php

namespace App\Exports;

use App\Models\producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductoExport implements FromCollection, WithHeadings
{
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
            if(count($producto->actividades) === 0) {
                array_push($aux,[$producto->cpcu->codigo, $producto->saclap->codigo, $producto->cnae->codigo, $producto->desc]);
            }
            if(count($producto->actividades) > 0) {
                $actArr = [];
                foreach ($producto->actividades as $key => $actividad) {
                   array_push($actArr, $actividad->codigo);
                }
                $imploded = implode("/", $actArr);
                array_push($aux,[$producto->cpcu->codigo, $producto->saclap->codigo, $producto->cnae->codigo, $producto->desc, $imploded]);
            }
        }
        return collect($aux);
    }
}
