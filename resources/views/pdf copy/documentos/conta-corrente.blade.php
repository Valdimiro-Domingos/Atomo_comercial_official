<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> {{ $dados['cliente']->designacao }}</title>
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
            {{ App\Helpers\Helpers::matriculaAGT() }} <span class="paginacao"></span> / {{ceil(count($dados['dados'])/5)}}</p>

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
                <h5><strong>CONTA CORRENTE</strong></h5>
                <p><strong>Sr(a). {{ $dados['cliente']->designacao }}</strong></p>
                <p><strong>NIF:</strong> {{ $dados['cliente']->contribuinte }}</p>
            </div>
            <div class="col-xs-6">
                <p><strong>Data de Emissão: {{ date('d-m-Y') }}</strong></p>
                <p><strong>Operador: {{ $dados['utilizador_name'] }}</strong></p>
            </div>
        </div>
        <hr>
        
         <!-- row -->
         <div class="row">
            <div class="col-xs-4">
                <p class="text-muted mb-2">Crédito</p>
                <h6 class="mb-0">{{ $dados['credito'] }}</h6>
            </div>
            <div class="col-xs-4">
                <p class="text-muted mb-2">Débito</p>
                <h6 class="mb-0">{{ $dados['debito'] }}</h6>
            </div>
            <div class="col-xs-4">
                <p class="text-muted mb-2">Saldo</p>
                <h6 class="mb-0">{{ $dados['saldo'] }}</span></h6>
            </div>
         </div>
        <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Operações</h5>
                        <div class="table-responsive" style="overflow: hidden;">
                            <table id="datatable" class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Estado</th>
                                        <th>Data</th>
                                        <th>Débito</th>
                                        <th>Crédito</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php   $balanco = 0;   @endphp
                                    @foreach ($dados['operacaos'] as $item)
                                        @php   $balanco = $balanco + $item['total'];   @endphp
                                        <tr>
                                            <td> <b>
                                                @if ($item['operacao'] == 'Crédito')
                                                  {{ $item['operacao'] }}
                                                @elseif($item['operacao'] == 'Débito')
                                                  {{ $item['operacao'] }}
                                                @else
                                                   {{ $item['operacao'] }}
                                                @endif</b>
                                            </td>
                                            <td>{{ $item['data'] }}</td>
                                            <td>
                                                {{ $item['documento'] }}
                                            </td>
                                            <td>
                                                {{ $item['descricao'] }}
                                            </td>
                                            <td>
                                                {{ number_format( $item['total'] , 2, ',', '.') }}
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        
        
    </div>
</body>

</html>
