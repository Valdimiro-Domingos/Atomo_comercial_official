<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> {{ $dados['dados']->numero }}</title>
    <link rel="stylesheet" href="{{ asset('public/assets/pdf/bootstrap.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            counter-reset: section;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: bold;
        }

        .container {
            margin-top: 0px;
        }

        .table {
            margin-top: 20px;
        }

        .header,
        .footer {
            width: 100%;
            position: fixed;
            padding: 10px 20px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .header {
            top: 0;
        }

        .footer {
            bottom: 0;
        }

        .header p,
        .footer p {
            margin: 0;
        }


        .paginacao::before {
            counter-increment: section;
            content: counter(section);
        }
        
        .image-logo{
            width:120px !important;
            height: 100px !important;
            object-fit: contain;
            object-position: left;
            position: relative;
            left: -30px;
        }
        
        .legenda span{
            display: block;
            font-size: 12.5px;
        }
        .legenda p{
            margin: 0px;
            font-weight: bold!important;
        }
        
        .border-top{
            border-top: 1.5px solid #333;
        }
        .border-bottom{
            border-bottom: 1.5px solid #333;
        }
        .border-bt{
            border-bottom: .8px solid #333;
        }
        
        .px-0{
            padding-left: 0px!important;
            padding-right: 0px!important;
        }
        
        .mx{
            padding-left: 0px!important;
            padding-right: 0px!important;
        }
        
        .p-y2{
           padding-top: 2px; 
           padding-bottom: 2px; 
        }
        .grid{
            background: #000;
        }
        .m-y{
            padding-top: 5px; 
           padding-bottom: 1rem; 
        }
        
        .columnFlex{
            display: flex;
            flex-flow: row;
            gap: 1rem;
        }
        table thead tr th{
            font-size: 10pt;
            font-weight: bold!important;
        }
        table tbody tr td{
            font-size: 9pt;
            padding: 0px;
            margin: 0px;
        }
        .pt{
            margin-top: 1rem;
        }
        .gridColumn{
            width: 100%;
            display: grid;
            border-bottom:1px solid #ccc;
            grid-template-columns: repeat(3, 1fr);
        }
        .gridFlexColumn{
            display: flex;
            flex-flow: row;
            justify-content: space-between;
        }
        .gridFlexColumn span{
            width: 100%;
        }
        
        .tableInset{
            padding: 0px!important
        }
        .tableInset, .tableInset thead, .tableInset thead tr, .tableInset thead tr td, 
        .tableInset, .tableInset tbody, .tableInset tbody tr, .tableInset tbody tr td{
            padding: 0px!important;
            margin: 0px!important;
        }
        
    </style>
</head>

<body>

    @php
        $valor_transporte = 0;
        $count = 0;
        $itens_por_pagina = 10;
        $total_itens = count($dados['item']);
        $total_paginas = ceil($total_itens / $itens_por_pagina);
    @endphp

    <div class="footer p-2">
        <p class="text-center" style="font-size: 8pt!important;">
            <span class="text-left">{{ App\Helpers\Helpers::hashAgt($dados['dados']->hash) }}- </b>
            {{ App\Helpers\Helpers::matriculaAGT() }}</span>
             
        <p class="text-right" style="font-size: 8pt!important;">
            <span class="paginacao"></span>/{{ $total_paginas }} 
        </p>
    </div>
 

    <div class="container px-0">
        @for ($pagina = 0; $pagina < $total_paginas; $pagina++)
            <table class="table border-0">
                <thead>
                 <tr>
                    <td colspan="8">
                        <div class="row">
                            <div class="col-xs-6">
                                <img  class="image-logo" src="{{ asset("public/upload/{$dados['empresa'][0]->foto}") }}"
                                    alt="">
                            </div>
                            <div class="col-xs-6"></div>
                        </div>
                    </td>
                </tr>
                
                <td colspan="8">
                        <div class="row">
                            <div class="col-xs-6 legenda">
                                <p><strong>{{ $dados['empresa'][0]->designacao }}</strong></p>
                                <span>{{ $dados['empresa'][0]->endereco }}</span>
                                <span>Tel: {{ $dados['empresa'][0]->telefone }}</span>
                                <span>E-mail: {{ $dados['empresa'][0]->email }}</span>
                                <span>Contribuinte: {{ $dados['empresa'][0]->nif }}</span>
                            </div>
                            <div class="col-xs-6 legenda">
                                <p><strong>Exmo.(s) Sr(s)</strong></p>
                                <span><strong>{{ $dados['dados']->cliente_nome }}</strong></span>
                                <br>
                                <span style="">{{ $dados['dados']->clienteOne->endereco->endereco }}</span>
                                <span style="font-size: 10.5px;">{{ $dados['dados']->clienteOne->endereco->pais }} - {{ $dados['dados']->clienteOne->endereco->cidade }}</span>
                            </div>
                        </div>
                        
                        <br>
                        <div class="row container">
                            <div class="col-xs-12 col-12 col-md-12 legenda  border-bottom px-0">
                                <span style="font-size: 9.5px;!important"><strong style="color: red;">Este documento não serve de Factura</strong></span>
                                <span><strong>FACTURA PROFORMA {{ $dados['dados']->numero }}</strong></span>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row px-0 m-y">
                                <div class="col-xs-6 px-0">
                                    <div class="columnFlex legenda">
                                        <span>Data de emissão:  <strong>{{ date('d-m-Y', strtotime($dados['dados']->data)) }}</strong></span>
                                        <span>Data de vencimento:  <strong>{{ date('d-m-Y', strtotime($dados['dados']->data_vencimento)) }}</strong></span>
                                        <span>Contribuinte: <strong>{{ $dados['dados']->contribuinte }}</strong></span>
                                        <span>Operador: <strong>{{ $dados['dados']->utilizador_nome }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-xs-6 px-0">
                                    <div class="columnFlex legenda">
                                        <span class="border-bt py-2">Observações</span>
                                        <span>{{ $dados['dados']->observacao }}</span>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-12 col-md-12 legenda  border-bottom px-0"></div>
                            </div>
                        </div>
                         
                              
                    </td>
                </tr>
            </thead>
            
            <tbody>
                @if ($pagina >  0)
                    <tr>
                        <td colspan="8" style="text-align: right">
                            <b>Valor transportado: {{ number_format($valor_transporte, 2, ',', '.') }}</b>
                        </td>
                    </tr>
                @endif
                
                @if ($pagina <=  0)
                    
                @endif
                
                <tr>
                    <th colspan="2">Descrição</th>
                    <th>Qtd</th>
                    <th>Preço Unitrio</th>
                    <th>Desc %</th>
                    <th>Taxa %</th>
                    <th colspan="2">Total</th>
                </tr>

                @php $inicio = $pagina * $itens_por_pagina; @endphp
                @for ($i = $inicio; $i < min($inicio + $itens_por_pagina, $total_itens); $i++)
                    @php
                        $item = $dados['item'][$i];
                        $valor_transporte += $item->subtotal;
                    @endphp
                    <tr>
                        <td colspan="2">{{ $item->designacao }} </td>
                        <td>{{ number_format($item->qtd, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->preco, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->desconto, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->imposto_taxa, 2, ',', '.') }}</td>
                        <td colspan="2">{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endfor
                       
                              
               </tbody>
               <tfoot>
                @if ($pagina <  ($total_paginas - 1))
                    <tr>
                        <td colspan="8" style="text-align: right">
                            <b>Valor à transportar: {{ number_format($valor_transporte, 2, ',', '.') }}</b>
                        </td>
                    </tr>
                @endif
                
                @php
                    $i = 0;
                @endphp
                
                @if ($pagina <  ($total_paginas - 1))
                    @while($i < 9)
                        <tr style="border:none;">
                            <td colspan="8"  style="border:none; color:#fff;">{{$pagina}}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endwhile
                @endif
                
               </tfoot>
            <tfoot>
        </table>
        @endfor
      
        
        @php
            $iva = ['imposto_tipo' => 'IVA (7%)', 'incidencia' => 0, 'visible'=>false, 'v_imposto' => 0];
            $iva_normal = ['imposto_tipo' => 'IVA (14%)', 'incidencia' => 0, 'visible'=>false, 'v_imposto' => 0];
            $isento = ['imposto_tipo' => 'Isento (0%)', 'incidencia' => 0, 'v_imposto' => 0];
        @endphp
        
        @foreach ($dados['item'] as $item)
            @php
                $imposto_id = $item->imposto_id;
                $imposto = \App\Imposto::findOrFail($imposto_id);
                $imposto_taxa = $imposto->taxa;
                $subtotal = $item->subtotal;
        
                if ($imposto_taxa == 7) {
                    $iva['visible'] = 'true';
                    $iva['incidencia'] += $subtotal;
                    $iva['v_imposto'] += ($subtotal * $imposto_taxa) / 100;
                }elseif ($imposto_taxa == 14) {
                    $iva_normal['visible'] = 'true';
                    $iva_normal['incidencia'] += $subtotal;
                    $iva_normal['v_imposto'] += ($subtotal * $imposto_taxa) / 100;
                }elseif ($imposto_taxa == 0) {
                    $isento['incidencia'] += $subtotal;
                }
            @endphp
        @endforeach

        
        
        
        <div class="row px-0  d-flex justify-content-between align-items-center" style="margin-top: 0rem;">
            <div class="col-xs-4">
                <table border="0" class="table border-0 px-0 mx-0">
                    <thead>
                        <tr class="px-0 py-0 mx-0 my-0">
                            <th class="text-left"><strong>Taxa/IVA</strong></th>
                            <th class="text-left"><strong>Incidência</strong></th>
                            <th class="text-center"><strong>Valor</strong></th>
                        </tr>
                    </thead>
                     <tbody>
                     @if($iva['visible'] == 'true')
                            <tr class="px-0 py-0 mx-0 my-0">
                                <td class="text-left"> {{ $iva['imposto_tipo'] }} </td>
                               <td class="text-left"> {{ number_format($iva['incidencia'], 2, ',', '.') }} Kz</td>
                                <td class="text-right"> <strong> {{ number_format($iva['v_imposto'], 2, ',', '.') }} Kz</strong></td>
                            </tr>
                        @endif
                        
                        @if($iva_normal['visible'] == 'true')
                            <tr class="px-0 py-0 mx-0 my-0">
                                <td class="text-left"> {{ $iva_normal['imposto_tipo'] }} </td>
                                <td class="text-left"> {{ number_format($iva_normal['incidencia'], 2, ',', '.') }} Kz</td>
                                <td class="text-right"> <strong> {{ number_format($iva_normal['v_imposto'], 2, ',', '.') }} Kz</strong></td>
                            </tr>
                        @endif
                        
                        <tr class="px-0 py-0 mx-0 my-0">
                            <td class="text-left">{{ $isento['imposto_tipo'] }} %</strong></td>
                            <td class="text-left">{{ number_format($isento['incidencia'], 2, ',', '.') }}  Kz</strong></td>
                            <td class="text-right"><strong>0 Kz</strong></td>
                        </tr>
                        
                        @if ($dados['dados']->retencao != 0)
                            <tr class="px-0 py-0 mx-0 my-0">
                                <td class="text-left"> IIS ({{ 6.5 }})</td>
                                <td class="text-left">{{ number_format($item->subtotal, 2, ',', '.') }} </td>
                                <td class="text-right"> <strong>{{ number_format($dados['dados']->retencao, 2, ',', '.') }}</strong></td>
                            </tr>
                        @endif
                        
                    </tbody>
        
                </table>
            </div>
            
            <div class="col-xs-2"></div>
        
            <div class="col-xs-4 pt">
                <table border="0"  class="table border-0">
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="text-right">{{ number_format($dados['dados']->total, 2, ',', '.') }} Kz</td>
                    </tr>
                </table>
            </div>
        </div>

        
        <div class="row px-0 " style="margin-top: 1rem;">
            <div class="col-xs-4">
                <table border="0" class="table border-0 px-0 mx-0">
                    <thead>
                        <tr class="px-0 py-0 mx-0 my-0">
                            <th class="text-left"><strong>Meio de pagamento</strong></th>
                        </tr>
                    </thead>
                     <tbody>
                        <tr class="px-0 py-0 mx-0 my-0">
                            <td class="text-left">{{ \App\FormasPagamento::find($dados['dados']->formapagamento_id)->designacao }} ({{ \App\Moeda::find($dados['dados']->moeda_id)->designacao }})</td>
                        </tr>
                    </tbody>
                </table>
                
                <table border="0"  class="table border-0" style="margin-top: -2rem;">
                    <thead>
                        <tr>
                            <th>Regime de IVA</th>
                        </tr>
                    </thead>
                    @if($iva['visible'] == 'true' ||  $iva_normal['visible'] == 'true')
                    <tr>
                        <td class="text-left"> Regime Geral </td>
                    </tr>
                    @else
                        <tr>
                            <td class="text-left">Regime simplificado</td>
                        </tr>
                        @endif
                </table> 
            </div>    
        </div>
       
        
        <div class="row px-0  d-flex justify-content-between align-items-center" style="margin-top: -2rem;">
             <div class="col-xs-4">
                @if (count($dados['bancos']))
                    <table border="0"  class="table border-0">
                        <thead>
                            <tr>
                                <th>COORDENADAS BANCÁRIAS</th>
                            </tr>
                        </thead>
                          @foreach ($dados['bancos'] as $item)
                          <tr>
                              <td class="text-left">  <span  style="font-size:7.5pt!important;">{{ $item->nome }} , Nº {{ $item->numero }}, IBAN {{ $item->iban }}</span></td>
                          </tr>
                          
                        @endforeach
                    </table>  
                @endif
            </div>
             <div class="col-xs-2"></div>
            <div class="col-xs-4" style="margin-top: 4rem;">
                 <span style="font-size:8pt!important;"> </span>
            </div>
        </div>

        
    </div>
</body>

</html>
