<?php

use App\Empresa;
use App\Factura;
use App\FacturaRecibo;
use App\Orcamento;
use App\Proforma;
use App\Recibo;
use App\Role;
use App\Serie;
use App\Stock;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/newPassword', 'UserController@newPassword')->name('newPassword');


Route::get('/', function () {
    return redirect('login');
});

Route::get('/register', function () {
    return view('auth.register_account');
})->name('register');

Route::post('/register', 'EmpresaController@register')->name('register_company');





Route::middleware(['auth'])->group(function () {

    /* AGT */
    Route::group(['prefix' => '/taxtable'], function () {
        Route::get('/', 'TaxTableController@index');
        Route::get('/show', 'TaxTableController@show');
        Route::get('/create', 'TaxTableController@create');
        Route::post('/store', 'TaxTableController@store');
        Route::get('/edit/{valor}', 'TaxTableController@edit');
        Route::put('/update/{valor}', 'TaxTableController@update');
        Route::delete('/destroy/{valor}', 'TaxTableController@destroy');
    });

    Route::group(['prefix' => '/saftaudit'], function () {
        Route::get('/', 'SaftAuditController@index');
        Route::get('/show', 'SaftAuditController@show');
        Route::get('/create', 'SaftAuditController@create');
        Route::post('/store', 'SaftAuditController@store');
        Route::get('/edit/{valor}', 'SaftAuditController@edit');
        Route::put('/update/{valor}', 'SaftAuditController@update');
        Route::delete('/destroy/{valor}', 'SaftAuditController@destroy');
    });

    Route::group(['prefix' => '/saft'], function () {
        Route::get('/', 'SaftController@index');
        Route::post('/generate', 'SaftController@generate');
    });


    /* EMPRESA */
    Route::group(['prefix' => '/empresa'], function () {
        Route::get('/', 'EmpresaController@index');
        Route::get('/show', 'EmpresaController@show');
        Route::get('/create', 'EmpresaController@create');
        Route::post('/store', 'EmpresaController@store');
        Route::get('/edit/{valor}', 'EmpresaController@edit');
        Route::put('/update/{valor}', 'EmpresaController@update');
        Route::delete('/destroy/{valor}', 'EmpresaController@destroy');
        
        
        
        Route::get('/utilizadores', 'EmpresaController@default');
    });


    /* DOCUMENTO */
    Route::group(['prefix' => '/documentos'], function () {

        Route::group(['prefix' => '/proforma'], function () {
            Route::get('/', 'ProformaController@index');
            Route::get('/show', 'ProformaController@show');
            Route::get('/create', 'ProformaController@create');
            Route::post('/store', 'ProformaController@store');
            Route::get('/edit/{valor}', 'ProformaController@edit');
            Route::put('/update/{valor}', 'ProformaController@update');
            Route::delete('/destroy/{valor}', 'ProformaController@destroy');
        });


        Route::group(['prefix' => '/factura'], function () {
            Route::get('/', 'FacturaController@index');
            Route::get('/show', 'FacturaController@show');
            Route::get('/create', 'FacturaController@create');
            Route::post('/store', 'FacturaController@store');
            Route::get('/edit/{valor}', 'FacturaController@edit');
            Route::put('/update/{valor}', 'FacturaController@update');
            Route::delete('/destroy/{valor}', 'FacturaController@destroy');
            Route::get('/search', 'FacturaController@search')->name("factura.search");
        });

        Route::get('/proforma-factura/{valor}', 'FacturaController@proforma_factura');

        Route::group(['prefix' => '/proforma-factura'], function () {
            Route::get('/', 'ProformaController@proforma_factura');
        });
        
        Route::group(['prefix' => '/pos'], function () {
            Route::get('/', 'FacturaReciboController@pos');
            Route::get('/factura-recibo/{id?}', 'FacturaReciboController@fatura_recibo_model');
            Route::post('/factura-recibo/pedido', 'FacturaReciboController@store_mesa');
            Route::post('/factura-recibo/pedido/produto', 'FacturaReciboController@store_mesa_produto');
        });
        
        
        Route::group(['prefix' => '/factura-recibo'], function () {
            Route::get('/', 'FacturaReciboController@index');
            Route::get('/show', 'FacturaReciboController@show');
            Route::get('/create', 'FacturaReciboController@create');
            Route::post('/store', 'FacturaReciboController@store');
            Route::get('/edit/{valor}', 'FacturaReciboController@edit');
            Route::put('/update/{valor}', 'FacturaReciboController@update');
            Route::delete('/destroy/{valor}', 'FacturaReciboController@destroy');
            Route::get('/search', 'FacturaReciboController@search')->name("factura-recibo.search");
            
            // pos
        });
        
        Route::group(['prefix' => '/factura-qr'], function () {
            Route::get('/', 'FacturaQRController@index');
            Route::get('/show', 'FacturaQRController@show');
            Route::get('/create/{id}', 'FacturaQRController@create');
            Route::post('/store', 'FacturaQRController@store');
            Route::get('/edit/{valor}', 'FacturaQRController@edit');
            Route::put('/update/{valor}', 'FacturaQRController@update');
            Route::delete('/destroy/{valor}', 'FacturaQRController@destroy');
        });
        

        Route::group(['prefix' => '/recibo'], function () {
            Route::get('/', 'ReciboController@index');
            Route::get('/show', 'ReciboController@show');
            Route::get('/documento/{valor}', 'ReciboController@documento');
            Route::get('/create/{valor}', 'ReciboController@create');
            Route::post('/store', 'ReciboController@store');
            Route::get('/edit/{valor}', 'ReciboController@edit');
            Route::put('/update/{valor}', 'ReciboController@update');
            Route::delete('/destroy/{valor}', 'ReciboController@destroy');
            Route::get('/search', 'ReciboController@search')->name("recibo.search");
        });

        Route::group(['prefix' => '/nota-credito'], function () {
            Route::get('/', 'NotaCreditoController@index');
            Route::get('/show', 'NotaCreditoController@show');
            Route::get('/create_fatura/{valor}', 'NotaCreditoController@create_fatura');
            Route::get('/create_fatura_recibo/{valor}', 'NotaCreditoController@create_fatura_recibo');
            Route::post('/store', 'NotaCreditoController@store');
            Route::get('/edit/{valor}', 'NotaCreditoController@edit');
            Route::put('/update/{valor}', 'NotaCreditoController@update');
            Route::delete('/destroy/{valor}', 'NotaCreditoController@destroy');
            Route::get('/search', 'NotaCreditoController@search')->name("nota-credito.search");
        });

        Route::group(['prefix' => '/nota-debito'], function () {
            Route::get('/', 'NotaDebitoController@index');
            Route::get('/show', 'NotaDebitoController@show');
            Route::get('/create', 'NotaDebitoController@create');
            Route::post('/store', 'NotaDebitoController@store');
            Route::get('/edit/{valor}', 'NotaDebitoController@edit');
            Route::put('/update/{valor}', 'NotaDebitoController@update');
            Route::delete('/destroy/{valor}', 'NotaDebitoController@destroy');
            Route::get('/search', 'NotaDebitoController@search')->name("nota-debito.search");
        });


        Route::group(['prefix' => '/guia-transporte'], function () {
            Route::get('/', 'GuiaTransporteController@index');
            Route::get('/show', 'GuiaTransporteController@show');
            Route::get('/create', 'GuiaTransporteController@create');
            Route::post('/store', 'GuiaTransporteController@store');
            Route::get('/edit/{valor}', 'GuiaTransporteController@edit');
            Route::put('/update/{valor}', 'GuiaTransporteController@update');
            Route::delete('/destroy/{valor}', 'GuiaTransporteController@destroy');
        });

        Route::group(['prefix' => '/guia-remessa'], function () {
            Route::get('/', 'GuiaRemessaController@index');
            Route::get('/show', 'GuiaRemessaController@show');
            Route::get('/create', 'GuiaRemessaController@create');
            Route::post('/store', 'GuiaRemessaController@store');
            Route::get('/edit/{valor}', 'GuiaRemessaController@edit');
            Route::put('/update/{valor}', 'GuiaRemessaController@update');
            Route::delete('/destroy/{valor}', 'GuiaRemessaController@destroy');
        });
    });

    /* ARTIGO */
    Route::group(['prefix' => '/artigo'], function () {
        Route::get('/', 'ArtigoController@index');
        Route::get('/show', 'ArtigoController@show');
        Route::get('/create', 'ArtigoController@create');
        Route::post('/store', 'ArtigoController@store');
        Route::get('/edit/{valor}', 'ArtigoController@edit');
        Route::put('/update/{valor}', 'ArtigoController@update');
        Route::delete('/destroy/{valor}', 'ArtigoController@destroy');
        Route::put('/anular/{valor}', 'ArtigoController@anular');
        Route::put('/activar/{valor}', 'ArtigoController@activar');
        Route::get('/search', 'ArtigoController@search')->name("artigo.search");
    });

    /* RECEITA & DESPESA */
    Route::group(['prefix' => '/receita-despesa'], function () {
        Route::get('/', 'ReceitaDespesaController@index');
        Route::get('/show', 'ReceitaDespesaController@show');
        Route::get('/create', 'ReceitaDespesaController@create');
        Route::post('/store', 'ReceitaDespesaController@store');
        Route::get('/edit/{valor}', 'ReceitaDespesaController@edit');
        Route::put('/update/{valor}', 'ReceitaDespesaController@update');
        Route::delete('/destroy/{valor}', 'ReceitaDespesaController@destroy');
    });

    /* Inseção */
    Route::group(['prefix' => '/imposto'], function () {
        Route::get('/', 'ImpostoController@index');
        Route::get('/show', 'ImpostoController@show');
        Route::get('/create', 'ImpostoController@create');
        Route::post('/store', 'ImpostoController@store');
        Route::get('/edit/{valor}', 'ImpostoController@edit');
        Route::put('/update/{valor}', 'ImpostoController@update');
        Route::delete('/destroy/{valor}', 'ImpostoController@destroy');
    });


    /* CATEGORIA */
    Route::group(['prefix' => '/categoria'], function () {
        Route::get('/', 'CategoriaController@index');
        Route::get('/show', 'CategoriaController@show');
        Route::get('/create', 'CategoriaController@create');
        Route::post('/store', 'CategoriaController@store');
        Route::get('/edit/{valor}', 'CategoriaController@edit');
        Route::put('/update/{valor}', 'CategoriaController@update');
        Route::delete('/destroy/{valor}', 'CategoriaController@destroy');
    });

    /* TIPO */
    Route::group(['prefix' => '/tipo'], function () {
        Route::get('/', 'TipoController@index');
        Route::get('/show', 'TipoController@show');
        Route::get('/create', 'TipoController@create');
        Route::post('/store', 'TipoController@store');
        Route::get('/edit/{valor}', 'TipoController@edit');
        Route::put('/update/{valor}', 'TipoController@update');
        Route::delete('/destroy/{valor}', 'TipoController@destroy');
    });

    /* MARCA */
    Route::group(['prefix' => '/departamento'], function () {
        Route::get('/', 'DepartamentoController@index');
        Route::get('/show', 'DepartamentoController@show');
        Route::get('/create', 'DepartamentoController@create');
        Route::post('/store', 'DepartamentoController@store');
        Route::get('/edit/{valor}', 'DepartamentoController@edit');
        Route::put('/update/{valor}', 'DepartamentoController@update');
        Route::delete('/destroy/{valor}', 'DepartamentoController@destroy');
    });


    /* FABRICANTE */
    Route::group(['prefix' => '/fabricante'], function () {
        Route::get('/', 'FabricanteController@index');
        Route::get('/show', 'FabricanteController@show');
        Route::get('/create', 'FabricanteController@create');
        Route::post('/store', 'FabricanteController@store');
        Route::get('/edit/{valor}', 'FabricanteController@edit');
        Route::put('/update/{valor}', 'FabricanteController@update');
        Route::delete('/destroy/{valor}', 'FabricanteController@destroy');
    });

    /* STOCK */
    Route::group(['prefix' => '/stock'], function () {
        Route::get('/', 'StockController@index');
        Route::get('/show', 'StockController@show');
        Route::get('/create', 'StockController@create');
        Route::post('/store', 'StockController@store');
        Route::get('/edit/{valor}', 'StockController@edit');
        Route::put('/update/{valor}', 'StockController@update');
        Route::delete('/destroy/{valor}', 'StockController@destroy');
        Route::get('/stock', 'StockController@stock');
    });


    /* CLIENTE */
    Route::group(['prefix' => '/cliente'], function () {
        Route::get('/', 'ClienteController@index');
        Route::get('/show', 'ClienteController@show');
        Route::get('/create', 'ClienteController@create');
        Route::post('/store', 'ClienteController@store');
        Route::get('/edit/{valor}', 'ClienteController@edit');
        Route::put('/update/{valor}', 'ClienteController@update');
        Route::delete('/destroy/{valor}', 'ClienteController@destroy');
        Route::get('/conta_corrente/{valor}', 'ClienteController@conta_corrente');
        Route::get('/search', 'ClienteController@search')->name("cliente.search");
        Route::get('anular/{id}', 'ClienteController@anular');
        Route::get('activar/{id}', 'ClienteController@activar');
        Route::get('cliente_code/{id}', 'ClienteController@criarCode');
        Route::get('cliente_qrcode/{id}', 'ClienteController@viewCode');
        Route::get('cliente_qrcode_pagamento/{id}', 'ClienteController@qrcodePagamento');
    });

    /* FORNECEDOR */
    Route::group(['prefix' => '/fornecedor'], function () {
        Route::get('/', 'FornecedorController@index');
        Route::get('/show', 'FornecedorController@show');
        Route::get('/create', 'FornecedorController@create');
        Route::post('/store', 'FornecedorController@store');
        Route::get('/edit/{valor}', 'FornecedorController@edit');
        Route::put('/update/{valor}', 'FornecedorController@update');
        Route::delete('/destroy/{valor}', 'FornecedorController@destroy');
        Route::put('/anular/{valor}', 'FornecedorController@anular');
        Route::put('/activar/{valor}', 'FornecedorController@activar');
    });


    /* ARMAZEM */
    Route::group(['prefix' => '/armazem'], function () {
        Route::get('/', 'ArmazemController@index');
        Route::get('/show', 'ArmazemController@show');
        Route::get('/create', 'ArmazemController@create');
        Route::post('/store', 'ArmazemController@store');
        Route::get('/edit/{valor}', 'ArmazemController@edit');
        Route::put('/update/{valor}', 'ArmazemController@update');
        Route::delete('/destroy/{valor}', 'ArmazemController@destroy');
    });

    // BANCO
    Route::prefix('banco')->group(function () {
        Route::get('', 'BancoController@index');
        Route::post('store', 'BancoController@store');
        Route::post('update', 'BancoController@update');
        Route::get('destroy/{id}', 'BancoController@destroy');
    });

    /* FORMA PAGAMENTO */
    Route::group(['prefix' => '/formaspagamento'], function () {
        Route::get('/', 'FormasPagamentoController@index');
        Route::get('/show', 'FormasPagamentoController@show');
        Route::get('/create', 'FormasPagamentoController@create');
        Route::post('/store', 'FormasPagamentoController@store');
        Route::get('/edit/{valor}', 'FormasPagamentoController@edit');
        Route::put('/update/{valor}', 'FormasPagamentoController@update');
        Route::delete('/destroy/{valor}', 'FormasPagamentoController@destroy');
    });
    
    /* PAISES */
    Route::group(['prefix' => '/pais'], function () {
        Route::get('/', 'PaisController@index');
        Route::get('/show', 'PaisController@show');
        Route::get('/create', 'PaisController@create');
        Route::post('/store', 'PaisController@store');
        Route::get('/edit/{valor}', 'PaisController@edit');
        Route::put('/update/{valor}', 'PaisController@update');
        Route::delete('/destroy/{valor}', 'PaisController@destroy');
    });
    

    /* MODO PAGAMENTO */
    Route::group(['prefix' => '/condicoespagamento'], function () {
        Route::get('/', 'CondicoesPagamentoController@index');
        Route::get('/show', 'CondicoesPagamentoController@show');
        Route::get('/create', 'CondicoesPagamentoController@create');
        Route::post('/store', 'CondicoesPagamentoController@store');
        Route::get('/edit/{valor}', 'CondicoesPagamentoController@edit');
        Route::put('/update/{valor}', 'CondicoesPagamentoController@update');
        Route::delete('/destroy/{valor}', 'CondicoesPagamentoController@destroy');
    });

    /* SERIE */
    Route::group(['prefix' => '/series'], function () {
        Route::get('/', 'SerieController@index');
        Route::get('/show', 'SerieController@show');
        Route::get('/create', 'SerieController@create');
        Route::post('/store', 'SerieController@store');
        Route::get('/edit/{valor}', 'SerieController@edit');
        Route::put('/update/{valor}', 'SerieController@update');
        Route::delete('/destroy/{valor}', 'SerieController@destroy');
    });


    /* MOTIVO ANULAÇÃO */
    Route::group(['prefix' => '/motivo_anulacao'], function () {
        Route::get('/', 'MotivoAnulacaoController@index');
        Route::get('/show', 'MotivoAnulacaoController@show');
        Route::get('/create', 'MotivoAnulacaoController@create');
        Route::post('/store', 'MotivoAnulacaoController@store');
        Route::get('/edit/{valor}', 'MotivoAnulacaoController@edit');
        Route::put('/update/{valor}', 'MotivoAnulacaoController@update');
        Route::delete('/destroy/{valor}', 'MotivoAnulacaoController@destroy');
    });


    /* API */
    Route::group(['prefix' => '/api'], function () {
        Route::post('/grafico', 'APIController@grafico');
        Route::get('/documentofactura/{valor}', 'APIController@getDocumentoFactura');
        Route::get('/fornecedor/{valor}', 'APIController@getFornecedorEnderecoContacto');
        Route::get('/cliente/{valor}', 'APIController@getClienteEnderecoContacto');
        Route::get('/artigo/{valor}', 'APIController@getArtigo');
        Route::get('/artigos/{valor?}', 'APIController@getArtigos');
        Route::get('/pedido/{id}', 'FacturaReciboController@filter_pedido');
        Route::post('/pedido/produto/{id}', 'FacturaReciboController@filter_produto_update');
    });


    /* PDF */
    Route::group(['prefix' => '/pdf'], function () {

        Route::group(['prefix' => '/documentos'], function () {
            Route::get('/proforma/{valor}', 'PDFController@proforma');
            Route::get('/factura/{valor}', 'PDFController@factura');
            Route::get('/factura-recibo/{valor}', 'PDFController@factura_recibo');
            Route::get('/recibo/{valor}', 'PDFController@recibo');
            Route::get('/nota-credito/{valor}', 'PDFController@nota_credito');
            Route::get('/nota-debito/{valor}', 'PDFController@nota_debito');
            Route::get('/guia-transporte/{valor}', 'PDFController@guia_transporte');
            Route::get('/guia-remessa/{valor}', 'PDFController@guia_remessa');
            Route::get('/stock/{valor}', 'PDFController@stock');
        });

        Route::group(['prefix' => '/relatorios'], function () {
            Route::post('/', 'PDFController@relatorio');
            Route::post('/paises', 'PDFController@pais_relatorio');
            Route::post('/imposto_geral', 'ClienteController@imposto_geral');
            Route::post('/paises', 'PDFController@pais_relatorio');
            Route::post('/imposto_geral', 'ClienteController@imposto_geral');
            Route::get('/cliente/{valor}', 'PDFController@relatorio_cliente');
        });
    });


    /* Print */
    Route::group(['prefix' => '/print'], function () {

        Route::group(['prefix' => '/documentos'], function () {
            Route::get('/proforma/{valor}', 'PrintController@proforma');
            Route::get('/factura/{valor}', 'PrintController@factura');
            Route::get('/factura-recibo/{valor}', 'PrintController@factura_recibo');
            Route::get('/recibo/{valor}', 'PrintController@recibo');
            Route::get('/nota-credito/{valor}', 'PrintController@nota_credito');
            Route::get('/nota-debito/{valor}', 'PrintController@nota_debito');
            Route::get('/guia-transporte/{valor}', 'PrintController@guia_transporte');
            Route::get('/guia-remessa/{valor}', 'PrintController@guia_remessa');
        });

        Route::group(['prefix' => '/relatorios'], function () {
            Route::post('/', 'PrintController@relatorio');
            Route::get('/cliente/{valor}', 'PrintController@relatorio_cliente');
        });
    });

    Route::prefix('utilizador')->group(function () {
        Route::get('index', 'UserController@index');
        Route::get('create', 'UserController@create');
        Route::post('store', 'UserController@store');
        Route::get('edit/{id}', 'UserController@edit');
        Route::post('update/{id}', 'UserController@update');
        Route::get('destroy/{id}', 'UserController@destroy');
        Route::post('actualizar_perfil/{id}', 'UserController@actualizarPerfil');
        Route::get('resetPassword/{id}', 'UserController@resetPassword');
        Route::get('newPassword', 'UserController@newPassword');
        Route::post('updateNewPassword', 'UserController@updateNewPassword');
        Route::post('assignrole/{id}', 'UserController@assignRole');
        Route::get('becomesuperadmin/{id}', 'UserController@becomeSuperAdmin');
        Route::get('/search', 'UserController@search')->name("utilizador.search");
    });

    Route::prefix('perfil')->group(function () {
        Route::get('index', 'PerfilController@index');
        Route::post('store', 'PerfilController@store');
        Route::post('update/{id}', 'PerfilController@update');
        Route::post('assignPermission/{id}', 'PerfilController@assignPermission');
        Route::get('destroy/{id}', 'PerfilController@destroy');
    });

    Route::prefix('permissao')->group(function () {
        Route::get('index', 'PermissaoController@index');
        Route::post('store', 'PermissaoController@store');
        Route::post('update/{id}', 'PermissaoController@update');
        Route::get('destroy/{id}', 'PermissaoController@destroy');
        Route::get('permission-table', 'PermissaoController@show_permission_table');
    });

    Route::prefix('ajax')->group(function () {
        Route::get('permissions/{valor}', function ($valor) {
            return Role::find($valor)->permissions;
        });
    });

    // BUGS
    Route::prefix('bug')->group(function () {
        Route::get('', 'BugController@index');
        Route::post('store', 'BugController@store');
        Route::post('update', 'BugController@update');
        Route::get('destroy/{id}', 'BugController@destroy');
    });
});

Route::get('logout', function () {
    session()->flash('alert_warning', 'Sessão encerrada');
  	Auth::logout();
    return redirect('login');
});
// Route::post('logout', function () {
//     Auth::logout();
//     session()->flash('alert_warning', 'Já existe um super administrador');
//     return redirect('login');
// });