@extends('layouts.app')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ strtoupper(Request::segment(1)) }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">{{ strtoupper(Request::segment(1)) }}</li>
                        <li class="breadcrumb-item active">{{ strtoupper(Request::segment(2)) }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- START PRODUCT INFORMATION -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Série:</label>
                                                <input type="text" name="serie"
                                                    value="{{ $dados['serie'][0]->designacao }}" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form row-password-input">Nº:</label>
                                                <input type="text" name="numero" class="form-control"
                                                    value="{{ $dados['numero'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Fornecedor</label>
                                                <input type="hidden" class="hidden" name="fornecedor_nome" value="{{$dados['fornecedor'][0]->designacao}}">
                                                <select onchange="getFornecedor();" name="fornecedor_id"
                                                    class="form-control  select2" required>
                                                    @foreach ($dados['fornecedor'] as $linha)
                                                        <option value="{{ $linha->id }}">
                                                            {{ $linha->designacao }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Contribuinte:</label>
                                                <input type="text" name="contribuinte" value="{{$dados['fornecedor'][0]->contribuinte}}"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Endereco:</label>
                                                <input type="text" name="endereco" class="form-control"
                                                value="{{$dados['fornecedor'][0]->endereco}}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome">Data</label>
                                                <input type="date" class="form-control" name="data"
                                                    placeholder="Escreva..." value="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Armazem</label>
                                                <select name="armazem" class="form-control  select2">
                                                    @foreach ($dados['armazem'] as $linha)
                                                        <option value="{{ $linha->designacao }}">
                                                            {{ $linha->designacao }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label >Descrição:</label>
                                        <textarea class="form-control" name="descricao"></textarea>
                                    </div>
                                </div>



                            </div>

                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-condensed table-bordered table-striped table-hover table-form"
                                        id="table-item">
                                        <thead>
                                            <tr>
                                                <th width="100px">Código</th>
                                                <th>Artigo</th>
                                                <th width="100px" style="text-align:center;">Qtd(+/-)</th>
                                                <th width="100px">Opcões</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control input-sm" placeholder="Código"
                                                        name="item-codigo" value="#" readonly>
                                                </td>
                                                <td>

                                                    <input type="hidden" class="hidden" name="item-artigo_id" value="0">
                                                    <input type="hidden" class="hidden" name="item-artigo_designacao"
                                                        value="#">
                                                    <select onchange="getArtigo();" name="item-artigo"
                                                        class="form-control  select2">
                                                        <option value="" disabled selected>Selecione...</option>
                                                        @foreach ($dados['artigos'] as $linha)
                                                            <option value="{{ $linha->id }}">
                                                                {{ $linha->designacao }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" step="any" class="form-control input-sm"
                                                        style="text-align:center;" placeholder="0" name="item-artigo_qtd"
                                                        value="0" required>
                                                </td>

                                                <td>
                                                    <button type="submit" onclick="addItemStock();"
                                                        class="btn btn-primary btn-block">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form id="form">

                                                <div class="d-print-none">
                                                    <div class="float-right">
                                                        <a type="submit" onclick="finalizarStock();"
                                                            class="btn btn-primary w-md waves-effect waves-light">
                                                            Finalizar
                                                        </a>
                                                        <a href="{{ url('' . Request::segment(1) . '') }}"
                                                            class="btn btn-warning" type="submit">Cancelar</a>


                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
