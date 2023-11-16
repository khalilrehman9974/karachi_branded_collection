@extends('layouts.app')
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>List of Parties</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List of Parties</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
            <div class="row">
                <div class="main col-md-12 float-right">
                    <form method="get" action="{{ route('party.parties') }}">
                        <!-- Another variation with a button -->
                        <div class="input-group col-md-12 float-right">
                            <div class="form-group col-md-3">
                                <div class="input-group-prepend">
                                    <input type="text" name="param" id="param" class="form-control clearable"
                                           value="{{ @$request['param'] }}" placeholder="Search Party">
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-success" type="submit"
                                        style="background-color: #007bff; height: 38px">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="input-group-btn advance-search-btn">
                                <div class="btn-group" role="group">
                                    <div class="dropdown dropdown-lg">
                                        <button type="button" class="btn btn-success"
                                                id="advance-search-btn">
                                            <span class="caret"></span>
                                            Advance Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group-append col-md-6">
                                <div class="btn-group" role="group">
                                    <button class="form-control btn btn-secondary" id="clear-filter" type="submit">
                                        Clear Filter
                                    </button>
                                </div>
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>

                                {{--<div class="btn-group btn-export" role="group">
                                    <button class="form-control btn btn-info" id="export" type="button">
                                        Download in Excel
                                    </button>
                                </div>
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>

                                <div class="btn-group" role="group" style="margin-left: 5px">
                                    <a href="{{ route('contracts.excel.download') }}"  class="form-control btn btn-primary"  type="button">
                                        Download Excel File
                                    </a>
                                </div>--}}
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>
                            </div>

                        </div>
                        <div class="row" id="advance-search">
                            <div class="card card-default" style=" min-width: 97%; margin-left: 23px">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Advanced Search</strong></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="{{ route('party.parties') }}">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label>From Date</label>
                                                <div class="input-group date" id="from_date"
                                                     data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input date"
                                                           name="from_date" id="from-date"
                                                           data-target="#from-date"
                                                           value="{{ @$request['from_date'] }}"/>
                                                    <div class="input-group-append" data-target="#from-date"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('from_date')
                                                    <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="to_date">To Date</label>
                                                <div class="input-group date" id="to_date"
                                                     data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input date"
                                                           name="to_date" id="to-date"
                                                           value="{{  @$request['to_date'] }}"
                                                           data-target="#to-date"/>
                                                    <div class="input-group-append" data-target="#to-date"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('to_date')
                                                    <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="mobile_no">Mobile No</label>
                                                <div class="input-group-prepend">
                                                    <input type="text" name="mobile_no" id="mobile_no"
                                                           class="form-control clearable"
                                                           value="{{ @$request['mobile_no'] }}" onkeypress="return isNumber(event)" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="whatsapp_no">Whatsapp No</label>
                                                <div class="input-group-prepend">
                                                    <input type="text" name="whatsapp_no" id="whatsapp_no"
                                                           class="form-control clearable"
                                                           value="{{ @$request['whatsapp_no'] }}" onkeypress="return isNumber(event)" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="city">City</label>
                                                <div class="input-group-prepend">
                                                    <input type="text" name="city" id="city"
                                                           class="form-control clearable"
                                                           value="{{ @$request['city'] }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </form>
                </div>
            </div>
                <div class="btn-group float-right" role="group">
                    <a href="{{ route('party.create') }}"  class="form-control btn btn-primary"  type="button">
                        Create Party
                    </a>
                </div>
            <br>
                <br>
            <!-- Default box -->
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Phone No</th>
                            <th>City</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$parties->isEmpty())
                            @foreach($parties as $party)
                                <tr class="party{{$party->id}}">
                                    <td>{{ $party->id }}</td>
                                    <td title="{{ $party->name }}">{{ $party->name }}</td>
                                    <td title="{{ $party->email }}">{{ $party->email }}</td>
                                    <td title="{{ $party->mobile_no }}"> {{ $party->mobile_no }}</td>
                                    <td title="{{ $party->phone_no }}"> {{ $party->phone_no }}</td>
                                    <td title="{{ $party->city }}"> {{ $party->city }}</td>
                                    <td class="project-actions float-right">
                                        <a class="btn btn-primary btn-sm" target="_blank"
                                           href="{{ route('party.view',$party->id) }}"
                                           id="view-package1" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('party.edit', $party->id) }}"
                                           data-id="{{ $party->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm delete"
                                           href="javascript:void(0)"
                                           data-id="{{ $party->id }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"><strong>No parties data</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="float-left">
                <b>Total Parties: </b> {{ $parties->total() }}
            </div>
            <div class="float-right">
                <nav>
                    <ul>

                        {!! $parties->setPath('')->appends(\Illuminate\Support\Facades\Request::query())->links() !!}
                    </ul>
                </nav>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ asset('js/party.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>

        // global routes configuration object
        var config = {
            routes: {
                deleteParty: "{{ url('party/delete') }}",
            },
            totalRecords: {{  $parties->total() }}
        };
    </script>
@endsection
