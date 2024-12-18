<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class PermissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissoes = Permission::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('permissoes.index', compact('permissoes'));
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
        if (Permission::create([
            'name' => $request->name,
            'empresa_id' => Auth::user()->empresa_id
        ])) {
            session()->flash('alert_success', 'Permissão salvo com succeso');
        } else {
            session()->flash('alert_error', 'Erro ao salvar permissão, por favor consulte o administrador');
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
        $perfil = Permission::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $perfil->name = $request->name;
        if ($perfil->save()) {
            session()->flash('alert_success', 'Permissão actualizado com succeso');
        } else {
            session()->flash('alert_error', 'Erro ao actualizar o permissão, por favor consulte o administrador');
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
        if ((Permission::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->count())) {
            session()->flash('alert_success', 'Esta permissão não pode ser removido por pertencer a um perfil');
        } else {
            if (Permission::where('empresa_id', Auth::user()->empresa_id)->destroy($id)) {
                session()->flash('alert_success', 'Permissão removido com succeso');
            } else {
                session()->flash('alert_error', 'Erro ao remover permissão, por favor consulte o administrador');
            }
        }
        return back();
    }

    /**
     * Show permissions for each role
     */
    public function show_permission_table()
    {
        $roles = Role::where('empresa_id', Auth::user()->empresa_id)->get();
        $permissions = Permission::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('permissoes.permission-table', compact('roles', 'permissions'));
    }
}
