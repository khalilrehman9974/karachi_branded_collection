@extends('layouts.app')
@section('content')
    @php
        $canEdit = false;
    @endphp

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>List of Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List of Users</li>
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
    <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="main col-md-12 float-right">
                    <form method="get" action="{{ route('user.users') }}">
                        <!-- Another variation with a button -->
                        <div class="input-group col-md-6 float-right">
                            <input type="text" name="param" id="param" class="form-control clearable"
                                   value="{{ @$param }}" placeholder="Search User">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit" style="background-color: #007bff;">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button class="form-control btn btn-secondary" id="clear-filter" type="submit"
                                        style="margin-left: 10px">
                                    Clear Filter
                                </button>
                                <span id="search-clear" class="glyphicon glyphicon-remove-circle"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="btn-group float-right" role="group">
                <a href="{{ route('user.create') }}"  class="form-control btn btn-primary"  type="button">
                    Create User
                </a>
            </div>
            <br>
            <br>
            <!-- Default box -->
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped users">
                        <thead>
                        <tr>
                            <th style="width: 35%">Name</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 10%">Role</th>
                            @permission('edit-user')
                            @php
                                $canEdit = true;
                            @endphp
                            <th style="width: 30%"></th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$users->isEmpty())
                            @foreach($users as $user)
                                <tr>
                                    <td title="{{ $user->name }}">{{ $user->name }}</td>
                                    <td title="{{ $user->email }}">{{ $user->email }}</td>
                                    <td>{{ $user->tid }}</td>
                                    <td></td>
                                    @if($canEdit)
                                        <td class="project-actions text-right">
                                            <a class="btn btn-primary btn-sm" href="{{ route('user.edit',$user->id) }}"
                                               id="view-package1" title="View">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"><strong>No users data</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="float-left">
                <b>Total Users: </b> {{ $users->total() }}
            </div>
            <div class="float-right">
                <nav>
                    <div class="float-right">
                        <ul>
                            {!! $users->setPath('/user/list')->appends(\Illuminate\Support\Facades\Request::query())->links() !!}
                        </ul>
                    </div>
                </nav>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
        // global routes configuration object
        var config = {
            routes: {
                getIsPackageEditable: "{{ url('package/get/checkpackageeditable') }}"
            }
        };
    </script>
    <script src="{{ asset('js/contract.js') }}"></script>
    <script>

    </script>
@endsection
