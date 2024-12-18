<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Imposto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ImpostoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Imposto::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('imposto.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados = Imposto::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('imposto.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new Imposto;
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->tipo = $request->input('tipo');
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->taxa = $request->input('taxa');
        $dados->motivo = $request->input('motivo');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/imposto')->with('success', 'Sucesso');
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
        $dados = Imposto::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('imposto.edit', compact('dados'));
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
        $dados = Imposto::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->tipo = $request->input('tipo');
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->taxa = $request->input('taxa');
        $dados->motivo = $request->input('motivo');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/imposto')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Imposto::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/imposto')->with('success', 'Sucesso');
    }
}