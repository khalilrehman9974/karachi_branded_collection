@extends('layouts.app')
@section('content')
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Start right Content here -->
        <div class="content-page">
            <!-- Start content -->
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
                                            <li class="breadcrumb-item active">Create Journal Voucher</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Journal Voucher</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body bpv-form">
                                        <form action="{{ route('jv.save')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="id"
                                                   value="{{ isset($jv->id) ? $jv->id : '' }}"/>
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark">Select Project<span style="color: red">*</span></h6>
                                                    <select class="select2 form-control mb-3 custom-select"
                                                            name="project_id" id="project_id"
                                                            style="width: 100%; height:36px;">
                                                        <option value="">Select</option>
                                                        @foreach( $dropDownData['projects'] as $key=>$value)
                                                            <option value="{{ $key }}" {{ (old("project_id") == $key ? "selected":"") || (!empty($jv->project_id) ? collect($jv->project_id)->contains($key) : '') ? 'selected':'' }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('project_id')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">JV#<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="jv_no" id="jv_no"
                                                           value="{{  old('jv_no', !empty($jv->jv_no) ? $jv->jv_no : '') }}"
                                                           placeholder="Enter CRV Number" maxlength="30">
                                                    @error('jv_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Debit Account<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="debit_account"
                                                           id="debit_account"
                                                           value="{{ old('debit_account', !empty($jv->debit_account) ? $jv->debit_account : '') }}"
                                                           placeholder="Enter Debit Account" maxlength="30" >
                                                    @error('debit_account')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Credit Account<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="credit_account"
                                                           id="credit_account"
                                                           value="{{ old('credit_account', !empty($jv->credit_account) ? $jv->credit_account : '') }}"
                                                           placeholder="Enter Credit Account" maxlength="30" >
                                                    @error('credit_account')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Debit Amount<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="debit_amount" id="debit_amount"
                                                           value="{{ old('debit_amount', !empty($jv->debit_amount) ? $jv->debit_amount : '') }}"
                                                           placeholder="Enter Debit Amount" maxlength="15">
                                                    @error('debit_amount')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Credit Amount<span style="color: red">*</span></h6>
                                                    <input type="text" class="form-control" name="credit_amount" id="credit_amount"
                                                           value="{{ old('credit_amount', !empty($jv->credit_amount) ? $jv->credit_amount : '') }}"
                                                           placeholder="Enter Credit Amount" maxlength="15">
                                                    @error('credit_amount')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Date<span style="color: red">*</span></h6>
                                                    <div class="input-daterange input-group" id="date-range">
                                                        <input type="text" class="form-control" name="date"
                                                               value="{{ old('date', !empty($jv->date) ? \Carbon\Carbon::parse($jv->date )->format('d-m-Y') : '')  }}"
                                                               placeholder="Select Date" readonly/>
                                                    </div>
                                                    @error('date')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h6 class="light-dark w-100">Enter WHT</h6>
                                                    <input type="text" class="form-control" name="wht" id="wht"
                                                           value="{{ old('wht', !empty($jv->wht) ? $jv->wht : '')  }}"
                                                           placeholder="Enter With Holding Tax" maxlength="70">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <h6 class="light-dark w-100">Description</h6>
                                                <textarea id="textarea" class="form-control" name="description"
                                                          id="description" maxlength="225" rows="3"
                                                          placeholder="Enter Description">{{ old('description', !empty($jv->description) ? $jv->description : '') }}</textarea>
                                            </div>

                                            @include('common._attachments')

                                            <div class="form-group button-items mb-0 text-right">
                                                <a href="{{ route('jv.list') }}" class="btn btn-outline-danger waves-effect waves-light">Cancel</a>
                                                @if($permission->insert_access == 1)

                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    @if(!isset($jv)) Save @else Update @endif
                                                </button>
                                                    @endif
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection