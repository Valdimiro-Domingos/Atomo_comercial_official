<?php

namespace App\Http\Controllers;

use App\Armazem;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ArmazemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Armazem::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('armazem.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo =  Helpers::mecanografico('', count(Armazem::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = Armazem::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('armazem.create', compact('dados', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new Armazem;
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/armazem')->with('success', 'Sucesso');
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
        $dados =  Armazem::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('armazem.edit', compact('dados'));
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
        $dados = Armazem::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/armazem')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Armazem::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/armazem')->with('success', 'Sucesso');
    }
}
