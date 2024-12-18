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
                        action="{{ url('' . Request::segment(1) . '/store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="nome">Tipo</label>
                                    <input type="text" class="form-control" name="tipo" placeholder="Escreva...">

                                </div>

                                <div class="form-group">
                                    <label for="nome">Código</label>
                                    <input type="text" class="form-control" name="codigo" placeholder="Escreva...">

                                </div>

                                <div class="form-group">
                                    <label for="nome">Designação</label>
                                    <input type="text" class="form-control" name="designacao" placeholder="Escreva..."
                                        value="" required>
                                </div>

                                <div class="form-group">
                                    <label for="nome">Taxa %</label>
                                    <input type="text" class="form-control" name="taxa" placeholder="Escreva..."
                                        value="" required>
                                </div>

                                <div class="form-group">
                                    <label for="nome">Motivo</label>
                                    <input type="text" class="form-control" name="motivo" placeholder="Escreva..."
                                        value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div
                                        class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-info mb-3">
                                        <input type="checkbox" class="custom-control-input" id="isoculto" name="status">
                                        <label class="custom-control-label" for="isoculto">Activo?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Salvar</button>
                        <a href="{{ url('' . Request::segment(1) . '') }}" class="btn btn-warning"
                            type="submit">Cancelar</a>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
