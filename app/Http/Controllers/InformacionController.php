<?php

namespace App\Http\Controllers;

use App\Imports\IndicadorEntidadPlanProductoImport;
use App\Models\actividad;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\familia;
use App\Models\indicador;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\indicadorEntidadPlanProducto;
use App\Models\nae;
use App\Models\producto;
use App\Models\saclap;
use App\Models\unidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Indirect;

class InformacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $productos = producto::all();
        $cpcus = cpcu::all();
        $saclaps = saclap::all();
        $naes = nae::all();
        $familias = familia::all();
        $entidades = entidad::all();
        $unidades = unidad::all();
        $actividades = actividad::all();
        $indicadores = indicador::all();

        $query = indicadorEntidadPlanProducto::query();

        $query->when(request()->input('producto'), function($q) {
            return $q->where('producto_id',request()->input('producto'));
        });

        $query->when(request()->input('cpcu'), function($q) {
            $q->whereHas('producto', function($q)
            {
                return $q->where('cpcu_id',request()->input('cpcu'));
            });
        });

        $query->when(request()->input('saclap'), function($q) {
            $q->whereHas('producto', function($q)
            {
                return $q->where('saclap_id',request()->input('saclap'));
            });
        });

        $query->when(request()->input('nae'), function($q) {
            $q->whereHas('producto', function($q)
            {
                return $q->where('nae_id',request()->input('nae'));
            });
        });

        $query->when(request()->input('familia'), function($q) {
            $q->whereHas('producto', function($q)
            {
                $q->whereHas('familia', function($q) {
                    return $q->where('familia_id',request()->input('familia'));
                });
            });
        });

        $query->when(request()->input('entidad'), function($q) {
            return $q->where('entidad_id',request()->input('entidad'));
        });

        $query->when(request()->input('unidad'), function($q) {
            return $q->where('unidad_id',request()->input('unidad'));
        });

        $query->when(request()->input('actividad'), function($q) {
            $q->whereHas('producto', function($q)
            {
                $q->whereHas('actividades', function($q) {
                    return $q->where('actividad_id',request()->input('actividad'));
                });
            });
        });

        $query->when(request()->input('indicador'), function($q) {
            return $q->where('indicador_id',request()->input('indicador'));
        });

        $query->when(request()->input('valorIni'), function($q) {
            return $q->where('value','>=',request()->input('valorIni'));
        });

        $query->when(request()->input('valorEnd'), function($q) {
            return $q->where('value','<=',request()->input('valorEnd'));
        });

        $query->when(request()->input('fechaIni'), function($q) {
            return $q->whereDate('date','>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIni'))->toDateString());
        });

        $query->when(request()->input('fechaEnd'), function($q) {
            return $q->whereDate('date','<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEnd'))->toDateString());
        });

        $informacion = $query->orderBy('date','ASC')->paginate(50);

        return view('informacion.index',compact('informacion', 'productos', 'cpcus', 'saclaps', 'naes', 'familias', 'entidades', 'unidades', 'actividades', 'indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $informacion = 'none';
        $productos = producto::all();
        $entidades = entidad::all();
        $indicadores = indicador::all();
        $unidades = unidad::all();
        return view('informacion.edit', compact('informacion', 'productos', 'entidades', 'indicadores', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'producto' => 'required',
            'indicador' => 'required',
            'valor' => 'required',
            'unidad' => 'required',
            'fecha' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);
        $informacion = new indicadorEntidadPlanProducto();
        $informacion->producto_id = $request->input('producto');
        $informacion->entidad_id = $request->input('entidad');
        $informacion->indicador_id = $request->input('indicador');
        $informacion->value = $request->input('valor');
        $informacion->unidad_id = $request->input('unidad');
        $informacion->date = Carbon::createFromFormat('d/m/Y', $request->input('fecha'))->toDateString();
        $informacion->save($validatedData);
        return redirect('/informacion')->with('status','Infomación creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $informacion = indicadorEntidadPlanProducto::find($id);
        $productos = producto::all();
        $entidades = entidad::all();
        $indicadores = indicador::all();
        $unidades = unidad::all();
        return view('informacion.edit', compact('informacion', 'productos', 'entidades', 'indicadores', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'producto' => 'required',
            'indicador' => 'required',
            'valor' => 'required',
            'unidad' => 'required',
            'fecha' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $informacion = indicadorEntidadPlanProducto::find($id);
        $informacion->producto_id = $request->input('producto');
        $informacion->entidad_id = $request->input('entidad');
        $informacion->indicador_id = $request->input('indicador');
        $informacion->value = $request->input('valor');
        $informacion->unidad_id = $request->input('unidad');
        $informacion->date = Carbon::createFromFormat('Y-m-d', $request->input('fecha'))->toDateString();
        $informacion->update($validatedData);
        return redirect('/informacion')->with('status','Infomación editada satisfactoriamente');
    }

    public function delete($id)
    {
        $informacion = indicadorEntidadPlanProducto::find($id);
        return view('informacion.delete', compact('informacion'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $informacion = indicadorEntidadPlanProducto::find($id);
        $informacion->delete();
        return redirect()->back()->with('status','Información eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('informacion.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new IndicadorEntidadPlanProductoImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }
}
