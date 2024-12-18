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
                        action='{{ url('' . Request::segment(1) . "/update/{$dados['artigo']->id}") }}'>
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nome">Código</label>
                                    <input type="text" class="form-control" name="codigo" placeholder="Escreva..."
                                        value="{{ $dados['artigo']->codigo }}" readonly>

                                </div>

                                <div class="form-group">
                                    <label for="nome">Designação</label>
                                    <input type="text" class="form-control" name="designacao" placeholder="Escreva..."
                                        value="{{ $dados['artigo']->designacao }}"
                                        {{ $dados['artigo']->is_used == true ? 'readonly' : 'required' }}>

                                </div>


                                <div class="form-group">
                                    <label for="nome">Tipo <span class="text-danger">*</span></label>
                                    <select class="form-control  select2" name="tipo_id" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        @foreach ($dados['tipo'] as $linha)
                                            <option value="{{ $linha->id }}"
                                                {{ $dados['artigo']->tipo_id == $linha->id ? 'selected' : '' }}>
                                                {{ $linha->designacao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="nome">Tipo Retenção<span class="text-danger">*</span></label>
                                    <select class="form-control  select2" name="retencao_id" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        @foreach ($dados['retencao'] as $linha)
                                            <option value="{{ $linha->id }}"
                                                {{ $dados['artigo']->retencao_id == $linha->id ? 'selected' : '' }}>
                                                {{ $linha->designacao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="nome">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-control  select2" name="categoria_id" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        @foreach ($dados['categoria'] as $linha)
                                            <option value="{{ $linha->id }}"
                                                {{ $dados['artigo']->categoria_id == $linha->id ? 'selected' : '' }}>
                                                {{ $linha->designacao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nome">Imposto<span class="text-danger">*</span></label>
                                    <select class="form-control  select2" name="imposto_id" required>
                                        <option value="">Selecione...</option>
                                        @foreach ($dados['imposto'] as $linha)
                                            <option value="{{ $linha->id }}"
                                                {{ $dados['artigo']->imposto_id == $linha->id ? 'selected' : '' }}>
                                                {{ $linha->designacao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nome">Preço</label>
                                    <input type="text" class="form-control mask-money" name="preco"
                                        placeholder="Escreva..." value="{{ $dados['artigo']->preco }}" required>

                                </div>
                            </div>
                        </div>



                        <div class="form-group row">

                            <div class="col-sm-4 mb-3 mb-sm-0 text-center">
                                <label class=newbtn>
                                    <label for="">Imagem 1</label>
                                    <br>
                                    <img id="blah" src='{{ asset("public/upload/{$dados['artigo']->imagem_1}") }}'>
                                    <input id="pic" name="file" class='pis' onchange="readURL(this);"
                                        type="file">
                                </label>
                            </div>

                            <div class="col-sm-4 mb-3 mb-sm-0 text-center">
                                <label class=newbtn_2>
                                    <label for="">Imagem 2</label>
                                    <br>
                                    <img id="blah_2" src='{{ asset("public/upload/{$dados['artigo']->imagem_2}") }}'>
                                    <input id="pic_2" name="file_2" class='pis' onchange="readURL_2(this);"
                                        type="file">
                                </label>
                            </div>

                            <div class="col-sm-4 mb-3 mb-sm-0 text-center">
                                <label class=newbtn_3>
                                    <label for="">Imagem 3</label>
                                    <br>
                                    <img id="blah_3" src='{{ asset("public/upload/{$dados['artigo']->imagem_3}") }}'>
                                    <input id="pic_3" name="file_3" class='pis' onchange="readURL_3(this);"
                                        type="file">
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-12">

                            <div id="accordion">
                                <div class="card mb-1 shadow-none">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            <a href="#collapseOne" class="text-dark" data-toggle="collapse"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                Outros Dados
                                            </a>
                                        </h6>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Unidade</label>
                                                        <input type="text" class="form-control" name="unidade"
                                                            placeholder="Escreva..."
                                                            value="{{ $dados['artigo']->unidade }}">

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Fornecedor</label>
                                                        <select class="form-control  select2" name="fornecedor_id">
                                                            <option value="" disabled selected>Selecione...</option>
                                                            @foreach ($dados['fornecedor'] as $linha)
                                                                <option value="{{ $linha->id }}"
                                                                    {{ $dados['artigo']->fornecedor_id == $linha->id ? 'selected' : '' }}>
                                                                    {{ $linha->designacao }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nome">Código de Barras</label>
                                                        <input type="text" class="form-control" name="codigo_barra"
                                                            placeholder="Escreva..."
                                                            value="{{ $dados['artigo']->codigo_barra }}">

                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div
                                                            class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-info mb-3">
                                                            <input type="checkbox" class="custom-control-input"
                                                                onclick="enable_is_stock()" id="is_stock"
                                                                name="is_stock"
                                                                {{ $dados['artigo']->is_stock ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="is_stock">Tem
                                                                Stock?</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" id="enable_is_stock_1">
                                                    <div class="form-group">
                                                        <label for="nome">Stock Mínimo</label>
                                                        <input type="number" min="0" class="form-control"
                                                            name="stock_minimo" placeholder="Escreva..."
                                                            value="{{ $dados['artigo']->stock_minimo }}">

                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="enable_is_stock_2">
                                                    <div class="form-group">
                                                        <label for="nome">Stock Máximo</label>
                                                        <input type="number" min="0" class="form-control"
                                                            name="stock_maximo" placeholder="Escreva..."
                                                            value="{{ $dados['artigo']->stock_maximo }}">

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Observação</label>
                                    <textarea class="form-control" name="observacao" style="margin: 0px -17.6563px 0px 0px;  height: 143px;">{{ $dados['artigo']->observacao }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div
                                        class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-info mb-3">
                                        <input type="checkbox" class="custom-control-input" id="status"
                                            name="status" {{ $dados['artigo']->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Activo?</label>
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
