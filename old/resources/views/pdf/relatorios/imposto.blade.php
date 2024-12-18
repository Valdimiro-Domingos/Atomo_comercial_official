<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> Relatorio Mapa de Impostos</title>
    <link rel="stylesheet" href="{{ asset('public/assets/pdf/bootstrap.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
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
            width:200px !important;
            height: 150px !important;
            object-fit: cover;
            object-position: left;
            position: relative;
            left: -50px;
        }
    </style>
</head>

<body>


    <div class="header">

    </div>
    <div class="footer">
        <p class="text-center"> {{----}}- </b>
            {{ App\Helpers\Helpers::matriculaAGT() }} <span class="paginacao"></span> </p>
    </div>


    <div class="container">


        <div class="row">
            <div class="col-xs-12">
                <img  class="image-logo" src="{{ asset("public/upload/{$dados['empresa'][0]->foto}") }}"
                    alt="">
            
                <h6>{{ $dados['empresa'][0]->designacao }}</h6>
                <p><strong>NIF: {{ $dados['empresa'][0]->nif }}</strong></p>
                <p> {{ $dados['empresa'][0]->telefone }}</p>
                <p> {{ $dados['empresa'][0]->email }}</p>
                <p> {{ $dados['empresa'][0]->endereco }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <h5><strong>MAPA DE IMPOSTO</strong></h5>
                <p>Intervalo: {{$dados['page']}} / ({{$request->data1 ?? date('d-m-Y') }} á {{$request->data2 ?? date('d-m-Y') }})</p>
            </div>
            <div class="col-xs-6">
                <p><strong>Data de Emissão: {{ date('d-m-Y') }}</strong></p>
                <p><strong>Operador: {{ $dados['utilizador_name'] }}</strong></p>
            </div>
        </div>
        <hr>
        <!-- row -->
         <div class="row">
             <div class="col-lg-12">
                 <div class="card-body">
                     <div class="table-responsive" style="overflow: hidden;">
                        <table id="datatable" class="table table-centered table-nowrap mb-0">
    <thead class="thead-light">
        <tr>
            <th>Imposto</th>
            <th>Taxa</th>
            <th>Nº Produtos</th>
            <th>IVA</th>
            <th>Base Incidência</th>
            <th>Total</th>
        </tr>
    </thead>
    @php 
        $taxaTotal = 0;
        $produtoTotal = 0;
        $impostoTotal = 0;
        $insidenciaTotal = 0;
        $impostoTotalFinal = 0;
    @endphp
    @foreach($dados['dados'] as $item)
        @php
            $impostoTotal += $item['taxa_total'];
            $produtoTotal += $item['produtos'];
             if($item['taxa'] != 0){
                $insidenciaTotal += $item['subtotal'];
            	$impostoTotal = $item['subtotal']*($item['taxa'] == '0' ? 1 : ($item['taxa'] / 100));
                $impostoTotalFinal += ($impostoTotal+$item['subtotal']);
                $taxaTotal += $impostoTotal;
             }

        @endphp
        <tr>
            <td>{{ $item['imposto_tipo'] }}</td>
            <td>{{ $item['taxa'] }} %</td>
            <td>{{ $item['produtos'] }}</td>
            <td>{{  $impostoTotal }}</td>
          	@if($item['taxa'] == 0)
              <td>0</td>
              <td>0</td>
         	@else
          	   <td>{{ $item['subtotal'] }}</td>
              <td>{{ $impostoTotal+ $item['subtotal'] }}</td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="1"></td>
        <td colspan="1"><b>Total</b></td>
        <td><b>{{ $produtoTotal }}</b></td>
        <td><b>{{ ($taxaTotal) }} Kz</b></td>
        <td><b>{{ ($insidenciaTotal) }} Kz</b></td>
        <td><b>{{($impostoTotalFinal) }} Kz</b></td>
    </tr>
</table>

                     </div>
                     <!-- end table-responsive -->
                 </div>
             </div>
         </div>
    </div>
</body>

</html>
