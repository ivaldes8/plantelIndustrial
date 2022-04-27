<?php

namespace App\Http\Controllers;

use App\Imports\IndicadorEntidadPlanProductoImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\indicadorEntidadPlanProducto;
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
        $informacion = indicadorEntidadPlanProducto::orderBy('date','ASC')->paginate(50);
        return view('informacion.index',compact('informacion'));
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
