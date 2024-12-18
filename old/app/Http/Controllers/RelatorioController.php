<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Endereco;
use App\Factura;
use App\FacturaRecibo;
use App\Http\Controllers\Controller;
use App\Orcamento;
use App\Proforma;
use App\Recibo;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    public $dados_relatorio_filtro = array();





    public function relatorio_filtro(Request $request)
    {


        $script = null;
        $dados = null;
        $empresa_id = Auth::user()->empresa_id;

        if ($request->iddocumento) {
            if ($request->serie != null)
                $script = $script . "AND serie = '$request->serie' ";

            if ($request->utilizador != null)
                $script = $script . "AND id_vendedor = $request->utilizador ";

            if ($request->tipo != null) {
                switch ($request->tipo) {
                    case 1:
                        $script = $script . "AND data = '" . date('Y-m-d', strtotime("now")) . "'";
                        break;
                    case 2:
                        $script = $script . "AND data >= '" . date('Y-m-d  00:00:00', strtotime("-7 day")) . "' AND data <= '" . date('Y-m-d  00:00:00') . "'";
                        break;
                    case 3:
                        $script = $script . "AND data >= '" . date('Y-m-d  00:00:00', strtotime("-1 month")) . "' AND data <= '" . date('Y-m-d  00:00:00') . "'";
                        break;
                    case 4:
                        $script = $script . "AND data >= '" . date('Y-m-d  00:00:00', strtotime("-3 month")) . "' AND data <= '" . date('Y-m-d  00:00:00') . "'";
                        break;
                    case 5:
                        $script = $script . "AND data >= '" . date('Y-m-d  00:00:00', strtotime("-6 month")) . "' AND data <= '" . date('Y-m-d  00:00:00') . "'";
                        break;
                    case 5:
                        $script = $script . "AND data >= '" . date('Y-m-d  00:00:00', strtotime("1 year")) . "' AND data <= '" . date('Y-m-d  00:00:00') . "'";
                        break;
                }
            }
            if ($request->data1 != null && $request->data2 != null)
                $script = $script . "AND data >= '" . $request->data1  . "' AND data <= '" . $request->data2 . "'";

            switch ($request->iddocumento) {
                case 1:
                    foreach (DB::select("SELECT * FROM facturas WHERE 1=1 AND empresa_id = $empresa_id AND status=1 $script") as $item) {
                        array_push(
                            $this->dados_relatorio_filtro,
                            [
                                'data' => $item->data,
                                'descricao' => $item->serie . '/' . $item->numero,
                                'total' => $item->total,
                                'operacao' => false,
                            ]
                        );
                    }

                    $dados =   array(
                        'empresa' =>  Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
                        'dados' => $this->dados_relatorio_filtro,
                        'config' => array('tipo' => 1, 'documento' => 'factura')
                    );
                    return view('pdf.relatorio_filtro', compact('dados'));
                case 2:
                    foreach (Cliente::where('empresa_id', Auth::user()->empresa_id)->get() as $item) {


                        $credito = (DB::select("SELECT NVL(SUM(total),0)'total' FROM factura_recibos WHERE 1=1 AND  empresa_id = $empresa_id AND id_cliente=$item->id AND status=1 $script")[0]->total)
                            +
                            (DB::select("SELECT NVL(SUM(total),0)'total' FROM recibos WHERE 1=1 AND  empresa_id = $empresa_id AND id_cliente=$item->id AND status=1 $script")[0]->total);
                        $debito = (DB::select("SELECT NVL(SUM(total),0)'total' FROM facturas WHERE 1=1 AND  empresa_id = $empresa_id AND id_cliente=$item->id AND status=1 $script")[0]->total);

                        $saldo = $credito - $debito;
                        array_push(
                            $this->dados_relatorio_filtro,
                            [
                                'cliente' => Endereco::getEntityEnderecoContacto($item->id, 'clientes')[0]->designacao,
                                'credito' => number_format($credito, 2, ',', '.'),
                                'debito' => number_format($debito, 2, ',', '.'),
                                'saldo' => number_format($saldo, 2, ',', '.')
                            ]
                        );
                    }
                    $dados =   array(
                        'empresa' =>  Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
                        'dados' =>  $this->dados_relatorio_filtro,
                        'config' => array('tipo' => 2, 'documento' => 'CLIENTE'),
                    );
                    return view('pdf.relatorio_filtro', compact('dados'));

                case 3:

                    foreach (Cliente::where('empresa_id', Auth::user()->empresa_id)->get() as $item) {


                        $dados = (DB::select("SELECT COUNT(id)'total', NVL(SUM(total),0)'valor' FROM orcamentos WHERE 1=1 AND  empresa_id = $empresa_id AND id_cliente=$item->id AND status=1 $script"));


                        array_push(
                            $this->dados_relatorio_filtro,
                            [
                                'cliente' => Endereco::getEntityEnderecoContacto($item->id, 'clientes')[0]->designacao,
                                'total' => $dados[0]->total,
                                'valor' => number_format($dados[0]->valor, 2, ',', '.'),
                            ]
                        );
                    }
                    $dados =   array(
                        'empresa' =>  Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
                        'dados' =>  $this->dados_relatorio_filtro,
                        'config' => array('tipo' => 3, 'documento' => 'CLIENTE'),
                    );
                    return view('pdf.relatorio_filtro', compact('dados'));
                default:
                    if ($request->iddocumento == 4) {
                        foreach (DB::select("SELECT * FROM orcamentos WHERE 1=1 AND  empresa_id = $empresa_id AND status=1 $script") as $item) {
                            array_push(
                                $this->dados_relatorio_filtro,
                                [
                                    'data' => $item->data,
                                    'descricao' => $item->serie . '/' . $item->numero,
                                    'total' => $item->total,
                                    'operacao' => false,
                                ]
                            );
                        }
                    }

                    if ($request->iddocumento == 5) {
                        foreach (DB::select("SELECT * FROM proformas WHERE 1=1 AND  empresa_id = $empresa_id AND  status=1 $script") as $item) {
                            array_push(
                                $this->dados_relatorio_filtro,
                                [
                                    'data' => $item->data,
                                    'descricao' => $item->serie . '/' . $item->numero,
                                    'total' => $item->total,
                                    'operacao' => false,
                                ]
                            );
                        }
                    }

                    if ($request->iddocumento == 6) {
                        foreach (DB::select("SELECT * FROM facturas WHERE 1=1 AND  empresa_id = $empresa_id AND  status=1 $script") as $item) {
                            array_push(
                                $this->dados_relatorio_filtro,
                                [
                                    'data' => $item->data,
                                    'descricao' => $item->serie . '/' . $item->numero,
                                    'total' => $item->total,
                                    'operacao' => false,
                                ]
                            );
                        }
                    }

                    if ($request->iddocumento == 7) {
                        foreach (DB::select("SELECT * FROM factura_recibos WHERE 1=1 AND  empresa_id = $empresa_id AND status=1 $script") as $item) {
                            array_push(
                                $this->dados_relatorio_filtro,
                                [
                                    'data' => $item->data,
                                    'descricao' => $item->serie . '/' . $item->numero,
                                    'total' => $item->total,
                                    'operacao' => false,
                                ]
                            );
                        }
                    }

                    $dados =   array(
                        'empresa' =>  Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
                        'dados' => $this->dados_relatorio_filtro,
                        'config' => array('tipo' => 1, 'documento' => '')
                    );
                    return view('pdf.relatorio_filtro', compact('dados'));
            }
        }
    }
}
