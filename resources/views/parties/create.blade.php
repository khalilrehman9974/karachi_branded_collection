@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($party) ? 'Edit Party' : 'Create New Party' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('party.parties') }}">List of Parties</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($party) ? 'Edit Party' : 'Create New Party' }}</li>
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
              action="{{ !empty($party) ? route('party.update') : route('party.store') }}">
            @csrf
            <input type="hidden" name="partyId" id="partyId" value="{{ @$party->id }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label><span style="color:red">*</span>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', @$party->name) }}"
                                               maxlength="200">
                                        @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email"
                                               class="form-control"
                                               value="{{ old('email', @$party->email) }}"
                                               maxlength="70">
                                        @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="phone_no">Phone Number</label>
                                        <input type="text" name="phone_no" id="phone_no" class="form-control"
                                               value="{{ old('phone_no', @$party->phone_no) }}"
                                               maxlength="100">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="mobile_no">Mobile Number</label><span style="color:red">*</span>
                                        <input type="text" name="mobile_no" id="mobile_no"
                                               class="form-control"
                                               value="{{ old('mobile_no', @$party->mobile_no) }}"
                                               maxlength="100">
                                        @error('mobile_no')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="whatsapp_no">Whatsapp Number</label><span style="color:red">*</span>
                                        <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control"
                                               value="{{ old('whatsapp_no', @$party->whatsapp_no) }}"
                                               maxlength="70">
                                        @error('whatsapp_no')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="city">City</label><span style="color:red">*</span>
                                        <input type="text" name="city" id="city"
                                               class="form-control"
                                               value="{{ old('city', @$party->city) }}"
                                               maxlength="70">
                                        @error('city')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mailing_address">Mailing Address</label><span style="color:red">*</span>
                                        <textarea name="mailing_address" id="mailing_address" class="form-control"
                                               maxlength="250" rows="4">{{ old('mailing_address', @$party->mailing_address) }}</textarea>
                                        @error('mailing_address')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="shipping_address">Shipping Address</label><span style="color:red">*</span>
                                        <textarea name="shipping_address" id="shipping_address"
                                               class="form-control"
                                               maxlength="250" rows="4">{{ old('shipping_address', @$party->shipping_address) }}</textarea>
                                        @error('shipping_address')
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
                        <input type="submit" value="{{ !empty($party) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('party.parties') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/party.js') }}"></script>
@endsection
