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
    <!-- start row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST"
                        action="{{ url('' . Request::segment(1) . '/generate') }}">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Data Inicio</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="data1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Data Fim</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="data2">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-primary  btn-block btn-lg" type="submit"><i
                                            class="fa fa-refresh"></i> GERAR SATF(AO)</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Designação</th>
                            <th>Data</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($dados as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->filename }}</td>
                                <td>{{ $item->created_at }}</td>

                                <td>

                                    <a class="btn btn-info btn-xs"
                                        href="{{ asset('public/agt/files/' . $item->filename . '') }}" download><i
                                            class="fa fa-download"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
