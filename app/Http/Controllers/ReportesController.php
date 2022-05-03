<?php

namespace App\Http\Controllers;

use App\Models\actividad;
use App\Models\indicadorEntidadPlanProducto;
use App\Models\producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function cuotaDeMercado(Request $request)
    {
        //UTILS
        function unique_multidim_array($array, $key) {
            $temp_array = array();
            $i = 0;
            $key_array = array();

            foreach($array as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
        }
        // dd($request->input());
        if(count($request->input()) === 0){
            $productsArray = [];
        }
        else {
            $validatedData = $request->validate([
                'startDate' => 'required',
                'endDate' => 'required',
                'actividades' => 'required'
            ], [
                'startDate.required' => 'Tiene que especificar una fecha de inicio',
                'endDate.required' => 'Tiene que especificar una fecha final',
                'actividades.required' => 'Tiene que seleccionar al menos una actividad industrial'
            ]);
            $result = 0;
            $query = indicadorEntidadPlanProducto::query()
            ->whereDate('date','>=', Carbon::createFromFormat('d/m/Y', request()->input('startDate'))->toDateString())
            ->whereDate('date','<=', Carbon::createFromFormat('d/m/Y', request()->input('endDate'))->toDateString())
            ->whereHas('producto', function($q){
              $q->whereHas('actividades', function($q){
                $q->whereIn('actividad_id', request()->input('actividades'));
              });
            })
            ->with('unidad')
            ->with('indicador')
            ->with('producto')
            ->with('producto.actividades')
            ->get();

            //Se crea un array con keys = producto_id, luego cada elemento del array es una array con tres valores [produccion U, importacion U, calculo del indicador U, Npmbre del Producto, CPCU del Producto, Actividades Industriales del producto, produccion Valor, importacion Valor, calculo del indicador Valor]
            $productsArray = [];
            for ($i=0; $i < count($query); $i++) {
                if(!array_search($query[$i]->producto_id, $productsArray)){
                    $productsArray +=[$query[$i]->producto_id => [0,0,0, $query[$i]->producto->desc, $query[$i]->producto->cpcu->codigo, $query[$i]->producto->actividades, 0, 0, 0]];
                }
            }

            //Se le da valor a la produccion y a las importaciones de los productos para unidades y valor
            for ($i=0; $i < count($query); $i++) {
                if($query[$i]->indicador->codigo === '1' && $query[$i]->unidad->desc === 'U'){
                    $productsArray[$query[$i]->producto_id][0] += $query[$i]->value;
                }
                if($query[$i]->indicador->codigo === '2' && $query[$i]->unidad->desc === 'U'){
                    $productsArray[$query[$i]->producto_id][1] += $query[$i]->value;
                }
                if($query[$i]->indicador->codigo === '1' && $query[$i]->unidad->desc === 'Valor'){
                    $productsArray[$query[$i]->producto_id][6] += $query[$i]->value;
                }
                if($query[$i]->indicador->codigo === '2' && $query[$i]->unidad->desc === 'Valor'){
                    $productsArray[$query[$i]->producto_id][7] += $query[$i]->value;
                }
            }
            //Se calcula el indicador
            foreach ($productsArray as $key => $value) {
                if($productsArray[$key][0] !== 0 && $productsArray[$key][1] !== 0){
                    $productsArray[$key][2] = $productsArray[$key][0]/($productsArray[$key][0]+$productsArray[$key][1])*100;
                }
                if($productsArray[$key][6] !== 0 && $productsArray[$key][7] !== 0){
                    $productsArray[$key][8] = $productsArray[$key][6]/($productsArray[$key][6]+$productsArray[$key][7])*100;
                }
            }
        }
        $actividad = actividad::all();
        return view('reportes.cuota', compact('actividad', 'productsArray'));
    }



}
