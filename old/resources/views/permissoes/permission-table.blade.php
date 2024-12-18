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
                        <a href="#" data-toggle="modal" data-target="#modal-novo-permissao" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        @foreach ($roles as $role)
                                            <th>{{ $role->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            @foreach ($roles as $role)
                                                @if ($role->permissions->where('id', $permission->id)->count())
                                                    <td><i class="bx bx-check bx-sm text-success"></i></td>
                                                @else
                                                    <td><i class="bx bx-x bx-sm text-danger"></i></td>
                                                @endif
                                            @endforeach
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
