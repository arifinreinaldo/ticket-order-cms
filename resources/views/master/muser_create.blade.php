@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/muser')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($muser))
                    <h5>Edit User Admin Panel</h5>
                @else
                    <h5>Create New User Admin Panel</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($muser))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/muser')}}/{{$type}}">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="name"
                                   @if (!empty($muser))
                                   value="{{$muser->name}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email"
                                   @if (!empty($muser))
                                   value="{{$muser->email}}"
                                @endif>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control selectpicker"
                                    id="role"
                                    name="role"
                                    data-live-search="true">
                                <option value="">Select Role</option>
                                @foreach($mrole as $data)
                                    <option value="{{$data->id}}">{{$data->role_name}}</option>
                                @endforeach
                                @if(empty($muser))
                                    @php($user_role= '')
                                @else
                                    @php($user_role = $muser->role)
                                @endif
                                <input type="hidden" id="role_value" value="{{$user_role}}">
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        @if (!empty($muser))
                            <input type="hidden" name="id" value="{{$muser->id}}">
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#role').val($('#role_value').val());
        });
    </script>
@endsection

