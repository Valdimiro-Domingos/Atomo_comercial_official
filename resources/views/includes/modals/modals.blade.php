<div id="modal-cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:800px; height:700px;">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <embed src="{{ url('cliente/create') }}" width="100%" height="480px">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i
                        class="fa fa-times"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>




<div id="modal-my-faturas" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Documentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>NIF</th>
                                    <th>Valor Total</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->where('utilizador_id', Auth::user()->id)->get() as $item)
                                    <tr>

                                        <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->numero }}</td>
                                        <td {!! !$item->status ? 'style="color:red"' : '' !!}>
                                            {{ date('d-m-Y H:m:s', strtotime($item->data)) }}
                                        </td>
                                        <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->cliente_nome }}</td>
                                        <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ $item->contribuinte }}</td>
                                        <td {!! !$item->status ? 'style="color:red"' : '' !!}>{{ number_format($item->total, 2, '.', ',') }}</td>
                                        <td>
                                            <a class="btn btn-primary" target="_blank"
                                                href='{{ url('pdf/documentos/factura-recibo'. "/{$item->id}") }}'><i
                                                    class="fa fa-print"></i></a>
                                            <a class="btn btn-primary" target="_blank"
                                                href='{{ url('print/documentos/factura-recibo'. "/{$item->id}") }}'><i
                                                    class="bx bx-printer"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i
                        class="fa fa-times"></i> Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!--
    Modal para escolha do tipo de pagamento no acto da listagem de liquidações em tesouraria
-->
<div id="modal-relatorio_filtro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Relatório</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form target="_blank" action="{{ url('pdf/relatorios') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card">
                        <div class="form-group">
                            <label>Documentos</label>
                            <select name="tipo" class="form-control" required>
                                <option value="" disabled selected>Selecione...</option>
                                @foreach (\App\Serie::where('empresa_id', Auth::user()->empresa_id)->get() as $linha)
                                    <option value="{{ $linha->tipo }}">
                                        {{ strtoupper($linha->tipo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cliente</label>
                            <select name="cliente_id" class="form-control ">
                                <option value="" disabled selected>Selecione...</option>
                                @foreach (\App\Cliente::where('empresa_id', Auth::user()->empresa_id)->get() as $linha)
                                    <option value="{{ $linha->id }}">
                                        {{ $linha->designacao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Utilizador</label>
                            <select name="utilizador_id" class="form-control ">
                                <option value="" disabled selected>Selecione...</option>
                                @foreach (\App\User::where('empresa_id', Auth::user()->empresa_id)->get() as $linha)
                                    <option value="{{ $linha->id }}">
                                        {{ $linha->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo">Data Inicio</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="data1">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Data Fim</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="data2">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i
                            class="fa fa-times"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary waves-effect"><i class="fa fa-search"></i>
                        Procurar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!--
    Modal para escolha de iva mensal
-->
<div id="modal-relatorio_mapa_iva" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Mapa Imposto/Iva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form target="_blank" action="{{ url('pdf/relatorios/imposto_geral') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card">
                 
                       
                            <div class="form-group">
                                <label for="tipo">Data Inicio</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="data1">
                            </div>
                            <div class="form-group">
                                <label for="tipo">Data Fim</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="data2">
                            </div>
                        
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i
                            class="fa fa-times"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary waves-effect"><i class="fa fa-search"></i>
                        Procurar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--
    Modal para escolha do tipo de paises  e relatorio de estrangeiro
-->


<div id="modal-relatorio_paises" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Relatório de Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form target="_blank" action="{{ url('pdf/relatorios/paises') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card">
                        <div class="form-group">
                            <label>Pais</label>
                            <select name="pais" class="form-control" id="" required>
                                <option value="" disabled selected>Selecione...</option>
                                @foreach (\App\Pais::where('empresa_id', Auth::user()->empresa_id)->get() as $linha)
                                    <option value="{{ $linha->designacao }}">
                                        {{ strtoupper($linha->designacao) }}
                                    </option>
                                @endforeach
                                <option value="*">TODOS PAISES</option>
                            </select>
                        </div>
                       
                        
                        <div id="hide_show_intervalo">
                            <div class="form-group">
                                <label for="tipo">Data Inicio</label>
                                <input type="date" class="form-control" required value="{{ date('Y-m-d') }}" name="data1">
                            </div>
                            <div class="form-group">
                                <label for="tipo">Data Fim</label>
                                <input type="date" class="form-control" required value="{{ date('Y-m-d') }}" name="data2">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i
                            class="fa fa-times"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary waves-effect"><i class="fa fa-search"></i>
                        Procurar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--
    Modal para escolha do tipo de pagamento no acto da listagem de liquidações em tesouraria
-->
<div id="modal-perfil-utilizador" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Seu Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ action('UserController@actualizarPerfil', ['id' => Auth::user()->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" value="{{ Auth::user()->nome }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ Auth::user()->email }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control"
                            accept=".png, .jpg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i
                            class="fa fa-times"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary waves-effect"><i class="bx bx-reset"></i>
                        Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
