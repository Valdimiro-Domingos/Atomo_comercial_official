<?php

namespace App\Http\Controllers;

use App\Endereco;
use App\FacturaRecibo;
use App\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PrintController extends Controller
{
    public function factura_recibo($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($documento_id),
            'item' => FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get(),
            'doc_via' => isset($_GET['doc_via']) ? $_GET['doc_via'] : 'ORIGINAL'
        );

        return view('print.documentos.factura-recibo', compact('dados'));
    }

}