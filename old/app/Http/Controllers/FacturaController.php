<?php

namespace App\Http\Controllers;

use App\Artigo;
use App\Cliente;
use App\Factura;
use App\Banco;
use App\FormasPagamento;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Item;
use App\Moeda;
use App\Proforma;
use App\Serie;
use Carbon\Carbon;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;




class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $dados = Factura::orderBy('id', 'DESC')->where('empresa_id', Auth::user()->empresa_id)->paginate(9);
        return view('documentos.factura.index', compact('dados'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $dados = Factura::query()
            ->where('cliente_nome', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('numero', 'like', "%$search%")
            ->paginate(10);
        return view('documentos.factura.index', compact('dados'));
    }


    public function create()
    {
        $dados = array(
            'numero' => Serie::where('tipo', 'factura')->get()[0]->designacao . '/' . (count(Factura::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'artigos' => Artigo::All()->where('empresa_id', Auth::user()->empresa_id)->where('status', true),
            'clientes' => Cliente::where('empresa_id', Auth::user()->empresa_id)->where('id', '!=', 1)->where('status', true)->get(),
            'formaspagamento' => FormasPagamento::All()->where('empresa_id', Auth::user()->empresa_id)->where('status', true),
            'moedas' => Moeda::where('empresa_id', Auth::user()->empresa_id)->get(),
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get(),
        );
        return view('documentos.factura.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $dados = new Factura();
        //Negocio
        $dados->documento_id = $request->input('documento_id');
        $dados->documento_numero = $request->input('documento_numero');

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
        $dados->empresa_id = Auth::user()->empresa_id;

        //Observação
        $dados->observacao = $request->input('observacao');
        //Sumario
        $dados->subtotal = $request->input('subtotal');
        $dados->desconto = $request->input('desconto');
        $dados->imposto = $request->input('imposto');
        $dados->retencao = $request->input('retencao');
        $dados->total = $request->input('total');
        $dados->total_pendente = $request->input('total');
        $dados->status = true;
        $dados->is_recibo = true;
        $dados->is_nota = true;

        $dados->hash = Helpers::assign($dados, 'factura');
        Helpers::setClientesUsed($request->input('cliente_id'));

        if ($dados->save()) {
            $dados_id = $dados->id;
            for ($i = 0; $i < count($request->input('item')['item_id']); $i++) {
                $dados_item = new Item();
                $dados_item->factura_id = $dados_id;
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

        //Negocio
        if (isset($request->documento_id)) {
            $dados = Proforma::where('empresa_id', Auth::user()->empresa_id)->find($request->documento_id);
            $dados->is_factura = false;
            $dados->save();
        }

        exit(json_encode(array('status' => 200)));
    }



    public function proforma_factura($documento_id)
    {
        $proforma = Proforma::where('empresa_id', Auth::user()->empresa_id)->find($documento_id);
        $dados = array(
            'numero' => Serie::where('empresa_id', Auth::user()->empresa_id)->where('tipo', 'factura')->get()[0]->designacao . '/' . (count(Factura::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'dados' => $proforma,
            'item' => $proforma->itens,
            'clientes' => Cliente::where('empresa_id', Auth::user()->empresa_id)->find($proforma->cliente_id),
            'formaspagamento' => FormasPagamento::all()->where('empresa_id', Auth::user()->empresa_id)->where('status', true),
            'moedas' => Moeda::where('empresa_id', Auth::user()->empresa_id)->get()
        );
        return view('documentos.factura.create_proforma_factura', compact('dados'));
    }
}
