<?php

namespace App\Http\Controllers;

use App\Artigo;
use App\Categoria;
use App\Fabricante;
use App\Fornecedor;
use App\Grupo;
use App\Helpers\Helpers;
use App\Imposto;
use App\Marca;
use App\Tipo;
use App\Retencao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ArtigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Artigo::where('empresa_id', Auth::user()->empresa_id)->paginate(9);
        return view('artigo.index', compact('dados'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $dados = Artigo::query()
            ->where('designacao', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('preco', 'like', "%$search%")
            ->paginate(10);

        return view('artigo.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $dados = array(
            "codigo" => Helpers::mecanografico(date('Y-'), count(Artigo::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            "artigo" => Artigo::where('empresa_id', Auth::user()->empresa_id)->get(),
            "imposto" => Imposto::where('empresa_id', Auth::user()->empresa_id)->get(),
            "categoria" => Categoria::where('empresa_id', Auth::user()->empresa_id)->get(),
            "tipo" => Tipo::where('empresa_id', Auth::user()->empresa_id)->get(),
            "retencao" => Retencao::where('empresa_id', Auth::user()->empresa_id)->get(),
            "fornecedor" => Fornecedor::where('empresa_id', Auth::user()->empresa_id)->get()
        );
        return view('artigo.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new Artigo;
        $dados->codigo = $request->input('codigo');
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->designacao = $request->input('designacao');
        $dados->tipo_id = $request->input('tipo_id');
        $dados->retencao_id = $request->input('retencao_id');
        $dados->categoria_id = $request->input('categoria_id');
        $dados->imposto_id = $request->input('imposto_id');
        $dados->preco = Helpers::parseDouble($request->input('preco'));
        $dados->imagem_1 = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : 'null.png';
        $dados->imagem_2 = ($request->file('file_2')) ? Helpers::uploadFile($request, 'file_2') : 'null.png';
        $dados->imagem_3 = ($request->file('file_3')) ? Helpers::uploadFile($request, 'file_3') : 'null.png';
        $dados->unidade = $request->input('unidade');
        $dados->fornecedor_id = $request->input('fornecedor_id');
        $dados->codigo_barra = $request->input('codigo_barra');
        $dados->is_stock = ($request->input('is_stock')) ? true : false;
        $dados->stock_minimo = Helpers::parseInt($request->input('stock_minimo'));
        $dados->stock_maximo = Helpers::parseInt($request->input('stock_maximo'));
        $dados->observacao = $request->input('observacao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        return redirect('/artigo')->with('success', 'Sucesso');
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
        $dados = array(
            "artigo" => Artigo::where('empresa_id', Auth::user()->empresa_id)->find($id),
            "imposto" => Imposto::where('empresa_id', Auth::user()->empresa_id)->get(),
            "categoria" => Categoria::where('empresa_id', Auth::user()->empresa_id)->get(),
            "tipo" => Tipo::where('empresa_id', Auth::user()->empresa_id)->get(),
            "retencao" => Retencao::where('empresa_id', Auth::user()->empresa_id)->get(),
            "fornecedor" => Fornecedor::where('empresa_id', Auth::user()->empresa_id)->get()
        );
        return view('artigo.edit', compact('dados'));
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
        $dados = Artigo::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->tipo_id = $request->input('tipo_id');
        $dados->retencao_id = $request->input('retencao_id');
        $dados->categoria_id = $request->input('categoria_id');
        $dados->imposto_id = $request->input('imposto_id');
        $dados->preco = Helpers::parseDouble($request->input('preco'));
        $dados->imagem_1 = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : $dados->imagem_1;
        $dados->imagem_2 = ($request->file('file_2')) ? Helpers::uploadFile($request, 'file_2') : $dados->imagem_2;
        $dados->imagem_3 = ($request->file('file_3')) ? Helpers::uploadFile($request, 'file_3') : $dados->imagem_3;
        $dados->unidade = $request->input('unidade');
        $dados->fornecedor_id = $request->input('fornecedor_id');
        $dados->codigo_barra = $request->input('codigo_barra');
        $dados->is_stock = ($request->input('is_stock')) ? true : false;
        $dados->stock_minimo = Helpers::parseInt($request->input('stock_minimo'));
        $dados->stock_maximo = Helpers::parseInt($request->input('stock_maximo'));
        $dados->observacao = $request->input('observacao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();



        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/artigo')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Artigo::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/artigo')->with('success', 'Sucesso');
    }


    public function anular($id)
    {
        $dados = Artigo::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->status = false;
        $dados->save();
        session()->flash('alt_success', 'Succeso');
        return redirect('/artigo')->with('success', 'Sucesso');
    }

    public function activar($id)
    {
        $dados = Artigo::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->status = true;
        $dados->save();
        session()->flash('alt_success', 'Succeso');
        return redirect('/artigo')->with('success', 'Sucesso');
    }
}