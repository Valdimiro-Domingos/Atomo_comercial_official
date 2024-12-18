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
                                        <p>Entre e continue com á plataforma de Faturação  da  {{ config('app.name') }}.</p>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <input type="text" name="email" class="form-control" id="username"
                                            placeholder="Insira o seu email">
                                        @if ($errors->has('email'))
                                            <p style="color: red">{{ $errors->first('email') }}<p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">Palavra-Passe</label>
                                        <input type="password" name="password" class="form-control" id="userpassword"
                                            placeholder="Insira a sua palavra-passes">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @if ($errors->has('password'))
                                                {{ $errors->first('password') }}
                                            @endif
                                        @enderror
                                    </div>

                                    {{-- <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                                        </div> --}}

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light"
                                            type="submit">Entrar</button>

                                            <p class="mt-3">Ainda no tem sua empresa registrada ? <a href="{{url('register')}}" class="font-weight-medium text-primary"> Clique aqui </a> </p>
                                    </div>
                                    
                                                     <!-- Mensagem de Pagamento -->
                                    @if (session('payment'))
                                        <div class="alert alert-info">
                                            {{ session('payment') }}
                                        </div>
                                    @endif
                                    <!-- Mensagem de Pagamento -->
                                    @if (session('company'))
                                        <div class="alert alert-info">
                                            {{ session('company') }}
                                        </div>
                                    @endif




                                    {{-- <div class="mt-4 text-center">
                                            <h5 class="font-size-14 mb-3">Sign in with</h5>
            
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="javascript::void()" class="social-list-item bg-primary text-white border-primary">
                                                        <i class="mdi mdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript::void()" class="social-list-item bg-info text-white border-info">
                                                        <i class="mdi mdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript::void()" class="social-list-item bg-danger text-white border-danger">
                                                        <i class="mdi mdi-google"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                        </div> --}}
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
