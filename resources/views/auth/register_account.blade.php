<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('piblic/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        body {
            overflow: hidden;
            /*background-image: url('public/assets/images/fundo.jpg');*/
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
        
                        <div class="card-body pt-0">
                           <div>
                                <a href="{{ route('login') }}">
                                    <div class="savatar-md sprofile-user-swid mb-2">
                                        <span class="savatar-title srounded-circle bg-light">
                                            <img src="{{ asset('public/assets/logo.png') }}" alt=""
                                                class="srounded-circle" height="134">
                                        </span>
                                      
                                      <br>
                                      <div class="text-primary p-2">
                                        <p>Entre e continue com  plataforma de Faturação  da  {{ config('app.name') }}.</p>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ route('register_company') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="designacao">Empresa (*)</label>
                                        <input type="text" required name="designacao" class="form-control" id="designacao"
                                            placeholder="Insira o nome da empresa">
                                        @if ($errors->has('designacao'))
                                            <p style="color: red">Empresa obrigatório/invalido<p>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="designacao">NIF (*)</label>
                                        <input type="text" required name="nif" class="form-control" id="nif"
                                            placeholder="Insira o nif da empresa">
                                        @if ($errors->has('nif'))
                                            <p style="color: red">NIF obrigatório/invalido<p>
                                        @endif
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="representante">Representante (*)</label>
                                        <input type="text" name="representante" required class="form-control" id="representante"
                                            placeholder="Responsavel da empresa">
                                    </div>

                                    

                                    <div class="form-group">
                                        <label for="username">Email (*)</label>
                                        <input type="text" name="email" required class="form-control" id="username"
                                            placeholder="Insira o seu email">
                                        @if ($errors->has('email'))
                                            <p style="color: red">Email obrigatório/invalido<p>
                                        @endif
                                    </div>
                                  
                                  <div class="form-group">
                                        <label for="designacao">Nº Telefone (*)</label>
                                        <input type="text" name="telefone" required class="form-control" id="nif"
                                            placeholder="Insira o numero de telefone">
                                        @if ($errors->has('telefone'))
                                            <p style="color: red">Telefone obrigatório/invalido<p>
                                        @endif
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="username">Senha</label>
                                        <input type="text" disabled readonly class="form-control" id="" placeholder="12345678">
                                    </div>

                                  
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light"
                                            type="submit">Cadastrar</button>
                                            <p class="mt-3">Caso tem sua empresa registrada <a href="{{url('login')}}" class="font-weight-medium text-primary"> Clique aqui </a> </p>
                                    </div>



                                 
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                           {{----}}
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Design & Develop by <i class="mdi mdi-heart text-danger"></i>
                            Átomo Tecnologias
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
</body>

</html>
