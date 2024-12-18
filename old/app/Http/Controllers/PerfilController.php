<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;



class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfis = Role::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('perfis.index', compact('perfis'));
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
        if (Role::create([
            'name' => $request->name,
            "empresa_id" => Auth::user()->empresa_id
        ])) {
            session()->flash('alert_success', 'Perfil salvo com succeso');
        } else {
            session()->flash('alert_error', 'Erro ao salvar perfil, por favor consulte o administrador');
        }
        return back();
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
        $perfil = Role::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $perfil->name = $request->name;
        if ($perfil->save()) {
            session()->flash('alert_success', 'Perfil actualizado com succeso');
        } else {
            session()->flash('alert_error', 'Erro ao actualizar o perfil, por favor consulte o administrador');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Role::where('empresa_id', Auth::user()->empresa_id)->find($id)->permissions->count()) {
            session()->flash('alert_success', 'Este perfil não pode ser removido por possuir permissões');
        } else {
            if (Role::where('empresa_id', Auth::user()->empresa_id)->destroy($id)) {
                session()->flash('alert_success', 'Perfil removido com succeso');
            } else {
                session()->flash('alert_error', 'Erro ao remover perfil, por favor consulte o administrador');
            }
        }
        return back();
    }

    /**
     * Atribue permissões ao perfil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignPermission(Request $request, $id)
    {
        foreach ($request->permissions as $permisson_id) {
            if (Role::where('empresa_id', Auth::user()->empresa_id)->find($id)->givePermissionTo(Permission::where('empresa_id', Auth::user()->empresa_id)->find($permisson_id))) {
                session()->flash('alert_success', 'Permissão vinculada com succeso');
            } else {
                session()->flash('alert_error', 'Erro ao vincular permissão, por favor consulte o administrador');
            }
        }
        return back();
    }
}
