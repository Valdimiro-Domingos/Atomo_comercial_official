<?php

namespace App\Http\Controllers;

use App\FacturaRecibo;
use App\GuiaRemessa;
use App\GuiaTransporte;
use App\Http\Controllers\Controller;
use App\Endereco;
use App\Factura;
use App\Banco;
use App\Cliente;
use App\NotaCredito;
use App\NotaDebito;
use App\Proforma;
use App\ReceitaDespesa;
use App\Recibo;
use App\Stock;
use Illuminate\Http\Request;
use PDF;
use App\Http\Resources\ClienteResource;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;


class PDFController extends Controller
{


    public function proforma($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => Proforma::where('empresa_id', Auth::user()->empresa_id)->with('clienteOne')->with('clienteOne.endereco')->find($documento_id),
            'item' => Proforma::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );

        $pdf = PDF::loadView('pdf.documentos.proforma', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(Proforma::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }

    public function factura($documento_id)
    {
    
        // return Factura::with('clienteOne')->with('clienteOne.endereco')->find($documento_id);
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => Factura::where('empresa_id', Auth::user()->empresa_id)->with('clienteOne')->with('clienteOne.endereco')->find($documento_id),
            'item' => Factura::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get(),
            'doc_via' => isset($_GET['doc_via']) ? $_GET['doc_via'] : 'ORIGINAL'
        );

        $pdf = PDF::loadView('pdf.documentos.factura', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(Factura::find($documento_id)->numero . '.pdf');
    }

    public function factura_recibo($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->with('clienteOne')->with('clienteOne.endereco')->find($documento_id),
            'item' => FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get(),
            'cliente' => Cliente::where('empresa_id', Auth::user()->empresa_id)->with('nomeLoja')->findOrFail(FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->cliente_id),
            'doc_via' => isset($_GET['doc_via']) ? $_GET['doc_via'] : 'ORIGINAL'
        );
        
        
        // return $dados;
        $pdf = PDF::loadView('pdf.documentos.factura-recibo', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }

    public function recibo($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => Recibo::where('empresa_id', Auth::user()->empresa_id)->with('clienteOne')->with('clienteOne.endereco')->find($documento_id),
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );

        $pdf = PDF::loadView('pdf.documentos.recibo', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(Recibo::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }



    public function nota_credito($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => NotaCredito::where('empresa_id', Auth::user()->empresa_id)->with('clienteOne')->with('clienteOne.endereco')->find($documento_id),
            'item' => NotaCredito::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );

        $pdf = PDF::loadView('pdf.documentos.nota-credito', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(NotaCredito::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }



    public function nota_debito($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => NotaDebito::where('empresa_id', Auth::user()->empresa_id)->with('clienteOne')->with('clienteOne.endereco')->find($documento_id),
            'item' => NotaDebito::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );
        $pdf = PDF::loadView('pdf.documentos.nota-debito', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(NotaDebito::find($documento_id)->numero . '.pdf');
    }


    public function guia_transporte($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => GuiaTransporte::where('empresa_id', Auth::user()->empresa_id)->find($documento_id),
            'item' => GuiaTransporte::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );
        $pdf = PDF::loadView('pdf.documentos.guia-transporte', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(GuiaTransporte::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }

    public function guia_remessa($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => GuiaRemessa::where('empresa_id', Auth::user()->empresa_id)->find($documento_id),
            'item' => GuiaRemessa::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );
        $pdf = PDF::loadView('pdf.documentos.guia-remessa', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(GuiaRemessa::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }

    public function stock($documento_id)
    {
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => Stock::where('empresa_id', Auth::user()->empresa_id)->find($documento_id),
            'item' => Stock::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->itens,
            'bancos' => Banco::where('empresa_id', Auth::user()->empresa_id)->get()
        );

        $pdf = PDF::loadView('pdf.documentos.stock', compact('dados'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream(Stock::where('empresa_id', Auth::user()->empresa_id)->find($documento_id)->numero . '.pdf');
    }


    public function relatorio(Request $request)
    {
        $resultado = null;
        $parametro = [];

        if ($request->filled('utilizador_id')) {
            $parametro['utilizador_id'] = $request->utilizador_id;
        }

        if ($request->filled('cliente_id')) {
            $parametro['cliente_id'] = $request->cliente_id;
        }

        $proformas = Proforma::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
            ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
            ->get();

        switch ($request->tipo) {
            case 'proforma':
                if (count($parametro)) {
                    $resultado = Proforma::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = Proforma::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->get();
                }
                break;
            case 'factura':
                if (count($parametro)) {
                    $resultado = Factura::where($parametro)
                        ->where('empresa_id', Auth::user()->empresa_id)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = Factura::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->get();
                }
                break;

            case 'factura-recibo':
                if (count($parametro)) {
                    $resultado = FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->get();
                }
                break;

            case 'recibo':
                if (count($parametro)) {
                    $resultado = Recibo::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = Recibo::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->get();
                }
                break;

            case 'nota-credito':
                if (count($parametro)) {
                    $resultado = NotaCredito::where($parametro)
                        ->where('empresa_id', Auth::user()->empresa_id)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = NotaCredito::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->get();
                }
                break;

            case 'nota-debito':
                if (count($parametro)) {
                    $resultado = NotaDebito::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = NotaDebito::whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->where('empresa_id', Auth::user()->empresa_id)->get();
                }
                break;
            case 'guia-transporte':
                if (count($parametro)) {
                    $resultado = GuiaTransporte::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = GuiaTransporte::whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->where('empresa_id', Auth::user()->empresa_id)->get();
                }
                break;
            case 'guia-remessa':
                if (count($parametro)) {
                    $resultado = GuiaRemessa::where('empresa_id', Auth::user()->empresa_id)->where($parametro)
                        ->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])
                        ->get();
                } else {
                    $resultado = GuiaRemessa::whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->where('empresa_id', Auth::user()->empresa_id)->get();
                }
                break;
            case 'receita-despesa':
                $resultado = ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [$request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59'])->get();
                break;
            case 'stock':
                $resultado = Stock::where('empresa_id', Auth::user()->empresa_id)->getStock($request->data1 . ' 00:00:00', $request->data2 . ' 23:59:59');
                break;

            default:
                break;
        }
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => $resultado,
            'documento' => strtoupper($request->tipo),
            'intervalo' => date('d-m-Y', strtotime($request->data1)) . ' / ' . date('d-m-Y', strtotime($request->data2)),
        );

        $pdf = PDF::loadView('pdf.relatorios.relatorio', compact('dados'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream(strtoupper($request->tipo) . '.pdf');
    }

    public function relatorio_cliente($cliente_id)
    {
        $resultado = null;

        switch ($_GET['tipo']) {
            case 'proforma':
                $resultado = Proforma::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;
            case 'factura':
                $resultado = Factura::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;

            case 'factura-recibo':
                $resultado = FacturaRecibo::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;

            case 'recibo':
                $resultado = Recibo::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;

            case 'nota-credito':
                $resultado = NotaCredito::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;

            case 'nota-debito':
                $resultado = NotaDebito::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;
            case 'guia-transporte':
                $resultado = GuiaTransporte::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;
            case 'guia-remessa':
                $resultado = GuiaRemessa::where('cliente_id', $cliente_id)->where('empresa_id', Auth::user()->empresa_id)->get();
                break;
            default:
                dd('');
                break;
        }
        $dados = array(
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => $resultado,
            'documento' => strtoupper($_GET['tipo']),
            'intervalo' => '',
        );


        $pdf = PDF::loadView('pdf.relatorios.relatorio', compact('dados'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream(strtoupper($_GET['tipo']) . '.pdf');
    }
    
    public function pais_relatorio(Request $request){
        $clientesList = [];
        $date1 = $request->input('data1');
        $date2 = $request->input('data2');
        $timeRange = $request->input('data_intervalo');
        
        
        if($request->pais != '*'){
            
            $clientes = Cliente::with('endereco')
            ->with('contacto')
            ->where('empresa_id', Auth::user()->empresa_id)
            ->whereHas('endereco', function ($query) use ($request) {
                $query->where('pais', $request->pais);
            })
            ->whereBetween('created_at', [$date1.' 00:00:00', $date2.' 23:59:59'])
            ->orderByDesc('id')
            ->get();  
        }else{
            $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)->with('endereco')->with('contacto')->whereBetween('created_at', [$date1 . ' 00:00:00', $date2 . ' 23:59:59'])->orderByDesc('id')->get();
        }
        
            
        $dados = array(
            'request'=> $request->all(), 
            'dados' => ClienteResource::collection($clientes),
            "total" => count($clientes),
            'utilizador_name' => User::findOrFail(Auth::user()->id)->nome,
            "empresa" => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas')
        );
        
            
        $pdf = PDF::loadView('pdf.relatorios.clientes', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('RC-'.$this->generateRandomString(5).'.pdf');
    }
    

    
    // Gera uma string aleatória de 10 caracteres
    public function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
