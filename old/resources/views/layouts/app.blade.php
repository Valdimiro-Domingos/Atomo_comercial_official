<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">
    <!-- twitter-bootstrap-wizard css -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/twitter-bootstrap-wizard/prettify.css') }}">
    <!-- DataTables -->
    <link href="{{ asset('public/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- advanced inputs js -->
    <link href="{{ asset('public/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <!-- Sweet Alert-->
    <link href="{{ asset('public/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Toastr -->
    <link href="{{ asset('public/bower_components/toastr/toastr.min.css') }}" id="app-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <style>
        
    .card_notification {
        color: #f1b44c;
        font-size: 11px;
    }
    
    .card_notification_body {
        padding: 2px;
    }
    
    .span_green {
        color: green!important;
    }
    
    .span_red {
        color: red!important;
    }
    </style>
</head>


<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('public/assets/images/logo-light.svg') }}" alt=""
                                    height="30">
                            </span>
                            <span class="logo-lg" style="margin-left:-45%; font-size:24px; color:grey">
                                <img src="{{ asset('public/assets/images/logo-light.svg') }}" alt=""
                                    height="50">
                                {{ config('app.name') }}
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">
                
                    @php
                        $notificacao = '';
                        function verificarExpiracaoApp($prazo_inicio = null, $prazo_termino = null)
                        {
                            $hoje = now(); // Obter a data atual
                            $prazoInicio = \Carbon\Carbon::parse($prazo_inicio);
                            $prazoTermino = \Carbon\Carbon::parse($prazo_termino);
                        
                            if ($hoje->greaterThanOrEqualTo($prazoInicio) && $hoje->lessThanOrEqualTo($prazoTermino)) {
                                $notificacao = "Efetuado";
                            } elseif ($hoje->greaterThan($prazoTermino)) {
                                $notificacao = "Expirado";
                            } else {
                                $notificacao = "Pendente";
                            }
                        }
                        verificarExpiracaoApp(@Auth::user()->empresa->prazo_inicio, @Auth::user()->empresa->prazo_termino);
                    @endphp
                
                    <div class="card_notification">
                        <div class="card_notification_body d-flex align-items-center h-100">
                            <p class="card-text">
                                @if($notificacao == 'Expirado')
                                    Pagamento: <span class="span_red">Expirado</span>
                                @elseif($notificacao == 'Efetuado')
                                    Pagamento: <span class="span_green">Efetuado</span>
                                @else
                                    Pagamento: <span>Pendente</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    
                    
                    @can('pos')
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect">
                                <a href="{{ url('documentos/pos') }}" rel="noopener noreferrer"><i
                                        class="fa fa-tv"></i></a>
                            </button>
                        </div>
                    @endcan


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ Auth::user()->foto ? asset('public/upload/' . Auth::user()->foto) : asset('public/upload/default.jpg') }}"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ml-1" key="t-henry">{{ Auth::user()->nome }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a class="dropdown-item" href="#" data-toggle="modal"
                                data-target="#modal-perfil-utilizador"><i
                                    class="bx bx-user font-size-16 align-middle mr-1"></i>
                                <span key="t-profile">Perfil</span></a>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault();document.getElementById('form-logout').submit();"><i
                                    class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> <span
                                    key="t-logout">Sair</span></a>
                            <form action="{{ route('logout') }}" method="post" id="form-logout">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Menu</li>
                        @can('painel')
                            <li>
                                <a href="{{ url('home') }}">
                                    <i class="bx bx-home"></i>
                                    <span key="t-ecommerce">Painel</span>
                                </a>
                            </li>
                        @endcan



                        @can('cliente')
                            <li>
                                <a href="{{ url('cliente') }}">
                                    <i class="bx bx-group"></i>
                                    <span key="t-ecommerce">Clientes</span>
                                </a>
                            </li>
                        @endcan

                        @can('artigo')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-cubes"></i>
                                    <span key="t-ecommerce">Artigos</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('artigo') }}" key="t-products">
                                            Artigos</a></li>
                                    <li><a href="{{ url('categoria') }}" key="t-products">
                                            Categoria</a></li>
                                 <li>
                                        <a href="{{ url('stock') }}">
                                            <span key="t-ecommerce">Stock</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <span key="t-ecommerce">Parametrizar</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                           {{--       <li><a href="{{ url('imposto') }}" key="t-products">
                                                    Impostos</a></li>
                                            <li><a href="{{ url('fabricante') }}" key="t-products">
                                                    Fabricante</a></li>
                                            <li><a href="{{ url('armazem') }}" key="t-products">
                                                    Armazem</a></li>

                                            <li><a href="{{ url('tipo') }}" key="t-products"> Tipo</a></li> --}}
                                                    
                                            <li>
                                                <a href="{{ url('fornecedor') }}">
                                                    <span key="t-ecommerce">Fornecedor</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        @endcan



                        @can('documento')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-receipt"></i>
                                    <span key="t-ecommerce">Documentos</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                
                                    
                                    <li><a href="{{ url('documentos/proforma') }}" key="t-products">ProForma</a>
                                    </li>

                                    <li><a href="{{ url('documentos/factura') }}" key="t-products">Factura</a>
                                    </li>
                                    <li><a href="{{ url('documentos/factura-recibo') }}" key="t-products">Factura
                                            Recibo</a>
                                    </li>
                                    <li><a href="{{ url('documentos/recibo') }}" key="t-products">Recibo</a>
                                    </li>

                                    <li><a href="{{ url('documentos/nota-credito') }}" key="t-products">Nota de
                                            Crédito</a>
                                    </li>

                                    {{-- <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <span key="t-ecommerce">Transporte</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="{{ url('documentos/guia-transporte') }}" key="t-products">Guia
                                                    de
                                                    Transporte</a>
                                            </li>
                                            <li><a href="{{ url('documentos/guia-remessa') }}" key="t-products">Guia de
                                                    Remessa</a>
                                            </li>
                                        </ul>
                                    </li> --}}

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <span key="t-ecommerce">Parametrizar</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            {{-- <li><a href="{{ url('series') }}" key="t-products">Series</a></li> --}}
                                            <li><a href="{{ url('formaspagamento') }}" key="t-products">Formas de
                                                    Pagamento</a></li>
                                            <li><a href="{{ url('pais') }}" key="t-products">Pais</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('receita_despesa')
                            <li><a href="{{ url('receita-despesa') }}" key="t-products"> <i
                                        class="fas fa-exchange-alt"></i> Receitas & Despesas</a>
                            </li>
                        @endcan

                        @can('relatorio')
                       
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-line-chart"></i>
                                    <span key="t-">Relatórios</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#modal-relatorio_paises">
                                            <span key="t-ecommerce">Clientes</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#modal-relatorio_mapa_iva">
                                            <span key="t-ecommerce">Mapa IVA Mensal</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#modal-relatorio_filtro">
                                            <span key="t-ecommerce">Relatório Geral</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('configuracoes')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span key="t-ecommerce">Configuracões</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <span key="t-ecommerce">Empresa</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="{{ url('empresa/') }}" key="t-products">Instituição</a>
                                            </li>
                                            <li> <a href="{{ url('departamento/') }}">
                                                    Departamentos
                                                </a></li>
                                            <li> <a href="{{ action('BancoController@index') }}">
                                                    Bancos
                                                </a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <span key="t-ecommerce">Gesto de Utilizadores</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li>
                                                <a href="{{ action('UserController@index') }}">
                                                    Utilizadores
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ action('PerfilController@index') }}">
                                                    Perfis
                                                </a>
                                            </li> </a>
                                   
                                            
                                            <li>
                                                <a href="{{ action('PermissaoController@show_permission_table') }}">
                                                    Permissões
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    @can('painel_gestao')
                                        <li>
                                            <a href="{{ url('empresa/utilizadores') }}">
                                                Gestão de Empresas
                                            </a>
                                        </li>
                                   @endcan

                                    <li> <a href="{{ url('saft') }}">
                                            GERAR SAFT(AO)
                                        </a> </li>
                                    <li>
                                        <a href="{{ action('BugController@index') }}">
                                            Reportar Problema
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Begin Page-content -->
                    @yield('conteudo')
                    <!-- End Page-content -->
                </div>
            </div>
            @include('includes.modals.modals')

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © {{ config('app.name') }}
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                {{ __('Design & Develop by Átomo Tecnologias') }}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail"
                        alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch"
                        checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail"
                        alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch"
                        data-bsStyle="assets/css/bootstrap-dark.min.css"
                        data-appStyle="assets/css/app-dark.min.css" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-3.jpg') }}" class="img-fluid img-thumbnail"
                        alt="">
                </div>
                <div class="custom-control custom-switch mb-5">
                    <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch"
                        data-appStyle="assets/css/app-rtl.min.css" />
                    <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('public/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('public/assets/js/pages/sweet-alerts.init.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('public/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- twitter-bootstrap-wizard js -->
    <script src="{{ asset('public/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('public/assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <!-- form wizard init -->
    <script src="{{ asset('public/assets/js/pages/form-wizard.init.js') }}"></script>

    <script src="{{ asset('public/assets/js/pages/dashboard.init.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('public/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- advanced inputs js -->
    <script src="{{ asset('public/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/form-advanced.init.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('public/assets/js/pages/datatables.init.js') }}"></script>
    <!-- Saas dashboard init -->
    <script src="{{ asset('public/assets/js/pages/saas-dashboard.init.js') }}"></script>
    <!-- Form validation -->
    <script src="{{ asset('public/assets/js/pages/form-validation.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('public/bower_components/toastr/toastr.min.js') }}"></script>

    <!-- maskMoney -->
    <script src="{{ asset('public/bower_components/jquery/dist/jquery.maskMoney.js') }}"></script>

    <!-- Axios -->
    <script src="{{ asset('public/bower_components/axios/dist/axios.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('public/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- apexcharts init -->
    <script src="{{ asset('public/assets/js/pages/apexcharts.init.js') }}"></script>
    <script>
        var base_url = "{{ url('') }}";
    </script>
    <!-- Script da aplicaço -->

    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select2').select2();
            $(".mask-money").maskMoney({
                symbol: 'R$ ',
                thousands: '.',
                decimal: ',',
                symbolStay: true,
                allowNegative: true
            });
        });
    </script>

    <script src="{{ asset('public/assets/js/app/utilizador.js') }}"></script>
    <script src="{{ asset('public/assets/js/app/stock.js') }}"></script>
    <script src="{{ asset('public/assets/js/script.js') }}"></script>
    <script src="{{ asset('public/assets/js/script_artigo.js') }}"></script>
    <script src="{{ asset('public/assets/js/script_documento.js') }}"></script>
    <script src="{{ asset('public/assets/js/script_stock.js') }}"></script>
    @yield('js')

    @include('includes.alerts')
</body>

</html>
