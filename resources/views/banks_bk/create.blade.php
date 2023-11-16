@extends('layouts.app')
@section('content')
    <!-- Begin page -->
        <div class="content-page">
            <div class="content">
                <div class="page-content-wrapper ">
                    @if(session()->has('message'))
                        <div class="alert" style="background-color: #a9e8a8">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <div class="btn-group float-right">
                                        <ol class="breadcrumb hide-phone p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#">Doaba Foundation</a></li>
                                            <li class="breadcrumb-item active">Bank Registration</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Bank Registration</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body bpv-form project-management donor-reg">
                                        <form action="{{ route('bank.save') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ isset($bank->id) ? $bank->id : ''  }}" autocomplete="off" >

                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark">Account Title<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="account_title" id="account_title" value="{{ old('account_title', !empty($bank->account_title) ? $bank->account_title : '') }}" placeholder="Enter Account Title">
                                                    @error('account_title')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h6 class="light-dark">Bank Name<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', !empty($bank->name) ? $bank->name : '') }}" placeholder="Enter bank name">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Branch Name<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="branch_name" id="branch_name" value="{{ old('branch_name', !empty($bank->branch_name) ? $bank->branch_name : '')  }}" placeholder="Enter Branch Name">
                                                    @error('branch_name')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Branch Code<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="branch_code" id="branch_code" value="{{ old('branch_code', !empty($bank->branch_code) ? $bank->branch_code : '')  }}" placeholder="Enter Branch Code">
                                                    @error('branch_code')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Phone<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', !empty($bank->phone) ? $bank->phone : '')  }}" placeholder="Enter Phone Number">
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Swift Code<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="swift_code" id="swift_code" value="{{ old('swift_code', !empty($bank->swift_code) ? $bank->swift_code : '')  }}" placeholder="Enter Swift Code">
                                                    @error('swift_code')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Address</h6>
                                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', !empty($bank->address) ? $bank->address : '')  }}" placeholder="Enter Address">
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>

                                            <div class="form-group button-items mb-0 text-right">
                                                <a href="{{ route('bank.list') }}" class="btn btn-outline-danger waves-effect waves-light">Cancel</a>
                                                @if($permission->insert_access == 1)
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">@if(!isset($bank)) Save @else Update @endif</button>
                                                @endif
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div><!-- container -->


                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->
    </div>

    <!-- END wrapper -->

    @endsection