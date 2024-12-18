<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> STOCK</title>
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
        <p class="text-center"><span class="paginacao"></span></p>

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
                <p><strong>RELATÓRIO STOCK</strong></p>
                <p><strong>Fornecedor: {{ $dados['dados']->fornecedor_nome }}</strong></p>
            </div>
            <div class="col-xs-6">
                <p><strong>Data: {{ date('d-m-Y', strtotime( $dados['dados']->data)) }}</strong></p>
                <p><strong>Armazem: {{ $dados['dados']->armazem }}</strong></p>
            </div>
        </div>
        <hr>
        <div class="row">
            <table class="table border-0">
                <thead>
                    <tr>
                      <th>Artigo</th>
                      <th>Qtd</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados['item'] as $key => $item)
                        <tr>
                            <td>{{ $item->designacao }}</td>
                            <td>{{ $item->qtd }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <p> {{ App\Helpers\Helpers::matriculaAGT() }}
            </p>


        </div>
    </div>
</body>

</html>
