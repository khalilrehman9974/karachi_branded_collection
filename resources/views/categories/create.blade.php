@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($category) ? 'Edit Category' : 'Create New Category' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('category.categories') }}">List of Categories</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($category) ? 'Edit Category' : 'Create New Category' }}</li>
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
              action="{{ !empty($category) ? route('category.update') : route('category.store') }}">
            @csrf
            <input type="hidden" name="categoryId" id="categoryId" value="{{ @$category->id }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label><span style="color:red">*</span>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', @$category->name) }}"
                                               maxlength="200">
                                        @error('name')
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
                        <input type="submit" value="{{ !empty($category) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('category.categories') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/category.js') }}"></script>
@endsection
