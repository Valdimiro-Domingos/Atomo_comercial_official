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
                <p>Intervalo: {{$dados['page']}}</p>
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
                                     <th>Total</th>>
                                 </tr>
                             </thead>
                                @php 
                                    $impostoTotal = 0;
                                    $taxaTotal = 0;
                                    $impostoTotal = 0;
                                @endphp
                                @foreach($dados['dados'] as $item)
                                    $impostoTotal += $item['imposto_total'];
                                    $taxaTotal = $item['taxa_total']
                                
                                    <tr>
                                        <td> {{ $item['imposto_tipo']}}</td>
                                        <td> {{ $item['taxa_total']}}</td>
                                        <td> {{ $item['produtos']}}</td>
                                        <td> {{ $item['imposto_total']}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    
                                    <tr>
                                    <td colspan="1"></td>
                                    <td colspan="1"><b>Total</b></td>
                                    <td>{{ $item['produtos']}}</td>
                                    <td> <strong>{{ $taxaTotal }} Kz</strong></td>
                                    <td> <strong>0,00 Kz</strong></td>
                                    <td> <strong>{{ $impostoTotal }} Kz</strong></td>
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
