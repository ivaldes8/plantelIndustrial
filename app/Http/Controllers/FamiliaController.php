<?php

namespace App\Http\Controllers;

use App\Models\familia;
use App\Models\producto;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familia = familia::paginate(10);
        return view('familia.index',compact('familia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $familia = 'none';
        $producto = producto::all();
        return view('familia.edit', compact('familia', 'producto'));
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
            'name' => 'required',
            'producto_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);
        $familia = new familia();
        $familia->name = $request->input('name');
        $familia->save($validatedData);

        if($request->input('producto_id') !== null){
            $familia->productos()->attach($request->input('producto_id'));
        }

        return redirect('/familia')->with('status','Familia creada satisfactoriamente');
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
        $familia = familia::find($id);
        $producto = producto::all();

        for ($i=0; $i < count($producto); $i++) {
            for ($j=0; $j < count($familia->productos->toArray()); $j++) {
                if($producto[$i]['id'] === $familia->productos->toArray()[$j]['id']){
                   $producto[$i]->cpcu_id = 'checked';
                }
            }
        }

        return view('familia.edit', compact('familia', 'producto'));
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
            'name' => 'required',
            'producto_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $familia = familia::find($id);
        $familia->name = $request->input('name');
        $familia->update($validatedData);

        if($request->input('producto_id') !== null) {
            $familia->productos()->sync($request->input('producto_id'));
        }

        return redirect('/familia')->with('status','Familia de productos editada satisfactoriamente');
    }

    public function delete($id)
    {
        $familia = familia::find($id);
        return view('familia.delete', compact('familia'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $familia = familia::find($id);
        $familia->delete();
        return redirect()->back()->with('status','Familia eliminada Satisfactoriamente');
    }
}
