<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Helpers\Helpers;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function index()
    {
        $utilizadores = User::where('empresa_id', Auth::user()->empresa_id)->paginate(9);
        return view('utilizador.index', compact('utilizadores'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $utilizadores = User::query()
            ->where('nome', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('email', 'like', "%$search%")
            ->paginate(10);
        return view('utilizador.index', compact('utilizadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::where('empresa_id', Auth::user()->empresa_id)->get();
        $roles = Role::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('utilizador.create', compact('departamentos', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->nome = $request->nome;
        $user->email = $request->email;
        $user->foto = 'default.jpg';
        $user->empresa_id = Auth::user()->empresa_id;
        $user->departamento_id = $request->departamento_id;
        $user->password = Hash::make(12345678);
        $user->status = $request->status ? 1 : 0;
        $user->reset_password = 1;


        if ($user->save()) {
            if (User::where('empresa_id', Auth::user()->empresa_id)->find($user->id)->roles->count()) {
                $role_id = User::where('empresa_id', Auth::user()->empresa_id)->find($user->id)->roles->first()->id;
                if ($role_id == $request->role_id) {
                    session()->flash('alert_warning', 'Este utilizador já possui este perfil');
                } else {
                    User::where('empresa_id', Auth::user()->empresa_id)->find($user->id)->removeRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($role_id)->name);
                    User::where('empresa_id', Auth::user()->empresa_id)->find($user->id)->assignRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($request->role_id));
                    session()->flash('alert_success', 'Perfil actualizado com successo');
                }
            } else {
                User::where('empresa_id', Auth::user()->empresa_id)->find($user->id)->assignRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($request->role_id));
                session()->flash('alert_success', 'Perfil associado com successo');
            }
            session()->flash('alert_success', 'Utilizador cadastrado com sucesso');
            return redirect()->action('UserController@index');
        }
        session()->flash('alert_error', 'Erro ao adastrar o utilizador');
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
        $utilizador = User::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $departamentos = Departamento::where('empresa_id', Auth::user()->empresa_id)->get();
        $roles = Role::where('empresa_id', Auth::user()->empresa_id)->get();

        return view('utilizador.edit', compact('utilizador', 'departamentos', 'roles'));
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
        $user = User::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $user->nome = $request->nome;
        $user->email = $request->email;
        $user->foto = 'default.jpg';
        $user->departamento_id = $request->departamento_id;
        $user->status = $request->status ? 1 : 0;
        if ($user->save()) {
            if (User::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->count()) {
                $role_id = User::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->first()->id;
                if ($role_id == $request->role_id) {
                    session()->flash('alert_warning', 'Este utilizador já possui este perfil');
                } else {
                    User::where('empresa_id', Auth::user()->empresa_id)->find($id)->removeRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($role_id)->name);
                    User::where('empresa_id', Auth::user()->empresa_id)->find($id)->assignRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($request->role_id));
                    session()->flash('alert_success', 'Perfil actualizado com successo');
                }
            } else {
                User::where('empresa_id', Auth::user()->empresa_id)->find($id)->assignRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($request->role_id));
                session()->flash('alert_success', 'Perfil associado com successo');
            }

            session()->flash('alert_success', 'Utilizador actualizado com sucesso');
            return redirect()->action('UserController@index');
        }
        session()->flash('alert_error', 'Erro ao actualizar o utilizador');
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request, $id)
    {
        $user = User::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $user->reset_password = 1;
        $user->password = Hash::make(12345678);
        if ($user->save()) {
            session()->flash('alert_success', 'Utilizador actualizado com sucesso');
            return redirect()->action('UserController@index');
        }
        session()->flash('alert_error', 'Erro ao actualizar o utilizador');
        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newPassword()
    {
        return view('auth.newPassword');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateNewPassword(Request $request)
    {
        $user = User::where('empresa_id', Auth::user()->empresa_id)->find(Auth::user()->id);

        $user->password = Hash::make($request->password);
        $user->reset_password = 0;
        if ($user->save()) {
            session()->flash('alert_success', 'Utilizador actualizado com sucesso');
            return redirect('home');
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
        if ($id != Auth::user()->id) {
            if (User::where('empresa_id', Auth::user()->empresa_id)->destroy($id)) {
                session()->flash('alert_success', 'Utilizador removido com sucesso');
            } else {
                session()->flash('alert_error', 'Erro ao remover utilizador, consulte o administrador');
            }
        } else {
            session()->flash('alert_warning', 'Não podes remover-se, consulte consulte o administrador');
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizarPerfil(Request $request, $id)
    {
        $user = User::where('empresa_id', Auth::user()->empresa_id)->find($id);
        if ($request->file('foto')) {
            //unlink(asset("public/upload/$user->foto"));
            $user->foto = Helpers::uploadFile($request, 'foto');
        }
        $user->nome = $request->nome;
        $user->email = $request->email;
        if ($user->save()) {
            session()->flash('alert_success', 'Perfil actualizado com sucesso');
        } else {
            session()->flash('alert_error', 'Erro ao actualizar perfil, consulte o administrador');
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request, $id)
    {
        if (User::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->count()) {
            $role_id = User::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->first()->id;
            if ($role_id == $request->perfil) {
                session()->flash('alert_warning', 'Este utilizador já possui este perfil');
            } else {
                User::where('empresa_id', Auth::user()->empresa_id)->find($id)->removeRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($role_id)->name);
                User::where('empresa_id', Auth::user()->empresa_id)->find($id)->assignRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($request->perfil));
                session()->flash('alert_success', 'Perfil actualizado com successo');
            }
        } else {
            User::where('empresa_id', Auth::user()->empresa_id)->find($id)->assignRole(Role::where('empresa_id', Auth::user()->empresa_id)->find($request->perfil));
            session()->flash('alert_success', 'Perfil associado com successo');
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id identificador do utilizador
     * @return \Illuminate\Http\Response
     */
    public function becomeSuperAdmin($id)
    {
        foreach (User::where('empresa_id', Auth::user()->empresa_id)->get() as $user) {
            if ($user->roles()->where('name', 'Super Administrador')->count()) {
                session()->flash('alert_warning', 'Já existe um super administrador');
                return back();
            }
        }
        if (Role::where('empresa_id', Auth::user()->empresa_id)->where('name', 'Super Administrador')->count()) {
            $role = Role::where('empresa_id', Auth::user()->empresa_id)->where('name', 'Super Administrador')->get();
        } else {
            $role = new Role();
            $role->name = 'Super Administrador';
            $role->empresa_id = Auth::user()->empresa_id;
            $role->save();
        }
        if (User::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->first() != null) {
            User::where('empresa_id', Auth::user()->empresa_id)->find($id)->removeRole(User::where('empresa_id', Auth::user()->empresa_id)->find($id)->roles->first()->name);
            User::where('empresa_id', Auth::user()->empresa_id)->find($id)->assignRole($role);
        } else {
            User::where('empresa_id', Auth::user()->empresa_id)->find($id)->assignRole($role);
        }
        session()->flash('alert_success', 'Super administrador definido com sucesso');
        return back();
    }
}
