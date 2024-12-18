<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Http\Requests\BancoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bancos = Banco::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('banco.index', compact('bancos'));
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
    public function store(BancoRequest $request)
    {
        if (Banco::create([
            'nome' => $request->nome,
            'numero' => $request->numero,
            'empresa_id' => Auth::user()->empresa_id,
            'iban' => $request->iban,
            'swift' => $request->swift,
        ])) {
            session()->flash('alert_success', 'Banco salvo com sucesso');
        } else {
            session()->flash('alert_error', 'Erro ao salvar o banco, consulte o administrador');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function show(Banco $banco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function edit(Banco $banco)
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
        $banco = Banco::find($request->id);
        $banco->nome = $request->nome;
        $banco->numero = $request->numero;
        $banco->iban = $request->iban;
        $banco->swift = $request->swift;
        $banco->empresa_id = Auth::user()->empresa_id;

        if ($banco->save()) {
            session()->flash('alert_success', 'Banco actualizado com sucesso');
        } else {
            session()->flash('alert_error', 'Erro ao actualizar o banco, consulte o administrador');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Banco::where('empresa_id', Auth::user()->empresa_id)->destroy($id)) {
            session()->flash('alert_success', 'Banco removido com sucesso');
        } else {
            session()->flash('alert_error', 'Erro ao remover o banco, consulte o administrador');
        }
        return back();
    }
}
