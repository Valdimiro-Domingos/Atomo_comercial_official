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

    <!-- start -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="float: right; margin-bottom: 1em;">
                        <a href="{{ url('' . Request::segment(1) . '/create') }}" class="btn btn-success"><i
                                class="fa fa-plus font-size-16 align-middle mr-2"></i>NOVO</a>
                    </div> --}}
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>AuditFileVersion</th>
                                        <th>CompanyID</th>
                                        <th>TaxRegistrationNumber</th>
                                        <th>TaxAccountingBasis</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dados as $item)
                                        <tr>
                                            <td>{{ $item->audit_file_version }}</td>
                                            <td>{{ $item->company_id }}</td>
                                            <td>{{ $item->tax_registration_number }}</td>
                                            <td>{{ $item->tax_accounting_basis }}</td>
                                            <td>
                                    
                                                <a href='{{ url('' . Request::segment(1) . "/edit/{$item->id}") }}'
                                                    class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                               {{--  <a class="btn btn-danger btn-xs" href="#" data-rel="tooltip"
                                                    data-placement="top" title="Eliminar" data-toggle="modal"
                                                    data-target="#delete{{ $item->id }}"><i
                                                        class="fa fa-trash"></i></a> --}}
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
