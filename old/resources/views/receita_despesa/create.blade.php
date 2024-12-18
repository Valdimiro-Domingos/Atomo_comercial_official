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
                                    <label for="nome">Código</label>
                                    <input type="text" class="form-control" name="codigo" value="{{ $codigo }}"
                                        readonly>

                                </div>
                                <div class="form-group">
                                    <label for="nome">Tipo<span class="text-danger">*</span></label>
                                    <select class="form-control  select2" name="tipo" required>
                                        <option value="1">Receita</option>
                                        <option value="2">Despesa</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nome">Designação</label>
                                    <input type="text" class="form-control" name="designacao" placeholder="Escreva..."
                                        value="" required>

                                </div>
                                <div class="form-group">
                                    <label for="nome">Total <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mask-money" name="total" value="0"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="nome">Data</label>
                                    <input type="date" class="form-control" name="data" placeholder="Escreva..."
                                        value="{{ date('Y-m-d') }}" required>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Descrição</label>
                                    <textarea class="form-control" name="descricao" style="margin: 0px -17.6563px 0px 0px;  height: 143px;"></textarea>
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
