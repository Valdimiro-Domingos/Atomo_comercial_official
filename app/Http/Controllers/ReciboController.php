<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\CondicoesPagamento;
use App\Factura;
use App\FormasPagamento;
use App\Helpers\Helpers;
use App\Recibo;
use App\Http\Controllers\Controller;
use App\ItemRecibo;
use App\Moeda;
use App\Serie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $dados = Recibo::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'DESC')->paginate(9);
        return view('documentos.recibo.index', compact('dados'));
    }

     public function search(Request $request)
     {
         $search = $request->input('search');
         $dados = Recibo::query()
            ->where('cliente_nome', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('numero', 'like', "%$search%")
             ->paginate(10);
         return view('documentos.recibo.index', compact('dados'));
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $dadosfatura = Factura::where('empresa_id', Auth::user()->empresa_id)->find($request->factura_id);
        $dados = new Recibo();

        //Cabecalho
        $dados->numero = Serie::where('empresa_id', Auth::user()->empresa_id)->where('tipo', 'recibo')->get()[0]->designacao .' '.date('Y').  '/' . (count(Recibo::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados->cliente_id = $dadosfatura->cliente_id;
        $dados->cliente_nome = $dadosfatura->cliente_nome;
        $dados->contribuinte = $dadosfatura->contribuinte;
        $dados->endereco = $dadosfatura->endereco;
        
        //Datelhes
        $dados->data = Carbon::now()->format('Y-m-d H:i:s');
        $dados->data_vencimento = date('Y-m-d');
        $dados->formapagamento_id = $dadosfatura->formapagamento_id;
        $dados->moeda_id = $dadosfatura->moeda_id;
        $dados->utilizador_id = Auth::user()->id;
        $dados->utilizador_nome = Auth::user()->nome;
        $dados->empresa_id = Auth::user()->empresa_id;
        //Observação
        $dados->observacao = $dadosfatura->observacao;

        //Recibo
        $dados->numero_documento = $request->numero;
        $dados->data_documento = $dadosfatura->data;
        $dados->total_pendente = $dadosfatura->total_pendente;
        $dados->valor_pago = Helpers::parseDouble($request->valor_pago);
        $dados->ficheiro = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : 'null.png';
        $dados->data_ficheiro = $request->data;
        $dados->retencao_taxa = $request->retencao;
        $dados->factura_id = $request->factura_id;

        //Sumario
        $dados->subtotal = $dadosfatura->subtotal;
        $dados->desconto = $dadosfatura->desconto;
        $dados->imposto = $dadosfatura->imposto;
        $dados->retencao = $dadosfatura->retencao;
        $dados->total = $dadosfatura->total;
        $dados->status = true;

        $dados->hash = Helpers::assign($dados, 'recibo');
  /*       Helpers::setClientesUsed($request->input('cliente_id')); */
        $dados->save();

        //Negocio
        if ($dadosfatura->total_pendente > Helpers::parseDouble($request->valor_pago)) {
            $dadosfatura->total_pendente -= Helpers::parseDouble($request->valor_pago);
        } else if ($dadosfatura->total_pendente == Helpers::parseDouble($request->valor_pago)) {
            $dadosfatura->total_pendente -= Helpers::parseDouble($request->valor_pago);
            $dadosfatura->is_recibo = false;
        } else {
            $dadosfatura->total_pendente = 0;
            $dadosfatura->is_recibo = false;
        }


        $dadosfatura->save();

        return redirect('/documentos/recibo')->with('success', 'Sucesso');
    }
}
