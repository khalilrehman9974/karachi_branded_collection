@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($bank) ? 'Edit Bank' : 'Create New Bank' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bank.list') }}">List of Banks</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($bank) ? 'Edit Bank' : 'Create Bank' }}</li>
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
              action="{{ !empty($bank) ? route('bank.update') : route('bank.save') }}">
            @csrf
            <input type="hidden" name="bankId" id="bankId" value="{{ @$bank->id }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="account_title">Account Title</label><span style="color:red">*</span>
                                        <input type="text" name="account_title" id="account_title" class="form-control"
                                               value="{{ old('name', @$bank->account_title) }}"
                                               maxlength="200">
                                        @error('account_title')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="account_number">Account Number</label><span style="color:red">*</span>
                                        <input type="text" name="account_number" id="account_number" class="form-control"
                                               value="{{ old('account_number', @$bank->account_number) }}"
                                               maxlength="200">
                                        @error('account_number')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Bank Name</label><span style="color:red">*</span>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', @$bank->name) }}"
                                               maxlength="200">
                                        @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="branch_name">Branch Name</label><span style="color:red">*</span>
                                        <input type="text" name="branch_name" id="branch_name" class="form-control"
                                               value="{{ old('branch_name', @$bank->branch_name) }}"
                                               maxlength="200">
                                        @error('branch_name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="branch_code">Branch Code</label><span style="color:red">*</span>
                                        <input type="text" name="branch_code" id="branch_code" class="form-control"
                                               value="{{ old('branch_code', @$bank->branch_code) }}"
                                               maxlength="200">
                                        @error('branch_code')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               value="{{ old('phone', @$bank->phone) }}"
                                               maxlength="200">
                                        @error('phone')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                               value="{{ old('address', @$bank->address) }}"
                                               maxlength="200">
                                        @error('address')
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
                        <input type="submit" value="{{ !empty($bank) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('bank.list') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
