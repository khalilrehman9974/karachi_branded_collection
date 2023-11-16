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
                        <h1>List of Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List of Categories</li>
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
                    <a href="{{ route('category.create') }}"  class="form-control btn btn-primary"  type="button">
                        Create Category
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
                        @if(!$categories->isEmpty())
                            @foreach($categories as $category)
                                <tr class="category{{$category->id}}">
                                    <td>{{ $category->id }}</td>
                                    <td title="{{ $category->name }}">{{ $category->name }}</td>
                                    <td class="project-actions float-right">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('category.edit', $category->id) }}"
                                          data-id="{{ $category->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm delete"
                                           href="javascript:void(0)"
                                           data-id="{{ $category->id }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"><strong>No categories data</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="float-left">
                <b>Total Categories: </b> {{ $categories->total() }}
            </div>
            <div class="float-right">
                <nav>
                    <ul>

                        {!! $categories->setPath('')->appends(\Illuminate\Support\Facades\Request::query())->links() !!}
                    </ul>
                </nav>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ asset('js/category.js') }}"></script>
    <script>

        // global routes configuration object
        var config = {
            routes: {
                deleteCategory: "{{ url('category/delete') }}",
            },
            totalRecords: {{  $categories->total() }}
        };
    </script>
@endsection
