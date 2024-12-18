<?php

namespace App\Http\Controllers;

use App\Artigo;
use App\Cliente;
use App\CondicoesPagamento;
use App\Factura;
use App\FacturaRecibo;
use App\FormasPagamento;
use App\Helpers\Helpers;
use App\ItemNotaCredito;
use App\Moeda;
use App\MotivoAnulacao;
use App\NotaCredito;
use App\Serie;
use App\TipoMotivoAnulacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotaCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $dados = NotaCredito::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'DESC')->paginate(9);
        return view('documentos.nota-credito.index', compact('dados'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $dados = NotaCredito::query()
            ->where('cliente_nome', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('numero', 'like', "%$search%")
            ->paginate(10);
        return view('documentos.nota-credito.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_fatura($documento_id)
    {

        $documento = Factura::find($documento_id);
        $dados = array(
            'numero' => Serie::where('empresa_id', Auth::user()->empresa_id)->where('tipo', 'nota-credito')->get()[0]->designacao . '/' . (count(NotaCredito::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'artigos' => Artigo::where('status', true)->where('empresa_id', Auth::user()->empresa_id)->get(),
            'dados' => $documento,
            'item' => $documento->itens,
            'clientes' => Cliente::where('empresa_id', Auth::user()->empresa_id)->find($documento->cliente_id),
            'formaspagamento' => FormasPagamento::where('status', true)->where('empresa_id', Auth::user()->empresa_id)->get(),
            'moedas' => Moeda::where('empresa_id', Auth::user()->empresa_id)->get(),
            'motivo_anulacao' => MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get(),
            'tipo_motivo_anulacao' => TipoMotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get(),
        );
        return view('documentos.nota-credito.create', compact('dados'));
    }

    public function create_fatura_recibo($documento_id)
    {

        $documento = FacturaRecibo::find($documento_id);
        $dados = array(
            'numero' => Serie::where('tipo', 'nota-credito')->where('empresa_id', Auth::user()->empresa_id)->get()[0]->designacao . '/' . (count(NotaCredito::where('empresa_id', Auth::user()->empresa_id)->get()) + 1),
            'dados' => $documento,
            'item' => $documento->itens,
            'clientes' => Cliente::where('empresa_id', Auth::user()->empresa_id)->find($documento->cliente_id),
            'formaspagamento' => FormasPagamento::where('status', true)->where('empresa_id', Auth::user()->empresa_id)->get(),
            'moedas' => Moeda::where('empresa_id', Auth::user()->empresa_id)->get(),
            'motivo_anulacao' => MotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get(),
            'tipo_motivo_anulacao' => TipoMotivoAnulacao::where('empresa_id', Auth::user()->empresa_id)->get(),
        );
        return view('documentos.nota-credito.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $dados = new NotaCredito();
        //Negocio
        $dados->documento_id = $request->input('documento_id');
        $dados->documento_numero = $request->input('documento_numero');
        $dados->motivo_anulacao_id = explode("-", $request->input('motivo_anulacao_id'))[0];
        $dados->motivo_anulacao_designacao = explode("-", $request->input('motivo_anulacao_id'))[1];
        $dados->tipo_motivo_anulacao_id = explode("-", $request->input('tipo_motivo_anulacao_id'))[0];
        $dados->tipo_motivo_anulacao_designacao = explode("-", $request->input('tipo_motivo_anulacao_id'))[1];
        $dados->empresa_id = Auth::user()->empresa_id;

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

        $dados->hash = Helpers::assign($dados, 'nota-credito');
        Helpers::setClientesUsed($request->input('cliente_id'));

        if ($dados->save()) {
            $dados_id = $dados->id;
            for ($i = 0; $i < count($request->input('item')['item_id']); $i++) {
                $dados_item = new ItemNotaCredito();
                $dados_item->nota_credito_id = $dados_id;
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
        if (strstr($request->input('documento_numero'), 'FT')) {
            if (isset($request->documento_id)) {
                $dados = Factura::where('empresa_id', Auth::user()->empresa_id)->find($request->documento_id);
                $dados->is_nota = false;
                $dados->save();
            }
        }
        if (strstr($request->input('documento_numero'), 'FR')) {
            if (isset($request->documento_id)) {
                $dados = FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($request->documento_id);
                $dados->is_nota = false;
                $dados->save();
            }
        }


        exit(json_encode(array('status' => 200)));
    }
}
