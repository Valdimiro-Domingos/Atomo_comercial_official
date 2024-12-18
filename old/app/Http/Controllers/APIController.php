<?php

namespace App\Http\Controllers;

use App\Artigo;
use App\Endereco;
use App\Factura;
use App\FacturaRecibo;
use App\Http\Controllers\Controller;
use App\Imposto;
use App\Recibo;
use App\Retencao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class APIController extends Controller
{
    public $dados_relatorio_filtro = array();
    /**
     * Grafico a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getArtigo($valor)
    {
        $dados = array('artigo' => Artigo::where('empresa_id', Auth::user()->empresa_id)->find($valor), 'imposto' => Imposto::where('empresa_id', Auth::user()->empresa_id)->find(Artigo::where('empresa_id', Auth::user()->empresa_id)->find($valor)->imposto_id), 'retencao' => Retencao::where('empresa_id', Auth::user()->empresa_id)->find(Artigo::where('empresa_id', Auth::user()->empresa_id)->find($valor)->retencao_id));
        exit(json_encode($dados));
    }

    public function getArtigos($valor = null)
    {
        $dados = array();
        $artigos = null;

        if (strlen($valor) == 0)
            $artigos = Artigo::where('empresa_id', Auth::user()->empresa_id)->get();
        else {
            $artigos = Artigo::
                where('id', '=', $valor)
                ->where('empresa_id', Auth::user()->empresa_id)
                ->orWhere('designacao', 'like', '%' . $valor . '%')
                ->orWhere('codigo_barra', '=', $valor)
                ->get();
        }

        foreach ($artigos as $key => $value) {
            array_push(
                $dados,
                [
                    'artigo' => Artigo::where('empresa_id', Auth::user()->empresa_id)->find($value->id),
                    'imposto' => Imposto::where('empresa_id', Auth::user()->empresa_id)->find(Artigo::where('empresa_id', Auth::user()->empresa_id)->find($value->id)->imposto_id),
                    'retencao' => Retencao::where('empresa_id', Auth::user()->empresa_id)->find(Artigo::where('empresa_id', Auth::user()->empresa_id)->find($value->id)->retencao_id)
                ]
            );
        }

        exit(json_encode($dados));
    }

    public function grafico(Request $request)
    {


        $script = null;
        if ($request->serie_grafico != null)
            $script = $script . "AND serie = '$request->serie_grafico' ";

        if ($request->utilizador_grafico != null)
            $script = $script . "AND id_vendedor = $request->utilizador_grafico ";

        if ($request->tipo_grafico != null) {
            switch ($request->tipo_grafico) {
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
        if ($request->data1_grafico != null && $request->data2_grafico != null)
            $script = $script . "AND data >= '" . $request->data1_grafico . "' AND data <= '" . $request->data2_grafico . "'";


        $empresa_id = Auth::user()->empresa_id;
        foreach (DB::select("SELECT * FROM facturas WHERE 1=1 AND empresa_id = $empresa_id AND status=1 $script") as $item) {
            array_push(
                $this->dados_relatorio_filtro,
                [
                    'data' => $item->data,
                    'descricao' => $item->serie . '/' . $item->numero,
                    'total' => $item->total,
                    'operacao' => 'D',
                ]
            );
        }

        foreach (DB::select("SELECT * FROM factura_recibos WHERE 1=1 AND empresa_id = $empresa_id AND status=1 $script") as $item) {
            array_push(
                $this->dados_relatorio_filtro,
                [
                    'data' => $item->data,
                    'descricao' => $item->serie . '/' . $item->numero,
                    'total' => $item->total,
                    'operacao' => 'C',
                ]
            );
        }

        foreach (DB::select("SELECT * FROM recibos WHERE 1=1 AND empresa_id = $empresa_id AND status=1 $script") as $item) {
            array_push(
                $this->dados_relatorio_filtro,
                [
                    'data' => $item->data,
                    'descricao' => $item->serie . '/' . $item->numero,
                    'total' => $item->total,
                    'operacao' => 'C',
                ]
            );
        }


        foreach (DB::select("SELECT * FROM orcamentos WHERE 1=1  AND empresa_id = $empresa_id AND status=1 $script") as $item) {
            array_push(
                $this->dados_relatorio_filtro,
                [
                    'data' => $item->data,
                    'descricao' => $item->serie . '/' . $item->numero,
                    'total' => $item->total,
                    'operacao' => 'P',
                ]
            );
        }



        usort($this->dados_relatorio_filtro, function ($a, $b) {
            return $a['data'] < $b['data'];
        });



        exit(json_encode($this->dados_relatorio_filtro));
    }


    public function getFornecedorEnderecoContacto($valor)
    {
        $dados = Endereco::where('empresa_id', Auth::user()->empresa_id)->getEntityEnderecoContacto($valor, 'fornecedors');
        exit(json_encode($dados));
    }

    public function getClienteEnderecoContacto($valor)
    {
        $dados = Endereco::where('empresa_id', Auth::user()->empresa_id)->getEntityEnderecoContacto($valor, 'clientes');
        exit(json_encode($dados));
    }



}