@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mgamecenter')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($data))
                    <h5>Edit Game Center</h5>
                @else
                    <h5>Create New Game Center</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mgamecenter')}}/{{$type}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Game Center Name</label>
                            <input type="text" class="form-control" name="name"
                                   @if (!empty($data))
                                   value="{{$data->name}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            @if(!empty($data))
                                <img class='img-fluid img-thumbnail' src='{{$data->getImage()}}'
                            @endif
                            <label for="image">Upload Banner Image ( Resolution 100px x 100px )</label>
                            <input type="file" class="form-control-file" id="image" name="image">

                        </div>

                        <h5>Branch</h5>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        @if (!empty($data))
                            <input type="hidden" name="id" value="{{$data->id}}">
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#order').val($('#order_value').val());
        });
    </script>
@endsection

