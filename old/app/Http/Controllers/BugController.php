<?php

namespace App\Http\Controllers;

use App\Bug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bugs = Bug::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('bugs.index', compact('bugs'));
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
        $bug = new Bug();
        $bug->descricao = $request->descricao;
        $bug->criador_id = Auth::user()->id;
        $bug->empresa_id = Auth::user()->empresa_id;
        
        if ($bug->save()) {
            session()->flash('alert_success', 'Problema reportado com sucesso, aguarde a resolução');
        } else {
            session()->flash('alert_error', 'Erro ao salvar o problema, consulte o administrador');
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $bug = Bug::where('empresa_id', Auth::user()->empresa_id)->find($request->id);
        $bug->descricao = $request->descricao;
        if ($bug->save()) {
            session()->flash('alert_success', 'Problema actualizado com sucesso.');
        } else {
            session()->flash('alert_error', 'Erro ao actualizar o problema, consulte o administrador');
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
        if (Bug::where('empresa_id', Auth::user()->empresa_id)->destroy($id)) {
            session()->flash('alert_success', 'Problema removido com sucesso.');
        } else {
            session()->flash('alert_error', 'Erro ao remover problema, consulte o administrador');
        }
        return back();
    }
}
