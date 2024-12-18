<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\MotivoAnulacao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MotivoAnulacaoController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('motivo_anulacao.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo =  Helpers::mecanografico('', count(MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('motivo_anulacao.create', compact('dados', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new MotivoAnulacao;
        $dados->empresa_id = Auth::user()->empresa_id;

        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/motivo_anulacao')->with('success', 'Sucesso');
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
        $dados =  MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('motivo_anulacao.edit', compact('dados'));
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
        $dados = MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/motivo_anulacao')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/motivo_anulacao')->with('success', 'Sucesso');
    }
}
