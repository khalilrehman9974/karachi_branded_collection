@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($product) ? 'Edit Product' : 'Create New Product' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product.products') }}">List of Products</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($product) ? 'Edit Product' : 'Create New Product' }}</li>
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
              action="{{ !empty($product) ? route('product.update') : route('product.store') }}">
            @csrf
            <input type="hidden" name="productId" id="productId" value="{{ @$product->id }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Brand</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="brand_id"
                                                id="brand_id">
                                            <option value="">Select</option>
                                            @foreach($brands as $key=>$value)
                                                <option value="{{ $key }}" {{!empty($product) && ($product->brand_id === $key) ? "selected" : ''}} {{($key == old('brand_id')) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', @$product->name) }}"
                                               maxlength="100">
                                        @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="price">Purchase Price</label><span style="color:red">*</span>
                                        <input type="text" name="price" id="price"
                                               class="form-control"
                                               value="{{ old('price', @$product->price) }}" return onkeypress="isNumber()"
                                               maxlength="10">
                                        @error('price')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">Sale Price</label><span style="color:red">*</span>
                                        <input type="text" name="sale_price" id="sale_price" class="form-control"
                                               value="{{ old('sale_price', @$product->sale_price) }}"
                                               maxlength="10">
                                        @error('sale_price')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="price">Size</label><span style="color:red">*</span>
                                        <input type="text" name="size" id="size"
                                               class="form-control"
                                               value="{{ old('size', @$product->size) }}" return onkeypress="isNumber()"
                                               maxlength="10">
                                        @error('size')
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
                        <input type="submit" value="{{ !empty($product) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('product.products') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
