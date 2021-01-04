@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mpromotion')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($data))
                    <h5>Edit Promotion</h5>
                @else
                    <h5>Create New Promotion</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mpromotion')}}/{{$type}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Promo Title</label>
                            <input type="text" class="form-control" name="promo_name"
                                   @if (!empty($data))
                                   value="{{$data->promo_name}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            @if(!empty($data))
                                <img class='img-fluid img-thumbnail' src='{{$data->getImage()}}'
                            @endif
                            <label for="image">Upload Cover Image (Resolution 100px x 100px)</label>
                            <input type="file" class="form-control-file" id="image" name="promo_image">

                        </div>
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

