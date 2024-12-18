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
                    <div style="float: right; margin-bottom: 1em;">
                        {{--<a href="#" data-toggle="modal" data-target="#modal-novo-perfil" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>--}}
                    </div>
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
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perfis as $index => $perfil)
                                        @if ($perfil->name != 'Super Administrador')
                                            <tr>
                                                <td> {{ $index++ + 1 }}</td>
                                                <td>{{ $perfil->name }}</td>
                                                <td>{{ $perfil->guard_name }}</td>
                                                <td>{{ $perfil->created_at }}</td>
                                                <td>{{ $perfil->updated_at }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fa fa-cogs"></i> <i
                                                                class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#edit{{ $perfil->id }}"><i
                                                                    class="fa fa-edit"></i> Editar</a>
                                                            <a class="dropdown-item"
                                                                href="{{ action('PerfilController@destroy', ['id' => $perfil->id]) }}"><i
                                                                    class="fa fa-trash"></i> Remover</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#add-permission{{ $perfil->id }}"><i
                                                                    class="fa fa-plus"></i> Add
                                                                Permissão</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#show-permissions{{ $perfil->id }}"><i
                                                                    class="fa fa-eye"></i> Ver Permissões</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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

    {{-- Modals para edição --}}
    @foreach ($perfis as $perfil)
        <div class="modal fade" id="edit{{ $perfil->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ action('PerfilController@update', ['id' => $perfil->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" id="name" value="{{ $perfil->name }}"
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

    {{-- Modals para atribuição de permissões --}}
    @foreach ($perfis as $perfil)
        <div class="modal fade" id="add-permission{{ $perfil->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ action('PerfilController@assignPermission', ['id' => $perfil->id]) }}"
                        method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name">Descrição</label>
                                <input type="text" name="name" id="name" value="{{ $perfil->name }}"
                                    class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Permissões</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple"
                                    data-placeholder="Choose ..." name="permissions[]" style="width: 100%">
                                    <optgroup label="Escolha a (as) permissões">
                                        @foreach (\Spatie\Permission\Models\Permission::all() as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
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

    {{-- Modals para ver permissões de cada perfil --}}
    @foreach ($perfis as $perfil)
        <div class="modal fade" id="show-permissions{{ $perfil->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Permissões do Perfil</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="guard_name">Perfil</label>
                            <input type="text" name="guard_name" id="guard_name" value="{{ $perfil->name }}"
                                class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <h4 class="text-center">Permissões</h4>
                            <table class="table">
                                <thead>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                </thead>
                                <tbody>
                                    @foreach ($perfil->permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i>
                            Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="modal-novo-perfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo Perfil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ action('PerfilController@store') }}" method="post">
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
