<?php

namespace App\Http\Controllers;

use App\Contacto;
use App\Endereco;
use App\Fornecedor;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Fornecedor::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('fornecedor.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo =  Helpers::mecanografico(date('Y-'), count(Fornecedor::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = Fornecedor::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('fornecedor.create', compact('dados','codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Endereco
        $dados_endereco = new Endereco();
        $dados_endereco->pais = $request->input('pais');
        $dados_endereco->cidade = $request->input('cidade');
        $dados_endereco->endereco = $request->input('endereco');
        $dados_endereco->empresa_id = Auth::user()->empresa_id;
        $dados_endereco->save();

        //Contacto
        $dados_contacto = new Contacto();
        $dados_contacto->telefone = $request->input('telefone');
        $dados_contacto->fax = $request->input('fax');
        $dados_contacto->telemovel = $request->input('telemovel');
        $dados_contacto->contacto = $request->input('contacto');
        $dados_contacto->email = $request->input('email');
        $dados_contacto->facebook = $request->input('facebook');
        $dados_contacto->whatsapp = $request->input('whatsapp');
        $dados_contacto->skype = $request->input('skype');
        $dados_contacto->twitter = $request->input('twitter');
        $dados_contacto->linkedin = $request->input('linkedin');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->empresa_id = Auth::user()->empresa_id;
        $dados_contacto->save();


        $dados = new Fornecedor;
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->contribuinte = $request->input('contribuinte');
        $dados->zona = $request->input('zona');
        $dados->observacao = $request->input('observacao');
        $dados->identificacao = $request->input('identificacao');
        $dados->imagem = ($request->file('file')) ? Helpers::uploadFile($request,'file') : 'null.png';
        $dados->status = ($request->input('status')) ? true : false;
        $dados->id_endereco =   $dados_endereco->id;
        $dados->id_contacto =   $dados_contacto->id;
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->save();

        return redirect('/fornecedor')->with('success', 'Sucesso');
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
        $dados =  Endereco::where('empresa_id', Auth::user()->empresa_id)->getEntityEnderecoContacto($id, 'fornecedors');
        return view('fornecedor.edit', compact('dados'));
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
        $dados = Fornecedor::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->contribuinte = $request->input('contribuinte');
        $dados->zona = $request->input('zona');
        $dados->observacao = $request->input('observacao');
        $dados->identificacao = $request->input('identificacao');
        $dados->imagem = ($request->file('file')) ? Helpers::uploadFile($request,'file') : $dados->imagem;
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();

        //Endereco
        $dados_endereco  = Endereco::where('empresa_id', Auth::user()->empresa_id)->find($dados->id_endereco);
        $dados_endereco->pais = $request->input('pais');
        $dados_endereco->cidade = $request->input('cidade');
        $dados_endereco->endereco = $request->input('endereco');
        $dados_endereco->save();

        //Contacto
        $dados_contacto = Contacto::where('empresa_id', Auth::user()->empresa_id)->find($dados->id_contacto);
        $dados_contacto->telefone = $request->input('telefone');
        $dados_contacto->fax = $request->input('fax');
        $dados_contacto->telemovel = $request->input('telemovel');
        $dados_contacto->contacto = $request->input('contacto');
        $dados_contacto->email = $request->input('email');
        $dados_contacto->facebook = $request->input('facebook');
        $dados_contacto->whatsapp = $request->input('whatsapp');
        $dados_contacto->skype = $request->input('skype');
        $dados_contacto->twitter = $request->input('twitter');
        $dados_contacto->linkedin = $request->input('linkedin');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->save();


        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/fornecedor')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Fornecedor::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/fornecedor')->with('success', 'Sucesso');
    }

    public function anular($id)
    {
        $dados = Fornecedor::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->status =  false;
        $dados->save();
        session()->flash('alt_success', 'Succeso');
        return redirect('/fornecedor')->with('success', 'Sucesso');
    }

    public function activar($id)
    {
        $dados = Fornecedor::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->status =  true;
        $dados->save();
        session()->flash('alt_success', 'Succeso');
        return redirect('/fornecedor')->with('success', 'Sucesso');
    }
}
