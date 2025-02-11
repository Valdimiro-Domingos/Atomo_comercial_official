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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nome">AuditFileVersion</label>
                                    <input type="text" class="form-control" name="audit_file_version" placeholder="Escreva..."
                                        value="" required>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="nome">CompanyID</label>
                                    <input type="text" class="form-control" name="company_id" placeholder="Escreva..."
                                        value="" required>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="nome">TaxRegistrationNumber</label>
                                    <input type="text" class="form-control" name="tax_registration_number" placeholder="Escreva..."
                                        value="" required>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="nome">TaxAccountingBasis</label>
                                    <input type="text" class="form-control" name="tax_accounting_basis" placeholder="Escreva..."
                                        value="" required>
                                    
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
