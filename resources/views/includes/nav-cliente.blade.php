<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div style="float: right; ">
                    <a href="{{ url('documentos/facturas/nova') }}" class="btn btn-warning"><i
                            class="fa fa-store font-size-16 align-middle mr-2"></i>NOVA VENDA</a>
                    <a href="{{ url('tesouraria/pendentes') }}" class="btn btn-dark"><i
                            class="fa fa-hand-holding font-size-16 align-middle mr-2"></i>PENDENTES</a>
                    <a href="{{ url('tesouraria/liquidacoes') }}" class="btn btn-danger"><i
                            class="fa fa-hand-holding-usd font-size-16 align-middle mr-2"></i>LIQUIDAÇÕES</a>
                    <a href="{{ action('ClienteController@index') }}" class="btn btn-primary"><i
                            class="fa fa-align-justify font-size-16 align-middle mr-2"></i>CLIENTES</a>
                    <a href="{{ action('ClienteController@create') }}" class="btn btn-success"><i
                            class="fa fa-bullhorn font-size-16 align-middle mr-2"></i>NOVO CLIENTE</a>
                    <a href="{{ url('clientes/vendas') }}" class="btn btn-info"><i
                            class="fa fa-store-alt font-size-16 align-middle mr-2"></i>VENDAS</a>
                </div>
            </div>
        </div>
    </div>
</div>
