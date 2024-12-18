@extends('layouts.app')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ strtoupper(Request::segment(1)) }} </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ Request::segment(1) }}</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(2) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- start -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h1>{{date('01-m-Y')}} / {{date('t-m-Y')}}</h1>
                    <div class="table-rep-plugin">

                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
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
                                    @foreach ($dados as $item)
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
