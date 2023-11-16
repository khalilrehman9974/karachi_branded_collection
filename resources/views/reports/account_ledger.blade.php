@extends('layouts.app')
@section('content')
    <style>
       /* table tr {
            overflow: hidden;
            height: 14px;
            white-space: nowrap;
        }*/
        table  tr {
            line-height: 7px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> Account Ledger</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Account Ledger
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
              action="{{ route('account-ledger.view') }}">
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
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
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Account</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="account_id"
                                                id="account_id">
                                            <option value="">Select</option>
                                            @foreach($accounts['accounts'] as $key=>$value)
                                                <option value="{{ $key }}" {{!empty($params) && ($params['account_id'] === $key) ? "selected" : ''}}  {{($key == old('account_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('account_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-3">
                                        <label for="mobile_number">Mobile Number</label>
                                        <input type="text" name="mobile_number" id="mobile_number" class="form-control"
                                               value="{{ !empty($params) ? $params['mobile_number'] : "" }}"
                                               maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Voucher/Invoice No</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data)
                                <tr hidden>{{
                                    $totalDebit = null,
                                    $totalCredit = null
                                }}</tr>
                                @foreach($data as $row)
                                    <tr>
                                        <td>{{ $row->date }}</td>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>{{ $row->debit }}</td>
                                        <td>{{ $row->credit }}</td>
                                        <td>{{ ($totalDebit += $row->debit) - ($totalCredit += $row->credit) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><strong>No ledger data</strong></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="row clearfix">
                    <div class="col-12" style="text-align: right;">
                        <input type="submit" value="View" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <input type="button" value="Print" class="btn btn-success">
                        <a href="{{ route('account-ledger.ledger') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
