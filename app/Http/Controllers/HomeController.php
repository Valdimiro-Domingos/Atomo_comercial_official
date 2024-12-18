<?php

namespace App\Http\Controllers;

use App\Factura;
use App\FacturaRecibo;
use App\GuiaRemessa;
use App\GuiaTransporte;
use App\NotaCredito;
use App\NotaDebito;
use App\Orcamento;
use App\Proforma;
use App\ReceitaDespesa;
use App\Recibo;
use App\User;
use App\Empresa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public $operacaos = array();
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        if (Auth::user()->reset_password == 1) {
            return redirect('/newPassword');
        }
		
      
      
        $hoje = Carbon::now();  // Obter a data atual
        $empresa = Empresa::find(Auth::user()->empresa_id);
        $prazoInicio = Carbon::parse($empresa->prazo_inicio);
        $prazoTermino = Carbon::parse($empresa->prazo_termino);

        
        // Verifique se a data atual está dentro do intervalo
        if ($hoje->greaterThanOrEqualTo($prazoInicio) && $hoje->lessThanOrEqualTo($prazoTermino)) {  }
        else {
            if(Auth::user()->empresa_id != 1){
                return $this->autentication($empresa->designacao, $empresa->nif);
            }
        }


        if (User::where('empresa_id', Auth::user()->empresa_id)->find(Auth::user()->id)->roles[0]->permissions->count() == 1) {
            if (User::where('empresa_id', Auth::user()->empresa_id)->find(Auth::user()->id)->roles[0]->permissions->where('name', 'pos')->count()) {
                return redirect('/documentos/pos')->with('pos');
            }
        }




        $credito = floatval(ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->where('tipo', 1)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get()->sum('total') + Factura::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get()->sum('total') + FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get()->sum('total'));
        $debito = floatval(ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->where('tipo', 2)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get()->sum('total'));
        $saldo = $credito - $debito;



        $this->getProforma();
        $this->getFactura();
        $this->getFacturaRecibo();
        $this->getRecibo();
        $this->getNotaCredito();
        $this->getNotaDebito();
        $this->getGuiaTransporte();
        $this->getGuiaRemessa();
        $this->getReceitaDespesa();

        usort($this->operacaos, function ($a, $b) {
            return $a['data'] < $b['data'];
        });

        $dados = array(
            'operacaos' => $this->operacaos,
            'credito' => number_format($credito, 2, ',', '.'),
            'debito' => number_format($debito, 2, ',', '.'),
            'saldo' => number_format($saldo, 2, ',', '.'),
        );

        return view('home', compact('dados'));
    }
  
      private function autentication($designation, $identity) {

        $response = Http::post('http://system.atomo.co.ao/gestor/api/auth', [
            'designation' => $designation,
            'identity' => $identity,
        ]);
        
        // Verifica se a chamada foi bem-sucedida
        if ($response->successful()) {
            // Obtém o corpo da resposta
            $responseData = $response->json();
        
            if ($responseData['error']  == false && $responseData['system'] == 'billing') {
                $empresa = Empresa::find(Auth::user()->empresa_id);
                $empresa->prazo_inicio = $responseData['dateIssure'];
                $empresa->prazo_termino = $responseData['dateDue'];
                $empresa->save();
                return;
            }else{
                Auth::logout();
                session()->flash('payment', $responseData['message']);
                return redirect('login')->with(['payment', $responseData['message']]);

            }
            
            session()->flash('company', $responseData['message']);
            return redirect('login')->with(['company', $responseData['message']]);
        }
    }




    public function getProforma()
    {
        foreach (Proforma::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'proforma',
                    'documento' => 'Proforma',
                    'operacao' => 'Informativo',
                ]
            );
        }
    }

    public function getFactura()
    {
        foreach (Factura::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'factura',
                    'documento' => 'Factura',
                    'operacao' => 'Crédito',
                ]
            );
        }
    }

    public function getFacturaRecibo()
    {
        foreach (FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'factura-recibo',
                    'documento' => 'Factura Recibo',
                    'operacao' => 'Crédito',
                ]
            );
        }
    }
    public function getRecibo()
    {
        foreach (Recibo::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->valor_pago,
                    'rota' => 'recibo',
                    'documento' => 'Recibo',
                    'operacao' => 'Crédito',
                ]
            );
        }
    }


    public function getNotaCredito()
    {
        foreach (NotaCredito::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'nota-credito',
                    'documento' => 'Nota Crédito',
                    'operacao' => 'Débito',
                ]
            );
        }
    }

    public function getNotaDebito()
    {
        foreach (NotaDebito::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'nota-debito',
                    'documento' => 'Nota Débito',
                    'operacao' => 'Débito',
                ]
            );
        }
    }

    public function getGuiaTransporte()
    {
        foreach (GuiaTransporte::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'guia-transporte',
                    'documento' => 'Guia Transporte',
                    'operacao' => 'Informativo',
                ]
            );
        }
    }


    public function getGuiaRemessa()
    {
        foreach (GuiaRemessa::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'guia-remessa',
                    'documento' => 'Guia Remessa',
                    'operacao' => 'Informativo',
                ]
            );
        }
    }

    public function getReceitaDespesa()
    {
        foreach (ReceitaDespesa::where('empresa_id', Auth::user()->empresa_id)->whereBetween('data', [date('Y-m-1 00:00:00'), date('Y-m-t 23:59:59')])->get() as $item) {
            if ($item->tipo == 1) {
                array_push(
                    $this->operacaos,
                    [
                        'id' => $item->id,
                        'data' => $item->data,
                        'descricao' => $item->codigo,
                        'total' => $item->total,
                        'rota' => null,
                        'documento' => 'Receita',
                        'operacao' => 'Crédito',
                    ]
                );
            } else {
                array_push(
                    $this->operacaos,
                    [
                        'id' => $item->id,
                        'data' => $item->data,
                        'descricao' => $item->codigo,
                        'total' => $item->total,
                        'rota' => null,
                        'documento' => 'Despesa',
                        'operacao' => 'Débito',
                    ]
                );
            }
        }
    }
}
