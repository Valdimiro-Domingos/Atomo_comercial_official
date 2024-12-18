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
            {{--         <div style="float: right; margin-bottom: 1em;">
                        <a href="{{ url('' . Request::segment(1) . '/create') }}" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    </div> --}}
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Código</th>
                                        <th>Designação</th>
                                        <th>Taxa %</th>
                                        <th>Status</th>
                                    {{--     <th>Opções</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dados as $item)
                                        <tr>
                                            <td>{{ $item->tipo }}</td>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->designacao }}</td>
                                            <td>{{ $item->taxa }}</td>
                                            <td>{{ $item->status ? 'ACTIVO' : 'INACTIVO' }}</td>
                                    {{--         <td>
                                                <a class="btn btn-info btn-xs" href="#" data-rel="tooltip"
                                                    data-placement="top" title="Ver" data-toggle="modal"
                                                    data-target="#view{{ $item->id }}"><i
                                                        class="fa fa-eye"></i></a>
                                                <a href='{{ url('' . Request::segment(1) . "/edit/{$item->id}") }}'
                                                    class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger btn-xs" href="#" data-rel="tooltip"
                                                    data-placement="top" title="Eliminar" data-toggle="modal"
                                                    data-target="#delete{{ $item->id }}"><i
                                                        class="fa fa-trash"></i></a>
                                                
                                            </td> --}}
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

    @foreach ($dados as $item)
        <div class="modal fade" id="view{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Visualizar</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <th>Código</th>
                                        <th>{{ $item->codigo }}</th>
                                    </tr>
                                    <tr>
                                        <th>Designação</th>
                                        <th>{{ $item->designacao }}</th>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja efetuar esta operação?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Eliminar Item!</b></div>
                    <div class="modal-footer">
                        <form action='{{ url('' . Request::segment(1) . "/destroy/{$item->id}") }}' method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-xs">Eliminar</button>
                        </form>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Sair</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
