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
                    <div style="float: right; margin-bottom: 1em;">
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#mdl-bug-create"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descrição do Problema</th>
                                        <th>Status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bugs as $index => $bug)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $bug->descricao }}</td>
                                            <td>{{ $bug->status }}</td>
                                            <td>

                                                <a class="btn btn-info btn-xs" data-toggle="modal"
                                                    data-target="#mdl-bug-edit-{{ $bug->id }}"><i
                                                        class="fa fa-pencil-alt"></i></a>

                                                <a class="btn btn-danger btn-xs"
                                                    href="{{ action('BugController@destroy', ['id' => $bug->id]) }}"><i
                                                        class="fa fa-trash-alt"></i></a>

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


    <div class="modal fade" id="mdl-bug-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ action('BugController@store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Novo Problema</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="5"
                                        placeholder="Descreva aqui o problema encontrado..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>
                            Salvar</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i>
                            Fechar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach ($bugs as $bug)
        <div class="modal fade" id="mdl-bug-edit-{{ $bug->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ action('BugController@update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $bug->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Problema</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="5"
                                            placeholder="Descreva aqui o problema encontrado..." required>{{ $bug->descricao }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>
                                Salvar</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal"><i
                                    class="fa fa-times"></i>
                                Fechar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
