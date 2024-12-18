@extends('layouts.pos')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">POS</h4>
                <input type="hidden" name="is_pos" value="1" class="form-control" readonly>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ strtoupper(Request::segment(1)) }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ strtoupper(Request::segment(2)) }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">

        <div class="col-lg-12">
            @isset($_GET['doc'])
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sucesso!</strong>
                    <hr>
                    <a class="btn btn-primary" target="_blank"
                        href='{{ url('print/documentos/factura-recibo' . "/{$_GET['doc']}") }}'><i
                            class="bx bx-printer"></i></a>
                    <a class="btn btn-primary" target="_blank"
                        href='{{ url('pdf/documentos/factura-recibo' . "/{$_GET['doc']}") }}'><i class="fa fa-print"></i></a>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endisset

            <div class="col-md-12">
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-my-faturas"><i
                        class="mdi mdi-file-multiple font-size-16 align-middle mr-2"></i>Faturas Emitidas</a>
                <hr>
            </div>

            <div id="accordion">
                <div class="card mb-1 shadow-none">
                    <div class="card-header bg-primary" id="headingOne1">
                        <h6 class="m-0">
                            <a href="#collapseOne1" class="text-dark" data-toggle="collapse" aria-expanded="false"
                                aria-controls="collapseOne1">
                                <span style="color: white"> Detalhes Fatura</span>
                            </a>
                        </h6>
                    </div>

                    <div id="collapseOne1" class="collapse " aria-labelledby="headingOne1" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Nº</label>
                                        <input type="text" name="numero" value="{{ $dados['numero'] }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control"
                                            value="{{ $dados['clientes']->designacao }}" name="cliente_nome">
                                        <input type="hidden" class="hidden" value="{{ $dados['clientes']->id }}"
                                            name="cliente_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contribuinte:</label>
                                        <input type="text" name="contribuinte"
                                            value="{{ $dados['clientes']->contribuinte }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Endereco:</label>
                                        <input type="text" name="endereco" class="form-control"
                                            value="{{ $dados['clientes']->endereco->endereco }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Data </label>
                                        <input type="date" class="form-control" name="data" placeholder="Escreva..."
                                            value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Data Vencimento</label>
                                        <input type="date" class="form-control" name="data_vencimento"
                                            placeholder="Escreva..." value="{{ date('Y-m-d') }}">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Formas de Pagamento</label>
                                        <select class="form-control " name="formapagamento_id" required>

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
                                        <select name="moeda_id" id="moeda_id" class="form-control  ">

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
                                        <input type="hidden" class="form-control" name="utilizador_id"
                                            placeholder="Escreva..." value="{{ Auth::user()->id }}" readonly>
                                        <input type="text" class="form-control" name="utilizador_nome"
                                            placeholder="Escreva..." value="{{ Auth::user()->nome }}" readonly>
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
        <div class="col-lg-8">

            <div class="row mb-3">

                <div class="col-lg-8 col-sm-6">
                    <form class="mt-4 mt-sm-0 float-sm-right form-inline">
                        <div class="search-box mr-2">
                            <div class="position-relative">
                                <input type="text" onkeyup="getArtigos();" name="artigo-chave"
                                    class="form-control border-0" placeholder="Procurar/BarCode">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="row" id="card-artigo">
                @foreach ($dados['artigos'] as $linha)
                    <div class="col-xl-4 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-img position-relative">
                                    <a onclick="setArtigo({{ $linha->id }});" href="#"><img
                                            src="{{ asset("public/upload/{$linha->imagem_1}") }}" alt=""
                                            class="img-fluid mx-auto d-block"></a>
                                </div>
                                <div class="mt-4 text-center">
                                    <h5 class="mb-3 text-truncate"><a onclick="setArtigo({{ $linha->id }});"
                                            href="#" class="text-dark">{{ $linha->designacao }}</a>
                                    </h5>
                                    <p class="text-muted">{{ $linha->codigo_barra }}</p>
                                    <h5 class="my-0"><b>{{ number_format($linha->preco, 2, ',', '.') }}</b>
                                    </h5>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <!-- end row -->


        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-artigo" class="table table-centered mb-0 table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>Artigo</th>
                                    <th>Preço</th>
                                    <th>Qtd</th>
                                    <th>Des %</th>
                                    <th colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Resumo do Documento</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th>Total Ilíquido</th>
                                        <th><input style="text-align: right;" type="number" step="any"
                                                class="form-control input-sm" name="subtotal" value="0.00" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Total Descontos</th>
                                        <th><input style="text-align: right;" type="number" step="any"
                                                class="form-control input-sm" name="desconto" value="0.00" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Total Impostos</th>
                                        <th><input style="text-align: right;" type="number" step="any"
                                                class="form-control input-sm" name="imposto" value="0.00" readonly>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Impostos Retidos</th>
                                        <th><input style="text-align: right;" type="number" step="any"
                                                class="form-control input-sm" name="retencao" value="0.00" readonly>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Total</th>
                                        <th style="color: red;"><input style="text-align: right;" type="number"
                                                step="any" class="form-control input-sm" name="total"
                                                value="0.00" readonly></th>
                                    </tr>
                                </tbody>
                            </table>
                        </table>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="text-sm-right mt-2 mt-sm-0">
                        <a data-rel="tooltip"
                        data-placement="top" data-toggle="modal" data-target="#modal-documento-finalizar"
                            class="btn block btn-primary btn-block">
                            <i class="mdi mdi-cart-arrow-right mr-1"></i> Finalizar </a>
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
                    <button class="btn btn-primary btn-xs" onclick="finalizar('factura-recibo')">Finalizar</button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
