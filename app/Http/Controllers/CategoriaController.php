<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Categoria::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('categoria.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo =  Helpers::mecanografico('', count(Categoria::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = Categoria::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('categoria.create', compact('dados', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new Categoria;
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/categoria')->with('success', 'Sucesso');
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
        $dados =  Categoria::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('categoria.edit', compact('dados'));
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
        $dados = Categoria::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/categoria')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Categoria::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/categoria')->with('success', 'Sucesso');
    }
}
