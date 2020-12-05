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
                <h5>Create New User Admin Panel</h5>
            </div>
            <div class="card-block table-border-style">
                <form method="POST" action="{{ route('/muser/store') }}">

                </form>
            </div>
        </div>
    </div>
    <script>
    </script>
@endsection

