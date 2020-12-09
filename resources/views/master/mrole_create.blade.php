@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mrole')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($role))
                    <h5>Edit User Role</h5>
                @else
                    <h5>Create New User Role</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($role))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mrole')}}/{{$type}}" id="formAction">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" class="form-control" name="role_name" required
                                   @if (!empty($role))
                                   value="{{$role->role_name}}"
                                @endif
                            >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Page</th>
                                    <th>Create</th>
                                    <th>Read</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($access as $data)
                                    <tr>
                                        <td>{{$data->menu}}</td>
                                        <td>
                                            <input type="checkbox" class="validateFilled" name="create_{{$data->id}}"
                                                   @if ($data->create_access==='X')
                                                   checked
                                                   @endif
                                                   value="X">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="validateFilled" name="read_{{$data->id}}"
                                                   @if ($data->read_access==='X')
                                                   checked
                                                   @endif
                                                   value="X">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="validateFilled" name="update_{{$data->id}}"
                                                   @if ($data->update_access==='X')
                                                   checked
                                                   @endif
                                                   value="X">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="validateFilled" name="delete_{{$data->id}}"
                                                   @if ($data->delete_access==='X')
                                                   checked
                                                   @endif
                                                   value="X">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    @if (!empty($role))
                        <input type="hidden" name="id" value="{{$role->id}}">
                    @endif
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#role').val($('#role_value').val());

        });
        $(document).on('click', '.btn-primary', function (e) {
            e.preventDefault();
            var validateFilled = false;
            $('.validateFilled').each(function () {
                if ($(this).is(":checked")) {
                    validateFilled = true;
                }
            });
            if (!validateFilled) {
                showMessage("Access must be given");
            } else {
                $('#formAction').submit();
            }
        });
    </script>
@endsection

