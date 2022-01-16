<?php

namespace App\Http\Controllers;

use App\Models\actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividad = actividad::paginate(10);
        return view('actividad.index',compact('actividad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actividad = 'none';
        return view('actividad.edit', compact('actividad'));
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
            'desc' => 'required'
        ], [
            'desc.required' => 'Este campo es requerido'
        ]);

        $actividad = new actividad();
        $actividad->desc = $request->input('desc');
        $actividad->save($validatedData);
        return redirect('/actividad')->with('status','Actividad Industrial creada satisfactoriamente');
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
        $actividad = actividad::find($id);
        return view('actividad.edit', compact('actividad'));
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
            'desc' => 'required'
        ], [
            'desc.required' => 'Este campo es requerido'
        ]);

        $actividad = actividad::find($id);
        $actividad->desc = $request->input('desactividad');
        $actividad->update($validatedData);
        return redirect('/actividad')->with('status','Actividad Industrial Editada satisfactoriamente');
    }

    public function delete($id)
    {
        $actividad = actividad::find($id);
        return view('actividad.delete', compact('actividad'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad = actividad::find($id);
        $actividad->delete();
        return redirect()->back()->with('status','Actividad Industrial eliminada Satisfactoriamente');
    }
}
