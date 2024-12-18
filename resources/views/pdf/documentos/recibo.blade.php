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
        $total_itens = 1;
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
                                <span><strong>RECIBO {{ $dados['dados']->numero }}</strong></span>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row px-0 m-y">
                                <div class="col-xs-6 px-0">
                                    <div class="columnFlex legenda">
                                        <span>Data de emissão:  <strong>{{ date('d-m-Y', strtotime($dados['dados']->data)) }}</strong></span>
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
               
                
                    <tr>
                        <th  colspan="2">Ref. Factura</th>
                        <th>Data de Emisso</th>
                        <th>Total Ilíquido</th>
                        <th>Total Desconto</th>
                        <th>Total Imposto</th>
                        <th colspan="2">Total Fatura</th>
                    </tr>

               
                    <tr>
                        <td colspan="2">{{ $dados['dados']->numero_documento }} </td>
                        <td>{{ date('d-m-Y', strtotime($dados['dados']->data_documento)) }} </td>
                        <td>{{ number_format($dados['dados']->subtotal, 2, ',', '.') }} </td>
                        <td>{{ number_format($dados['dados']->desconto, 2, ',', '.') }} </td>
                        <td>{{ number_format($dados['dados']->imposto, 2, ',', '.') }} </td>
                        <td colspan="2">{{ number_format($dados['dados']->total, 2, ',', '.') }} </td>
                    </tr>
                       
                              
               </tbody>
            <tfoot>
        </table>
        @endfor
      
        
        
        
        <div class="row px-0  d-flex justify-content-between align-items-center" style="margin-top: 0rem;">
            <div class="col-xs-4"></div>
            
            <div class="col-xs-2"></div>
        
            <div class="col-xs-4 pt">
                <table border="0"  class="table border-0">
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="text-right">{{ number_format($dados['dados']->total, 2, ',', '.') }} Kz</td>
                    </tr>
                    
                     @if ($dados['dados']->formapagamento_id == 4)
                        <tr>
                            <td><strong>Total Caixa</strong></td>
                            <td class="text-right">{{ number_format($dados['dados']->total_caixa, 2, ',', '.') }} Kz</td>
                        </tr>
                        <tr>
                            <td><strong>Total Dinheiro</strong></td>
                            <td class="text-right">{{ number_format($dados['dados']->total_banco, 2, ',', '.') }} Kz</td>
                        </tr>
                        @endif
                        
                        @if ($dados['dados']->total_pendente > $dados['dados']->valor_pago)
                            <tr>
                                <td><strong>Total Pendete</strong></td>
                                <td class="text-right">{{ number_format($dados['dados']->total_pendente, 2, ',', '.') }} Kz</td>
                            </tr>
                            <tr>
                                <td><strong>Total Pago</strong></td>
                                <td class="text-right">{{ number_format($dados['dados']->valor_pago, 2, ',', '.') }} Kz</td>
                            </tr>
                            <tr>
                                <td><strong>Total Divida</strong></td>
                                <td class="text-right">{{ number_format(($dados['dados']->total_pendente - $dados['dados']->valor_pago), 2, '.', ',') }} Kz</td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Total Pago</strong></td>
                                <td class="text-right">{{ number_format($dados['dados']->valor_pago, 2, ',', '.') }} Kz</td>
                            </tr>
                        @endif
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
            </div>    
        </div>
       
        
    </div>
</body>

</html>
