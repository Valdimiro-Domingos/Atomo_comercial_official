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
        <p class="text-center">{{-- {{ App\Helpers\Helpers::hashAgt($dados['dados']->hash) }}-  --}}</b> {{ App\Helpers\Helpers::matriculaAGT() }} <span class="paginacao"></span> / {{ceil(count($dados['item'])/5)}}</p>

    </div>


    <div class="container">


        <div class="row">
            <div class="col-xs-6">
                <img height="100" width="250" src="{{ asset("public/upload/{$dados['empresa'][0]->foto}") }}"
                    alt="">
            </div>
            <div class="col-xs-6">
                <h4>{{ $dados['empresa'][0]->designacao }}</h4>
                <p><strong>NIF: {{ $dados['empresa'][0]->nif }}</strong></p>
                <p> {{ $dados['empresa'][0]->telefone }}</p>
                <p> {{ $dados['empresa'][0]->email }}</p>
                <p> {{ $dados['empresa'][0]->endereco }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <p><strong>GUIA DE REMESSA {{ $dados['dados']->numero }}</strong></p>
                <p></p>
            </div>
            <div class="col-xs-6">
                <p><strong>Data de Emissão: {{ date('d-m-Y', strtotime($dados['dados']->data)) }}</strong></p>
                <p><strong>Operador: {{ $dados['dados']->utilizador_nome }}</strong></p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <p><strong>Sr(a). {{ $dados['dados']->cliente_nome }}</strong></p>
                <p><strong>NIF:</strong> {{ $dados['dados']->contribuinte }}</p>
            </div>

        </div>
        <hr>

        <div class="row">

            <div>
                <table class="table border-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Artigo</th>
                            <th>Qtd</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($dados['item'] as $key => $item)
                            <tr>
                                <td>{{ $item->id }} </td>
                                <td>{{ $item->designacao }} </td>
                                <td>{{ number_format($item->qtd, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>


        <div class="row">
            <hr>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <p><b>Entreguei</b></p>
                <p>_________________________________</p>
            </div>
            <div class="col-xs-6">
                <p><b>Recebi</b></p>
                <p>_________________________________</p>
            </div>
        </div>

    </div>
</body>

</html>
