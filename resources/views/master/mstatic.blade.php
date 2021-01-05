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
        @if($menu->alias=='mstatic')
            @php($create = $menu->create_access)
            @php($update = $menu->update_access)
            @php($delete = $menu->delete_access)
        @endif
    @endforeach
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Static Page Management</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Page Title</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="align-middle">1</td>
                            <td class="align-middle">Syarat & Ketentuan</td>
                            <td>
                                @if($update=='X')
                                    <a class='btn btn-primary btn-show' href="{{url('/mstatic/edit/1')}}" title='Edit'>
                                        <span class='fa fa-fw fa-edit'></span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">2</td>
                            <td class="align-middle">Kebijakan Privacy</td>
                            <td>
                                @if($update=='X')
                                    <a class='btn btn-primary btn-show' href="{{url('/mstatic/edit/2')}}" title='Edit'>
                                        <span class='fa fa-fw fa-edit'></span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">3</td>
                            <td class="align-middle">FAQ</td>
                            <td>
                                @if($update=='X')
                                    <a class='btn btn-primary btn-show' href="{{url('/mfaq')}}" title='Edit'>
                                        <span class='fa fa-fw fa-edit'></span>
                                    </a>
                                @endif
                            </td>
                        </tr>
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

        });
        $(document).on("click", ".btn-activate", function () {
            var userid = $(this).attr('userid');
            $('#userid_param').val(userid);
            $('#actionForm').attr('action', '{{url('/mstatic/toggle')}}');
            $('#actionForm').submit();
        });
        @if($update=='X')
        $(document).on("click", ".btn-edit", function () {
            var userid = $(this).attr('userid');
            window.location.href = '/mstatic/edit/' + userid;
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
                $('#actionForm').attr('action', '{{url('/mstatic/toggle')}}');
                showModal("Activate Confirmation", "Are you sure want to activate these users?");
            }
        });
        $(document).on("click", "#actDeactivate", function () {
            var ids = checkEmpty();
            if (ids != "") {
                $('#state_param').val(2);
                $('#userid_param').val(ids);
                $('#actionForm').attr('action', '{{url('/mstatic/toggle')}}');
                // $('#actionForm').submit();
                showModal("Deactivate Confirmation", "Are you sure want to deactivate these users?");
            }
        });
        $(document).on("click", "#actDelete", function () {
            var ids = checkEmpty();
            if (ids != "") {
                $('#state_param').val(2);
                $('#userid_param').val(ids);
                $('#actionForm').attr('action', '{{url('/mstatic/destroy')}}');
                showModal("Delete Confirmation", "Are you sure want to delete these users?");
            }
        });
        $(document).on("click", "#confirmButtonModal", function () {
            $('#actionForm').submit();
        });
    </script>
@endsection


@section('injectstyle')
    @if($update=='')
        <style>
            .text-c-blue.pointer {
                color: #888;
                cursor: auto !important;
            }
        </style>
    @endif
@endsection

