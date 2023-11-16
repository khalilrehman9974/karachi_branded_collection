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
                        <h1>Sale Detail</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sale.sales') }}">List of Sales</a>
                            </li>
                            <li class="breadcrumb-item active">Sale Detail</li>
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
                                        <td><b>Invoice ID</b></td>
                                        <td class="project-actions text-left">
                                            {{ $saleMaster->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Date</b></td>
                                        <td class="project-actions text-left">
                                            {{ \Carbon\Carbon::parse($saleMaster->date)->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Name</b></td>
                                        <td class="project-actions text-left">
                                            {{ $saleMaster->customerName }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Brand</b></td>
                                        <td class="project-actions text-left">
                                            {{ $saleMaster->brandName }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #000000; color: #FFFFFF"><b>Total Quantity</b></td>
                                        <td class="project-actions text-left">
                                            {{ $saleMaster->totalQuantity }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  style="background-color: #000000; color: #FFFFFF"><b>Total Amount</b></td>
                                        <td class="project-actions text-left">
                                            {{ $saleMaster->totalAmount  }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  style="background-color: #000000; color: #FFFFFF"><b>Tracking Number</b></td>
                                        <td class="project-actions text-left">
                                            {{ $saleMaster->tracking_number  }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3>Items Detail</h3>

                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <table id="example1" class="table table-bordered"
                                       style="overflow-scrolling: auto; max-height: 5px">
                                    <thead class="text-nowrap">
                                    <tr>
                                        {{--                                                    <th><input type="checkbox" checked></th>--}}
                                        <th>Item</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($saleDetail as $saleDet)
                                            <tr>
                                                <td class="project-actions text-left">
                                                    {{ $saleDet->productName }}
                                                </td>

                                                <td class="project-actions text-left">
                                                    {{ $saleDet->price }}
                                                </td>

                                                <td class="project-actions text-left">
                                                    {{ $saleDet->quantity }}
                                                </td>

                                                <td class="project-actions text-left">
                                                    {{ $saleDet->amount }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('sale.sales') }}" class="btn btn-secondary float-right">Back</a>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
