<?php

namespace App\Http\Controllers\Individuos;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Individuos\Sexo;
use Flash;

class SexoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('individuos.sexos.index')
            ->with('sexos', Sexo::orderBy('nombre', 'asc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('individuos.sexos.create')
            ->with('sexo', new Sexo());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Sexo::create($request->all());

        Flash::success('El Sexo se creó correctamente');

        return redirect(route('individuos::sexos.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       try {
            return view('individuos.sexos.edit')
                ->with('sexo', Sexo::findOrFail($id));

        } catch(ModelNotFoundException $e) {

            Flash::warning('No se encontró el registro a editar');

            return redirect(route('individuos::sexos.index'));
        }
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
        try {

            $sexo = $this->assignEntity(Sexo::findOrFail($id), $request);
            $sexo->save();

            Flash::success('El registro se modificó correctamente');

            return redirect(route('individuos::sexos.index'));

        } catch(ModelNotFoundException $e) {

            Flash::warning('No se encontró el registro a editar');

            return redirect(route('individuos::sexos.edit', $id));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $sexo = Sexo::findOrFail($id);
            $sexo->delete();

            Flash::success('El registro se borró correctamente');

        } catch(ModelNotFoundException $e) {

            Flash::warning('No se encontró el registro a borrar');
        }

        return redirect(route('individuos::sexos.index'));
    }

    protected function assignEntity(Sexo $entity, Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
        ]);

        $entity->fill($request->input());

        return $entity;
    }
}