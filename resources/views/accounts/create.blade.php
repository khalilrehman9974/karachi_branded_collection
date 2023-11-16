@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($account) ? 'Edit Account' : 'Create New Account' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('account.accounts') }}">List of Accounts</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($account) ? 'Edit Account' : 'Create New Account' }}</li>
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
              action="{{ !empty($account) ? route('account.update') : route('account.store') }}">
            @csrf
            <input type="hidden" name="accountId" id="accountId" value="{{ @$account->id }}"/>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Account Type</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="account_type"
                                                id="account_type">
                                            <option value="">Select</option>
                                            @foreach($accountTypes as $key=>$value)
                                                <option
                                                    value="{{ $key }}" {{!empty($account) && ($account->account_type === $key) ? "selected" : ''}} {{($key == old('account_type')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('account_type')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label><span style="color:red">*</span>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', @$account->name) }}"
                                               maxlength="200">
                                        @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!isset($account) || @$account->account_type == 'P' || @$account->account_type == 'S')
                                        <div class="form-group col-md-6" id="email-div">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                   class="form-control"
                                                   value="{{ old('email', @$account->email) }}"
                                                   maxlength="70">
                                            @error('email')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                                @if(!isset($account) || @$account->account_type == 'P' || @$account->account_type == 'S')

                                    <div class="row">
                                        <div class="form-group col-md-6" id="phone-div">
                                            <label for="phone_no">Phone Number</label>
                                            <input type="text" name="phone_no" id="phone_no" class="form-control"
                                                   value="{{ old('phone_no', @$account->phone_no) }}"
                                                   maxlength="100" onkeypress="return isNumber(event)">
                                        </div>
                                        <div class="form-group col-md-6" id="mobile-div">
                                            <label for="mobile_no">Mobile Number</label><span style="color:red">*</span>
                                            <input type="text" name="mobile_no" id="mobile_no"
                                                   class="form-control"
                                                   value="{{ old('mobile_no', @$account->mobile_no) }}"
                                                   maxlength="100" onkeypress="return isNumber(event)">
                                            @error('mobile_no')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if(!isset($account) || @$account->account_type == 'P' || @$account->account_type == 'S')
                                    <div class="row">
                                        <div class="form-group col-md-6" id="whatsapp-div">
                                            <label for="whatsapp_no">Whatsapp Number</label><span
                                                style="color:red">*</span>
                                            <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control"
                                                   value="{{ old('whatsapp_no', @$account->whatsapp_no) }}"
                                                   maxlength="70" onkeypress="return isNumber(event)">
                                            @error('whatsapp_no')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6" id="city-div">
                                            <label for="city">City</label><span style="color:red">*</span>
                                            <input type="text" name="city" id="city"
                                                   class="form-control"
                                                   value="{{ old('city', @$account->city) }}"
                                                   maxlength="70">
                                            @error('city')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if(!isset($account) || @$account->account_type == 'P' || @$account->account_type == 'S')
                                    <div class="row">
                                        <div class="form-group col-md-6" id="mailingAddress-div">
                                            <label for="mailing_address">Mailing Address</label><span style="color:red">*</span>
                                            <textarea name="mailing_address" id="mailing_address" class="form-control"
                                                      maxlength="250"
                                                      rows="4">{{ old('mailing_address', @$account->mailing_address) }}</textarea>
                                            @error('mailing_address')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6" id="shippingAddress-div">
                                            <label for="shipping_address">Shipping Address</label><span
                                                style="color:red">*</span>
                                            <textarea name="shipping_address" id="shipping_address"
                                                      class="form-control"
                                                      maxlength="250"
                                                      rows="4">{{ old('shipping_address', @$account->shipping_address) }}</textarea>
                                            @error('shipping_address')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-12" style="text-align: right;">
                        <input type="submit" value="{{ !empty($account) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('account.accounts') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/account.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
