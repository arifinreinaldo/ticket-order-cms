@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        MArticle
                        <button type="button" style="float: right" class="btn btn-primary" id="btn-add"
                                data-toggle="modal" data-target="#actionModal">
                            <span class="fa fa-plus"></span> Add Data
                        </button>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
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

                    <div class="col-6">
                        <div class="modal" id="actionModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formAction" action="/marticle/store" method="POST">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" class="form-control" id=""
                                                       name=""
                                                       aria-describedby="" maxlength="">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" id="btnSave" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formDelete" action="/marticle/destroy" method="POST">
                                            {{csrf_field()}}
                                            Are you sure want to delete data?
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" id="btnDelete" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-12">
                            <table id="tabeldata" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach($marticle as $data)
                                    <tr>
                                        <td>{{$data->}}</td>
                                        <td>{{$data->}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-edit"
                                                    id="{{$data->}}">
                                                <span class="fa fa-pen"></span>
                                            </button>
                                            &nbsp

                                            <button class="btn btn-danger btn-delete"
                                                    id="{{$data->}}"
                                            >
                                                <span class="fa fa-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$marticles->links()}}
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).on("keyup", "input.onlynumber", function () {
            var value = $(this).val();
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        $(document).ready(function () {

            $("#btnSave").click(function () {
                $("#formAction").submit();
            });

            $("#btnDelete").click(function () {
                $("#formDelete").submit();
            });

            $("#btn-add").click(function () {
                $("#formAction").attr("action", "/marticle/store");
            });

            $(".btn-edit").click(function () {

                var id = $(this).attr("id");
                var field1 = $(this).attr("field1");
                var field2 = $(this).attr("field2");

                $("#formAction").attr("action", "/marticle/update/" + id);

                $("#id").val(id);
                $("#field1").val(field1);
                $("#field2").val(field2);

                $("#actionModal").modal("show");
            })

            $(".btn-delete").click(function () {
                var id = $(this).attr("id");
                $("#formDelete").attr("action", "/marticle/destroy/" + id);
                $("#deleteModal").modal("show");
            })

            $("#tabeldata_filter").css("float", "right");

            $("#tabeldata_paginate").css("float", "right");
        });
    </script>

@endsection

