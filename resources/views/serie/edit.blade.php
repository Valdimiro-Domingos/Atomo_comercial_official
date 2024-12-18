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
                <form enctype="multipart/form-data" method="POST" action='{{ url('' . Request::segment(1) . "/update/{$dados->id}") }}'>
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Código</label>
                                <input type="text" class="form-control" name="codigo" placeholder="Escreva..." value="{{ $dados->codigo }}" readonly>
                                
                            </div>

                            <div class="form-group">
                                <label for="nome">Designação</label>
                                <input type="text" class="form-control" name="designacao" placeholder="Escreva..." value="{{ $dados->designacao }}" required>
                                
                            </div>

                            <div class="form-group">
                                <label for="nome">Tipo</label>
                                <select class="form-control  select2" name="tipo" required>
                                    <option {{ $dados->tipo=='factura-global'?'selected':'' }} value="factura">Factura</option>
                                    <option {{ $dados->tipo=='factura-global'?'selected':'' }} value="factura-global">Factura Global</option>
                                    <option {{ $dados->tipo=='factura-recibo'?'selected':'' }} value="factura-recibo">Factura Recibo</option>
                                    <option {{ $dados->tipo=='recibo'?'selected':'' }} value="recibo">Recibo</option>
                                    <option {{ $dados->tipo=='nota-credito'?'selected':'' }} value="nota-credito">Nota de Crédito</option>
                                    <option {{ $dados->tipo=='nota-debito'?'selected':'' }} value="nota-debito">Nota de Dédito</option>
                                    <option {{ $dados->tipo=='proforma'?'selected':'' }} value="proforma">Proforma</option>
                                    <option {{ $dados->tipo=='orcamento'?'selected':'' }} value="orcamento">Orçamento</option>
                                    <option {{ $dados->tipo=='encomenda'?'selected':'' }} value="encomenda">Encomenda</option>
                                    <option {{ $dados->tipo=='guia-transporte'?'selected':'' }} value="guia-transporte">Guia de Transporte</option>
                                    <option {{ $dados->tipo=='guia-remessa'?'selected':'' }} value="guia-remessa">Guia de Remessa</option>
                                    <option {{ $dados->tipo=='stock'?'selected':'' }} value="stock">Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Descrição</label>
                                <textarea class="form-control" name="descricao" style="margin: 0px -17.6563px 0px 0px;  height: 143px;">{{ $dados->descricao }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-info mb-3">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" {{ $dados->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status">Activo?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Salvar</button>
                    <a href="{{ url('' . Request::segment(1) . '') }}" class="btn btn-warning" type="submit">Cancelar</a>
                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>
<!-- end row -->

@endsection