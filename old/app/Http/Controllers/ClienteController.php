<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Contacto;
use App\Endereco;
use App\Factura;
use App\FacturaRecibo;
use App\GuiaRemessa;
use App\GuiaTransporte;
use App\Helpers\Helpers;
use App\NotaCredito;
use App\NotaDebito;
use App\Orcamento;
use App\Proforma;
use App\Recibo;
use Carbon\Carbon;
use Illuminate\Http\Request;

use PDF;
use Illuminate\Support\Facades\Auth;
use App\ItemFacturaRecibo;
use App\Item;
use App\Imposto;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;


// use chillerlan\QRCode\QRCode;
// use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Storage;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ClienteController extends Controller
{
    public $operacaos = array();
    public $operacaosFiltro = array();
    
    
    private $baseSistema = array();
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Cliente::where('empresa_id', Auth::user()->empresa_id)->paginate(9);
        return view('cliente.index', compact('dados'));
    }


     public function search(Request $request)
    {
        $search = $request->input('search');
        $dados = Cliente::query()
            ->where('designacao', 'like', "%$search%")
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orWhere('contribuinte', 'like', "%$search%")
            ->paginate(10);
        return view('cliente.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo = Helpers::mecanografico(date('Y-'), count(Cliente::where('empresa_id', Auth::user()->empresa_id)->get()) + 1);
        $dados = Cliente::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('cliente.create', compact('dados', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Endereco
        $dados_endereco = new Endereco();
        $dados_endereco->pais = $request->input('pais');
        $dados_endereco->cidade = $request->input('cidade');
        $dados_endereco->endereco = $request->input('endereco');
        $dados_endereco->empresa_id = Auth::user()->empresa_id;
        $dados_endereco->save();

        //Contacto
        $dados_contacto = new Contacto();
        $dados_contacto->telefone = $request->input('telefone');
        $dados_contacto->fax = $request->input('fax');
        $dados_contacto->telemovel = $request->input('telemovel');
        $dados_contacto->contacto = $request->input('contacto');
        $dados_contacto->email = $request->input('email');
        $dados_contacto->facebook = $request->input('facebook');
        $dados_contacto->whatsapp = $request->input('whatsapp');
        $dados_contacto->skype = $request->input('skype');
        $dados_contacto->twitter = $request->input('twitter');
        $dados_contacto->linkedin = $request->input('linkedin');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->empresa_id = Auth::user()->empresa_id;
        $dados_contacto->save();


        $dados = new Cliente;
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->contribuinte = $request->input('contribuinte');
        $dados->zona = $request->input('zona');
        $dados->observacao = $request->input('observacao');
        $dados->identificacao = $request->input('identificacao');
        $dados->imagem = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : 'null.png';
        $dados->status = ($request->input('status')) ? true : false;
        $dados->id_endereco = $dados_endereco->id;
        $dados->id_contacto = $dados_contacto->id;
        $dados->empresa_id = Auth::user()->empresa_id;

        // $dados->id_artigo = $request->input('id_artigo');
        // $dados->nave = $request->input('nave');
        // $dados->local = $request->input('local');
        $dados->save();

        return redirect('/cliente')->with('success', 'Sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function criarCode($id){
        $base = url('/')."/documentos/factura-qr/create/".$id;
        $qrCode = QrCode::size(200)->generate($base);

        // Renderizar o QR code em um elemento HTML
        $qrCodeHtml = '<img src="data:image/png;base64,' . base64_encode($qrCode) . '" />';
        $cliente = Cliente::findOrFail($id);
        
       // validar o campo status qr
        if ($cliente->is_qr == 0) {
            $cliente->is_qr = '1';
            $cliente->save();
        }
        
        
        // Gerar o PDF com o QR code
        $pdf = PDF::loadView('pdf.documentos.proforma_code', ['qrCode' => $qrCodeHtml, 'cliente' => $cliente]);
        return $pdf->download('cliente-'.time().'.pdf');
    }
    
    public function qrcodePagamento($id){
        $urlCurrent = url('/')."/cliente_code";
    }
    
    
    public function viewCode($id){
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $artigo  = Cliente::where('empresa_id', Auth::user()->empresa_id)->with('loja')->findOrFail($id)->loja;
        $dados = Endereco::getEntityEnderecoContacto($id, 'clientes');
        return view('cliente.edit', compact('dados', 'artigo'));
    }


    public function cmp($a, $b)
    {
        return $a['nome'] > $b['nome'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dados = Cliente::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->codigo = $request->input('codigo');
        $dados->designacao = $request->input('designacao');
        $dados->contribuinte = $request->input('contribuinte');
        $dados->zona = $request->input('zona');
        $dados->observacao = $request->input('observacao');
        $dados->identificacao = $request->input('identificacao');
        $dados->imagem = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : $dados->imagem;
        $dados->status = ($request->input('status')) ? true : false;
        
        //$dados->id_artigo = $request->input('id_artigo/');
        // $dados->empresa_id = Auth::user()->empresa_id;
        $dados->save();

        //Endereco
        $dados_endereco = Endereco::find($dados->id_endereco);
        $dados_endereco->pais = $request->input('pais');
        $dados_endereco->cidade = $request->input('cidade');
        $dados_endereco->endereco = $request->input('endereco');
        // $dados->empresa_id = Auth::user()->empresa_id;
        $dados_endereco->save();

        //Contacto
        $dados_contacto = Contacto::find($dados->id_contacto);
        // $dados->empresa_id = Auth::user()->empresa_id;
        $dados_contacto->telefone = $request->input('telefone');
        $dados_contacto->fax = $request->input('fax');
        $dados_contacto->telemovel = $request->input('telemovel');
        $dados_contacto->contacto = $request->input('contacto');
        $dados_contacto->email = $request->input('email');
        $dados_contacto->facebook = $request->input('facebook');
        $dados_contacto->whatsapp = $request->input('whatsapp');
        $dados_contacto->skype = $request->input('skype');
        $dados_contacto->twitter = $request->input('twitter');
        $dados_contacto->linkedin = $request->input('linkedin');
        $dados_contacto->website = $request->input('website');
        $dados_contacto->save();


        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/cliente')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Cliente::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/cliente')->with('success', 'Sucesso');
    }

    public function anular($id)
    {
        $dados = Cliente::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->status = false;
        $dados->save();
        session()->flash('alt_success', 'Succeso');
        return redirect('/cliente')->with('success', 'Sucesso');
    }

    public function activar($id)
    {
        $dados = Cliente::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->status = true;
        $dados->save();
        session()->flash('alt_success', 'Succeso');
        return redirect('/cliente')->with('success', 'Sucesso');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function conta_corrente($id)
    {

        $credito = floatval(FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->get()->where('cliente_id', $id)->sum('total') + Recibo::where('empresa_id', Auth::user()->empresa_id)->get()->where('cliente_id', $id)->sum('valor_pago'));
        $debito = floatval(Factura::where('empresa_id', Auth::user()->empresa_id)->get()->where('cliente_id', $id)->sum('total'));
        $saldo = $credito - $debito;
        
        $this->getProforma($id);
        $this->getFactura($id);
        $this->getFacturaRecibo($id);
        $this->getRecibo($id);
        $this->getNotaCredito($id);
        $this->getNotaDebito($id);
        $this->getGuiaTransporte($id);
        $this->getGuiaRemessa($id);

        usort($this->operacaos, function ($a, $b) {
            return $a['data'] < $b['data'];
        });

        $dadosa = array(
            'cliente' => Endereco::getEntityEnderecoContacto($id, 'clientes'),
        );
        
        $dados = array(
            'operacaos' => $this->operacaos,
            'credito' => number_format($credito, 2, ',', '.'),
            'debito' => number_format($debito, 2, ',', '.'),
            'saldo' => number_format($saldo, 2, ',', '.'),
            'empresa' => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas'),
            'dados' => $this->operacaos,
            'cliente' => Endereco::getEntityEnderecoContacto($id, 'clientes')[0],
            'utilizador_name' => User::findOrFail(Auth::user()->id)->nome,
            'doc_via' => isset($_GET['doc_via']) ? $_GET['doc_via'] : 'ORIGINAL'
        );
        
        // return $dados;
        $pdf = PDF::loadView('pdf.documentos.conta-corrente', compact('dados'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('contacorrente.pdf');
        // return view('cliente.conta_corrente', compact('dados'));
    }
    
    
    public function imposto_geral(Request $request){
        $page = '';
        switch ($request->input('data_intervalo')) {
            case '*':
            $page = 'Geral';
            break;
            case 'today':
                $page = 'Atual';
                break;
            case 'this_week':
                $page = 'Semanal';
                break;
            case 'first_semester':
                $page = 'Mensal';
                break;
            case 'second_semester':
                    $page = 'Segundo Semestre';
                    break;
            case 'this_year':
                $page = 'Ano Atual';
                break;
                        
            default:
                $page = 'Personalizado';
                break;
        }
        
        // $dateOfIssure = Carbon::parse($date_of_issure)->format('Y-m-d');
        // $dateDue = Carbon::parse($date_due)->format('Y-m-d');
        
        $this->baseSistema = [];
        
        $impostos = Imposto::where('empresa_id', Auth::user()->empresa_id)->get();
        foreach ($impostos as $key => $imposto) {
            // $items = Item::where('imposto_id', $imposto->id)->get();
            
           
            if(ItemFacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->count() > 0 || Item::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->count() > 0){
                array_push(
                    $this->baseSistema,
                    [
                        'imposto_total' =>  (ItemFacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->sum('imposto_taxa') + Item::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->sum('imposto_taxa')),
                        'taxa_total' =>  (ItemFacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->sum('imposto_taxa') +  Item::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->sum('imposto_taxa')),
                        "imposto_tipo" => $imposto->designacao,
                       	"taxa" => $imposto->taxa,
                      	"subtotal" => (ItemFacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->sum('subtotal') +  Item::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->sum('subtotal')),
                        "produtos" => (ItemFacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->count() +  Item::where('empresa_id', Auth::user()->empresa_id)->where('imposto_id', $imposto->id)->whereBetween('created_at', [($request->data1 ?? date('Y-m-d')). ' 00:00:00', ($request->data2 ?? date('Y-m-d')). ' 23:59:59'])->count())
                    ]
                );
            }
        }
        
        usort($this->operacaosFiltro, function ($a, $b) {
            return $a['data'] < $b['data'];
        });

        $dados = array(
            'request'=> $request->all(), 
            'page' => $page,
            'dados' => $this->baseSistema,
            'utilizador_name' => User::findOrFail(Auth::user()->id)->nome,
            "empresa" => Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas')
        );
        
    
        $pdf = PDF::loadView('pdf.relatorios.imposto', compact('dados', 'request'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('MAPA_IMPOSTO'.date('Hms').'.pdf');
    }

    public function getProforma($id)
    {
        foreach (Proforma::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
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

    public function getFiltroFactura($id)
    {
        foreach (Factura::with('itens')->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id)->where('is_nota', false)->get() as $item) {
            array_push(
                $this->operacaosFiltro,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'imposto' =>  $item->imposto,
                    'retencao' =>  $item->retencao,
                    'imposto_designacao' =>  $item->imposto_designacao,
                    'rota' => 'factura',
                    'documento' => 'Factura',
                    'operacao' => 'Débito',
                ]
            );
        }
    }
    
    public function getFiltroFacturaRecibo($id)
    {
        foreach (FacturaRecibo::with('itens')->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id)->where('is_nota', false)->get() as $item) {
            array_push(
                $this->operacaosFiltro,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'imposto' =>  $item->imposto,
                    'retencao' =>  $item->retencao,
                    'rota' => 'factura-recibo',
                    'documento' => 'Factura Recibo',
                    'operacao' => 'Crédito',
                ]
            );
        }
    }
    
    
    public function getFactura($id)
    {
        foreach (Factura::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'factura',
                    'documento' => 'Factura',
                    'operacao' => 'Dbito',
                ]
            );
        }
    }
    public function getFacturaRecibo($id)
    {
        foreach (FacturaRecibo::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
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
    public function getRecibo($id)
    {
        foreach (Recibo::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
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

    public function getNotaCredito($id)
    {
        foreach (NotaCredito::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'nota-credito',
                    'documento' => 'Nota Crédito',
                    'operacao' => 'Informativo',
                ]
            );
        }
    }

    public function getNotaDebito($id)
    {
        foreach (NotaDebito::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
            array_push(
                $this->operacaos,
                [
                    'id' => $item->id,
                    'data' => $item->data,
                    'descricao' => $item->numero,
                    'total' => $item->total,
                    'rota' => 'nota-debito',
                    'documento' => 'Nota Débito',
                    'operacao' => 'Informativo',
                ]
            );
        }
    }

    public function getGuiaTransporte($id)
    {
        foreach (GuiaTransporte::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
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
    public function getGuiaRemessa($id)
    {
        foreach (GuiaRemessa::all()->where('empresa_id', Auth::user()->empresa_id)->where('cliente_id', $id) as $item) {
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
}