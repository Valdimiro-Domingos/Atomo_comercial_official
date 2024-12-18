<?php

namespace App\Http\Controllers;

use App\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaisController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Pais::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('pais.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados = Pais::where('empresa_id', Auth::user()->empresa_id)->where('status', 'true')->get();
        return view('pais.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new Pais;
        $dados->designacao = $request->input('designacao');
        $dados->empresa_id = Auth::user()->empresa_id;

        $dados->sigla = $request->input('sigla');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/pais')->with('success', 'Sucesso');
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
        $dados =  Pais::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('pais.edit', compact('dados'));
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
        $dados = Pais::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->designacao = $request->input('designacao');
        $dados->sigla = $request->input('sigla');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/pais')->with('success', 'Sucesso');
    }

   
    public function destroy($id)
    {
        $dados = Pais::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/pais')->with('success', 'Sucesso');
    }
}
