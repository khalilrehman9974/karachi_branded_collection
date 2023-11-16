@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>List of Bank Payment Vouchers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List of Bank Payment Vouchers</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
            <div class="row">
                <div class="main col-md-12 float-right">
                    <form method="get" action="{{ route('bpv.list') }}">
                        <!-- Another variation with a button -->
                        <div class="input-group col-md-12 float-right">
                            <div class="form-group col-md-3">
                                <div class="input-group-prepend">
                                    <input type="text" name="param" id="param" class="form-control clearable"
                                           value="{{ @$request['param'] }}" placeholder="Search Bank Payment Voucher">
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-success" type="submit"
                                        style="background-color: #007bff; height: 38px">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="input-group-append col-md-6">
                                <div class="btn-group" role="group">
                                    <button class="form-control btn btn-secondary" id="clear-filter" type="submit">
                                        Clear Filter
                                    </button>
                                </div>
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>

                                {{--<div class="btn-group btn-export" role="group">
                                    <button class="form-control btn btn-info" id="export" type="button">
                                        Download in Excel
                                    </button>
                                </div>
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>

                                <div class="btn-group" role="group" style="margin-left: 5px">
                                    <a href="{{ route('contracts.excel.download') }}"  class="form-control btn btn-primary"  type="button">
                                        Download Excel File
                                    </a>
                                </div>--}}
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="btn-group float-right" role="group">
                <a href="{{ route('bpv.create') }}"  class="form-control btn btn-primary"  type="button">
                    New Bank Payment voucher
                </a>
            </div>
            <br>
            <br>
            <!-- Default box -->
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Bank Account</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$bpvs->isEmpty())
                            @foreach($bpvs as $bpv)
{{--                                {{ dd($bpv) }}--}}
                                <tr class="bpv{{ $bpv->id }}">
                                    <td>{{ \Carbon\Carbon::parse($bpv->date)->format('d-m-Y') }}</td>
                                    <td>
                                      {{ $bpv->bank->name }}
                                    </td>
                                    <td> {{ $bpv->description }}</td>
                                    <td> {{ $bpv->credit }}</td>
                                    <td class="project-actions float-right">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('bpv.edit', $bpv->id) }}"
                                           data-id="{{ $bpv->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm deleteVoucher"
                                           href="javascript:void(0)"
                                           data-id="{{ $bpv->voucher_number }}" data-type="{{ $bpv->transaction_type }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"><strong>No bank payment data</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="float-left">
                <b>Total Records: </b> {{ $bpvs->total() }}
            </div>
            <div class="float-right">
                <nav>
                    <ul>
                        {!! $bpvs->setPath('')->appends(\Illuminate\Support\Facades\Request::query())->links() !!}
                    </ul>
                </nav>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ asset('js/common.js') }}"></script>
    <script>

        // global routes configuration object
        var config = {
            routes: {
                deleteVoucher: "{{ url('bpv/delete') }}",
            },
            totalRecords: {{  $bpvs->total() }}
        };

    </script>
@endsection