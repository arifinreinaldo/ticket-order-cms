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
    {{$create = ''}}
    {{$update = ''}}
    {{$delete = ''}}
    @foreach (session('menu') as $menu)
        @if($menu->alias=='muser')
            @php($create = $menu->create_access)
            @php($update = $menu->update_access)
            @php($delete = $menu->delete_access)
        @endif
    @endforeach
    @if($update=='X' or $delete=='X' or $create=='X')
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    @if($create=='X')
                        <a href="{{url('/muser/create')}}">
                            <button type="button" class="btn btn-primary" title="">Create</button>
                        </a>
                    @endif
                    @if($update=='X' or $delete=='X')
                        <div class="btn-group mb-2 mr-2 float-right">
                            <button type="button" class="btn btn-info">Action</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                @if($update=='X')
                                    <span class="dropdown-item pointer" id="actActivate">Activate</span>
                                    <span class="dropdown-item pointer" id="actDeactivate">Deactivate</span>
                                @endif
                                @if($delete=='X')
                                    <span class="dropdown-item pointer text-c-red" id="actDelete">Delete</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
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
                            <th></th>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            {{--                            <th>Action</th>--}}
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
        <input type="hidden" name="state" id="state_param">
    </form>
    <script>
        var table = ""
        $(document).ready(function () {
            table = $("#dataTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('/ajaxmuser')}}",
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'u.name'},
                    {data: 'email', name: 'u.email'},
                    {data: 'role_name', name: 'ur.role_name'},
                    {data: 'status_name', name: 's.name'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
                // , columnDefs: [
                //     {width: '10%', targets: 5}
                // ],
            });
        });
        $(document).on("click", ".btn-activate", function () {
            var userid = $(this).attr('userid');
            $('#userid_param').val(userid);
            $('#actionForm').attr('action', '{{url('/muser/toggle')}}');
            $('#actionForm').submit();
        });
        @if($update=='X')
        $(document).on("click", ".btn-edit", function () {
            var userid = $(this).attr('userid');
            window.location.href = '/muser/edit/' + userid;
        });
        @endif
        $(document).on("click", "#all_check", function () {
            var check = $(this).is(':checked');
            table.$('.check-control').each(function () {
                $(this).prop('checked', check);
            });
        });
        $(document).on("click", "#actActivate", function () {
            var ids = checkEmpty();
            if (ids != "") {
                $('#state_param').val(1);
                $('#userid_param').val(ids);
                $('#actionForm').attr('action', '{{url('/muser/toggle')}}');
                showModal("Delete Confirmation", "Are you sure want to activate these users?");
            }
        });
        $(document).on("click", "#actDeactivate", function () {
            var ids = checkEmpty();
            if (ids != "") {
                $('#state_param').val(2);
                $('#userid_param').val(ids);
                $('#actionForm').attr('action', '{{url('/muser/toggle')}}');
                // $('#actionForm').submit();
                showModal("Delete Confirmation", "Are you sure want to deactivate these users?");
            }
        });
        $(document).on("click", "#actDelete", function () {
            var ids = checkEmpty();
            if (ids != "") {
                $('#state_param').val(2);
                $('#userid_param').val(ids);
                $('#actionForm').attr('action', '{{url('/muser/destroy')}}');
                showModal("Delete Confirmation", "Are you sure want to delete these users?");
            }
        });
        $(document).on("click", "#confirmButtonModal", function () {
            $('#actionForm').submit();
        });


        function checkEmpty() {
            var isEmpty = true;
            var ids = "";
            table.$('.check-control').each(function () {
                if ($(this).is(":checked")) {
                    isEmpty = false;
                    ids += "," + $(this).attr('userid');
                }
            });
            if (isEmpty) {
                showMessage("Please Select One User");
            }
            return ids;
        }
    </script>
@endsection

