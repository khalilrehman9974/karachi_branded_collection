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
                        <h1>List of Brands</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List of Brands</li>
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
            </div>
                <div class="btn-group float-right" role="group">
                    <a href="{{ route('brand.create') }}"  class="form-control btn btn-primary"  type="button">
                        Create Brand
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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$brands->isEmpty())
                            @foreach($brands as $brand)
                                <tr class="brand{{$brand->id}}">
                                    <td>{{ $brand->id }}</td>
                                    <td title="{{ $brand->name }}">{{ $brand->name }}</td>
                                    <td class="project-actions float-right">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('brand.edit', $brand->id) }}"
                                          data-id="{{ $brand->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm delete"
                                           href="javascript:void(0)"
                                           data-id="{{ $brand->id }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"><strong>No brands data</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="float-left">
                <b>Total Brands: </b> {{ $brands->total() }}
            </div>
            <div class="float-right">
                <nav>
                    <ul>

                        {!! $brands->setPath('')->appends(\Illuminate\Support\Facades\Request::query())->links() !!}
                    </ul>
                </nav>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ asset('js/brand.js') }}"></script>
    <script>

        // global routes configuration object
        var config = {
            routes: {
                deleteBrand: "{{ url('brand/delete') }}",
            },
            totalRecords: {{  $brands->total() }}
        };
    </script>
@endsection
