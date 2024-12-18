<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> {{ $dados['documento'] }}</title>´
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
                <p><strong>RELATÓRIO {{ $dados['documento'] }}</strong></p>
                <p><strong> {{ $dados['intervalo'] }}</strong></p>
            </div>
            <div class="col-xs-6">
                <p><strong>Data de Emissão: {{ date('d-m-Y') }}</strong></p>
            </div>
        </div>
        <hr>

        @if (strtolower($dados['documento']) != strtolower('stock') &&
                strtolower($dados['documento']) != strtolower('receita-despesa'))
            @php
                $subtotal = 0;
                $desconto = 0;
                $imposto = 0;
                $retencao = 0;
                $total = 0;
            @endphp
            <div class="row">
                <table class="table border-0">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>NIF</th>
                            <th>Operador</th>
                            <th>Subtotal</th>
                            <th>Desconto</th>
                            <th>Imposto</th>
                            <th>Retenção</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados['dados'] as $item)
                            <tr>
                                <td>{{ $item->numero }}</td>
                                <td>
                                    {{ date('d-m-Y', strtotime($item->data)) }}
                                </td>
                                <td>{{ $item->cliente_nome }}</td>
                                <td>{{ $item->contribuinte }}</td>
                                <td>{{ $item->utilizador_nome }}</td>
                                <td>{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                                <td>{{ number_format($item->desconto, 2, '.', ',') }}</td>
                                <td>{{ number_format($item->imposto, 2, '.', ',') }}</td>
                                <td>{{ number_format($item->retencao, 2, '.', ',') }}</td>
                                <td>{{ number_format($item->total, 2, '.', ',') }}</td>
                            </tr>
                            @php
                                $subtotal += $item->subtotal;
                                $desconto += $item->desconto;
                                $imposto += $item->imposto;
                                $retencao += $item->retencao;
                                $total += $item->total;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <p> {{ App\Helpers\Helpers::matriculaAGT() }}
                </p>
                <hr>
                <div class="col-xs-12">
                    <b>SUMÁRIO</b>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>Total Ilíquido</b></td>
                                <td><b>{{ number_format($subtotal, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Desconto</b></td>
                                <td><b>{{ number_format($desconto, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Imposto</b></td>
                                <td><b>{{ number_format($imposto, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Impostos Retidos</b></td>
                                <td><b>{{ number_format($retencao, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total a pagar</b></td>
                                <td><b>{{ number_format($total, 2, ',', '.') }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        @endif

        @if (strtolower($dados['documento']) == strtolower('receita-despesa'))
            @php
                $totalreceita = 0;
                $totaldespesa = 0;
            @endphp
            <div class="row">
                <table class="table border-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Designação</th>
                            <th>Total</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($dados['dados'] as $item)
                            <tr>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->tipo == 1 ? 'Receita' : 'Despesa' }}</td>
                                <td>{{ $item->designacao }}</td>
                                <td>{{ number_format($item->total, 2, ',', '.') }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->data)) }}</td>
                            </tr>


                            @php
                                if ($item->tipo == 1) {
                                    $totalreceita = $item->total;
                                } else {
                                    $totaldespesa = $item->total;
                                }
                            @endphp
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="row">
                <p> {{ App\Helpers\Helpers::matriculaAGT() }}
                </p>
                <hr>
                <div class="col-xs-12">
                    <b>SUMÁRIO</b>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>Total Receita</b></td>
                                <td><b>{{ number_format($totalreceita, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Despesa</b></td>
                                <td><b>{{ number_format($totaldespesa, 2, ',', '.') }}</b></td>
                            </tr>

                            <tr>
                                <td><b>Total</b></td>
                                <td><b>{{ number_format(($totalreceita-$totaldespesa), 2, ',', '.') }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        @endif

        @if (strtolower($dados['documento']) == strtolower('stock'))
            @php
                $totalqtdstock = 0;
                $totalstock = 0;
                $totalqtdvendido = 0;
                $totalvendido = 0;
            @endphp
            <div class="row">
                <table class="table border-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Designação</th>
                            <th>Stock Disponivel</th>
                            <th>Saldo em Stock</th>
                            <th>Qtd. Vendida</th>
                            <th>Saldo Vendido</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($dados['dados'] as $item)
                            <tr>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->designacao }}</td>
                                <td>{{ $item->stock + $item->qtd_nota_creditos - ($item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos) }}
                                </td>
                                <td>{{ number_format(($item->stock + $item->qtd_nota_creditos - ($item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos)) * $item->preco, 2, ',', '.') }}
                                </td>
                                <td>{{ $item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos }}
                                </td>
                                <td>{{ number_format(($item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos) * $item->preco, 2, ',', '.') }}
                                </td>
                            </tr>

                            @php
                                $totalqtdstock += $item->stock + $item->qtd_nota_creditos - ($item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos);
                                $totalstock += ($item->stock + $item->qtd_nota_creditos - ($item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos)) * $item->preco;
                                $totalqtdvendido += $item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos;
                                $totalvendido += ($item->qtd_faturas + $item->qtd_factura_recibos + $item->qtd_nota_debitos) * $item->preco;
                            @endphp
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="row">
                <p> {{ App\Helpers\Helpers::matriculaAGT() }}
                </p>
                <hr>
                <div class="col-xs-12">
                    <b>SUMÁRIO</b>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>Total Qtd. Stock</b></td>
                                <td><b>{{ $totalqtdstock }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Stock</b></td>
                                <td><b>{{ number_format($totalstock, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Qtd. Stock</b></td>
                                <td><b>{{ $totalqtdvendido }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Vendido</b></td>
                                <td><b>{{ number_format($totalvendido, 2, ',', '.') }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        @endif

    </div>
</body>

</html>
