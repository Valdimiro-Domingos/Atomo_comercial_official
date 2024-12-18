<?php

namespace App\Http\Controllers;

use App\Armazem;
use App\Artigo;
use App\Fornecedor;
use App\Helpers\Helpers;
use App\ItemStock;
use App\Serie;
use App\Stock;
use App\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Stock::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'DESC')->get();
        return view('stock.index', compact('dados'));
    }


    public function stock()
    {
        $dados = Stock::where('empresa_id', Auth::user()->empresa_id)->getStock(date('Y-m-01 00:00:00'),date('Y-m-t  23:59:59'));
        return view('stock.stock', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    
        $dados =   array(
            'serie' => Serie::where('empresa_id', Auth::user()->empresa_id)->where('tipo', 'stock')->get(),
            'numero' => Helpers::mecanografico('', count(Stock::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'dados' => Stock::where('empresa_id', Auth::user()->empresa_id)->get(),
            'artigos' => Artigo::where('empresa_id', Auth::user()->empresa_id)->get(),
            "fornecedor" => Fornecedor::where('empresa_id', Auth::user()->empresa_id)->where("status", true)->get(),
            'armazem' => Armazem::where('empresa_id', Auth::user()->empresa_id)->get(),
        );
;
        return view('stock.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $dados = new Stock();
        $dados->data = $request->input('data');
        $dados->serie = $request->input('serie');
        $dados->numero = $request->input('numero');
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->ref_doc = $request->input('ref_doc');
        $dados->armazem = $request->input('armazem');
        $dados->fornecedor_nome = $request->input('fornecedor_nome');
        $dados->fornecedor_id = $request->input('fornecedor_id');
        $dados->endereco = $request->input('endereco');
        $dados->descricao = $request->input('descricao');
        $dados->status = true; 
        
        $dados->save();
        
        if ($dados->save()) {
            $dados_id = $dados->id;
            for ($i = 0; $i < count($request->input('item')['item_id']); $i++) {
                $dados_item = new ItemStock();
                $dados_item->stock_id = $dados_id;
                $dados_item->empresa_id = Auth::user()->empresa_id;
                
                $dados_item->artigo_id = $request->input('item')['item_id'][$i];
                $dados_item->codigo = $request->input('item')['item_codigo'][$i];
                $dados_item->designacao = $request->input('item')['item_designacao'][$i];
                $dados_item->qtd = $request->input('item')['item_qtd'][$i];
                $dados_item->save();
            }
        }

        exit(json_encode(array('status' => 200)));
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
        $dados =  Stock::find($id);
        return view('stock.edit', compact('dados'));
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
        $dados = Stock::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->descricao = $request->input('descricao');
        $dados->status = ($request->input('status')) ? true : false;
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/stock')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Stock::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/stock')->with('success', 'Sucesso');
    }
}
