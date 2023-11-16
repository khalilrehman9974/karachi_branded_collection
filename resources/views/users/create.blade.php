@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> {{ !empty($user) ? 'Edit User' : 'Create New User' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.users') }}">List of Users</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ !empty($user) ? 'Edit User' : 'Create New User' }}</li>
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
              action="{{ !empty($user) ? route('user.update') : route('user.store') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="userId" id="userId" value="{{ @$user->id }}"/>
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label><span style="color:red">*</span>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', @$user->name) }}"
                                               maxlength="200">
                                        @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"
                                               class="form-control"
                                               value="{{ old('email', @$user->email) }}"
                                               maxlength="70">
                                        @error('email')
                                        <div class="error-message" >{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label><span style="color:red">*</span>
                                        <input type="password" name="password" id="password" class="form-control"
                                               value=""
                                               maxlength="70" autocomplete="off">
                                        @error('password')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>User Type</label>
                                        <select class="form-control select2" style="width: 100%;"
                                                name="role"
                                                id="role">
                                            <option value="">Select</option>
                                            <option value="admin" {{!empty($user) && ($user->role === 'admin') ? "selected" : ''}} {{('admin' == old('role')) ? 'selected' : ''}}>Admin</option>
                                            <option value="user" {{!empty($user) && ($user->role === 'user') ? "selected" : ''}} {{('user' == old('role')) ? 'selected' : ''}}>User</option>
                                        </select>
                                        @error('role')
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
                        <input type="submit" value="{{ !empty($user) ? 'Update' : 'Save' }}" class="btn btn-success"
                               style="background-color: #3c8dbc">
                        <a href="{{ route('user.users') }}" class="btn btn-secondary ">Cancel</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script src="{{ asset('js/user.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
