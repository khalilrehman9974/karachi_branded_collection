@extends('layouts.app')
@section('content')
    <style>
        /* table tr {
             overflow: hidden;
             height: 14px;
             white-space: nowrap;
         }*/
        table tr {
            line-height: 7px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> Stock Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Stock Report
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif

        <form method="GET"
              action="{{ route('stock.view') }}">
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    {{--<div class="form-group col-md-3">
                                        <label>From Date</label>
                                        <div class="input-group date" id="date"
                                             data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input date"
                                                   name="from_date" id="from-date"
                                                   data-target="#from-date"
                                                   value="{{ empty( $cpv->date) ? null :  \Illuminate\Support\Carbon::parse(  $cpv->date)->format('d-m-Y')}}"}}/>
                                            <div class="input-group-append" data-target="#from-date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            @error('from-date')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>To Date</label>
                                        <div class="input-group date" id="date"
                                             data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input date"
                                                   name="to_date" id="to-date"
                                                   data-target="#to-date"
                                                   value="{{ empty( $cpv->date) ? null :  \Illuminate\Support\Carbon::parse(  $cpv->date)->format('d-m-Y')}}"}}/>
                                            <div class="input-group-append" data-target="#to-date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            @error('to-date')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>--}}
                                    <div class="form-group col-md-4">
                                        <label>Product</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="product_id"
                                                id="product_id">
                                            <option value="">Select</option>
                                            @foreach($products['products'] as $key=>$value)
                                                <option
                                                    value="{{ $key }}" {{($key == old('product_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div id="print-area">
                    <h3 style="text-align: center"><u>Stock Report</u></h3>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Purchased Quantity</th>
                                    <th>Sold Quantity</th>
                                    <th>Stock Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($stockData)
                                    @foreach($stockData as $row)
                                        <tr>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->debit_quantity }}</td>
                                            <td>{{ $row->credit_quantity }}</td>
                                            <td>{{ $row->balance }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"><strong>Item data not found</strong></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-12" style="text-align: right;">
                        <input type="submit" value="View" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <input type="button" value="Print" onclick="printDiv()" class="btn btn-success">
                        <a href="{{ route('stock.report') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/stock.js') }}"></script>
@endsection
