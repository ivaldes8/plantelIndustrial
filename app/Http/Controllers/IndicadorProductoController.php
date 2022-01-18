<?php

namespace App\Http\Controllers;

use App\Models\indicador;
use App\Models\indicadorProducto;
use App\Models\producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndicadorProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $producto = producto::find($id);
        $indicador = 'none';
        $indicadores = indicador::all();
        return view('indicadorProducto.edit', compact('indicador', 'indicadores','producto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'indicador' => 'required',
            'date' => 'required|date',
            'value' => 'required'
        ], [
            'required' => 'Este campo es requerido',
            'date.date' => 'Esta fecha no es válida'
        ]);
        $indicadorProducto = new indicadorProducto();
        $indicadorProducto->producto_id = $id;
        $indicadorProducto->indicador_id = $request->input('indicador');
        $indicadorProducto->value = $request->input('value');
        $indicadorProducto->date = (new Carbon($request->input('date')))->format('Y-m-d');
        $indicadorProducto->save($validatedData);
        return redirect('/producto/' .$id)->with('status','Indicador creado satisfactoriamente');
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
    public function edit($indicador, $producto)
    {
        $indicador = indicadorProducto::find($indicador);
        $producto = producto::find($producto);
        $indicadores = indicador::all();
        return view('indicadorProducto.edit', compact('indicador', 'indicadores', 'producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $indicador, $producto)
    {
        $validatedData = $request->validate([
            'indicador' => 'required',
            'date' => 'required|date',
            'value' => 'required'
        ], [
            'required' => 'Este campo es requerido',
            'date.date' => 'Esta fecha no es válida'
        ]);

        $newDate = ((new Carbon($request->input('date')))->format('Y-m-d'));

        $indicadorProducto = indicadorProducto::find($indicador);
        $indicadorProducto->producto_id = $producto;
        $indicadorProducto->indicador_id = $request->input('indicador');
        $indicadorProducto->value = $request->input('value');
        $indicadorProducto->date = $newDate;
        $indicadorProducto->update();
        return redirect('/producto/' .$producto)->with('status','Indicador editado satisfactoriamente');
    }

    public function delete($id)
    {
        $indicador = indicadorProducto::find($id);
        return view('indicadorProducto.delete', compact('indicador'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indicador = indicadorProducto::find($id);
        $indicador->delete();
        return redirect()->back()->with('status','Indicador eliminado Satisfactoriamente');
    }
}
