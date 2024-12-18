<?php

namespace App\Http\Controllers;

use App\CondicoesPagamento;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

class CondicoesPagamentoController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = CondicoesPagamento::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('condicoespagamento.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo =  Helpers::mecanografico('', count(CondicoesPagamento::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = CondicoesPagamento::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('condicoespagamento.create', compact('dados', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new CondicoesPagamento;
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/condicoespagamento')->with('success', 'Sucesso');
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
        $dados =  CondicoesPagamento::find($id);
        return view('condicoespagamento.edit', compact('dados'));
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
        $dados = CondicoesPagamento::find($id);
        $dados->codigo = $request->input('codigo');
        // $dados->empresa_id = Auth::user()->empresa_id;
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/condicoespagamento')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = CondicoesPagamento::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/condicoespagamento')->with('success', 'Sucesso');
    }
}
