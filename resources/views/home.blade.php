@extends('layouts.app')
@section('conteudo')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Painel ({{ date('01-m-Y') }} / {{ date('t-m-Y') }})</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Painel</a></li>
                                <li class="breadcrumb-item active">Painel</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-muted font-weight-medium">Receita </p>
                                            <h4 class="mb-0">{{ $dados['credito'] }}</h4>
                                        </div>

                                        <div class="avatar-sm rounded-circle bg-info align-self-center mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-info">
                                                <i class="fas fa-arrow-down"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-muted font-weight-medium">Despesa</p>
                                            <h4 class="mb-0">{{ $dados['debito'] }}</h4>
                                        </div>

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-danger align-self-center">
                                            <span class="avatar-title rounded-circle bg-danger">
                                                <i class="fas fa-arrow-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-muted font-weight-medium">Balanço</p>
                                            <h4 class="mb-0">{{ $dados['saldo'] }}</h4>
                                        </div>

                                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="fas fa-balance-scale"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Operações</h4>
                            <div class="table-responsive" style="overflow: hidden;">
                                <table id="datatable" class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Estado</th>
                                            <th>Data</th>
                                            <th>Documento</th>
                                            <th>Descrição</th>
                                            <th>Total</th>
                                            <th>Ver Detalhes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dados['operacaos'] as $item)
                                            <tr>
                                                <td>
                                                    @if ($item['operacao'] == 'Crédito')
                                                        <span
                                                            class="badge badge-pill badge-soft-success font-size-12">{{ $item['operacao'] }}</span>
                                                    @elseif($item['operacao'] == 'Débito')
                                                        <span
                                                            class="badge badge-pill badge-soft-danger font-size-12">{{ $item['operacao'] }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-pill badge-soft-info font-size-12">{{ $item['operacao'] }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($item['data'])) }}</td>
                                                <td>
                                                    {{ $item['documento'] }}
                                                </td>
                                                <td>
                                                    {{ $item['descricao'] }}
                                                </td>
                                                <td>
                                                    {{ number_format($item['total'], 2, ',', '.') }}
                                                </td>

                                                <td>
                                                    @if ($item['rota'])
                                                        <a class="btn btn-primary " target="_blank"
                                                            href='{{ url('pdf/documentos/' . $item['rota'] . '/' . $item['id']) }}'><i
                                                                class="fa fa-print"></i>

                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection
