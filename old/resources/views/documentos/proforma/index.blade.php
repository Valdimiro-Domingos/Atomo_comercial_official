@extends('layouts.app')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ strtoupper(Request::segment(1)) }} </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ strtoupper(Request::segment(1)) }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ strtoupper(Request::segment(2)) }}</li>
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
                    <div style="float: right; margin-bottom: 1em;">
                        @if (App\Cliente::all()->count() > 1)
                            <a href="{{ url('documentos/' . Request::segment(2) . '/create') }}" class="btn btn-success"><i
                                    class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                        @else
                            <a class="btn btn-danger">Registe um
                                cliente para poder fazer a operação</a>
                        @endif
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Documento</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>NIF</th>
                                        <th>Valor Total</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dados as $key => $item)
                                        <tr>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $key + 1 }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->numero }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>
                                                {{ date('d-m-Y H:m:s', strtotime($item->data)) }}
                                            </td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->cliente_nome }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->contribuinte }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ number_format($item->total, 2, '.', ',') }}</td>
                                            <td>
                                                <a class="btn btn-primary" target="_blank"
                                                    href='{{ url('pdf/documentos/' . Request::segment(2) . "/{$item->id}") }}'><i
                                                        class="fa fa-print"></i></a>
                                                @if ($item->is_factura)
                                                    <a href='{{ url('' . Request::segment(1) . "/proforma-factura/{$item->id}") }}'
                                                        class="btn btn-info btn-xs">Fatura</a>
                                                @endif

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
