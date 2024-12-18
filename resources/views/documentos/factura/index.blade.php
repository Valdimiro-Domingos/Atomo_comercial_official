@extends('layouts.app')
@section('conteudo')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ strtoupper(Request::segment(1)) }} </h4>

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

    <!-- start -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div style="float: right; margin-bottom: 1em;">
                        @if (App\Cliente::all()->count() > 1)
                        <a href="{{ url('documentos/' . Request::segment(2) . '/create') }}" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    @else
                        <a class="btn btn-danger">Registe um
                            cliente para poder fazer a operação</a>
                    @endif
                    </div>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Documento</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>NIF</th>
                                        <th>Valor Total</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dados as $key => $item)
                                        <tr>

                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $key + 1 }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->numero }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>
                                                {{ date('d-m-Y H:m:s', strtotime($item->data)) }}
                                            </td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->cliente_nome }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->contribuinte }}</td>
                                            <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ number_format($item->total, 2, '.', ',') }}</td>
                                            <td>
                                                <a class="btn btn-primary" target="_blank"
                                                    href='{{ url('pdf/documentos/' . Request::segment(2) . "/{$item->id}") }}'><i
                                                        class="fa fa-print"></i></a>
                                                <a class="btn btn-primary" target="_blank"
                                                    href='{{ url('pdf/documentos/' . Request::segment(2) . "/{$item->id}?doc_via=Segunda Via") }}'><i
                                                        class="mdi mdi-file-replace"></i></a>
                                                <a class="btn btn-primary" target="_blank"
                                                    href='{{ url('pdf/documentos/' . Request::segment(2) . "/{$item->id}?doc_via=Duplicado") }}'><i
                                                        class="mdi mdi-file-multiple"></i></a>


                                                @if ($item->is_nota)
                                                    @if ($item->is_recibo)
                                                        <a class="btn btn-info btn-xs" href="#" data-rel="tooltip"
                                                            data-placement="top" data-toggle="modal"
                                                            data-target="#recibo{{ $item->id }}">Recibo</a>
                                                    @endif

                                                    <a href='{{ url("documentos/nota-credito/create_fatura/{$item->id}") }}'
                                                        class="btn btn-warning btn-xs">Nota de crédito</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="d-flex justify-content-between ">
                                        <td colspan="7">{{ $dados->links() }}</td>
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


    @foreach ($dados as $item)
        <div class="modal fade" id="recibo{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recibo</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" action="{{ url('documentos/recibo/store/') }}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Documento</label>
                                <input type="hidden" name="factura_id" value="{{ $item->id }}" class="form-control"
                                    readonly>
                                <input type="text" name="numero" value="{{ $item->numero }}" class="form-control"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label>Comprovativo</label>
                                <input type="file" name="file" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Total</label>
                                <input type="text" name="total" value="{{ number_format($item->total, 2, '.', ',') }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Total Pendente</label>
                                <input type="text" name="total_pendente"
                                    value="{{ number_format($item->total_pendente, 2, '.', ',') }}" class="form-control"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label>Valor Pago</label>
                                <input type="text" value="0,00" name="valor_pago" class="form-control mask-money"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Data de Pagamento (Que consta no comprovativo)</label>
                                <input type="date" name="data" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                                    class="form-control" required>
                            </div>


                            <div class="form-group">
                                <label>Retenção na fonte</label>
                                <select name="retencao" class="form-control" required>
                                    <option value="0">Não</option>
                                    <option value="6.5">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit"><i class="bx bx-rotate-left"></i>
                                Salvar</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal"><i
                                    class="fa fa-times"></i>
                                Fechar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
@endsection
