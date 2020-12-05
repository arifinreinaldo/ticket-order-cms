@extends('layouts.app')

@section('content')
    {{--    <div class="page-header">--}}
    {{--        <div class="page-block">--}}
    {{--            <div class="row align-items-center">--}}
    {{--                <div class="col-md-12">--}}
    {{--                    <div class="page-header-title">--}}
    {{--                        <h5 class="m-b-10">User Admin Management</h5>--}}
    {{--                    </div>--}}
    {{--                    <ul class="breadcrumb">--}}
    {{--                        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>--}}
    {{--                        <li class="breadcrumb-item"><a href="#">User Admin Management</a></li>--}}
    {{--                    </ul>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/muser/create')}}">
                    <button type="button" class="btn btn-primary" title="">Create</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>User Admin Panel</h5>
            </div>
            <div class="card-block table-border-style">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{session('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(session('failed'))
                    <div class="alert alert-danger" role="alert">
                        {{session('failed')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="post" id="actionForm">
        @csrf
        <input type="hidden" name="userid" id="userid_param">
    </form>
    <script>
        $(document).ready(function () {
            $("#dataTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('/ajaxmuser')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'u.name'},
                    {data: 'email', name: 'u.email'},
                    {data: 'role', name: 'u.role'},
                    {data: 'status_name', name: 's.name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ], columnDefs: [
                    {width: '10%', targets: 5}
                ],
            });
        });
        $(document).on("click", ".btn-activate", function () {
            var userid = $(this).attr('userid');
            $('#userid_param').val(userid);
            $('#actionForm').attr('action', '{{url('/muser/toggle')}}');
            $('#actionForm').submit();
        });
        $(document).on("click", ".btn-edit", function () {
            var userid = $(this).attr('userid');
            window.location.href = '/muser/edit/' + userid;
        });
    </script>
@endsection

