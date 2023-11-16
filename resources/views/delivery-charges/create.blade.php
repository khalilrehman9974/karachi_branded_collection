@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($deliveryCharges) ? 'Edit Delivery Charges' : 'Create New Delivery Charges' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('delivery-charges.dc-list') }}">List of Delivery Charges</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($deliveryCharges) ? 'Edit Delivery Charges' : 'Create New Delivery Charges' }}</li>
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
              action="{{ !empty($deliveryCharges) ? route('delivery-charges.update') : route('delivery-charges.store') }}">
            @csrf
            <input type="hidden" name="deliveryChargesId" id="deliveryChargesId" value="{{ @$deliveryCharges->id }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Shipment Type</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="shipment_type_id"
                                                id="shipment_type_id">
                                            <option value="">Select</option>
                                            @foreach($shipmentTypes as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('shipment_type_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Zone</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="zone_id"
                                                id="zone_id">
                                            <option value="">Select</option>
                                            @foreach($zones as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('zone_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fuel_percentage">Fuel%</label>
                                        <input type="text" name="fuel_percentage" id="fuel_percentage" class="form-control"
                                               value="{{ old('fuel_percentage', @$deliveryCharges->fuel_percentage) }}"
                                               maxlength="100" onkeypress="return isNumber(event)">
                                        @error('fuel_percentage')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gst_percentage">GST%</label><span style="color:red">*</span>
                                        <input type="text" name="gst_percentage" id="gst_percentage"
                                               class="form-control"
                                               value="{{ old('gst_percentage', @$deliveryCharges->gst_percentage) }}"
                                               maxlength="100" onkeypress="return isNumber(event)">
                                        @error('gst_percentage')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="additional_kg_charges">Additional Kg Charges</label><span style="color:red">*</span>
                                        <input type="text" name="additional_kg_charges" id="additional_kg_charges" class="form-control"
                                               value="{{ old('additional_kg_charges', @$deliveryCharges->additional_kg_charges) }}"
                                               maxlength="70" onkeypress="return isNumber(event)">
                                        @error('additional_kg_charges')
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
                        <input type="submit" value="{{ !empty($deliveryCharges) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('customer.customers') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/customer.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
