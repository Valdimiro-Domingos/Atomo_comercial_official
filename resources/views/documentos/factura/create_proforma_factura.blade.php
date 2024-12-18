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
                                                <label >Documento de Origem</label>
                                                <input type="hidden" name="documento_id" value="{{ $dados['dados']->id }}"
                                                class="form-control" readonly>
                                                <input type="text" name="documento_numero" value="{{ $dados['dados']->numero }}"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Nº</label>
                                                <input type="text" name="numero" value="{{ $dados['numero'] }}"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <input type="hidden" class="hidden" name="cliente_id"
                                                    value="{{ $dados['clientes']->id }}">
                                                <input type="text" name="cliente_nome"
                                                    value="{{ $dados['clientes']->designacao }}" name="cliente_nome"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Contribuinte:</label>
                                                <input type="text" name="contribuinte"
                                                    value="{{ $dados['clientes']->contribuinte }}" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Endereco:</label>
                                                <input type="text" name="endereco" class="form-control"
                                                    value="{{ $dados['clientes']->endereco->endereco }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div id="accordion">
                                        <div class="card mb-1 shadow-none">
                                            <div class="card-header bg-primary" id="headingOne1">
                                                <h6 class="m-0">
                                                    <a href="#collapseOne1" class="text-dark" data-toggle="collapse"
                                                        aria-expanded="true" aria-controls="collapseOne1">
                                                        <span style="color: white"> Detalhes</span>
                                                    </a>
                                                </h6>
                                            </div>

                                            <div id="collapseOne1" class="collapse show" aria-labelledby="headingOne1"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="nome">Data </label>
                                                                <input type="date" class="form-control" name="data"
                                                                    placeholder="Escreva..." value="{{ date('Y-m-d') }}"
                                                                    >
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="nome">Data Vencimento</label>
                                                                <input type="date" class="form-control"
                                                                    name="data_vencimento" placeholder="Escreva..."
                                                                    value="{{ date('Y-m-d') }}">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="nome">Formas de Pagamento</label>
                                                                <select class="form-control  select2"
                                                                    name="formapagamento_id" required>

                                                                    @foreach ($dados['formaspagamento'] as $linha)
                                                                        <option value="{{ $linha->id }}">
                                                                            {{ $linha->designacao }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="moeda">Moeda</label>
                                                                <select name="moeda_id" id="moeda_id"
                                                                    class="form-control  select2">

                                                                    @foreach ($dados['moedas'] as $linha)
                                                                        <option value="{{ $linha->id }}">
                                                                            {{ $linha->designacao }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="nome">Utilizador</label>
                                                                <input type="hidden" class="form-control"
                                                                    name="utilizador_id" placeholder="Escreva..."
                                                                    value="{{ Auth::user()->id }}" readonly>
                                                                <input type="text" class="form-control"
                                                                    name="utilizador_nome" placeholder="Escreva..."
                                                                    value="{{ Auth::user()->nome }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table
                                        class="table table-condensed table-bordered table-striped table-hover table-form"
                                        id="table-item">
                                        <thead>
                                            <tr>
                                                <th width="300px">Artigo</th>
                                                <th width="200px">Qtd</th>
                                                <th width="200px">Preço Unitário</th>
                                                <th width="200px">Desc %</th>
                                                <th width="200px">Taxa</th>
                                                <th width="200px">Total</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($dados['item'] as $item)
                                                <tr>
                                                    <td><input type="hidden" class="hidden item-artigo_id"
                                                            value="{{ $item->artigo_id }}">
                                                        <input type="text"
                                                            class="form-control input-sm item-artigo_designacao"
                                                            value="{{ $item->designacao }}" readonly>
                                                    </td>
                                                    <td><input type="number" step="any" style="text-align:center;"
                                                            class="form-control input-sm item-artigo_qtd"
                                                            value="{{ $item->qtd }}" readonly>
                                                    </td>

                                                    <td><input type="number" style="text-align:center;" step="any"
                                                            class="form-control input-sm item-artigo_preco"
                                                            value="{{ $item->preco }}" readonly></td>

                                                    <td><input type="number" style="text-align:center;" step="any"
                                                            class="form-control input-sm item-artigo_desconto"
                                                            value="{{ $item->desconto }}" readonly></td>


                                                    <td><input type="hidden" class="item-retencao_id"
                                                            value="{{ $item->retencao_id }}">
                                                        <input type="hidden" class="item-retencao_designacao"
                                                            value="{{ $item->retencao_designacao }}">
                                                        <input type="hidden" class="item-retencao_taxa"
                                                            value="{{ $item->retencao_taxa }}">
                                                        <input type="hidden" class="item-imposto_id"
                                                            value="{{ $item->imposto_id }}">
                                                        <input type="hidden" class="item-imposto_tipo"
                                                            value="{{ $item->imposto_tipo }}">
                                                        <input type="hidden" class="item-imposto_codigo"
                                                            value="{{ $item->imposto_codigo }}">
                                                        <input type="hidden" class="item-imposto_designacao"
                                                            value="{{ $item->imposto_designacao }}">
                                                        <input type="hidden" class="item-imposto_motivo"
                                                            value="{{ $item->imposto_motivo }}">
                                                        <input type="number" style="text-align:center;" step="any"
                                                            class="form-control input-sm item-imposto_taxa"
                                                            value="{{ $item->imposto_taxa }}" readonly>
                                                    </td>
                                                    <td><input type="number" style="text-align:right;" step="any"
                                                            class="form-control input-sm item-subtotal"
                                                            value="{{ $item->subtotal }}" readonly></td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align:right;">Total Iliquido </th>
                                                <td>
                                                    <input type="number" style="text-align:right;" step="any"
                                                        class="form-control input-sm" name="item-total"
                                                        value="{{ $dados['dados']->subtotal }}" readonly>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nome">Observações</label>
                                        <textarea class="form-control" name="observacao"></textarea>

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3">Resumo do Documento</h4>

                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Total Ilíquido</th>
                                                            <th><input style="text-align: right;" type="number"
                                                                    step="any" class="form-control input-sm"
                                                                    name="subtotal"
                                                                    value="{{ $dados['dados']->subtotal }}" readonly></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Descontos</th>
                                                            <th><input style="text-align: right;" type="number"
                                                                    step="any" class="form-control input-sm"
                                                                    name="desconto"
                                                                    value="{{ $dados['dados']->desconto }}" readonly></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Impostos</th>
                                                            <th><input style="text-align: right;" type="number"
                                                                    step="any" class="form-control input-sm"
                                                                    name="imposto" value="{{ $dados['dados']->imposto }}"
                                                                    readonly></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Impostos Retidos</th>
                                                            <th><input style="text-align: right;" type="number"
                                                                    step="any" class="form-control input-sm"
                                                                    name="retencao"
                                                                    value="{{ $dados['dados']->retencao }}" readonly></th>
                                                        </tr>

                                                        <tr>
                                                            <th>Total</th>
                                                            <th style="color: red;"><input style="text-align: right;"
                                                                    type="number" step="any"
                                                                    class="form-control input-sm" name="total"
                                                                    value="{{ $dados['dados']->total }}" readonly></th>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>
                                    <form id="form">
                                        <div class="d-print-none">
                                            <div class="float-right">
                                                <a href="{{ url('' . Request::segment(1) . '/' . Request::segment(2) . '') }}"
                                                    class="btn btn-warning">Cancelar</a>
                                                <a data-rel="tooltip" data-placement="top" data-toggle="modal"
                                                    data-target="#modal-documento-finalizar"
                                                    class="btn btn-primary w-md waves-effect waves-light">
                                                    Finalizar
                                                </a>
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

    <div class="modal fade" id="modal-documento-finalizar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja efetuar esta operação?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" onclick="finalizar('factura')">Finalizar</button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
