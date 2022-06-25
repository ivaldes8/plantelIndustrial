<?php

namespace App\Http\Controllers;

use App\Exports\EntidadExport;
use App\Models\entidad;
use App\Models\organismo;
use App\Models\osde;
use Illuminate\Http\Request;
use App\Imports\EntidadImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganismoExport;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad = entidad::paginate(10);
        return view('entidad.index',compact('entidad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entidad = 'none';
        $osde = osde::all();
        $organismo = organismo::all();
        return view('entidad.edit', compact('entidad','osde','organismo'));
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
            'codREU' => 'required|unique:entidads,codreu',
            'codNIT' => 'required|unique:entidads,codnit',
            'org_id' => 'required',
            'osde_id' => 'required'
        ], [
            'name.required' => 'Este campo es requerido',
            'codREU.required' => 'Este campo es requerido',
            'codREU.unique' => 'El código reu :input ya se encuentra en la base de datos',
            'codNIT.unique' => 'El código nit :input ya se encuentra en la base de datos',
            'org_id.required' => 'Este campo es requerido',
            'osde_id.required' => 'Este campo es requerido'
        ]);

        $entidad = new entidad();
        $entidad->name = $request->input('name');
        $entidad->codREU = $request->input('codREU');
        $entidad->codNIT = $request->input('codNIT');
        $entidad->codFormOrg = $request->input('codFormOrg');
        $entidad->formOrg = $request->input('formOrg');
        $entidad->org_id = $request->input('org_id');
        $entidad->osde_id = $request->input('osde_id');
        $entidad->dpa = $request->input('dpa');
        $entidad->siglas = $request->input('siglas');
        $entidad->direccion = $request->input('direccion');
        $entidad->save($validatedData);
        return redirect('/entidad')->with('status','Entidad creada satisfactoriamente');
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
        $entidad = entidad::find($id);
        $osde = osde::all();
        $organismo = organismo::all();
        return view('entidad.edit', compact('entidad','osde','organismo'));
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
            'codREU' => 'required',
            'org_id' => 'required',
            'osde_id' => 'required'
        ], [
            'name.required' => 'Este campo es requerido',
            'codREU.required' => 'Este campo es requerido',
            'org_id.required' => 'Este campo es requerido',
            'osde_id.required' => 'Este campo es requerido'
        ]);

        $entidad = entidad::find($id);
        $entidad->name = $request->input('name');
        $entidad->codREU = $request->input('codREU');
        $entidad->codNIT = $request->input('codNIT');
        $entidad->codFormOrg = $request->input('codFormOrg');
        $entidad->formOrg = $request->input('formOrg');
        $entidad->org_id = $request->input('org_id');
        $entidad->osde_id = $request->input('osde_id');
        $entidad->dpa = $request->input('dpa');
        $entidad->siglas = $request->input('siglas');
        $entidad->direccion = $request->input('direccion');
        $entidad->update($validatedData);
        return redirect('/entidad')->with('status','Entidad Editada satisfactoriamente');
    }

    public function delete($id)
    {
        $entidad = entidad::find($id);
        return view('entidad.delete', compact('entidad'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entidad = entidad::find($id);
        $entidad->delete();
        return redirect()->back()->with('status','Entidad eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('entidad.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new EntidadImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new EntidadExport, 'entidades.xlsx');
    }
}
