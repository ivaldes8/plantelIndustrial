<?php

namespace App\Http\Controllers;

use App\Models\cpcu;
use App\Models\nae;
use App\Models\producto;
use App\Models\saclap;
use Illuminate\Http\Request;

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
        $cpcu = cpcu::all();
        $saclap = saclap::all();
        $nae = nae::all();
        return view('producto.edit', compact('producto', 'cpcu', 'saclap', 'nae'));
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
        ], [
            'desc.required' => 'Este campo es requerido'
        ]);

        $producto = new producto();
        $producto->desc = $request->input('desc');
        $producto->cpcu_id = $request->input('cpcu_id');
        $producto->saclap_id = $request->input('saclap_id');
        $producto->nae_id = $request->input('nae_id');
        $producto->save($validatedData);
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
        $producto = producto::find($id);
        $cpcu = cpcu::all();
        $saclap = saclap::all();
        $nae = nae::all();
        return view('producto.edit', compact('producto', 'cpcu', 'saclap', 'nae'));
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
        ], [
            'desc.required' => 'Este campo es requerido'
        ]);

        $producto = producto::find($id);
        $producto->desc = $request->input('desc');
        $producto->cpcu_id = $request->input('cpcu_id');
        $producto->saclap_id = $request->input('saclap_id');
        $producto->nae_id = $request->input('nae_id');
        $producto->update($validatedData);
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
}
