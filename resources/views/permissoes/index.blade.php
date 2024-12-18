@extends('layouts.app')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ Request::segment(1) }} </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ Request::segment(2) }}</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(3) }}</li>
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
                    <!-- <div style="float: right; margin-bottom: 1em;">
                        <a href="#" data-toggle="modal" data-target="#modal-novo-permissao" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    </div> -->
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Guard</th>
                                        <th>Data de Criação</th>
                                        <th>Ultima Actualização</th>
                                       <!--  <th>Opções</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissoes as $index => $permissao)
                                        <tr>
                                            <td> {{ $index++ + 1 }}</td>
                                            <td>{{ $permissao->name }}</td>
                                            <td>{{ $permissao->guard_name }}</td>
                                            <td>{{ $permissao->created_at }}</td>
                                            <td>{{ $permissao->updated_at }}</td>
                                           <!--  <td>
                                                <a href="#" class="btn btn-warning btn-xs" data-toggle="modal"
                                                    data-target="#edit{{ $permissao->id }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger btn-xs"
                                                    href="{{ action('PermissaoController@destroy', ['id' => $permissao->id]) }}"
                                                    data-rel="tooltip" data-placement="top" title="Eliminar"><i
                                                        class="fa fa-trash"></i></a>
                                            </td> -->
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


    @foreach ($permissoes as $permissao)
        <div class="modal fade" id="edit{{ $permissao->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Permissao</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ action('PermissaoController@update', ['id' => $permissao->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" id="name" value="{{ $permissao->name }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i>
                                Fechar</button>
                            <button class="btn btn-primary" type="submit"><i class="bx bx-rotate-left"></i>
                                Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="modal-novo-permissao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nova Permissão</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ action('PermissaoController@store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" required class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i>
                            Fechar</button>
                        <button class="btn btn-primary" type="submit"><i class="bx bx-rotate-left"></i>
                            Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
