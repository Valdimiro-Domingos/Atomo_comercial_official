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
                    
                     <div class="col-sm-12 col-md-12">
                        <div class="row justify-content-between">
                            <form class="col-4" action="{{ route('nota-credito.search') }}"  method="GET">
                               <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Pesquisar" name="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        <a href="{{ url('documentos/nota-credito')}}" class="btn btn-outline-secondary">Limpar</a>
                                    </div>
                                </div>
                            </form>

                            <div class="col-4 d-flex justify-content-end" style=" margin-bottom: 1em;">

                            </div>
                        </div>
                    </div>
                
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
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
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="d-flex justify-content-between ">
                                        <td colspan="7">{{ $dados->links() }}</td>
                                    </tr>
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
