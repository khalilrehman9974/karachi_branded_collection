@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($purchaseReturn) ? 'Edit Purchase Return Entry' : 'Create New Purchase Return' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('purchase-return.purchases') }}">List of all
                                    Purchase Return</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($purchaseReturn) ? 'Edit Purchase Return' : 'Create New Purchase Return' }}</li>
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
              action="{{ !empty($purchaseReturnReturn) ? route('purchase-return.update') : route('purchase-return.store') }}" id="frmPurchaseReturn">
            @csrf
            <input type="hidden" name="purchaseReturnId" id="purchaseReturnId" value="{{ @$purchaseReturnReturn->id }}"/>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Date</label>
                                        <div class="input-group date" id="date"
                                             data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input date"
                                                   name="date" id="purchase-date"
                                                   data-target="#purchase-date"
                                                   value="{{ empty( $purchaseReturn->date) ? null :  \Illuminate\Support\Carbon::parse(  $purchaseReturn->date)->format('d-m-Y')}}"}}/>
                                            <div class="input-group-append" data-target="#purchase-date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            @error('date')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Party</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="party_id"
                                                id="party_id">
                                            <option value="">Select</option>
                                            @foreach($parties as $key=>$value)
                                                <option value="{{ $key }}" {{!empty($purchaseReturn) && ($purchaseReturn->party_id === $key) ? "selected" : ''}} {{($key == old('party_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('party_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Brand</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="brand_id"
                                                id="brand_id">
                                            <option value="">Select</option>
                                            @foreach($brands as $key=>$value)
                                                <option value="{{ $key }}"  {{!empty($purchaseReturn) && ($purchaseReturn->brand_id === $key) ? "selected" : ''}} {{($key == old('brand_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks" id="remarks" value=""></textarea>
                                </div>
                                </div>
                            <div class="m-l-r-15">
                                <div class="card">
                                    <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead class="text-nowrap">
                                                <tr>
                                                    <th></th>
                                                    {{--                                                    <th><input type="checkbox" checked></th>--}}
                                                    <th>Item</th>
                                                    <th>Rate</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th width="50px">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                @if(!empty($purchaseReturnDetails))
                                                    @foreach($purchaseReturnDetails as $productDetail)
                                                        <tr class="tr_clone validator_0">
                                                            <td><input type="checkbox" name="row_id[]" class="row_id"
                                                                       value="0" hidden></td>
                                                            <td><select class="form-control select2 product_id product_id"
                                                                        style="width: 300px"
                                                                        name="product_id[]" value="{{!empty($productDetail) && ($productDetail->product_id === $key) ? "selected" : ''}}" data-uom=""
                                                                        data-item-number="">
                                                                    <option value="">Select</option>
                                                                    @foreach($products as $key=>$value)
                                                                        <option value="{{ $key }}"  {{!empty($productDetail) && ($productDetail->product_id === $key) ? "selected" : ''}} {{($key == old('product_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div><span class="spinner-border spinner-border-sm"
                                                                           id="product_id-spinner"
                                                                           style="margin-top: -26px; margin-left: 306px; display: none"></span>
                                                                </div>
                                                            </td>
                                                            <td><input type="text" name="price[]" class="form-control price"
                                                                       value="{{ $productDetail->price }}" onkeypress="return isNumber(event)"
                                                                       style="width: 150px" id="price"></td>
                                                            <td><input type="text" name="quantity[]"
                                                                       class="form-control quantity"
                                                                       onkeypress="return isNumber(event)"
                                                                       style="width: 150px"
                                                                       id="quantity" value="{{ $productDetail->quantity }}"></td>
                                                            <td><input type="text" name="amount[]" class="form-control amount"
                                                                       value="{{ $productDetail->amount }}"
                                                                       style="width: 190px" readonly>
                                                            </td>
                                                            <td class="project-actions float-right" style="width: 200px">
                                                                <button class="btn btn-primary btn-sm btn-duplicate"
                                                                        title="Create">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                                <button class="btn btn-primary btn-sm delete-row delete_row_0"
                                                                        title="Delete Row">
                                                                    <i class="fas fa-remove"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                @else
                                                    <tr class="tr_clone validator_0">
                                                        <td><input type="checkbox" name="row_id[]" class="row_id"
                                                                   value="0" hidden></td>
                                                        <td><select class="form-control select2 product_id product_id_0"
                                                                    style="width: 300px"
                                                                    name="product_id[]" value="" data-uom=""
                                                                    data-item-number="">
                                                            </select>
                                                            @error('product_id')
                                                            <div class="error-message">{{ $message }}</div>
                                                            @enderror
                                                            <div><span class="spinner-border spinner-border-sm product_id"
                                                                       id="product_id-spinner"
                                                                       style="margin-top: -26px; margin-left: 306px; display: none"></span>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="price[]" class="form-control price price_0"
                                                                   value="" onkeypress="return isNumber(event)"
                                                                   style="width: 150px" id="price"></td>
                                                        <td><input type="text" name="quantity[]"
                                                                   class="form-control quantity quantity_0"
                                                                   onkeypress="return isNumber(event)"
                                                                   style="width: 150px"
                                                                   id="quantity" value=""></td>
                                                        <td><input type="text" name="amount[]" class="form-control amount amount_0"
                                                                   value=""
                                                                   style="width: 190px" readonly>
                                                        </td>
                                                        <td class="project-actions float-right" style="width: 200px">
                                                            <button class="btn btn-primary btn-sm btn-duplicate"
                                                                    title="Create">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <button class="btn btn-primary btn-sm delete-row delete_row_0"
                                                                    title="Delete Row" style="display: none">
                                                                <i class="fas fa-remove"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    <!-- /.card-body -->
                                </div>

                                <table class="table table-striped">
                                    <thead class="text-nowrap">
                                    <tr>
                                        {{--                                                    <th><input type="checkbox" checked></th>--}}
                                        {{--<th>Item</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th width="50px">Actions</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                    <tr class="tr_clone validator_0">
                                        <td></td>
                                        <td></td>

                                        <td><input type="text" name="totalQty"
                                                   class="form-control totalQty" id="totalQty"
                                                   style="width: 150px; margin-left:447px"
                                                   id="quantity" value="{{!empty($purchaseReturn) ? $purchaseReturn->quantity : ''}}"></td>
                                        <td><input type="text" name="totalAmount" id="totalAmount" class="form-control totalAmount"
                                                   value="{{!empty($purchaseReturn) ? $purchaseReturn->amount : ''}}"
                                                   style="width: 190px; margin-right:179px" readonly>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="float-left">
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-12" style="text-align: right;">
                        <input type="button" value="{{ !empty($purchaseReturn) ? 'Update' : 'Save' }}" id="save" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('purchase-return.purchases') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/purchase-return.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        // global routes configuration object
        var config = {
            routes: {
                getBrandProducts: "{{ url('purchase-return/get/brand-products') }}",
                getProductDetail: "{{ url('purchase-return/get/product-detail') }}",
            },
        };
    </script>
@endsection
