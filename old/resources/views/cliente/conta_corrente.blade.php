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


    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="me-4">
                                <img id="blah" style="height: 2rem;  border-radius: 100%;"
                                    src='{{ asset("public/upload/{$dados['cliente'][0]->imagem}") }}'>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h5>{{ $dados['cliente'][0]->designacao }}</h5>
                        </div>
                    </div>


                </div>
                <div class="card-body border-top">

                    <div class="row">

                        <div class="col-sm-12">
                            <div class="text-sm-end mt-4 mt-sm-0">
                                <p class="text-muted mb-2"><b>Código: </b>{{ $dados['cliente'][0]->codigo }}</p>
                                <p class="text-muted mb-2"><b>Telemovel: </b>{{ $dados['cliente'][0]->telemovel }}</p>
                                <p class="text-muted mb-2"><b>Email: </b>{{ $dados['cliente'][0]->email }}</p>
                                <p class="text-muted mb-2"><b>Nave: </b>{{ $dados['cliente'][0]->nave ?? '--' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body border-top">
                    <p class="text-muted mb-2">Imprimir</p>
                    <div class="text-center">
                        <div class="col-xs-12">
                            <div class="row">


                                @foreach (\App\Serie::all() as $linha)
                                    <div class="col-xs-4">
                                        <div class="mt-4 mt-sm-0">
                                            <div class="mt-3">
                                                <a target="_blank"
                                                    href='{{ url("pdf/relatorios/cliente/{$dados['cliente'][0]->id_tabela}?tipo={$linha->tipo}") }}'
                                                    class="btn btn-primary btn-sm w-md mr-2">
                                                    {{ strtoupper($linha->tipo) }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-white font-size-18">
                                        <i class="fas fa-arrow-down"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p class="text-muted mb-2">Crédito</p>
                                    <h5 class="mb-0">{{ $dados['credito'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-danger bg-soft text-white font-size-18">
                                        <i class="fas fa-arrow-up"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p class="text-muted mb-2">Débito</p>
                                    <h5 class="mb-0">{{ $dados['debito'] }}</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-info bg-soft text-white font-size-18">
                                        <i class="fas fa-balance-scale"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p class="text-muted mb-2">Saldo</p>
                                    <h5 class="mb-0">{{ $dados['saldo'] }}</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        @php   $balanco = 0;   @endphp
                                        @foreach ($dados['operacaos'] as $item)
                                            @php   $balanco = $balanco + $item['total'];   @endphp
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
                                                <td>{{ $item['data'] }}</td>
                                                <td>
                                                    {{ $item['documento'] }}
                                                </td>
                                                <td>
                                                    {{ $item['descricao'] }}
                                                </td>
                                                <td>
                                                    {{ number_format( $item['total'] , 2, ',', '.') }}
                                                </td>

                                                <td>
                                                    <a class="btn btn-primary " target="_blank"
                                                        href='{{ url('pdf/documentos/' . $item['rota'] . '/' . $item['id']) }}'><i
                                                            class="fa fa-print"></i>

                                                    </a>
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

        </div>
    </div>

    <!-- end row -->
@endsection
