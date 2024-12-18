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
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#mdl-banco-create"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Número</th>
                                        <th>IBAN</th>
                                        <th>Swift</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bancos as $index => $banco)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $banco->nome }}</td>
                                            <td>{{ $banco->numero }}</td>
                                            <td>{{ $banco->iban }}</td>
                                            <td>{{ $banco->swift == null ? 'sem swift' : $banco->swift }}</td>
                                            <td>                                                       
                                                <a href="#" data-toggle="modal"
                                                    data-target="#mdl-banco-edit-{{ $banco->id }}"
                                                    class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i></a>
                                                <a href="{{ action('BancoController@destroy', ['id' => $banco->id]) }}"
                                                    class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>
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


    <div class="modal fade" id="mdl-banco-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ action('BancoController@store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Novo Banco</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nome">Nome <span class="text-danger">*</span></label>
                                    <input name="nome" id="nome" class="form-control"
                                        placeholder="Ex: Banco Econômico" required>
                                </div>
                                <div class="form-group">
                                    <label for="numero">Numero <span class="text-danger">*</span></label>
                                    <input name="numero" id="numero" class="form-control"
                                        placeholder="Ex: 1111111111" required>
                                </div>
                                <div class="form-group">
                                    <label for="iban">IBAN <span class="text-danger">*</span></label>
                                    <input name="iban" id="iban" class="form-control"
                                        placeholder="Ex: 000600000172248130110" required>
                                </div>
                                <div class="form-group">
                                    <label for="swift">SWIFT</label>
                                    <input name="swift" id="swift" class="form-control" placeholder="Ex: BESCAOLU">
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

    @foreach ($bancos as $banco)
        <div class="modal fade" id="mdl-banco-edit-{{ $banco->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ action('BancoController@update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $banco->id }}">
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
                                        <label for="nome">Nome <span class="text-danger">*</span></label>
                                        <input name="nome" id="nome" class="form-control"
                                            placeholder="Ex: Banco Econômico" value="{{ $banco->nome }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="numero">Número <span class="text-danger">*</span></label>
                                        <input name="numero" id="numero" class="form-control"
                                            placeholder="Ex: 1111111111" value="{{ $banco->numero }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="iban">IBAN <span class="text-danger">*</span></label>
                                        <input name="iban" id="iban" class="form-control"
                                            placeholder="Ex: 000600000172248130110" value="{{ $banco->iban }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="swift">SWIFT</label>
                                        <input name="swift" id="swift" class="form-control"
                                            placeholder="Ex: BESCAOLU" value="{{ $banco->swift }}">
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
