<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> {{ $dados['dados']->numero }}</title>
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
            margin-top: 20px;
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
        <p class="text-center">{{-- {{ App\Helpers\Helpers::hashAgt($dados['dados']->hash) }}- --}} </b> {{ App\Helpers\Helpers::matriculaAGT() }} <span
                class="paginacao"></span> / 1</p>

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
                <p><strong>RECIBO {{ $dados['dados']->numero }}</strong></p>
                <p></p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <p><strong>Sr(a). {{ $dados['dados']->cliente_nome }}</strong></p>
                <p><strong>NIF:</strong> {{ $dados['dados']->contribuinte }}</p>
            </div>

            <div class="col-xs-6">
                <p><strong>Data de Emissão: {{ date('d-m-Y', strtotime($dados['dados']->data)) }}</strong></p>
                <p><strong>Operador: {{ $dados['dados']->utilizador_nome }}</strong></p>
            </div>

        </div>
        <hr>

        <div class="row">

            <div>
                <table class="table border-0">
                    <thead>
                        <tr>
                            <th>Ref. Factura</th>
                            <th>Data de Emissão</th>
                            <th>Total Ilíquido</th>
                            <th>Total Desconto</th>
                            <th>Total Imposto</th>
                            <th>Total Fatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $dados['dados']->numero_documento }} </td>
                            <td>{{ date('d-m-Y', strtotime($dados['dados']->data_documento)) }} </td>
                            <td>{{ number_format($dados['dados']->subtotal, 2, ',', '.') }} </td>
                            <td>{{ number_format($dados['dados']->desconto, 2, ',', '.') }} </td>
                            <td>{{ number_format($dados['dados']->imposto, 2, ',', '.') }} </td>
                            <td>{{ number_format($dados['dados']->total, 2, ',', '.') }} </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>


        <div class="row">
            <hr>
            <div class="col-xs-7">

            </div>
            <div class="col-xs-4">
                <b>SUMÁRIO</b>
                <table class="table">
                    <tbody>
                        @if ($dados['dados']->total_pendente > $dados['dados']->valor_pago)
                            <tr>
                                <td><b>Total Pendente</b></td>
                                <td><b> {{ number_format($dados['dados']->total_pendente, 2, '.', ',') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Pago</b></td>
                                <td><b> {{ number_format($dados['dados']->valor_pago, 2, '.', ',') }}</b></td>
                            </tr>

                            <tr>
                                <td><b>Total Dívida</b></td>
                                <td><b>
                                        {{ number_format($dados['dados']->total_pendente > $dados['dados']->valor_pago ? $dados['dados']->total_pendente - $dados['dados']->valor_pago : 0, 2, '.', ',') }}</b>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><b>Total Pago</b></td>
                                <td><b> {{ number_format($dados['dados']->valor_pago, 2, '.', ',') }}</b></td>
                            </tr>
                        @endif




                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>

</html>
