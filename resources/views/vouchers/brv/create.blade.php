@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($brv) ? 'Edit Bank Receipt Voucher' : 'Bank Receipt Voucher' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('brv.list') }}">List of Bank Receipt Vouchers</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($brv) ? 'Edit Bank Receipt Voucher' : 'Bank Receipt Voucher' }}</li>
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

        <form method="post"
              action="{{ !empty($brv) ? route('brv.update') : route('brv.save') }}">
            @csrf
            <input type="hidden" name="brvId" id="brvId" value="{{ @$brv->voucher_number }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Date</label>
                                        <div class="input-group date" id="date"
                                             data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input date"
                                                   name="date" id="bpv-date"
                                                   data-target="#bpv-date"
                                                   value="{{ empty( $brv->date) ? null :  \Illuminate\Support\Carbon::parse(  $brv->date)->format('d-m-Y')}}"}}/>
                                            <div class="input-group-append" data-target="#bpv-date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('date')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Bank</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="bank_id"
                                                id="bank_id">
                                            <option value="">Select</option>
                                            @foreach($dropDownData['banks'] as $key=>$value)
                                                <option value="{{ $key }}" {{!empty($brv) && ($brv->account_id === $key) ? "selected" : ''}} {{($key == old('account_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Account</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="account_id"
                                                id="account_id">
                                            <option value="">Select</option>
                                            @foreach($dropDownData['accounts'] as $key=>$value)
                                                <option value="{{ $key }}" {{!empty($brv) && ($party->account_id === $key) ? "selected" : ''}} {{($key == old('account_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('account_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                <div class="form-group col-md-8">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" id="description" value="">{{ @$brv->description }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="cheque_number">Cheque Number</label>
                                        <input type="text" name="cheque_number" id="cheque_number" class="form-control" onkeypress="return isNumber(event)"
                                               value="{{ old('cheque_number', @$brv->cheque_number) }}"
                                               maxlength="20">
                                        @error('cheque_number')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>
                                <div class="form-group col-md-3">
                                    <label for="credit">Amount</label>
                                    <input type="text" name="credit" id="credit" class="form-control" onkeypress="return isNumber(event)"
                                           value="{{ old('debit', @$brv->debit) }}"
                                           maxlength="20">
                                    @error('credit')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror

                                </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-12" style="text-align: right;">
                        <input type="submit" value="{{ !empty($brv) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('brv.list') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
