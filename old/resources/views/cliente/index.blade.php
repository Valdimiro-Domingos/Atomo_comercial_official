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
                    
                    <div class="col-sm-12 col-md-12">
                        <div class="row justify-content-between">
                            <form class="col-4" action="{{ route('cliente.search') }}"  method="GET">
                               <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Pesquisar" name="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        <a href="{{ url('cliente')}}" class="btn btn-outline-secondary">Limpar</a>
                                    </div>
                                </div>
                            </form>

                            <div class="col-4 d-flex justify-content-end" style=" margin-bottom: 1em;">
                                <a href="{{ url('' . Request::segment(1) . '/create') }}" class="btn btn-success"><i
                                        class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
                                        <th>Código</th>
                                        <th>Designação</th>
                                        <th>Contribuinte</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dados as $item)
                                        <tr>
                                            <td><img style="height:30px; width:60px;"
                                                    src='{{ asset("public/upload/{$item->imagem}") }}'></td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->codigo }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->designacao }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->contribuinte }}</td>
                                            <td>
                                                <a href='{{ url('' . Request::segment(1) . "/conta_corrente/{$item->id}") }}'
                                                    class="btn btn-info btn-xs">Conta Corrente</a>
                                                <a href='{{ url('' . Request::segment(1) . "/edit/{$item->id}") }}'
                                                    class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-info btn-xs" href="#" data-rel="tooltip"
                                                    data-placement="top" title="Ver" data-toggle="modal"
                                                    data-target="#view{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                @if ($item->id != 1)
                                                    @if ($item->status)
                                                        <a class="btn btn-danger btn-xs"
                                                            href="{{ action('ClienteController@anular', ['id' => $item->id]) }}"
                                                            data-rel="tooltip" data-placement="top" title="Anular"><i
                                                                class="fa fa fa-ban"></i></a>
                                                    @else
                                                        <a class="btn btn-primary btn-xs"
                                                            href="{{ action('ClienteController@activar', ['id' => $item->id]) }}"
                                                            data-rel="tooltip" data-placement="top" title="Activar"><i
                                                                class="fa fa-check"></i></a>
                                                    @endif
                                                @endif

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
                                        <th>Designação</th>
                                        <th>{{ $item->designacao }}</th>
                                    </tr>
                                    <tr>
                                        <th>Contribuinte</th>
                                        <th>{{ $item->contribuinte }}</th>
                                    </tr>
                                    {{-- <tr>
                                        <th>Telefone</th>
                                        <th>{{ \App\Endereco::getEntityEnderecoContacto($item->id,'fornecedors')[0]->telefone }}</th>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <th>{{ \App\Endereco::getEntityEnderecoContacto($item->id,'fornecedors')[0]->email  }}</th>
                                    </tr> --}}
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

        <div class="modal fade" id="anular{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja efetuar esta operação?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Anular Item!</b></div>
                    <div class="modal-footer">
                        <form action='{{ url('' . Request::segment(1) . "/anular/{$item->id}") }}' method="post">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-danger btn-xs">Anular</button>
                        </form>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Sair</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="activar{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja efetuar esta operação?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Activar Item!</b></div>
                    <div class="modal-footer">
                        <form action='{{ url('' . Request::segment(1) . "/activar/{$item->id}") }}' method="post">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-danger btn-xs">Activar</button>
                        </form>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Sair</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
