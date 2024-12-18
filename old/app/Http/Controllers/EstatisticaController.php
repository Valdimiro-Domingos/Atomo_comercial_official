<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Factura;
use App\FacturaRecibo;
use App\Proforma;
use App\Recibo;
use App\User;
use Illuminate\Http\Request;

class EstatisticaController extends Controller
{
    public function grafico()
    {
        return view('estatistica.grafico');
    }

    public function facturacao_por_vendedor(Request $request)
    {
        return view('estatistica.facturacao.por_vendedor', ['vendedor_id' => $request->vendedor]);
    }

    public function facturacao_por_data(Request $request)
    {
        return view('estatistica.facturacao.por_data', ['data' => $request->data]);
    }

    public function facturacao_por_ano(Request $request)
    {
        return view('estatistica.facturacao.por_ano', ['ano' => $request->ano]);
    }

    public function facturacao_por_mes(Request $request)
    {
        switch ($request->mes) {
            case '01': {
                    $mes_literal = 'Janeiro';
                }
                break;
            case '02': {
                    $mes_literal = 'Fevereiro';
                }
                break;
            case '03': {
                    $mes_literal = 'Março';
                }
                break;
            case '04': {
                    $mes_literal = 'Abril';
                }
                break;
            case '05': {
                    $mes_literal = 'Maio';
                }
                break;
            case '06': {
                    $mes_literal = 'Junho';
                }
                break;
            case '07': {
                    $mes_literal = 'Julho';
                }
                break;
            case '08': {
                    $mes_literal = 'Agosto';
                }
                break;
            case '09': {
                    $mes_literal = 'Setembro';
                }
                break;
            case '10': {
                    $mes_literal = 'Outubro';
                }
                break;
            case '11': {
                    $mes_literal = 'Novembro';
                }
                break;
            case '12': {
                    $mes_literal = 'Dezembro';
                }
                break;
            default: {
                    $mes_literal = '';
                }
        }
        return view('estatistica.facturacao.por_mes', ['mes' => date('Y') . '-' . $request->mes, 'mes_literal' => $mes_literal]);
    }

    public function facturacao_por_trimestre(Request $request)
    {
        if ($request->trimestre == 1) {
            $inicio = $request->ano . '-01-01';
            $fim = $request->ano . '-03-31';
        } else if ($request->trimestre == 2) {
            $inicio = $request->ano . '-04-01';
            $fim = $request->ano . '-06-30';
        } else if ($request->trimestre == 3) {
            $inicio = $request->ano . '-07-01';
            $fim = $request->ano . '-09-30';
        } else {
            $inicio = $request->ano . '-10-01';
            $fim = $request->ano . '-12-31';
        }
        return view('estatistica.facturacao.por_trimestre', ['inicio' => $inicio, 'fim' => $fim]);
    }

    public function venda_por_vendedor(Request $request)
    {
        return view('estatistica.documento.por_vendedor');
    }
}
