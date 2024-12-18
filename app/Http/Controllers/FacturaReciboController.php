<?php

namespace App\Http\Controllers;

use App\Artigo;
use App\Cliente;
use App\Banco;
use App\FacturaRecibo;
use App\FormasPagamento;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\ItemFacturaRecibo;
use App\Moeda;
use App\Serie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FacturaReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $dados = FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'DESC')->paginate(9);
        return view('documentos.factura-recibo.index', compact('dados'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $dados = FacturaRecibo::query()
            ->where('cliente_nome', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('numero', 'like', "%$search%")
            ->paginate(10);
        return view('documentos.factura-recibo.index', compact('dados'));
    }


    public function pos()
    {
        $dados = array(
            'numero' => Serie::where('tipo', 'factura-recibo')->where('empresa_id', Auth::user()->empresa_id)->get()[0]->designacao .' '.date('Y').'/' . (count(FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'artigos' => Artigo::where('empresa_id', Auth::user()->empresa_id)->where('status', true)->get(),
            'clientes' => Cliente::where('empresa_id', Auth::user()->empresa_id)->first(),
            'formaspagamento' => FormasPagamento::where('empresa_id', Auth::user()->empresa_id)->where('status', true)->get(),
            'moedas' => Moeda::where('empresa_id', Auth::user()->empresa_id)->get(),
          'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get(),
        );
        return view('documentos.pos.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $dados = array(
            'numero' => Serie::where('tipo', 'factura-recibo')->where('empresa_id', Auth::user()->empresa_id)->get()[0]->designacao .' '.date('Y') . (count(FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'artigos' => Artigo::where('empresa_id', Auth::user()->empresa_id)->where('status', true)->get(),
            'clientes' => Cliente::where('empresa_id', Auth::user()->empresa_id)->where('status', true)->get(),
            'formaspagamento' => FormasPagamento::where('empresa_id', Auth::user()->empresa_id)->where('status', true)->get(),
            'moedas' => Moeda::where('empresa_id', Auth::user()->empresa_id)->get(),
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );
      	
        return view('documentos.factura-recibo.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $dados = new FacturaRecibo();
        //Cabecalho
        $dados->numero = $request->input('numero');
        $dados->cliente_id = $request->input('cliente_id');
        $dados->cliente_nome = $request->input('cliente_nome');
        $dados->contribuinte = $request->input('contribuinte');
        $dados->endereco = $request->input('endereco');
        //Datelhes
        $dados->data = Carbon::now()->format('Y-m-d H:i:s');
        $dados->data_vencimento = $request->input('data_vencimento');
        $dados->formapagamento_id = $request->input('formapagamento_id');
        $dados->banco_id = $request->input('banco_id');
        $dados->total_banco = $request->input('total_banco');
        $dados->total_caixa = $request->input('total_caixa');    
        $dados->moeda_id = $request->input('moeda_id');
        $dados->utilizador_id = $request->input('utilizador_id');
        $dados->utilizador_nome = $request->input('utilizador_nome');
        //Observação
        $dados->observacao = $request->input('observacao');
        //Sumario
        $dados->subtotal = $request->input('subtotal');
        $dados->desconto = $request->input('desconto');
        $dados->imposto = $request->input('imposto');
        $dados->retencao = $request->input('retencao');
        $dados->total = $request->input('total');
        $dados->status = true;
        $dados->is_nota = true;
        $dados->empresa_id = Auth::user()->empresa_id;


        $dados->hash = Helpers::assign($dados, 'factura-recibo');
        Helpers::setClientesUsed($request->input('cliente_id'));

        if ($dados->save()) {
            $dados_id = $dados->id;

            for ($i = 0; $i < count($request->input('item')['item_id']); $i++) {
                $dados_item = new ItemFacturaRecibo();
                $dados_item->factura_recibo_id = $dados_id;
                $dados_item->artigo_id = $request->input('item')['item_id'][$i];
                $dados_item->designacao = $request->input('item')['item_designacao'][$i];
                $dados_item->preco = $request->input('item')['item_preco'][$i];
                $dados_item->qtd = $request->input('item')['item_qtd'][$i];
                $dados_item->desconto = $request->input('item')['item_desconto'][$i];
                $dados_item->empresa_id = Auth::user()->empresa_id;


                //Retencao
                $dados_item->retencao_id = $request->input('item')['item_retencao_id'][$i];
                $dados_item->retencao_designacao = $request->input('item')['item_retencao_designacao'][$i];
                $dados_item->retencao_taxa = $request->input('item')['item_retencao_taxa'][$i];

                //Imposto
                $dados_item->imposto_id = $request->input('item')['item_imposto_id'][$i];
                $dados_item->imposto_tipo = $request->input('item')['item_imposto_tipo'][$i];
                $dados_item->imposto_codigo = $request->input('item')['item_imposto_codigo'][$i];
                $dados_item->imposto_designacao = $request->input('item')['item_imposto_designacao'][$i];
                $dados_item->imposto_motivo = $request->input('item')['item_imposto_motivo'][$i];
                $dados_item->imposto_taxa = $request->input('item')['item_imposto_taxa'][$i];

                $dados_item->subtotal = $request->input('item')['item_subtotal'][$i];
                Helpers::setArtigoUsed($request->input('item')['item_id'][$i]);

                $dados_item->save();
            }
        }
        session()->flash('alert_success', 'Sucesso');

        if ($request->input('is_pos') == 1) {
            exit(json_encode(array('status' => 200, 'is_pos' => $request->input('is_pos'), 'doc' => $dados_id)));
        } else {
            exit(json_encode(array('status' => 200)));
        }


    }


}