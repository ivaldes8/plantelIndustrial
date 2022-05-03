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
use Illuminate\Http\Request;

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
        $informacion = indicadorEntidadPlanProducto::orderBy('date','ASC')->paginate(50);
        return view('informacion.index',compact('informacion', 'productos', 'cpcus', 'saclaps', 'naes', 'familias', 'entidades', 'unidades', 'actividades', 'indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
