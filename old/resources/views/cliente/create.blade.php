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
    <!-- end page title -->
    <!-- start row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST"
                        action="{{ url('' . Request::segment(1) . '/store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <label for="nome">Imagem</label>
                                <label class=newbtn>
                                    <img id="blah" src='{{ asset('public/upload/null.png') }}' width="100%">
                                    <input id="pic" name="file" class='pis' onchange="readURL(this);"
                                        type="file">
                                </label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="nome">Código</label>
                                    <input type="text" class="form-control" name="codigo" placeholder="Escreva..."
                                        value="{{ $codigo }}" readonly>

                                </div>

                                <div class="form-group">
                                    <label for="nome">Designação</label>
                                    <input type="text" class="form-control" name="designacao" placeholder="Escreva..."
                                        value="" required>

                                </div>

                                <div class="form-group">
                                    <label for="nome">Contribuinte</label>
                                    <input type="text" class="form-control" name="contribuinte" placeholder="Escreva..."
                                         required>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12">

                            <div id="accordion">
                                <div class="card mb-1 shadow-none">
                                    <div class="card-header bg-primary" id="headingOne">
                                        <h6 class="m-0">
                                            <a href="#collapseOne" class="text-dark" data-toggle="collapse"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                > Endereço
                                            </a>
                                        </h6>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">País</label>
                                                        <select name="pais" class="form-control select2">
                                                            @foreach (\App\Pais::all() as $item)
                                                                <option value="{{ $item->designacao }}">
                                                                    {{ $item->designacao }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Cidade</label>
                                                        <input type="text" class="form-control" name="cidade"
                                                            placeholder="Escreva...">

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nome">Endereço</label>
                                                        <input type="text" class="form-control" name="endereco"
                                                            placeholder="Escreva..." required>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-1 shadow-none">
                                    <div class="card-header bg-primary" id="headingTwo">
                                        <h6 class="m-0">
                                            <a href="#collapseTwo" class="text-dark collapsed" data-toggle="collapse"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                > Contacto
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nome">Telemovel</label>
                                                        <input type="text" class="form-control" name="telemovel"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nome">Contacto</label>
                                                        <input type="text" class="form-control" name="contacto"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nome">Telefone</label>
                                                        <input type="text" class="form-control" name="telefone"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Fax</label>
                                                        <input type="text" class="form-control" name="fax"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Email</label>
                                                        <input type="text" class="form-control" name="email"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Facebook</label>
                                                        <input type="text" class="form-control" name="facebook"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Whatsapp</label>
                                                        <input type="text" class="form-control" name="whatsapp"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nome">Skype</label>
                                                        <input type="text" class="form-control" name="skype"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nome">Twitter</label>
                                                        <input type="text" class="form-control" name="twitter"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nome">Linkedin</label>
                                                        <input type="text" class="form-control" name="linkedin"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nome">Web Site</label>
                                                        <input type="text" class="form-control" name="website"
                                                            placeholder="Escreva..." value="">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Observação</label>
                                    <textarea class="form-control" name="observacao" style="margin: 0px -17.6563px 0px 0px;  height: 143px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div
                                        class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-info mb-3">
                                        <input type="checkbox" class="custom-control-input" id="isoculto"
                                            name="status">
                                        <label class="custom-control-label" for="isoculto">Activo?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Salvar</button>
                        <a href="{{ url('' . Request::segment(1) . '') }}" class="btn btn-warning"
                            type="submit">Cancelar</a>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
