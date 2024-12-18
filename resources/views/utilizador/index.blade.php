@extends('layouts.app')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Utilizador </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Utilizador</a></li>
                        <li class="breadcrumb-item active">listagem</li>
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
                            <form class="col-4" action="{{ route('utilizador.search') }}"  method="GET">
                               <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Pesquisar" name="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        <a href="{{ url('utilizador/index')}}" class="btn btn-outline-secondary">Limpar</a>
                                    </div>
                                </div>
                            </form>

                            <div class="col-4 d-flex justify-content-end" style=" margin-bottom: 1em;">
                              <a href="{{ action('UserController@create') }}" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                            </div>
                        </div>

                    </div>
                    
                    
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Departamento</th>
                                        <th>Perfil</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($utilizadores as $utilizador)
                                        <tr>
                                            <td>{{ $utilizador->nome }}</td>
                                            <td>{{ $utilizador->email }}</td>
                                            <td>{{ $utilizador->departamento->designacao }}</td>
                                            <td>{{ ($role = $utilizador->roles->first()) ? $role->name : '' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-cogs"></i> <i
                                                            class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#view{{ $utilizador->id }}"><i
                                                                class="fa fa-eye"></i> Ver</a>
                                                        <a class="dropdown-item"
                                                            href="{{ action('UserController@edit', ['id' => $utilizador->id]) }}"><i
                                                                class="fa fa-edit"></i> Editar</a>
                                                        <a class="dropdown-item"
                                                            href="{{ action('UserController@destroy', ['id' => $utilizador->id]) }}"><i
                                                                class="fa fa-trash"></i> Remover</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#update-role{{ $utilizador->id }}"><i
                                                                class="fa fa-undo"></i> Actualizar Perfil</a>
                                                        <a class="dropdown-item"
                                                            href="{{ action('UserController@resetPassword', ['id' => $utilizador->id]) }}"><i
                                                                class="fa fa-edit"></i> Redifinir Senha</a>
                                                        <a class="dropdown-item"
                                                            href="{{ action('UserController@becomeSuperAdmin', ['id' => $utilizador->id]) }}"><i
                                                                class="fa fa-user-cog"></i>
                                                            Super Admin</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <tr class="d-flex justify-content-between ">
                                        <td colspan="7">{{ $utilizadores->links() }}</td>
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


    @foreach ($utilizadores as $utilizador)
        <div class="modal fade" id="view{{ $utilizador->id }}" tabindex="-1" role="dialog"
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
                                        <th>nome</th>
                                        <th>{{ $utilizador->nome }}</th>
                                    </tr>
                                    <tr>
                                        <th>email</th>
                                        <th>{{ $utilizador->email }}</th>
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
    @endforeach

    {{-- Modal para actualização de perfil --}}
    @foreach ($utilizadores as $utilizador)
        <div class="modal fade" id="update-role{{ $utilizador->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Perfil</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ action('UserController@assignRole', ['id' => $utilizador->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="nome">Utilizador</label>
                                <input type="text" id="guard_nome" value="{{ $utilizador->nome }}"
                                    class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Perfil</label>
                                <select class="select form-control" data-placeholder="Escolha ..." name="perfil"
                                    style="width: 100%">
                                    <optgroup label="Escolha a (as) permissões">
                                        @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                            @if ($role->name != 'Super Administrador')
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == (($r = $utilizador->roles->first()) ? $r->id : 0) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal"><i
                                    class="fa fa-times"></i>
                                Fechar</button>
                            <button class="btn btn-primary" type="submit"><i class="bx bx-rotate-left"></i>
                                Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
