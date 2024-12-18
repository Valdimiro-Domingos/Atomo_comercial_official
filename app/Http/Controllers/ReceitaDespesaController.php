<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\ReceitaDespesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReceitaDespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('receita_despesa.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo =  Helpers::mecanografico('', count(ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('receita_despesa.create', compact('dados', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new ReceitaDespesa;
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->tipo = $request->input('tipo');
        $dados->total = Helpers::parseDouble($request->input('total'));
        $dados->data = $request->input('data');
        $dados->descricao = $request->input('descricao');
        $dados->save();
        return redirect('/receita-despesa')->with('success', 'Sucesso');
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
        $dados =  ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('receita_despesa.edit', compact('dados'));
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
        $dados = ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->tipo = $request->input('tipo');
        $dados->total = Helpers::parseDouble($request->input('total'));
        $dados->data = $request->input('data');
        $dados->descricao = $request->input('descricao');
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/receita-despesa')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/receita-despesa')->with('success', 'Sucesso');
    }
}
