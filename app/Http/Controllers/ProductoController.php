<?php

namespace App\Http\Controllers;

use App\Exports\ProductoExport;
use App\Imports\IndicadorEntidadPlanProductoImport;
use App\Models\actividad;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\indicadorProducto;
use App\Models\nae;
use App\Models\producto;
use App\Models\saclap;
use Illuminate\Http\Request;
use App\Imports\ProductoImport;
use App\Models\familia;
use App\Models\indicadorEntidadPlanProducto;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto = producto::paginate(10);
        return view('producto.index',compact('producto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = 'none';
        $actividad = actividad::all();
        $cpcu = cpcu::all();
        $saclap = saclap::all();
        $nae = nae::all();
        $familia = familia::all();
        return view('producto.edit', compact('producto', 'actividad', 'cpcu', 'saclap', 'nae', 'familia'));
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
            'desc' => 'required',
            'cpcu_id' => 'required',
            'saclaps' => 'required',
            'nae_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);
        $producto = new producto();
        $producto->desc = $request->input('desc');
        $producto->cpcu_id = $request->input('cpcu_id');
        // $producto->saclap_id = $request->input('saclap_id');
        $producto->nae_id = $request->input('nae_id');
        $producto->save($validatedData);

        if($request->input('actividades') !== null){
            $producto->actividades()->attach($request->input('actividades'));
        }

        if($request->input('saclaps') !== null){
            $producto->saclaps()->attach($request->input('saclaps'));
        }

        return redirect('/producto')->with('status','Producto creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = producto::find($id);
        $indicador = indicadorEntidadPlanProducto::where('producto_id',$producto->id)->get();
        return view('indicadorProducto.index',compact('indicador', 'producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = producto::find($id);
        $actividad = actividad::all();
        $cpcu = cpcu::all();
        $saclap = saclap::all();
        $nae = nae::all();
        $familia = familia::all();

        for ($i=0; $i < count($actividad); $i++) {
            for ($j=0; $j < count($producto->actividades->toArray()); $j++) {
                if($actividad[$i]['id']=== $producto->actividades->toArray()[$j]['id']){
                   $actividad[$i]->osde_id = 'checked';
                }
            }
        }

        for ($i=0; $i < count($saclap); $i++) {
            for ($j=0; $j < count($producto->saclaps->toArray()); $j++) {
                if($saclap[$i]['id'] === $producto->saclaps->toArray()[$j]['id']){
                   $saclap[$i]->checked = 'checked';
                }
            }
        }

        return view('producto.edit', compact('producto', 'actividad', 'cpcu', 'saclap', 'nae', 'familia'));
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
            'desc' => 'required',
            'cpcu_id' => 'required',
            'saclaps' => 'required',
            'nae_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $producto = producto::find($id);
        $producto->desc = $request->input('desc');
        $producto->cpcu_id = $request->input('cpcu_id');
        // $producto->saclap_id = $request->input('saclap_id');
        $producto->nae_id = $request->input('nae_id');
        $producto->update($validatedData);

        $producto->familia()->sync($request->input('familia_id'));

        $producto->actividades()->sync($request->input('actividades'));

        if($request->input('saclaps') !== null) {
            $producto->saclaps()->sync($request->input('saclaps'));
        }

        return redirect('/producto')->with('status','Producto editado satisfactoriamente');
    }

    public function delete($id)
    {
        $producto = producto::find($id);
        return view('producto.delete', compact('producto'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = producto::find($id);
        $producto->delete();
        return redirect()->back()->with('status','Producto eliminado Satisfactoriamente');
    }

    public function filter(Request $request)
    {
        $query = producto::query();
        $query->when(request()->input('descP'), function($q) {
            return $q->where('desc', 'like', '%'.request()->input('descP').'%');
        });

        $query->when(request()->input('cpcu'), function($q) {
            return $q->whereHas('cpcu', function($q)
            {
                $q->where('codigo', 'like', '%'.request()->input('cpcu').'%');
            });
        });

        $query->when(request()->input('saclap'), function($q) {
            return $q->whereHas('saclap', function($q)
            {
                $q->where('codigo', 'like', '%'.request()->input('saclap').'%');
            });
        });

        $query->when(request()->input('cnae'), function($q) {
            return $q->whereHas('cnae', function($q)
            {
                $q->where('codigo', 'like', '%'.request()->input('cnae').'%');
            });
        });

        $query->when(request()->input('entidades'), function($q) {

            return $q->whereHas('entidades', function($q)
            {
                $q->whereIn('entidad_id', request()->input('entidades'));
            });
        });

        $query->when(request()->input('actividades'), function($q) {

            return $q->whereHas('actividades', function($q)
            {
                $q->whereIn('actividad_id', request()->input('actividades'));
            });
        });

        $producto = $query->paginate(10);
        $entidad = entidad::all();
        $actividad = actividad::all();
        return view('producto.filter',compact('producto', 'entidad', 'actividad'));
    }

    public function fileImportExport()
    {
        return view('producto.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new ProductoImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new ProductoExport, 'productos.xlsx');
    }


}
