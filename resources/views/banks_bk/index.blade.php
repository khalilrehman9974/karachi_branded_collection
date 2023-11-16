@extends('layouts.app')
@section('content')
    <!-- Begin page -->
    <div id="wrapper">
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
                                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                                            <li class="breadcrumb-item active">List Of Banks</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">List Of Banks</h4>
                                </div>
                            </div>
                        </div>

            <!-- end page title end breadcrumb -->

                        <div class="form-group button-items mb-0 text-right">
                            <a href="{{ route('bank.create') }}" class="btn btn-primary waves-effect waves-light">Create Bank</a>
                        </div>
                        <br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{ route('bank.search') }}" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <h6 class="light-dark w-100">Search Bank</h6>
                                                    <input type="text" id="query" name="query" class="form-control" placeholder="Search" value="{{ isset($params) ? $params['query'] : '' }}">
                                                        <span class="input-group-prepend">
                                                            <button type="submit" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h6 class="light-dark">Sort By</h6>
                                            <select name="order_by" id="order_by" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;">
                                                <option value="">Select</option>
                                                <option value="name">Name</option>
                                                <option value="created_at">Created at</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <table class="table table-hover subject-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Account Title</th>
                                    <th>Branch Name</th>
                                    <th>Swift Code</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($banks as $bank)
                                    <a href="{{ route('bank.edit',['id'=>$bank->id]) }}">
                                        <tr id="row_{{$bank->id}}">
                                            <th scope="row">{{ $bank->name }}</th>
                                            <td>{{ $bank->account_title }}</td>
                                            <td>{{ $bank->branch_name }}</td>
                                            <td>{{ $bank->swift_code }}</td>
                                            <td>
                                                @if($permission->edit_access == 1)
                                                    <a href="{{ route('bank.edit',['id'=>$bank->id]) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endif
                                                    @if($permission->delete_access == 1)
                                                <a href="#" ><i class="fa fa-trash-o delete" data-id="{{ $bank->id }}"></i></a>
                                                    @endif
                                            </td>
                                        </tr>
                                    </a>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end">
                                    {!! $banks->render() !!}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="card m-b-30">

                    </div>
                </div>
            </div>



        </div><!-- container -->


    </div> <!-- Page content Wrapper -->

    </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.delete').click(function(){
                var el = this;
                var bankId = $(this).data('id');
                bootbox.confirm("Do you really want to delete record?", function(result) {
                    if(result){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ url('bank/delete') }}'+'/'+bankId,
                            type: 'DELETE',
                            data: { id:bankId },
                            success: function(response){
                                console.log(response);
                                if(response.success){
                                    $("#row_"+bankId).remove();
                                    bootbox.alert(response.message);
                                }else if(response.error){
                                    bootbox.alert(response.error);
                                }
                            }
                        });
                    }
                });
            });
       });
    </script>

@endsection
