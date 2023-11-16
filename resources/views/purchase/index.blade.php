@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>List of Purchases</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List of Purchases</li>
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
                    <form method="get" action="{{ route('purchase.purchases') }}">
                        <!-- Another variation with a button -->
                        <div class="input-group col-md-12 float-right">
                            <div class="form-group col-md-3">
                                <div class="input-group-prepend">
                                    <input type="text" name="param" id="param" class="form-control clearable"
                                           value="{{ @$request['param'] }}" placeholder="Search Purchase">
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
                <a href="{{ route('purchase.create') }}"  class="form-control btn btn-primary"  type="button">
                    New Purchase
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
                            <th>Brand</th>
                            <th>Party</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$purchases->isEmpty())
                            @foreach($purchases as $purchase)
                                <tr class="purchase{{ $purchase->id }}">
                                    <td>{{ \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') }}</td>
                                    <td>{{ $purchase->brand->name }}</td>
                                    <td> {{ $purchase->party->name }}</td>
                                    <td> {{ $purchase->amount }}</td>
                                    <td class="project-actions float-right">
                                        <a class="btn btn-primary btn-sm" target="_blank"
                                           href="{{ route('purchase.view',$purchase->id) }}"
                                           id="view-package1" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('purchase.edit', $purchase->id) }}"
                                           data-id="{{ $purchase->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm delete"
                                           href="javascript:void(0)"
                                           data-id="{{ $purchase->id }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"><strong>No purchase data</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="float-left">
                <b>Total Records: </b> {{ $purchases->total() }}
            </div>
            <div class="float-right">
                <nav>
                    <ul>
                        {!! $purchases->setPath('')->appends(\Illuminate\Support\Facades\Request::query())->links() !!}
                    </ul>
                </nav>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ asset('js/purchase.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        // global routes configuration object
        var config = {
            routes: {
                deletePurchase: "{{ url('purchase/delete') }}",
            },
            totalRecords: {{  $purchases->total() }}
        };

    </script>
@endsection
