@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Customer Detail</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customers') }}">List of Customers</a>
                            </li>
                            <li class="breadcrumb-item active">Customer Detail</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <table id="example1" class="table table-bordered"
                                       style="overflow-scrolling: auto; max-height: 5px">
                                    <tbody>
                                    <tr>
                                        <td><b>Id</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Phone No</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->phone_no }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Mobile No</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->mobile_no }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Whatsapp No</b></td>
                                        <td class="project-actions text-left">
                                            {{   $customer->whatsapp_no  }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>City</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->city }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Mailing Address</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->mailing_address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Shipping Address</b></td>
                                        <td class="project-actions text-left">
                                            {{ $customer->shipping_address }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('customers') }}" class="btn btn-secondary float-right">Back</a>

                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
